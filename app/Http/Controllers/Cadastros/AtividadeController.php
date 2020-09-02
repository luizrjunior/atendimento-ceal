<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\Atividade;

class AtividadeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $atividades = Atividade::all();
        return view('cadastros.atividades.index', compact('atividades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cadastros.atividades.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome'=>'required|string|max:255|unique:atividades'
        ]);

        $encoding = mb_internal_encoding();
        $somente_colaborador = $request->get('somente_colaborador') ? $request->get('somente_colaborador') : 1;

        $atividade = new Atividade([
            'somente_colaborador' => $somente_colaborador,
            'nome' => mb_strtoupper($request->get('nome'), $encoding)
        ]);
        $atividade->save();

        return redirect('/atividades/' . $atividade->id . '/edit')->with('success', 'Atividade adicionada com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Session::put('atividade_id', $id);
        $atividade = Atividade::find($id);
        return view('cadastros.atividades.edit', compact('atividade'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome'=>'required|string|max:255|unique:atividades,nome,' . $id . ',id'
        ]);
  
        $encoding = mb_internal_encoding();
        $somente_colaborador = $request->get('somente_colaborador') ? $request->get('somente_colaborador') : 1;

        $atividade = Atividade::find($id);
        $atividade->somente_colaborador = $somente_colaborador;
        $atividade->nome = mb_strtoupper($request->get('nome'), $encoding);
        $atividade->save();
  
        return redirect('/atividades/' . $atividade->id . '/edit')->with('success', 'Atividade atualizada com sucesso!');
    }

    public function ativarDesativarAtividade(Request $request) {
        $atividade = Atividade::find($request->atividade_id);
        $msg = "Atividade ativada com sucesso!";
        $situacao = 1;
        if ($atividade->situacao == 1) {
            $msg = "Atividade desativada com sucesso!";
            $situacao = 2;
        }
        $atividade->situacao = $situacao;
        $atividade->save();

        $dados = array();
        $dados['textoMsg'] = $msg;

        return response()->json($dados, 200);
    }

    public function carregarComboAtividades()
    {
        return Atividade::all();
    }

}
