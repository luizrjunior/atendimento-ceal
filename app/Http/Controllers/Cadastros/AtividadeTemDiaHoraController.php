<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\AtividadeTemDiaHora;

class AtividadeTemDiaHoraController extends Controller
{
    const MESSAGES_ERRORS = [
        'dia_semana.unique' => 'Já existe horário registrado para este dia da semana. Por favor, '
            . 'você pode verificar isso?',
        'hora_termino.after' => 'Hora Término precisa ser uma hora posterior a Hora de Início. Por favor, '
        . 'você pode verificar isso?',
    ];

    public function loadAtividadeTemDiasHoras($atividade_id)
    {
        return AtividadeTemDiaHora::where('atividade_id', $atividade_id)->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'dia_semana' => [
                'required',
                Rule::unique('atividades_tem_dias_horas')->where(function ($query) use ($request) {
                    $query->where('id', "<>", $request->atividade_tem_dia_hora_id)
                        ->where('situacao', "=", 1)
                        ->where('hora_inicio', "<=", $request->hora_inicio . ":00")
                        ->where('hora_termino', ">=", $request->hora_inicio . ":00");
                }),
            ],
            'hora_inicio' => 'required',
            'hora_termino' => 'required|after:hora_inicio',
        ], self::MESSAGES_ERRORS);
        
        if ($request->atividade_tem_dia_hora_id == null) {
            $msg = "Dia e Hora adicionado com sucesso!";
            $atividade_has_role = new AtividadeTemDiaHora([
                'atividade_id' => $request->get('atividade_id'),
                'dia_semana'=> $request->get('dia_semana'),
                'hora_inicio'=> $request->get('hora_inicio'),
                'hora_termino'=> $request->get('hora_termino')
            ]);
        } else {
            $msg = "Dia e Hora alterado com sucesso!";
            $atividade_has_role = AtividadeTemDiaHora::find($request->atividade_tem_dia_hora_id);
            $atividade_has_role->dia_semana = $request->get('dia_semana');
            $atividade_has_role->hora_inicio = $request->get('hora_inicio');
            $atividade_has_role->hora_termino = $request->get('hora_termino');
        }
        $atividade_has_role->save();

        return redirect('/atividades/' . $request->atividade_id . '/edit')->with('success', $msg);
    }

    public function edit(Request $request)
    {
        $atividade_tem_dia_hora = AtividadeTemDiaHora::find($request->atividade_tem_dia_hora_id);
        return response()->json($atividade_tem_dia_hora, 200);
    }

    public function ativarDesativarAtividadeTemDiaHora(Request $request) {
        $atividade_tem_dia_hora = AtividadeTemDiaHora::find($request->atividade_tem_dia_hora_id);
        $msg = "Dia Hora da Atividade ativada com sucesso!";
        $situacao = 1;
        if ($atividade_tem_dia_hora->situacao == 1) {
            $msg = "Dia Hora da Atividade desativada com sucesso!";
            $situacao = 2;
        }
        $atividade_tem_dia_hora->situacao = $situacao;
        $atividade_tem_dia_hora->save();

        $dados = array();
        $dados['textoMsg'] = $msg;

        return response()->json($dados, 200);
    }

}
