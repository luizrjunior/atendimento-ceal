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
@endphp
                    
@extends('layouts.app')

@section('javascript')
<script type="text/javascript" src="{{ asset('/js/agendas/agendamentos/listar-agendamentos.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <h4 class="text-primary">
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M10.146 4.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 8l-2.647-2.646a.5.5 0 0 1 0-.708z"/>
            <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5H13a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8z"/>
        </svg>
        {{$horario->atividade->nome}}
    </h4>
    <h4 class="text-primary">
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-return-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M10.146 5.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 9l-2.647-2.646a.5.5 0 0 1 0-.708z"/>
            <path fill-rule="evenodd" d="M3 2.5a.5.5 0 0 0-.5.5v4A2.5 2.5 0 0 0 5 9.5h8.5a.5.5 0 0 0 0-1H5A1.5 1.5 0 0 1 3.5 7V3a.5.5 0 0 0-.5-.5z"/>
        </svg>
        {{$arrDiaSemana[$horario->dia_semana]}} - De {{substr($horario->hora_inicio, 0, -3)}} às {{substr($horario->hora_termino, 0, -3)}} - {{$horario->local->numero}} - {{$horario->local->nome}}
    </h4>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Formas de Atendimento e Vagas Disponíveis') }}
                    <a href="javascript:history.back();" class="float-right">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4 1h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H4z"/>
                            <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z"/>
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

                    {{ __('Agende seu atendimento clincando na forma de atendimento desejado!') }}

                    <br />&nbsp;

                    <form id="formListarAgendamentos" method="post" action="{{ route('atendimentos.abrir-create') }}">
                        @csrf
                        <input type="hidden" id="agendamento_id" name="agendamento_id" value="">
                        <input type="hidden" id="situacao" name="situacao" value="">
                        <input type="hidden" id="forma" name="forma" value="">

                        @php
                        $atendimentoController = new \App\Http\Controllers\Agendas\AtendimentoController();
                        @endphp

                        @foreach($agendamentos as $agendamento)

                            @if ($agendamento->numero_vagas_virtual > 0)

                                @php
                                $atendimentosVirtuais = $atendimentoController->numeroVagasAtendimento($agendamento->id, 1, 1);
                                $atendimentosVirtuaisFila = $atendimentoController->numeroVagasAtendimento($agendamento->id, 1, 5);
                                @endphp

                                @if ($atendimentosVirtuais < $agendamento->numero_vagas_virtual)

                        <button type="button" class="btn btn-outline-secondary btn-lg btn-block" onclick="abrirAtendimento({{$agendamento->id}}, 1, 1)">
                            Atendimento Virtual - Vagas Disponíveis: {{str_pad(($agendamento->numero_vagas_virtual - $atendimentosVirtuais), 2, 0, STR_PAD_LEFT)}}
                        </button>

                                @else

                                    @if ($atendimentosVirtuaisFila < $agendamento->numero_espera_virtual)

                        <button type="button" class="btn btn-outline-secondary btn-lg btn-block" onclick="abrirAtendimento({{$agendamento->id}}, 5, 1)">
                            Atendimento Virtual - Vagas Disponíveis: {{str_pad(($agendamento->numero_espera_virtual - $atendimentosVirtuais), 2, 0, STR_PAD_LEFT)}} (FILA DE ESPERA)
                        </button>

                                    @endif
   
                                @endif

                            @endif

                            @if ($agendamento->numero_vagas_presencial > 0)

                                @php
                                $atendimentosPresenciais = $atendimentoController->numeroVagasAtendimento($agendamento->id, 2, 1);
                                $atendimentosPresenciaisFila = $atendimentoController->numeroVagasAtendimento($agendamento->id, 2, 5);
                                @endphp

                                @if ($atendimentosPresenciais < $agendamento->numero_vagas_virtual)

                        <button type="button" class="btn btn-outline-secondary btn-lg btn-block" onclick="abrirAtendimento({{$agendamento->id}}, 1, 2)">
                            Atendimento Presencial - Vagas Disponíveis: {{str_pad(($agendamento->numero_vagas_presencial - $atendimentosPresenciais), 2, 0, STR_PAD_LEFT)}}
                        </button>

                                @else

                                    @if ($atendimentosPresenciaisFila < $agendamento->numero_espera_presencial)

                        <button type="button" class="btn btn-outline-secondary btn-lg btn-block" onclick="abrirAtendimento({{$agendamento->id}}, 1, 2)">
                            Atendimento Presencial - Vagas Disponíveis: {{str_pad(($agendamento->numero_espera_presencial - $atendimentosPresenciaisFila), 2, 0, STR_PAD_LEFT)}} (FILA DE ESPERA)
                        </button>

                                    @endif

                                @endif

                            @endif

                            @if ($agendamento->numero_vagas_distancia > 0)

                                @php
                                $atendimentosDistancia = $atendimentoController->numeroVagasAtendimento($agendamento->id, 3, 1);
                                @endphp

                                @if ($atendimentosDistancia < $agendamento->numero_vagas_virtual)

                        <button type="button" class="btn btn-outline-secondary btn-lg btn-block" onclick="abrirAtendimento({{$agendamento->id}}, 1, 3)">
                            Atendimento à Distância - Vagas Disponíveis: {{str_pad(($agendamento->numero_vagas_distancia - $atendimentosDistancia), 2, 0, STR_PAD_LEFT)}}
                        </button>

                                @endif

                            @endif

                        @endforeach

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
