<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Funcao;

class FuncaoController extends Controller
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
        $funcoes = Funcao::all();
        return view('cadastros.funcoes.index', compact('funcoes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cadastros.funcoes.create');
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
            'nome'=>'required|string|max:255|unique:funcoes'
        ]);

        $encoding = mb_internal_encoding();

        $funcao = new Funcao([
            'nome' => mb_strtoupper($request->get('nome'), $encoding)
        ]);
        $funcao->save();

        return redirect('/funcoes/' . $funcao->id . '/edit')->with('success', 'Função adicionada com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $funcao = Funcao::find($id);
        return view('cadastros.funcoes.edit', compact('funcao'));
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
            'nome'=>'required|string|max:255|unique:funcoes,nome,' . $id . ',id'
        ]);
  
        $encoding = mb_internal_encoding();

        $funcao = Funcao::find($id);
        $funcao->nome = mb_strtoupper($request->get('nome'), $encoding);
        $funcao->save();
  
        return redirect('/funcoes/' . $funcao->id . '/edit')->with('success', 'Função atualizada com sucesso!');
    }

    public function ativarDesativarFuncao(Request $request) {
        $funcao = Funcao::find($request->funcao_id);
        $msg = "Função ativada com sucesso!";
        $situacao = 1;
        if ($funcao->situacao == 1) {
            $msg = "Função desativada com sucesso!";
            $situacao = 2;
        }
        $funcao->situacao = $situacao;
        $funcao->save();

        $dados = array();
        $dados['textoMsg'] = $msg;

        return response()->json($dados, 200);
    }

    public function carregarComboFuncoes()
    {
        return Funcao::all();
    }

}
