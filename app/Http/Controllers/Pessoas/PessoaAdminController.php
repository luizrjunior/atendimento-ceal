<?php

namespace App\Http\Controllers\Pessoas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pessoa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PessoaAdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    private function filtrosPesquisa($request)
    {
        $data = $request->except('_token');
        if (empty($data['nome_psq'])) {
            $data['nome_psq'] = "";
        }

        if (empty($data['cpf_psq'])) {
            $data['cpf_psq'] = "";
        }

        $data['totalPage'] = isset($data['totalPage']) ? $data['totalPage'] : 25;

        return $data;
    }

    public function index(Request $request)
    {
        $data = $this->filtrosPesquisa($request);

        $pessoas = Pessoa::where(function ($query) use ($data) {
                if ($data['nome_psq'] != "") {
                    $query->where('nome', 'LIKE', "%" . strtoupper($data['nome_psq']) . "%");
                }
                if ($data['cpf_psq'] != "") {
                    $query->where('cpf', $data['cpf_psq']);
                }
                if (Session::get('tela') == 'create_atendimento_admin') {
                    $query->orWhere('cpf', $data['nome_psq']);
                }
            })->orderBy('nome')->paginate($data['totalPage']);

        return view('pessoas.admin.index', compact('pessoas', 'data'));
    }

    public function create()
    {
        return view('pessoas.admin.create');
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
            'user_id' => null
        ]);
        $pessoa->save();

        return redirect('/pessoas-admin/' . $pessoa->id . '/edit')->with('success', 'Dados cadastrais adicionado com sucesso!');
    }

    public function edit($id)
    {
        $pessoa = Pessoa::find($id);
        return view('pessoas.admin.edit', compact('pessoa'));
    }

    public function update(Request $request, $id)
    {
        dd($request->all());
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
  
        return redirect('/pessoas-admin/' . $pessoa->id . '/edit')->with('success', 'Dados Cadastrais atualizado com sucesso!');
    }

    public function selecionar($pessoa_id)
    {
        Session::put('pessoa_id', $pessoa_id);

        return redirect('/atendimentos/create');
    }

}
