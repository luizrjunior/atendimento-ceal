<?php

namespace App\Http\Controllers\Agendas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Agendamento;
use App\Models\Horario;

class AgendamentoController extends Controller
{
    const MESSAGES_ERRORS = [
        'horario_id.unique' => 'Já existe Horário e Local registrado para esta data.',
        'data_agendamento.after_or_equal' => 'O campo Data deve ser uma data posterior ou igual a Hoje.',
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $agendamentos = Agendamento::with('horario')->get();
        return view('agendas.agendamentos.index', compact('agendamentos'));
    }

    public function create()
    {
        return view('agendas.agendamentos.create');
    }

    public function store(Request $request)
    {
        $data = \DateTime::createFromFormat('d/m/Y', $request->data_agendamento)->format('Y-m-d');

        $request->validate([
            'atividade_id'=>'required',
            'horario_id'=>[
                'required',
                Rule::unique('agendamentos')->where(function ($query) use ($data) {
                    $query->where('situacao', 1)->where('data', "=", $data);
                }),
            ],
            'data_agendamento'=>'required|date_format:d/m/Y|after_or_equal:today',
            'numero_vagas_virtual'=>'required|numeric',
            'numero_vagas_presencial'=>'required|numeric',
            'numero_vagas_distancia'=>'required|numeric',
            'numero_espera_virtual'=>'required|numeric',
            'numero_espera_presencial'=>'required|numeric',
            'numero_espera_distancia'=>'required|numeric'
        ], self::MESSAGES_ERRORS);
  
        $agendamento = new Agendamento([
            'horario_id' => $request->get('horario_id'),
            'data' => $data,
            'numero_vagas_virtual' => $request->get('numero_vagas_virtual'),
            'numero_vagas_presencial' => $request->get('numero_vagas_presencial'),
            'numero_vagas_distancia' => $request->get('numero_vagas_distancia'),
            'numero_espera_virtual' => $request->get('numero_espera_virtual'),
            'numero_espera_presencial' => $request->get('numero_espera_presencial'),
            'numero_espera_distancia' => $request->get('numero_espera_distancia')
        ]);
        $agendamento->save();

        return redirect('/agendamentos/' . $agendamento->id . '/edit')->with('success', 'Agendamento adicionado com sucesso!');
    }

    public function edit($id)
    {
        $agendamento = Agendamento::find($id);
        return view('agendas.agendamentos.edit', compact('agendamento'));
    }

    public function update(Request $request, $id)
    {
        $data = \DateTime::createFromFormat('d/m/Y', $request->data_agendamento)->format('Y-m-d');
        $request->validate([
            'atividade_id'=>'required',
            'horario_id'=>[
                'required',
                Rule::unique('agendamentos')->where(function ($query) use ($id, $data) {
                    $query->where('id', "<>", $id)->where('situacao', 1)->where('data', "=", $data);
                }),
            ],
            'data_agendamento'=>'required|date_format:d/m/Y|after_or_equal:today',
            'numero_vagas_virtual'=>'required|numeric',
            'numero_vagas_presencial'=>'required|numeric',
            'numero_vagas_distancia'=>'required|numeric',
            'numero_espera_virtual'=>'required|numeric',
            'numero_espera_presencial'=>'required|numeric',
            'numero_espera_distancia'=>'required|numeric'
        ], self::MESSAGES_ERRORS);
  
        $agendamento = Agendamento::find($id);
        $agendamento->horario_id = $request->get('horario_id');
        $agendamento->data = $data;
        $agendamento->numero_vagas_virtual = $request->get('numero_vagas_virtual');
        $agendamento->numero_vagas_presencial = $request->get('numero_vagas_presencial');
        $agendamento->numero_vagas_distancia = $request->get('numero_vagas_distancia');
        $agendamento->numero_espera_virtual = $request->get('numero_espera_virtual');
        $agendamento->numero_espera_presencial = $request->get('numero_espera_presencial');
        $agendamento->numero_espera_distancia = $request->get('numero_espera_distancia');
        $agendamento->save();
  
        return redirect('/agendamentos/' . $agendamento->id . '/edit')->with('success', 'Agendamento atualizado com sucesso!');
    }

    public function ativarDesativarAgendamento(Request $request) {
        $agendamento = Agendamento::find($request->agendamento_id);
        $msg = "Agendamento ativado com sucesso!";
        $situacao = 1;
        if ($agendamento->situacao == 1) {
            $msg = "Agendamento desativado com sucesso!";
            $situacao = 2;
        }
        $agendamento->situacao = $situacao;
        $agendamento->save();

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

        return view('agendas.agendamentos.listar-agendamentos', compact('horario', 'agendamentos'));
    }

}
