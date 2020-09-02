<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Local;

class LocalController extends Controller
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
        $locais = Local::all();
        return view('cadastros.locais.index', compact('locais'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cadastros.locais.create');
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
            'nome'=>'required|string|max:255|unique:locais',
            'numero'=>'required|string|max:255'
        ]);

        $encoding = mb_internal_encoding();

        $local = new Local([
            'nome' => mb_strtoupper($request->get('nome'), $encoding),
            'numero' => mb_strtoupper($request->get('numero'), $encoding)
        ]);
        $local->save();

        return redirect('/locais/' . $local->id . '/edit')->with('success', 'Local adicionado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $local = Local::find($id);
        return view('cadastros.locais.edit', compact('local'));
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
            'nome'=>'required|string|max:255|unique:locais,nome,' . $id . ',id',
            'numero'=>'required|string|max:255'
        ]);

        $encoding = mb_internal_encoding();
  
        $local = Local::find($id);
        $local->nome = mb_strtoupper($request->get('nome'), $encoding);
        $local->numero = mb_strtoupper($request->get('numero'), $encoding);
        $local->save();
  
        return redirect('/locais/' . $local->id . '/edit')->with('success', 'Local atualizado com sucesso!');
    }

    public function ativarDesativarLocal(Request $request) {
        $local = Local::find($request->local_id);
        $msg = "Local ativado com sucesso!";
        $situacao = 1;
        if ($local->situacao == 1) {
            $msg = "Local desativado com sucesso!";
            $situacao = 2;
        }
        $local->situacao = $situacao;
        $local->save();

        $dados = array();
        $dados['textoMsg'] = $msg;

        return response()->json($dados, 200);
    }

    public function carregarComboLocais()
    {
        return Local::all();
    }

}
