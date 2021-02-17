@php
$arrDiaSemana = array(
    '1' => "SEGUNDA-FEIRA",
    '2' => "TERÇA-FEIRA",
    '3' => "QUARTA-FEIRA",
    '4' => "QUINTA-FEIRA",
    '5' => "SEXTA-FEIRA",
    '6' => "SÁBADO",
    '7' => "DOMINGO",
);
$arrSituacao = array(
    '1' => "AGENDADO",
    '2' => "FILA DE ESPERA",
    '3' => "CANCELADO",
    '4' => "CONCLUÍDO",
    '5' => "LIBERADO"
);
$arrForma = array(
    '0' => "INDEFINIDO",
    '1' => "VIRTUAL",
    '2' => "PRESENCIAL",
    '3' => "À DISTÂNCIA"
);
$bgColor = array(
    '1' => "primary",
    '2' => "danger",
    '3' => "warning",
    '4' => "success",
    '5' => "default"
);

$data_inicio_psq = $data['data_inicio_psq'] ? $data['data_inicio_psq'] : "";
$data_termino_psq = $data['data_termino_psq'] ? $data['data_termino_psq'] : "";

$atividade_id_psq = $data['atividade_id_psq'] ? $data['atividade_id_psq'] : "";
$horario_id_psq = $data['horario_id_psq'] ? $data['horario_id_psq'] : "";

$forma_psq = $data['forma_psq'] ? $data['forma_psq'] : "";
$situacao_psq = $data['situacao_psq'] ? $data['situacao_psq'] : "";

$atendente_id_psq = $data['atendente_id_psq'] ? $data['atendente_id_psq'] : "";
$nome_paciente_psq = $data['nome_paciente_psq'] ? $data['nome_paciente_psq'] : "";

$totalPage = $data['totalPage'] ? $data['totalPage'] : 25;
@endphp
                    
@extends('layouts.app')

@section('javascript')
<script>
    top.urlListaAtendimentos = "{{ url('atendimentos-admin') }}";
    top.urlAtivarDesativarAtendimento = "{{ url('atendimentos-admin/ativar-desativar-atendimento') }}";
    top.routeCarregarHorarios = '{{ route('horarios.carregar-horarios-atividade-json') }}';

    top.valorSelectAtividade = '{{ $atividade_id_psq }}';
    top.valorSelectHorario = '{{ $horario_id_psq }}';

    top.valorSelectForma = '{{ $forma_psq }}';
    top.valorSelectSituacao = '{{ $situacao_psq }}';

    top.valorSelectColaborador = '{{ $atendente_id_psq }}';

    $('#atividade_id_psq').val(top.valorSelectAtividade);

    $('#forma_psq').val(top.valorSelectForma);
    $('#situacao_psq').val(top.valorSelectSituacao);

    $('#atendente_id_psq').val(top.valorSelectColaborador);
</script>
<script type="text/javascript" 
    src="{{ asset('/js/plugins/jquery.maskedinput.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/atendimentos-admin/index-atendimento-admin.js') }}"></script>
