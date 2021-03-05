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
        'dia_semana.unique' => 'Este Horário ou Local já está sendo utilizado neste dia da semana. Por favor, '
            . 'você pode verificar isso?',
        'hora_termino.after' => 'Hora Término precisa ser uma hora posterior a Hora de Início. Por favor, '
        . 'você pode verificar isso?',
    ];

    public function index()
    {
        $atividade_id = Session::get('atividade_id');
        $atividade = Atividade::find($atividade_id);

        $horarios = Horario::where('atividade_id', $atividade_id)->orderBy('dia_semana')->orderBy('hora_inicio')->get();
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
            'numero_vagas'=>'required|numeric',
            'numero_vagas_espera'=>'required|numeric',
        ], self::MESSAGES_ERRORS);

        $horario = new Horario([
            'atividade_id' => $request->get('atividade_id'),
            'dia_semana'=> $request->get('dia_semana'),
            'hora_inicio'=> $request->get('hora_inicio'),
            'hora_termino'=> $request->get('hora_termino'),
            'local_id'=> $request->get('local_id'),
            'numero_vagas' => $request->get('numero_vagas'),
            'numero_vagas_espera' => $request->get('numero_vagas_espera'),
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
            'numero_vagas'=>'required|numeric',
            'numero_vagas_espera'=>'required|numeric',
        ], self::MESSAGES_ERRORS);

        $horario = Horario::find($id);
        $horario->dia_semana = $request->get('dia_semana');
        $horario->hora_inicio = $request->get('hora_inicio');
        $horario->hora_termino = $request->get('hora_termino');
        $horario->local_id = $request->get('local_id');
        $horario->numero_vagas = $request->get('numero_vagas');
        $horario->numero_vagas_espera = $request->get('numero_vagas_espera');
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

    public function loadHorarios($atividade_id)
    {
        return Horario::where('atividade_id', $atividade_id)->orderBy('dia_semana')->orderBy('hora_inicio')->get();
    }

    public function carregarHorariosAtividadeJson(Request $request)
    {
        $horarios = Horario::select('horarios.id as id', 'horarios.dia_semana', 'horarios.hora_inicio',
            'horarios.hora_termino', 'locais.numero', 'locais.nome')
            ->where('horarios.atividade_id', $request->atividade_id)->where('horarios.situacao', 1)
            ->join('locais', 'horarios.local_id', 'locais.id')->get();

        return response()->json($horarios, 200);
    }

    public function listarHorariosPorAtividade(Request $request)
    {
        $arrDiaSemana = array(
            '1' => "SEGUNDA-FEIRA",
            '2' => "TERÇA-FEIRA",
            '3' => "QUARTA-FEIRA",
            '4' => "QUINTA-FEIRA",
            '5' => "SEXTA-FEIRA",
            '6' => "SÁBADO",
            '7' => "DOMINGO",
        );

        $atividade_id = $request->atividade_id;
        $atividade = Atividade::find($atividade_id);

        /**
         * 1º - FAZES LOOP DE 30 DIAS A PARTIR DA DATA ATUAL
         * 2º - PEGAR SOMENTE AS DATAS EM QUE O DIA DA SEMANA CORRESPONDENTE AO DIA SELECINADO PELO USUARIO
         */

        $dtInicial = date('d/m/Y');
        $dtFinal = date("d/m/Y", mktime(0, 0, 0, (date('m') + 1), 0, date('Y')));

        //Star date
        $dateStart = $this->transformDate($dtInicial);
        //End date
        $dateEnd = $this->transformDate($dtFinal);

        //Prints days according to the interval
        $dateRanges = array();
        $datas = array();
        $i = 0;
        while ($dateStart <= $dateEnd) {
            $dateWeed = $dateStart->format('D');
            $horario = $this->selecionarHorarioPorAtividadePorDiaSemana($atividade_id, $dateWeed);

            if (count($horario) > 0) {
                $texto1 = 'Dia ' . $dateStart->format('d/m/Y') . ' - ' . $arrDiaSemana[$horario[0]->dia_semana];
                $texto2 = 'De ' . substr($horario[0]->hora_inicio, 0, -3) . ' horas até ' . substr($horario[0]->hora_termino, 0, -3) . ' horas';
                $texto3 = 'Local: ' . $horario[0]->local->nome . ' - ' . $horario[0]->local->numero;
                $datas[$i]['horario_id'] = $horario[0]->id;
                $datas[$i]['data_atendimento'] = $dateStart->format('d/m/Y');
                $datas[$i]['numero_vagas'] = $horario[0]->numero_vagas;
                $datas[$i]['numero_vagas_espera'] = $horario[0]->numero_vagas_espera;
                if ($horario[0]->dia_semana == 1 && $dateWeed == 'Mon') {
                    $datas[$i]['texto1'] = $texto1;
                    $datas[$i]['texto2'] = $texto2;
                    $datas[$i]['texto3'] = $texto3;
                }
                if ($horario[0]->dia_semana == 2 && $dateWeed == 'Tue') {
                    $datas[$i]['texto1'] = $texto1;
                    $datas[$i]['texto2'] = $texto2;
                    $datas[$i]['texto3'] = $texto3;
                }
                if ($horario[0]->dia_semana == 3 && $dateWeed == 'Wed') {
                    $datas[$i]['texto1'] = $texto1;
                    $datas[$i]['texto2'] = $texto2;
                    $datas[$i]['texto3'] = $texto3;
                }
                if ($horario[0]->dia_semana == 4 && $dateWeed == 'Thu') {
                    $datas[$i]['texto1'] = $texto1;
                    $datas[$i]['texto2'] = $texto2;
                    $datas[$i]['texto3'] = $texto3;
                }
                if ($horario[0]->dia_semana == 5 && $dateWeed == 'Fri') {
                    $datas[$i]['texto1'] = $texto1;
                    $datas[$i]['texto2'] = $texto2;
                    $datas[$i]['texto3'] = $texto3;
                }
                if ($horario[0]->dia_semana == 6 && $dateWeed == 'Sat') {
                    $datas[$i]['texto1'] = $texto1;
                    $datas[$i]['texto2'] = $texto2;
                    $datas[$i]['texto3'] = $texto3;
                }
                if ($horario[0]->dia_semana == 7 && $dateWeed == 'Sun') {
                    $datas[$i]['texto1'] = $texto1;
                    $datas[$i]['texto2'] = $texto2;
                    $datas[$i]['texto3'] = $texto3;
                }
                $i++;
            }
            $dateRanges[] = $dateStart->format('D d/m');
            $dateStart = $dateStart->modify('+1day');
        }

        return view('cadastros.horarios.listar-horarios-por-atividade', compact('atividade', 'datas'));
    }

    private function selecionarHorarioPorAtividadePorDiaSemana($atividade_id, $dia_semana)
    {
        switch ($dia_semana) {
            case 'Mon':
                $dia_semana = 1;
                break;
            case 'Tue':
                $dia_semana = 2;
                break;
            case 'Wed':
                $dia_semana = 3;
                break;
            case 'Thu':
                $dia_semana = 4;
                break;
            case 'Fri':
                $dia_semana = 5;
                break;
            case 'Sat':
                $dia_semana = 6;
                break;
            case 'Sun':
                $dia_semana = 7;
                break;
            default:
                $dia_semana = 0;
                break;
        }
        $horarios = Horario::select('horarios.*')->where('horarios.atividade_id', $atividade_id)
            ->where('horarios.dia_semana', $dia_semana)->where('horarios.situacao', 1)
            ->orderBy('horarios.hora_inicio')->orderBy('horarios.dia_semana')->get();
        return $horarios;
    }

    /**
     * Transformar Data
     *
     * @param string $data
     * @return void
     */
    private function transformDate(string $data)
    {
        $date = $data;
        $date = implode('-', array_reverse(explode('/', substr($date, 0, 10)))) . substr($date, 10);

        return new \DateTime($date);
    }

}
