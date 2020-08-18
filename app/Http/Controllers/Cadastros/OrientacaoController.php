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

    public function index()
    {
        $orientacoes = Orientacao::all();
        return view('cadastros.orientacoes.index', compact('orientacoes'));
    }

    public function create()
    {
        return view('cadastros.orientacoes.create');
    }

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

    public function edit($id)
    {
        $orientacao = Orientacao::find($id);
        return view('cadastros.orientacoes.edit', compact('orientacao'));
    }

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