@endsection

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="container">

    <form method="post" action="{{ route('atendimentos-admin.index') }}">
        @csrf

    <div class="card uper">
        <div class="card-header">
            Filtro de Atendimentos
        </div>
        <div class="card-body">

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="data_inicio_psq">Periodo de</label>
                    <input type='text' class="form-control" id="data_inicio_psq" name="data_inicio_psq" value="{{ $data_inicio_psq }}" autocomplete="data_inicio_psq">
                </div>
                <div class="form-group col-md-6">
                    <label for="data_termino_psq">Até</label>
                    <input type='text' class="form-control" id="data_termino_psq" name="data_termino_psq" value="{{ $data_termino_psq }}" autocomplete="data_termino_psq">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="atividade_id_psq">Atividade</label>
                    <select class="form-control" id="atividade_id_psq" name="atividade_id_psq">
                        <option value=""> - - SELECIONE - - </option>
                        @php
                        $atividadeController = new \App\Http\Controllers\Cadastros\AtividadeController();
                        $atividades = $atividadeController->carregarComboAtividades();
                        @endphp

                        @foreach ($atividades as $atividade)
                        <option value="{{$atividade->id}}">{{$atividade->nome}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="horario_id_psq">Horário e Local</label>
                    <select class="form-control" id="horario_id_psq" name="horario_id_psq">
                        <option value=""> - - SELECIONE - - </option>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="forma_psq">Forma de Atendimento</label>
                    <select class="form-control" id="forma_psq" name="forma_psq">
                        <option value=""> - - SELECIONE - - </option>
                        @foreach ($arrForma as $key => $value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="situacao_psq">Situação</label>
                    <select class="form-control" id="situacao_psq" name="situacao_psq">
                        <option value=""> - - SELECIONE - - </option>
                        @foreach ($arrSituacao as $key => $value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="atendente_id_psq">Atendente</label>
                    <select class="form-control" id="atendente_id_psq" name="atendente_id_psq">
                        <option value=""> - - SELECIONE - - </option>
                        @php
                        $atendenteController = new \App\Http\Controllers\Pessoas\ColaboradorController();
                        $atendentes = $atendenteController->carregarComboColaboradores();
                        @endphp

                        @foreach ($atendentes as $atendente)
                        <option value="{{$atendente->pessoa_id}}">{{$atendente->pessoa->nome}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="nome_paciente_psq">{{ __('Name') }} do Paciente</label>
                    <input id="nome_paciente_psq" type="text" class="form-control maiuscula" name="nome_paciente_psq" value="{{ $nome_paciente_psq }}" autocomplete="nome_paciente_psq">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-primary">
                        Pesquisar
                    </button>
                </div>
            </div>

        </div>
    </div>

    <div class="card uper">
        <div class="card-header">
            Lista dos Atendimentos
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td><b>Data</b></td>
                        <td><b>Atividade</b></td>
                        <td><b>Dia e Horário</b></td>
                        {{-- <td><b>Local</b></td>
                        <td><b>Forma</b></td> --}}
                        <td><b>Paciente</b></td>
                        <td><b>Situação</b></td>
                        <td colspan="2"><b>Ações</b></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($atendimentos as $atendimento)
                    <tr>
                        <td>{{date('d/m/Y', strtotime($atendimento->dataAtendimento))}}</td>
                        <td>{{$atendimento->nomeAtividade}}</td>
                        <td>{{$arrDiaSemana[$atendimento->diaSemana]}} - {{substr($atendimento->horaInicio, 0, -3)}} às {{substr($atendimento->horaTermino, 0, -3)}}</td>
                        {{-- <td>{{$atendimento->nomeLocal}} - {{$atendimento->numeroLocal}}</td>
                        <td>{{$arrForma[$atendimento->forma]}}</td> --}}
                        <td>{{$atendimento->nomePaciente}}</td>
                        <td>
                            <span class="badge badge-{{$bgColor[$atendimento->situacao]}}"
                                data-toggle="tooltip" title="{{$arrSituacao[$atendimento->situacao]}}">
                                {{$arrSituacao[$atendimento->situacao]}}
                            </span>
                        </td>
                        <td><a href="{{ route('atendimentos-admin.edit', $atendimento->id) }}" class="btn btn-primary btn-sm">Editar</a></td>
                    </tr>
                    @endforeach

                    @if (count($atendimentos) == 0)
                    <tr>
                        <td colspan="8">Nenhum registro encontrado!</td>
                    </tr>
                    @endif

                    @if (isset($data))
                    <tr>
                        <td colspan="2">
                            <input id="totalPage" name="totalPage" type="text" value="{{ $totalPage }}" 
                                class="form-control" size="10" style="text-align: right;">
                                Registros por página
                        </td>
                        <td colspan="6">
                            {{  $atendimentos->appends($data)->links() }}
                        </td>
                    </tr>
                    @else
                    <tr>
                        <td colspan="2">
                            <input id="totalPage" name="totalPage" type="text" value="{{ $totalPage }}" 
                                class="form-control" size="10" style="text-align: right;">
                                Registros por página
                        </td>
                        <td colspan="6">
                            {{ $atendimentos->links() }}
                        </td>
                    </tr>
                    @endif

                </tbody>
            </table>
        <div>
    <div>
    </form>

<div>
@endsection