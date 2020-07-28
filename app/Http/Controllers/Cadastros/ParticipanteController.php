<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Session;

use App\Models\Horario;
use App\Models\Participante;

class ParticipanteController extends Controller
{
    const MESSAGES_ERRORS = [
        'horario_id.unique' => 'Este colaborador já é participante desta atividade. Por favor, '
            . 'você pode verificar isso?',
    ];

    public function loadParticipantes($horario_id)
    {
        return Participante::where('horario_id', $horario_id)->get();
    }

    public function index()
    {
        Session::put('tela', 'index_participantes');
        
        $horarios = Horario::all();
        return view('cadastros.participantes.index', compact('horarios'));
    }

    public function create()
    {
        $horario_id = Session::get('horario_id');
        $horario = Horario::find($horario_id);

        return view('cadastros.participantes.create', compact('horario'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'horario_id' => [
                'required',
                Rule::unique('participantes')->where(function ($query) use ($request) {
                    $query->where('colaborador_id', "=", $request->colaborador_id);
                }),
            ],
            'colaborador_id' => 'required',
            'funcao_id' => 'required',
        ], self::MESSAGES_ERRORS);
  
        $participante = new Participante([
            'horario_id' => $request->get('horario_id'),
            'colaborador_id'=> $request->get('colaborador_id'),
            'funcao_id'=> $request->get('funcao_id')
        ]);
        $participante->save();

        $msg = "Participante adicionado com sucesso!";
        return redirect('/participantes/' . $request->horario_id . '/edit')->with('success', $msg);
    }

    public function edit($id)
    {
        Session::put('horario_id', $id);

        $horario = Horario::find($id);
        $participantes = Participante::where('horario_id', $id)->get();

        return view('cadastros.participantes.edit', compact('horario', 'participantes'));
    }

    public function destroy(Request $request, $id)
    {
        Participante::where('horario_id', $id)->where('colaborador_id', $request->partic_colaborador_id)->delete();
        return redirect('/participantes/' . $id . '/edit')->with('success', 'Colaborador removido com sucesso!');
    }

}
