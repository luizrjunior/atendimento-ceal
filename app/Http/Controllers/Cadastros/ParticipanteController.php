<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Session;

use App\Models\Atividade;
use App\Models\Horario;
use App\Models\Participante;

class ParticipanteController extends Controller
{
    const MESSAGES_ERRORS = [
        'dia_semana.unique' => 'Já existe horário registrado para este dia da semana. Por favor, '
            . 'você pode verificar isso?',
        'hora_termino.after' => 'Hora Término precisa ser uma hora posterior a Hora de Início. Por favor, '
        . 'você pode verificar isso?',
    ];

    public function loadParticipantes($horario_id)
    {
        return Participante::where('horario_id', $horario_id)->get();
    }

    public function index()
    {
        $atividade_id = Session::get('atividade_id');
        $atividade = Atividade::find($atividade_id);
        
        $horario_id = Session::get('horario_id');
        $horario = Horario::find($horario_id);

        $diasHorasLocaisTemParticipantes = Participante::where('atividade_id', $atividade_id)->get();
        return view('cadastros.dias-horas-locais-tem-participantes.index', compact('atividade', 'horario', 'diasHorasLocaisTemParticipantes'));
    }

    public function create()
    {
        $atividade_id = Session::get('atividade_id');
        $atividade = Atividade::find($atividade_id);

        return view('cadastros.dias-horas-locais-tem-participantes.create', compact('atividade'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dia_semana' => [
                'required',
                Rule::unique('atividades_tem_dias_horas_locais')->where(function ($query) use ($request) {
                    $query->where('situacao', "=", 1)
                        ->where('local_id', "=", $request->local_id)
                        ->where('hora_inicio', "<=", $request->hora_inicio . ":00")
                        ->where('hora_termino', ">=", $request->hora_inicio . ":00");
                }),
            ],
            'hora_inicio' => 'required',
            'hora_termino' => 'required|after:hora_inicio',
            'local_id' => 'required',
        ], self::MESSAGES_ERRORS);
  
        $horario = new Participante([
            'atividade_id' => $request->get('atividade_id'),
            'dia_semana'=> $request->get('dia_semana'),
            'hora_inicio'=> $request->get('hora_inicio'),
            'hora_termino'=> $request->get('hora_termino'),
            'local_id'=> $request->get('local_id')
        ]);
        $horario->save();

        $msg = "Dia, Hora e Local adicionado com sucesso!";
        return redirect('/dias-horas-locais-tem-participantes/' . $horario->id . '/edit')->with('success', $msg);
    }

    public function edit($id)
    {
        Session::put('horario_id', $id);
        $atividade_id = Session::get('atividade_id');
        $atividade = Atividade::find($atividade_id);
        
        $horario = Participante::find($id);
        return view('cadastros.dias-horas-locais-tem-participantes.edit', compact('atividade', 'horario'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'dia_semana' => [
                'required',
                Rule::unique('atividades_tem_dias_horas_locais')->where(function ($query) use ($request, $id) {
                    $query->where('id', "<>", $id)
                        ->where('situacao', "=", 1)
                        ->where('local_id', "=", $request->local_id)
                        ->where('hora_inicio', "<=", $request->hora_inicio . ":00")
                        ->where('hora_termino', ">=", $request->hora_inicio . ":00");
                }),
            ],
            'hora_inicio' => 'required',
            'hora_termino' => 'required|after:hora_inicio',
            'local_id' => 'required',
        ], self::MESSAGES_ERRORS);
  
        $horario = Participante::find($id);
        $horario->dia_semana = $request->get('dia_semana');
        $horario->hora_inicio = $request->get('hora_inicio');
        $horario->hora_termino = $request->get('hora_termino');
        $horario->local_id = $request->get('local_id');
        $horario->save();

        $msg = "Dia, Horário e Local alterado com sucesso!";
        return redirect('/dias-horas-locais-tem-participantes/' . $horario->id . '/edit')->with('success', $msg);
    }

    public function ativarDesativarParticipante(Request $request) {
        $atividade_tem_dia_hora = Participante::find($request->horario_id);
        $msg = "Dia, Hora e Local da Atividade ativada com sucesso!";
        $situacao = 1;
        if ($atividade_tem_dia_hora->situacao == 1) {
            $msg = "Dia, Hora e Local da Atividade desativada com sucesso!";
            $situacao = 2;
        }
        $atividade_tem_dia_hora->situacao = $situacao;
        $atividade_tem_dia_hora->save();

        $dados = array();
        $dados['textoMsg'] = $msg;

        return response()->json($dados, 200);
    }

}
