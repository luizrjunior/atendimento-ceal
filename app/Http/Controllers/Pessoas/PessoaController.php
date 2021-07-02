<?php

namespace App\Http\Controllers\Pessoas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Pessoa;

class PessoaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('pessoas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cpf' => 'nullable|cpf|unique:pessoas',
            'nome'=>'required|string|max:255',
            'nascimento'=>'required|date_format:d/m/Y',
            'sexo'=>'required',
            'telefone'=>'required|max:15',
            'profissao'=>'nullable|string|max:255',
            'socio'=>'required',
            'bairro'=>'required|string|max:255'
        ]);

        $encoding = mb_internal_encoding();
        $nascimento = \DateTime::createFromFormat('d/m/Y', $request->nascimento)->format('Y-m-d');

        $pessoa = new Pessoa([
            'cpf' => $request->get('cpf'),
            'nome' => mb_strtoupper($request->get('nome'), $encoding),
            'nascimento' => $nascimento,
            'sexo' => $request->get('sexo'),
            'telefone' => $request->get('telefone'),
            'profissao' => mb_strtoupper($request->get('profissao'), $encoding),
            'socio' => $request->get('socio'),
            'bairro' => mb_strtoupper($request->get('bairro'), $encoding),
            'user_id' => Auth::id()
            ]);
        $pessoa->save();
  
        return redirect('/home')->with('success', 'Dados cadastrais adicionado com sucesso!');
    }

    public function edit($id)
    {
        $pessoa = Pessoa::find($id);
        return view('pessoas.edit', compact('pessoa'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cpf' => 'nullable|cpf|unique:pessoas,cpf,' . $id . ',id',
            'nome'=>'required|string|max:255',
            'nascimento'=>'required|date_format:d/m/Y',
            'sexo'=>'required',
            'telefone'=>'required|max:15',
            'profissao'=>'nullable|string|max:255',
            'socio'=>'required',
            'bairro'=>'required|string|max:255'
        ]);

        $encoding = mb_internal_encoding();
        $nascimento = \DateTime::createFromFormat('d/m/Y', $request->nascimento)->format('Y-m-d');
  
        $pessoa = Pessoa::find($id);
        $pessoa->cpf = $request->get('cpf');
        $pessoa->nome = mb_strtoupper($request->get('nome'), $encoding);
        $pessoa->nascimento = $nascimento;
        $pessoa->sexo = $request->get('sexo');
        $pessoa->telefone = $request->get('telefone');
        $pessoa->profissao = mb_strtoupper($request->get('profissao'), $encoding);
        $pessoa->socio = $request->get('socio');
        $pessoa->bairro = mb_strtoupper($request->get('bairro'), $encoding);
        $pessoa->save();
  
        return redirect('/pessoas/' . $pessoa->id . '/edit')->with('success', 'Dados Cadastrais atualizado com sucesso!');
    }

    public function carregarPessoaPorCPF(Request $request)
    {
        $pessoa = null;
        $pessoa_request = Pessoa::where('cpf', $request->cpf)->get();
        if (count($pessoa_request) > 0) {
            $pessoa = $pessoa_request[0];
        }
        return response()->json($pessoa, 200);
    }

    public function buscarPessoaAtendimento(Request $request)
    {
        $pessoa = null;
        $pessoa_request = Pessoa::where('cpf', $request->nome)->orWhere('nome', 'LIKE', "%" . strtoupper($request->nome) . "%")->get();
        if (count($pessoa_request) == 1) {
            $pessoa = $pessoa_request[0];
        }
        $pessoa['qtde_pessoas'] = count($pessoa_request);
        return response()->json($pessoa, 200);
    }

}
