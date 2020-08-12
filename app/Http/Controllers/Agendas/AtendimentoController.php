<?php

namespace App\Http\Controllers\Agendas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;

use App\Models\Agendamento;
use App\Models\Atendimento;
use App\Models\Horario;
use App\Models\Pessoa;

class AtendimentoController extends Controller
{
    const MESSAGES_ERRORS = [
        'pessoa_id.unique' => 'Já existe atendimento registrado para este dia da semana. Por favor, '
            . 'você pode verificar isso?',
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $atendimentos = Atendimento::where('pessoa_id', Session::get('pessoa_id'))->get();
        return view('agendas.atendimentos.index', compact('atendimentos'));
    }

    public function indexAdmin()
    {
        $atendimentos = Agendamento::all();
        return view('agendas.atendimentos.index', compact('atendimentos'));
    }

    public function abrirCreate(Request $request)
    {
        Session::put('agendamento_id', $request->agendamento_id);
        Session::put('situacao', $request->situacao);
        Session::put('forma', $request->forma);

        return redirect('/atendimentos/create');
    }

    public function create()
    {
        $agendamento_id = Session::get('agendamento_id');
        $agendamento = Agendamento::find($agendamento_id);

        $situacao = Session::get('situacao');
        $forma = Session::get('forma');
        
        $pessoa_id = Session::get('pessoa_id');
        $pessoa = Pessoa::find($pessoa_id);
        
        return view('agendas.atendimentos.create', compact('agendamento', 'situacao', 'forma', 'pessoa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'agendamento_id'=>'required',
            'situacao'=>'required',
            'forma'=>'required',
            'pessoa_id'=>[
                'required',
                Rule::unique('atendimentos')->where(function ($query) use ($request) {
                    $query->where('agendamento_id', "=", $request->agendamento_id);
                }),
            ]
        ], self::MESSAGES_ERRORS);

        $atendimento = new Atendimento([
            'agendamento_id' => $request->get('agendamento_id'),
            'situacao' => $request->get('situacao'),
            'forma' => $request->get('forma'),
            'pessoa_id' => $request->get('pessoa_id')
        ]);
        $atendimento->save();

        return redirect('/atendimentos/' . $atendimento->id . '/edit')->with('success', 'Atendimento adicionado com sucesso!');
    }

    public function edit($id)
    {
        $atendimento = Atendimento::find($id);
        $agendamento = Agendamento::find($atendimento->agendamento_id);
        $pessoa = Pessoa::find($atendimento->pessoa_id);

        return view('agendas.atendimentos.edit', compact('agendamento', 'pessoa', 'atendimento'));
    }

    public function editAdmin($id)
    {
        $atendimento = Atendimento::find($id);
        $agendamento = Agendamento::find($atendimento->agendamento_id);
        $pessoa = Pessoa::find($atendimento->pessoa_id);

        return view('agendas.atendimentos.edit', compact('agendamento', 'pessoa', 'atendimento'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'agendamento_id'=>'required',
            'situacao'=>'required',
            'forma'=>'required',
            'pessoa_id'=>[
                'required',
                Rule::unique('atendimentos')->where(function ($query) use ($request, $id) {
                    $query->where('id', "<>", $id)->where('agendamento_id', "=", $request->agendamento_id);
                }),
            ]
        ]);
  
        $atendimento = Atendimento::find($id);
        $atendimento->agendamento_id = $request->get('agendamento_id');
        $atendimento->situacao = $request->get('situacao');
        $atendimento->forma = $request->get('forma');
        $atendimento->pessoa_id = $request->get('pessoa_id');
        $atendimento->save();
  
        return redirect('/atendimentos/' . $atendimento->id . '/edit')->with('success', 'Atendimento atualizado com sucesso!');
    }

    public function ativarDesativarAtendimento(Request $request) {
        $atendimento = Atendimento::find($request->atendimento_id);
        $msg = "Atendimento ativado com sucesso!";
        $situacao = 1;
        if ($atendimento->situacao == 1) {
            $msg = "Atendimento desativado com sucesso!";
            $situacao = 2;
        }
        $atendimento->situacao = $situacao;
        $atendimento->save();

        $dados = array();
        $dados['textoMsg'] = $msg;

        return response()->json($dados, 200);
    }

    public function carregarComboLocais()
    {
        return Agendamento::all();
    }

    public function listarAgendamentosPorHorario(Request $request)
    {
        $horario_id = $request->horario_id;
        $horario = Horario::find($horario_id);

        $agendamentos = Agendamento::where('horario_id', $horario_id)->where('situacao', 1)->get();

        return view('agendas.atendimentos.listar-agendamentos', compact('horario', 'agendamentos'));
    }

    public function numeroVagasAtendimento($agendamento_id, $forma, $situacao)
    {
        $atendimentos = Atendimento::where('agendamento_id', $agendamento_id)
            ->where('forma', $forma)->where('situacao', $situacao)->get();
        return count($atendimentos);
    }

}
