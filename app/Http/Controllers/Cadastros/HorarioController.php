<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Session;

use App\Models\Atividade;
use App\Models\Horario;

class HorarioController extends Controller
{
    const MESSAGES_ERRORS = [
        'dia_semana.unique' => 'Já existe horário registrado para este dia da semana. Por favor, '
            . 'você pode verificar isso?',
        'hora_termino.after' => 'Hora Término precisa ser uma hora posterior a Hora de Início. Por favor, '
        . 'você pode verificar isso?',
    ];

    public function loadHorarios($atividade_id)
    {
        return Horario::where('atividade_id', $atividade_id)->get();
    }

    public function index()
    {
        $atividade_id = Session::get('atividade_id');
        $atividade = Atividade::find($atividade_id);

        $horarios = Horario::where('atividade_id', $atividade_id)->get();
        return view('cadastros.horarios.index', compact('atividade', 'horarios'));
    }

    public function create()
    {
        $atividade_id = Session::get('atividade_id');
        $atividade = Atividade::find($atividade_id);

        return view('cadastros.horarios.create', compact('atividade'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dia_semana' => [
                'required',
                Rule::unique('horarios')->where(function ($query) use ($request) {
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
  
        $horario = new Horario([
            'atividade_id' => $request->get('atividade_id'),
            'dia_semana'=> $request->get('dia_semana'),
            'hora_inicio'=> $request->get('hora_inicio'),
            'hora_termino'=> $request->get('hora_termino'),
            'local_id'=> $request->get('local_id')
        ]);
        $horario->save();

        $msg = "Horário e Local adicionado com sucesso!";
        return redirect('/horarios/' . $horario->id . '/edit')->with('success', $msg);
    }

    public function edit($id)
    {
        Session::put('tela', 'edit_horario');
        Session::put('horario_id', $id);
        $atividade_id = Session::get('atividade_id');
        $atividade = Atividade::find($atividade_id);
        
        $horario = Horario::find($id);
        return view('cadastros.horarios.edit', compact('atividade', 'horario'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'dia_semana' => [
                'required',
                Rule::unique('horarios')->where(function ($query) use ($request, $id) {
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
  
        $horario = Horario::find($id);
        $horario->dia_semana = $request->get('dia_semana');
        $horario->hora_inicio = $request->get('hora_inicio');
        $horario->hora_termino = $request->get('hora_termino');
        $horario->local_id = $request->get('local_id');
        $horario->save();

        $msg = "Horário e Local alterado com sucesso!";
        return redirect('/horarios/' . $horario->id . '/edit')->with('success', $msg);
    }

    public function ativarDesativarHorario(Request $request) {
        $horario = Horario::find($request->horario_id);
        $msg = "Horário e Local ativado com sucesso!";
        $situacao = 1;
        if ($horario->situacao == 1) {
            $msg = "Horário e Local desativado com sucesso!";
            $situacao = 2;
        }
        $horario->situacao = $situacao;
        $horario->save();

        $dados = array();
        $dados['textoMsg'] = $msg;

        return response()->json($dados, 200);
    }

}
