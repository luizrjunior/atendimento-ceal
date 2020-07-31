<?php

namespace App\Http\Controllers\Agendas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Agendamento;

class AgendamentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $agendamentos = Agendamento::all();
        return view('agendas.agendamentos.index', compact('agendamentos'));
    }

    public function create()
    {
        return view('agendas.agendamentos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'atividade_id'=>'required',
            'horario_id'=>'required',
            'data'=>'required|date_format:d/m/Y|after_or_equal:today',
            'numero_vagas_virtual'=>'required|numeric',
            'numero_vagas_presencial'=>'required|numeric',
            'numero_espera_virtual'=>'required|numeric',
            'numero_espera_presencial'=>'required|numeric'
        ]);

        $data = \DateTime::createFromFormat('d/m/Y', $request->data)->format('Y-m-d');
  
        $agendamento = new Agendamento([
            'horario_id' => $request->get('horario_id'),
            'data' => $data,
            'numero_vagas_virtual' => $request->get('numero_vagas_virtual'),
            'numero_vagas_presencial' => $request->get('numero_vagas_presencial'),
            'numero_espera_virtual' => $request->get('numero_espera_virtual'),
            'numero_espera_presencial' => $request->get('numero_espera_presencial')
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
        $request->validate([
            'nome'=>'required|string|max:255|unique:agendamentos,nome,' . $id . ',id',
            'numero'=>'required|string|max:255'
        ]);
  
        $agendamento = Agendamento::find($id);
        $agendamento->nome = strtoupper($request->get('nome'));
        $agendamento->numero = strtoupper($request->get('numero'));
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

}
