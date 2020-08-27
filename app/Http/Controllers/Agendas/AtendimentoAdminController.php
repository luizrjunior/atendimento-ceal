<?php

namespace App\Http\Controllers\Agendas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Atendimento;
use App\Models\Agendamento;
use App\Models\Pessoa;

class AtendimentoAdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    private function filtrosPesquisa($request)
    {
        $data = $request->except('_token');

        if (empty($data['data_inicio_psq'])) {
            $data['data_inicio_psq'] = \DateTime::createFromFormat('d/m/Y', date('d/m/Y'))->format('d/m/Y');
        }

        if (empty($data['data_termino_psq'])) {
            $timestamp = strtotime("15 days");
            $data['data_termino_psq'] = \DateTime::createFromFormat('d/m/Y', date('d/m/Y', $timestamp))->format('d/m/Y');
        }

        if (empty($data['atividade_id_psq'])) {
            $data['atividade_id_psq'] = "";
        }

        if (empty($data['horario_id_psq'])) {
            $data['horario_id_psq'] = "";
        }

        if (empty($data['forma_psq'])) {
            $data['forma_psq'] = "";
        }

        if (empty($data['situacao_psq'])) {
            $data['situacao_psq'] = "";
        }

        if (empty($data['colaborador_id_psq'])) {
            $data['colaborador_id_psq'] = "";
        }

        if (empty($data['nome_psq'])) {
            $data['nome_psq'] = "";
        }

        $data['totalPage'] = isset($data['totalPage']) ? $data['totalPage'] : 25;

        return $data;
    }

    public function index(Request $request)
    {
        $data = $this->filtrosPesquisa($request);
        $atendimentos = Atendimento::select(
                'atendimentos.id as id', 'atendimentos.situacao as situacao', 'atendimentos.forma as forma', 'agendamentos.data as dataAgendamento', 
                'atividades.nome as nomeAtividade', 'horarios.dia_semana as diaSemana', 
                'horarios.hora_inicio as horaInicio', 'horarios.hora_termino as horaTermino', 
                'locais.numero as numeroLocal', 'locais.nome as nomeLocal', 
                'pessoas.nome as nomeAtendido')
            ->join('agendamentos', 'atendimentos.agendamento_id', 'agendamentos.id')
            ->join('horarios', 'agendamentos.horario_id', 'horarios.id')
            ->join('atividades', 'horarios.atividade_id', 'atividades.id')
            ->join('locais', 'horarios.local_id', 'locais.id')
            ->join('pessoas', 'atendimentos.pessoa_id', 'pessoas.id')
            ->where(function ($query) use ($data) {
                $data['data_inicio_psq'] = \DateTime::createFromFormat('d/m/Y', $data['data_inicio_psq'])->format('Y-m-d');
                $data['data_termino_psq'] = \DateTime::createFromFormat('d/m/Y', $data['data_termino_psq'])->format('Y-m-d');

                if ($data['data_inicio_psq'] != "") {
                    $query->where('agendamentos.data', '>=', $data['data_inicio_psq'] . ' 00:00:00');
                }
                if ($data['data_termino_psq'] != "") {
                    $query->where('agendamentos.data', '<=', $data['data_termino_psq'] . ' 23:59:59');
                }
        
                if ($data['atividade_id_psq'] != "") {
                    $query->where('horarios.atividade_id', $data['atividade_id_psq']);
                }
                if ($data['horario_id_psq'] != "") {
                    $query->where('agendamentos.horario_id', $data['horario_id_psq']);
                }

                if ($data['forma_psq'] != "") {
                    $query->where('atendimentos.situacao', $data['forma_psq']);
                }
                if ($data['situacao_psq'] != "") {
                    $query->where('atendimentos.situacao', $data['situacao_psq']);
                }

                if ($data['colaborador_id_psq'] != "") {
                    $query->where('atendimentos.colaborador_id', $data['colaborador_id_psq']);
                }
                if ($data['nome_psq'] != "") {
                    $query->where('pessoas.nome', 'LIKE', "%" . strtoupper($data['nome_psq']) . "%");
                }
            })->orderBy('agendamentos.data', 'DESC')->orderBy('pessoas.nome')->paginate($data['totalPage']);
            // })->orderBy('pessoas.nome')->toSql();

            // dd($atendimentos);

        return view('agendas.atendimentos-admin.index', compact('data', 'atendimentos'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function edit($id)
    {
        $atendimento = Atendimento::find($id);
        $agendamento = Agendamento::find($atendimento->agendamento_id);
        $pessoa = Pessoa::find($atendimento->pessoa_id);

        return view('agendas.atendimentos-admin.edit', compact('agendamento', 'pessoa', 'atendimento'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'agendamento_id'=>'required',
            'situacao'=>'required',
            'forma'=>'required',
            'colaborador_id'=>'required',
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
        $atendimento->colaborador_id = $request->get('colaborador_id');
        $atendimento->pessoa_id = $request->get('pessoa_id');
        $atendimento->save();
  
        return redirect('/atendimentos-admin/' . $atendimento->id . '/edit')->with('success', 'Atendimento atualizado com sucesso!');
    }

}
