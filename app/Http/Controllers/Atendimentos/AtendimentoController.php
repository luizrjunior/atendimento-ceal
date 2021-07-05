<?php

namespace App\Http\Controllers\Atendimentos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;

use App\Models\Agendamento;
use App\Models\Atendimento;
use App\Models\Horario;
use App\Models\Pessoa;

class AtendimentoController extends Controller
{
    const MESSAGES_ERRORS = [
        'forma.different' => 'O campo Forma de Atendimento precisa ser definido. '
            . 'Por favor, você pode verificar isso?',

        'paciente_id.required' => 'Não encontramos a Pessoa Atendida/Paciente. Por favor, '
            . 'você pode verificar isso? Clique em buscar.',

        'paciente_id.unique' => 'Permissão Negada! Já existe atendimento registrado para este dia da semana. Por favor, '
            . 'você pode verificar isso?',
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $atendimentos = Atendimento::where('paciente_id', Session::get('pessoa_id'))->orderBy('data_atendimento')->get();
        return view('atendimentos.index', compact('atendimentos'));
    }

    public function historico($paciente_id)
    {
        $atendimentos = Atendimento::where('paciente_id', $paciente_id)->orderBy('data_atendimento')->get();
        return $atendimentos;
    }

    public function abrirCreate(Request $request)
    {
        Session::put('horario_id', $request->horario_id);
        Session::put('situacao', $request->situacao);
        Session::put('data_atendimento', $request->data_atendimento);
        Session::put('paciente_id', Session::get('pessoa_id'));
        Session::put('create_atendimento_admin_paciente_id', '');

        return redirect('/atendimentos/create');
    }

    public function create()
    {
        $horario_id = Session::get('horario_id');
        $situacao = Session::get('situacao');
        $data_atendimento = Session::get('data_atendimento');
        $paciente_id = Session::get('paciente_id');

        $horario = Horario::find($horario_id);
        $paciente = Pessoa::find($paciente_id);

        if (Session::get('tela') == 'create_atendimento_admin') {
            $paciente_id = null;
            $paciente = new Pessoa();
            if (Session::get('create_atendimento_admin_paciente_id') != '') {
                $paciente_id = Session::get('create_atendimento_admin_paciente_id');
                $paciente = Pessoa::find($paciente_id);
            }
        }
        if (Session::get('tela') == 'edit_atendimento_admin') {
            $paciente_id = Session::get('paciente_id_atendimento_admin');
            $paciente = Pessoa::find($paciente_id);
        }

        return view('atendimentos.create', compact('horario', 'situacao', 'data_atendimento', 'paciente'));
    }

    public function store(Request $request)
    {
        $data_atendimento = \DateTime::createFromFormat('d/m/Y', $request->data_atendimento)->format('Y-m-d');
        $request->validate([
            'horario_id' => 'required',
            'situacao' => 'required',
            'paciente_id' => [
                'required',
                Rule::unique('atendimentos')->where(function ($query) use ($request, $data_atendimento) {
                    $query->where('horario_id', "=", $request->horario_id)
                        ->where('data_atendimento', "=", $data_atendimento);
                }),
            ],
            'data_atendimento' => 'required|date_format:d/m/Y|after_or_equal:today',
        ], self::MESSAGES_ERRORS);

        $atendimento = new Atendimento([
            'horario_id' => $request->get('horario_id'),
            'situacao' => $request->get('situacao'),
            'forma' => $request->get('forma'),
            'data_atendimento' => $data_atendimento,
            'paciente_id' => $request->get('paciente_id')
        ]);
        $atendimento->save();

        Session::put('horario_id', $request->horario_id);
        Session::put('situacao', $request->situacao);
        Session::put('data_atendimento', $request->data_atendimento);
        Session::put('paciente_id', $request->paciente_id);

        return redirect('/atendimentos/' . $atendimento->id . '/edit')->with('success', 'Atendimento adicionado com sucesso!');
    }

    public function edit($id)
    {
        $atendimento = Atendimento::find($id);
        $horario = Horario::find($atendimento->horario_id);
        $paciente = Pessoa::find($atendimento->paciente_id);

        return view('atendimentos.edit', compact('horario', 'paciente', 'atendimento'));
    }

    public function editAdmin($id)
    {
        $atendimento = Atendimento::find($id);
        $horario = Horario::find($atendimento->horario_id);
        $paciente = Pessoa::find($atendimento->paciente_id);

        return view('atendimentos.edit', compact('horario', 'paciente', 'atendimento'));
    }

    /**
     * Este metodo de update serve apenas para Cancelar o Atendimento
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $data_atendimento = \DateTime::createFromFormat('d/m/Y', $request->data_atendimento)->format('Y-m-d');
        $request->validate([
            'horario_id' => 'required',
            'situacao' => 'required',
            'paciente_id' => [
                'required',
                Rule::unique('atendimentos')->where(function ($query) use ($request, $id, $data_atendimento) {
                    $query->where('id', "<>", $id)->where('horario_id', "=", $request->horario_id)
                        ->where('data_atendimento', "=", $data_atendimento);
                }),
            ],
            'data_atendimento' => 'required|date_format:d/m/Y|after_or_equal:today',
        ]);

        $atendimento = Atendimento::find($id);
        $atendimento->horario_id = $request->get('horario_id');
        $atendimento->situacao = 3;//ATENDIMENTO CANCELADO
        $atendimento->forma = $request->get('forma');
        $atendimento->data_atendimento = $data_atendimento;
        $atendimento->paciente_id = $request->get('paciente_id');
        $atendimento->save();

        return redirect('/atendimentos/' . $atendimento->id . '/edit')->with('success', 'Atendimento alterado com sucesso!');
    }

    public function ativarDesativarAtendimento(Request $request)
    {
        $atendimento = Atendimento::find($request->atendimento_id);
        $msg = "Atendimento ativado com sucesso!";
        $situacao = 1;
        if ($atendimento->situacao == 1) {
            $msg = "Atendimento desativado com sucesso!";
            $situacao = 2;
        }
        $atendimento->situacao = $situacao;
        $atendimento->save();

        $dados = array();
        $dados['textoMsg'] = $msg;

        return response()->json($dados, 200);
    }

    public function carregarComboLocais()
    {
        return Agendamento::all();
    }

    public function listarAgendamentosPorHorario(Request $request)
    {
        $horario_id = $request->horario_id;
        $horario = Horario::find($horario_id);

        $agendamentos = Agendamento::where('horario_id', $horario_id)->where('situacao', 1)->get();

        return view('atendimentos.listar-agendamentos', compact('horario', 'agendamentos'));
    }

    public function numeroVagasAtendimento($horario_id, $situacao, $data_atendimento)
    {
        $data_atendimento = \DateTime::createFromFormat('d/m/Y', $data_atendimento)->format('Y-m-d');
        $atendimentos = Atendimento::where('horario_id', $horario_id)
            ->where('situacao', $situacao)->where('data_atendimento', $data_atendimento)->get();
        return count($atendimentos);
    }

}
