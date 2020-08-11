<?php

namespace App\Http\Controllers\Pessoas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Colaborador;

class ColaboradorController extends Controller
{
    const MESSAGES_ERRORS = [	
        'pessoa_id.unique' => 'A pessoa informada já está associada como colaborador. Por favor, '
        . 'você pode verificar isso?',
    ];

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

        if (empty($data['situacao_psq'])) {
            $data['situacao_psq'] = "";
        }

        $data['totalPage'] = isset($data['totalPage']) ? $data['totalPage'] : 25;

        return $data;
    }

    public function index(Request $request)
    {
        $data = $this->filtrosPesquisa($request);

        $colaboradores = Colaborador::select(
                'colaboradores.id', 'colaboradores.situacao', 
                'pessoas.nome', 'pessoas.telefone', 'pessoas.bairro')
            ->join('pessoas', 'colaboradores.pessoa_id', 'pessoas.id')
            ->where(function ($query) use ($data) {
                if ($data['nome_psq'] != "") {
                    $query->where('pessoas.nome', 'LIKE', "%" . strtoupper($data['nome_psq']) . "%");
                }
                if ($data['situacao_psq'] != "") {
                    $query->where('colaboradores.situacao', $data['situacao_psq']);
                }
            })->orderBy('pessoas.nome')->paginate($data['totalPage']);

        return view('pessoas.colaboradores.index', compact('colaboradores', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pessoas.colaboradores.create');
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
            'cpf' => 'required|cpf',
            'pessoa_id' => [
                'required',
                Rule::unique('colaboradores'),
            ],
        ]);
        
        $colaborador = new Colaborador([
            'pessoa_id' => $request->get('pessoa_id')
        ]);
        $colaborador->save();
    
        return redirect('/colaboradores/' . $colaborador->id . '/edit')->with('success', 'Colaborador adicionado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $colaborador = Colaborador::find($id);
        return view('pessoas.colaboradores.edit', compact('colaborador'));
    }

    public function ativarDesativarColaborador(Request $request) {
        $colaborador = Colaborador::find($request->colaborador_id);
        $msg = "Colaborador ativado com sucesso!";
        $situacao = 1;
        if ($colaborador->situacao == 1) {
            $msg = "Colaborador desativado com sucesso!";
            $situacao = 2;
        }
        $colaborador->situacao = $situacao;
        $colaborador->save();

        $dados = array();
        $dados['textoMsg'] = $msg;

        return response()->json($dados, 200);
    }

    public function carregarComboColaboradores()
    {
        return Colaborador::all();
    }

}
