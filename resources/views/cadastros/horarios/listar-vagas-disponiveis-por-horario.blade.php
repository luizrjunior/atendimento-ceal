@php
$arrDiaSemana = array(
    '1' => "Segunda-feira",
    '2' => "Terça-feira",
    '3' => "Quarta-feira",
    '4' => "Quinta-feira",
    '5' => "Sexta-feira",
    '6' => "Sábado",
    '7' => "Domingo",
);
@endphp
                    
@extends('layouts.app')

@section('javascript')
<script type="text/javascript" src="{{ asset('/js/cadastros/horarios/listar-vagas-disponiveis-por-horario.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <h4>
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M10.146 4.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 8l-2.647-2.646a.5.5 0 0 1 0-.708z"/>
            <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5H13a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8z"/>
        </svg>
        {{$horario->atividade->nome}}
    </h4>
    <h5>
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-return-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M10.146 5.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 9l-2.647-2.646a.5.5 0 0 1 0-.708z"/>
            <path fill-rule="evenodd" d="M3 2.5a.5.5 0 0 0-.5.5v4A2.5 2.5 0 0 0 5 9.5h8.5a.5.5 0 0 0 0-1H5A1.5 1.5 0 0 1 3.5 7V3a.5.5 0 0 0-.5-.5z"/>
        </svg>
        Data: {{$data_atendimento}}
    </h5>
    <h5>
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-return-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M10.146 5.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 9l-2.647-2.646a.5.5 0 0 1 0-.708z"/>
            <path fill-rule="evenodd" d="M3 2.5a.5.5 0 0 0-.5.5v4A2.5 2.5 0 0 0 5 9.5h8.5a.5.5 0 0 0 0-1H5A1.5 1.5 0 0 1 3.5 7V3a.5.5 0 0 0-.5-.5z"/>
        </svg>
        Dia: {{$arrDiaSemana[$horario->dia_semana]}}
    </h5>
    <h5>
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-return-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M10.146 5.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 9l-2.647-2.646a.5.5 0 0 1 0-.708z"/>
            <path fill-rule="evenodd" d="M3 2.5a.5.5 0 0 0-.5.5v4A2.5 2.5 0 0 0 5 9.5h8.5a.5.5 0 0 0 0-1H5A1.5 1.5 0 0 1 3.5 7V3a.5.5 0 0 0-.5-.5z"/>
        </svg>
        De {{substr($horario->hora_inicio, 0, -3)}} horas às {{substr($horario->hora_termino, 0, -3)}} horas
    </h5>
    <h5>
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-return-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M10.146 5.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 9l-2.647-2.646a.5.5 0 0 1 0-.708z"/>
            <path fill-rule="evenodd" d="M3 2.5a.5.5 0 0 0-.5.5v4A2.5 2.5 0 0 0 5 9.5h8.5a.5.5 0 0 0 0-1H5A1.5 1.5 0 0 1 3.5 7V3a.5.5 0 0 0-.5-.5z"/>
        </svg>
        Local: {{$horario->local->nome}} - {{$horario->local->numero}}
    </h5>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Vagas') }}
                    <a href="javascript:history.back();" class="float-right">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-left-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                            <path fill-rule="evenodd" d="M8.354 11.354a.5.5 0 0 0 0-.708L5.707 8l2.647-2.646a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708 0z"/>
                            <path fill-rule="evenodd" d="M11.5 8a.5.5 0 0 0-.5-.5H6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 .5-.5z"/>
                        </svg>
                        Voltar
                    </a>
                </div>

                <div class="card-body">
                    
                    @include('components.alertas')

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form id="formListarVagasDisponiveisPorHorario" method="post" action="{{ route('atendimentos.abrir-create') }}">
                        @csrf
                        <input type="hidden" id="horario_id" name="horario_id" value="">
                        <input type="hidden" id="situacao" name="situacao" value="">
                        <input type="hidden" id="data_atendimento" name="data_atendimento" value="">

                        @php
                        $atendimentoController = new \App\Http\Controllers\Atendimentos\AtendimentoController();
                        @endphp

                        @php
                        $atendimentos = $atendimentoController->numeroVagasAtendimento($horario->id, 1, $data_atendimento);
                        $atendimentoFila = $atendimentoController->numeroVagasAtendimento($horario->id, 2, $data_atendimento);
                        @endphp

                        @if ($horario->numero_vagas > 0)
                            @if ($atendimentos < $horario->numero_vagas)
                        <button type="button" class="btn btn-outline-secondary btn-lg btn-block" onclick="abrirAtendimento({{$horario->id}}, 1, '{{$data_atendimento}}')">
                            {{str_pad(($horario->numero_vagas - $atendimentos), 2, 0, STR_PAD_LEFT)}} Vagas Disponíveis
                        </button>
                            @else
                                @if ($atendimentosFila < $agendamento->numero_vagas_espera)
                        <button type="button" class="btn btn-outline-secondary btn-lg btn-block" onclick="abrirAtendimento({{$horario->id}}, 2, '{{$data_atendimento}}')">
                            {{str_pad(($horario->numero_vagas_espera - $atendimentosFila), 2, 0, STR_PAD_LEFT)}} Vagas Em Espera Disponíveis
                        </button>
                        * Vagas Em Espera ficam aguardando o cancelamento ou desistência de algum atendimento no dia.
                                @else
                        <button type="button" class="btn btn-outline-secondary btn-lg btn-block">
                            NÃO HÁ VAGAS DISPONÍVEIS NO MOMENTO. POR FAVOR AGUARDE...
                        </button>
                                @endif
                            @endif
                        @else
                        <button type="button" class="btn btn-outline-secondary btn-lg btn-block">
                            NÃO HÁ VAGAS DISPONÍVEIS NO MOMENTO. POR FAVOR AGUARDE...
                        </button>
                        @endif

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
