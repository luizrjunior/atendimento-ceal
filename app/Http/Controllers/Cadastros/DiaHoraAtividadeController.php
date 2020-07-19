<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\DiaHoraAtividade;

class DiaHoraAtividadeController extends Controller
{
    const MESSAGES_ERRORS = [
        'dia_semana.unique' => 'Já existe horário registrado para este dia da semana. Por favor, '
            . 'você pode verificar isso?',
        'hora_termino.after' => 'Hora Término precisa ser uma hora posterior a Hora de Início. Por favor, '
        . 'você pode verificar isso?',
    ];

    public function loadDiasHorasAtividade($atividade_id)
    {
        return DiaHoraAtividade::where('atividade_id', $atividade_id)->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'dia_semana' => [
                'required',
                Rule::unique('dias_horas_atividades')->where(function ($query) use ($request) {
                    $query->where('id', "<>", $request->dia_hora_atividade_id)
                        ->where('situacao', "=", 1)
                        ->where('hora_inicio', "<=", $request->hora_inicio . ":00")
                        ->where('hora_termino', ">=", $request->hora_inicio . ":00");
                }),
            ],
            'hora_inicio' => 'required',
            'hora_termino' => 'required|after:hora_inicio',
        ], self::MESSAGES_ERRORS);
        
        if ($request->dia_hora_atividade_id == null) {
            $msg = "Dia e Hora adicionado com sucesso!";
            $atividade_has_role = new DiaHoraAtividade([
                'atividade_id' => $request->get('atividade_id'),
                'dia_semana'=> $request->get('dia_semana'),
                'hora_inicio'=> $request->get('hora_inicio'),
                'hora_termino'=> $request->get('hora_termino')
            ]);
        } else {
            $msg = "Dia e Hora alterado com sucesso!";
            $atividade_has_role = DiaHoraAtividade::find($request->dia_hora_atividade_id);
            $atividade_has_role->dia_semana = $request->get('dia_semana');
            $atividade_has_role->hora_inicio = $request->get('hora_inicio');
            $atividade_has_role->hora_termino = $request->get('hora_termino');
        }
        $atividade_has_role->save();

        return redirect('/atividades/' . $request->atividade_id . '/edit')->with('success', $msg);
    }

    public function edit(Request $request)
    {
        $dia_hora_atividade = DiaHoraAtividade::find($request->dia_hora_atividade_id);
        return response()->json($dia_hora_atividade, 200);
    }

    public function ativarDesativarDiaHoraAtividade(Request $request) {
        $dia_hora_atividade = DiaHoraAtividade::find($request->dia_hora_atividade_id);
        $msg = "Dia Hora da Atividade ativada com sucesso!";
        $situacao = 1;
        if ($dia_hora_atividade->situacao == 1) {
            $msg = "Dia Hora da Atividade desativada com sucesso!";
            $situacao = 2;
        }
        $dia_hora_atividade->situacao = $situacao;
        $dia_hora_atividade->save();

        $dados = array();
        $dados['textoMsg'] = $msg;

        return response()->json($dados, 200);
    }

}
