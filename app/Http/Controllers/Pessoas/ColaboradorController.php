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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colaboradores = Colaborador::all();
        return view('pessoas.colaboradores.index', compact('colaboradores'));
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

}
