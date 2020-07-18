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
        $funcaos = Funcao::all();
        return view('cadastros.funcaos.index', compact('funcaos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cadastros.funcaos.create');
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
            'nome'=>'required|string|max:255|unique:funcaos'
          ]);
  
          $funcao = new Funcao([
            'nome' => $request->get('nome')
          ]);
          $funcao->save();
  
          return redirect('/funcaos/' . $funcao->id . '/edit')->with('success', 'Função adicionada com sucesso!');
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
        return view('cadastros.funcaos.edit', compact('funcao'));
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
            'nome'=>'required|string|max:255|unique:funcaos,nome,' . $id . ',id'
        ]);
  
        $funcao = Funcao::find($id);
        $funcao->nome = $request->get('nome');
        $funcao->save();
  
        return redirect('/funcaos/' . $funcao->id . '/edit')->with('success', 'Função atualizada com sucesso!');
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

}
