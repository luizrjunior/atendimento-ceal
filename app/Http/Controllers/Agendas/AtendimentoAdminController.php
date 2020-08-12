<?php

namespace App\Http\Controllers\Agendas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
            })->orderBy('pessoas.nome')->paginate($data['totalPage']);
            // })->orderBy('pessoas.nome')->toSql();

            // dd($atendimentos);

        return view('agendas.atendimentos-admin.index', compact('data', 'atendimentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $atendimento = Atendimento::find($id);
        $agendamento = Agendamento::find($atendimento->agendamento_id);
        $pessoa = Pessoa::find($atendimento->pessoa_id);

        return view('agendas.atendimentos-admin.edit', compact('agendamento', 'pessoa', 'atendimento'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
