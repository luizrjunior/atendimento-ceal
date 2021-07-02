<?php

namespace App\Http\Controllers\Atendimentos;

use Validator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Atendimento;
use App\Models\Horario;
use App\Models\Pessoa;

use Illuminate\Support\Facades\Session;

class AtendimentoAdminController extends Controller
{
    const MESSAGES_ERRORS = [
        'forma.different' => 'O campo Forma de Atendimento precisa ser definido. '
            . 'Por favor, você pode verificar isso?',

        'atendente_id.required' => 'O campo Atendente Responsável precisa ser informado. '
            . 'Por favor, você pode verificar isso?',
    ];

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

        if (empty($data['atendente_id_psq'])) {
            $data['atendente_id_psq'] = "";
        }

        if (empty($data['nome_paciente_psq'])) {
            $data['nome_paciente_psq'] = "";
        }

        $data['totalPage'] = isset($data['totalPage']) ? $data['totalPage'] : 25;

        return $data;
    }

    public function index(Request $request)
    {
        $data = $this->filtrosPesquisa($request);
        $atendimentos = Atendimento::select(
                'atendimentos.id as id', 'atendimentos.situacao as situacao', 'atendimentos.forma as forma', 'atendimentos.data_atendimento as dataAtendimento', 
                'atividades.nome as nomeAtividade', 'horarios.dia_semana as diaSemana', 
                'horarios.hora_inicio as horaInicio', 'horarios.hora_termino as horaTermino', 
                'locais.numero as numeroLocal', 'locais.nome as nomeLocal', 
                'pacientes.nome as nomePaciente', 'atendentes.nome as nomeAtendente')
            ->join('horarios', 'atendimentos.horario_id', 'horarios.id')
            ->join('atividades', 'horarios.atividade_id', 'atividades.id')
            ->join('locais', 'horarios.local_id', 'locais.id')
            ->join('pessoas as pacientes', 'atendimentos.paciente_id', 'pacientes.id')
            ->leftJoin('pessoas as atendentes', 'atendimentos.atendente_id', 'pacientes.id')
            ->where(function ($query) use ($data) {
                $data['data_inicio_psq'] = \DateTime::createFromFormat('d/m/Y', $data['data_inicio_psq'])->format('Y-m-d');
                $data['data_termino_psq'] = \DateTime::createFromFormat('d/m/Y', $data['data_termino_psq'])->format('Y-m-d');

                if ($data['data_inicio_psq'] != "") {
                    $query->where('atendimentos.data_atendimento', '>=', $data['data_inicio_psq'] . ' 00:00:00');
                }
                if ($data['data_termino_psq'] != "") {
                    $query->where('atendimentos.data_atendimento', '<=', $data['data_termino_psq'] . ' 23:59:59');
                }
        
                if ($data['atividade_id_psq'] != "") {
                    $query->where('horarios.atividade_id', $data['atividade_id_psq']);
                }
                if ($data['horario_id_psq'] != "") {
                    $query->where('atendimentos.horario_id', $data['horario_id_psq']);
                }

                if ($data['forma_psq'] != "") {
                    $query->where('atendimentos.forma', $data['forma_psq']);
                }
                if ($data['situacao_psq'] != "") {
                    $query->where('atendimentos.situacao', $data['situacao_psq']);
                }

                if ($data['atendente_id_psq'] != "") {
                    $query->where('atendimentos.atendente_id', $data['atendente_id_psq']);
                }
                if ($data['nome_paciente_psq'] != "") {
                    $query->where('pacientes.nome', 'LIKE', "%" . strtoupper($data['nome_paciente_psq']) . "%");
                }
            })->orderBy('atendimentos.data_atendimento')->orderBy('pacientes.nome')->paginate($data['totalPage']);
            // })->orderBy('pessoas.nome')->toSql();

            // dd($atendimentos);

        return view('atendimentos-admin.index', compact('data', 'atendimentos'));
    }

    public function create()
    {
        Session::put('tela', 'create_atendimento_admin');
        return redirect('/home')->with('success', 'Por gentileza, selecione a Atividade do Atendimento!');
    }

    public function store(Request $request)
    {
        //
    }

    public function edit($id)
    {
        $atendimento = Atendimento::find($id);
        $horario = Horario::find($atendimento->horario_id);
        $paciente = Pessoa::find($atendimento->paciente_id);

        return view('atendimentos-admin.edit', compact('atendimento', 'horario', 'paciente'));
    }

    public function update(Request $request, $id)
    {
        $data_atendimento = \DateTime::createFromFormat('d/m/Y', $request->data_atendimento)->format('Y-m-d');
        $request->validate([
            'horario_id'=>'required',
            'situacao'=>'required',
            'forma'=>'different:forma_validate',
            'atendente_id'=>'required',
            'paciente_id'=>[
                'required',
                Rule::unique('atendimentos')->where(function ($query) use ($request, $id, $data_atendimento) {
                    $query->where('id', "<>", $id)->where('horario_id', "=", $request->horario_id)
                    ->where('data_atendimento', "=", $data_atendimento);
                }),
            ],
            'data_atendimento'=>'required|date_format:d/m/Y|after_or_equal:today'
        ], self::MESSAGES_ERRORS);

        $atendimento = Atendimento::find($id);
        $atendimento->horario_id = $request->get('horario_id');
        $atendimento->situacao = $request->get('situacao');
        $atendimento->forma = $request->get('forma');
        $atendimento->data_atendimento = $data_atendimento;
        $atendimento->atendente_id = $request->get('atendente_id');
        // NÃO É PERMITIDO ALTERAR O PACIENTE
        // $atendimento->paciente_id = $request->get('paciente_id');
        $atendimento->save();
  
        return redirect('/atendimentos-admin/' . $atendimento->id . '/edit')->with('success', 'Atendimento atualizado com sucesso!');
    }

    /**
     * Este metodo de update serve apenas para Cancelar o Atendimento
     *
     * @param Request $request
     * @return void
     */
    public function salvarObservacoesAtendimento(Request $request)
    {
        $request->validate([
            'observacoes'=>'required'
        ]);

        $atendimento = Atendimento::find($request->atendimento_id);
        $atendimento->observacoes = $request->get('observacoes');
        $atendimento->save();

        return redirect('/atendimentos-admin/' . $atendimento->id . '/edit')->with('success', 'Observação salva com sucesso!');
    }

    public function marcarNovoAtendimento(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'forma' => 'different:forma_validate',
            'atendente_id' => 'required',
        ], self::MESSAGES_ERRORS);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $atendimento = Atendimento::find($request->atendimento_id);
        $atendimento->situacao = 4;
        $atendimento->forma = $request->get('forma');
        $atendimento->atendente_id = $request->get('atendente_id');
        $atendimento->save();

        Session::put('tela', 'edit_atendimento_admin');
        Session::put('paciente_id_atendimento_admin', $atendimento->paciente_id);

        $msg = "Atendimento alterado com sucesso!";

        $dados = array();
        $dados['textoMsg'] = $msg;

        return response()->json($dados, 200);
    }

}
