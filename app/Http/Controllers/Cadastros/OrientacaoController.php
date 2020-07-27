<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Orientacao;

class OrientacaoController extends Controller
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
        $orientacoes = Orientacao::all();
        return view('cadastros.orientacoes.index', compact('orientacoes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cadastros.orientacoes.create');
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
            'descricao'=>'required|string|max:255|unique:orientacoes'
          ]);
  
        $orientacao = new Orientacao([
        'descricao' => strtoupper($request->get('descricao'))
        ]);
        $orientacao->save();

        return redirect('/orientacoes/' . $orientacao->id . '/edit')->with('success', 'Orientação adicionada com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $orientacao = Orientacao::find($id);
        return view('cadastros.orientacoes.edit', compact('orientacao'));
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
            'descricao'=>'required|string|max:255|unique:orientacoes,descricao,' . $id . ',id'
        ]);
  
        $orientacao = Orientacao::find($id);
        $orientacao->descricao = strtoupper($request->get('descricao'));
        $orientacao->save();
  
        return redirect('/orientacoes/' . $orientacao->id . '/edit')->with('success', 'Orientação atualizada com sucesso!');
    }

    public function ativarDesativarOrientacao(Request $request) {
        $orientacao = Orientacao::find($request->orientacao_id);
        $msg = "Orientação ativada com sucesso!";
        $situacao = 1;
        if ($orientacao->situacao == 1) {
            $msg = "Orientação desativada com sucesso!";
            $situacao = 2;
        }
        $orientacao->situacao = $situacao;
        $orientacao->save();

        $dados = array();
        $dados['textoMsg'] = $msg;

        return response()->json($dados, 200);
    }

    public function carregarOrientacoes()
    {
        return Orientacao::all();
    }

}
