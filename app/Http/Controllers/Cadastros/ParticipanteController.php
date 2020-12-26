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
        return Participante::join('colaboradores', 'participantes.colaborador_id', 'colaboradores.id')
            ->join('pessoas', 'colaboradores.pessoa_id', 'pessoas.id')
            ->where('participantes.horario_id', $horario_id)->orderBy('pessoas.nome')->get();
    }

    public function index()
    {
        Session::put('tela', 'index_participantes');

        $horarios = Horario::orderBy('dia_semana')->orderBy('hora_inicio')->get();

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

        return redirect('/participantes/search');
    }

    public function destroy(Request $request)
    {
        Participante::where('horario_id', $request->horario_id)->where('colaborador_id', $request->partic_colaborador_id)->delete();

        $msg = "Participante removido com sucesso!";

        $dados = array();
        $dados['textoMsg'] = $msg;

        return response()->json($dados, 200);
    }

    private function filtrosPesquisa($request)
    {
        $data = $request->except('_token');
        if (empty($data['nome_psq'])) {
            $data['nome_psq'] = "";
        }

        if (empty($data['funcao_id_psq'])) {
            $data['funcao_id_psq'] = "";
        }

        $data['totalPage'] = isset($data['totalPage']) ? $data['totalPage'] : 25;

        return $data;
    }

    public function search(Request $request)
    {
        $horario_id = Session::get('horario_id');

        $data = $this->filtrosPesquisa($request);
        $horario = Horario::find($horario_id);
        $participantes = Participante::join('colaboradores', 'participantes.colaborador_id', 'colaboradores.id')
            ->join('pessoas', 'colaboradores.pessoa_id', 'pessoas.id')
            ->where('horario_id', $horario_id)
            ->where(function ($query) use ($data) {
                if ($data['nome_psq'] != "") {
                    $query->where('pessoas.nome', 'LIKE', "%" . strtoupper($data['nome_psq']) . "%");
                }
                if ($data['funcao_id_psq'] != "") {
                    $query->where('participantes.funcao_id', $data['funcao_id_psq']);
                }
            })->orderBy('pessoas.nome')->paginate($data['totalPage']);

        return view('cadastros.participantes.edit', compact('horario', 'participantes', 'data'));
    }

}
