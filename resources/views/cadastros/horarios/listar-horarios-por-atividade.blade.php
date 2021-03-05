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
<script type="text/javascript" src="{{ asset('/js/cadastros/horarios/listar-horarios-por-atividade.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4>
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10.146 4.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 8l-2.647-2.646a.5.5 0 0 1 0-.708z"/>
                    <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5H13a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8z"/>
                </svg>
                {{$atividade->nome}}
            </h4>
            <div class="card">
                <div class="card-header">
                    {{ __('Horários Disponíveis') }}
                    <a href="{{ url('home') }}" class="float-right">
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

                    <form id="formListarDatasPorHorario" method="post" action="{{ route('atendimentos.abrir-create') }}">
                        @csrf

                        <input type="hidden" id="horario_id" name="horario_id" value="">
                        <input type="hidden" id="situacao" name="situacao" value="">
                        <input type="hidden" id="data_atendimento" name="data_atendimento" value="">

                        @foreach($datas as $data)

                            @php
                            $horario_id = $data['horario_id'];
                            $atendimentoController[$horario_id] = new \App\Http\Controllers\Atendimentos\AtendimentoController();

                            $atendimentos = $atendimentoController[$horario_id]->numeroVagasAtendimento($data['horario_id'], 1, $data['data_atendimento']);
                            $atendimentoFila = $atendimentoController[$horario_id]->numeroVagasAtendimento($data['horario_id'], 2, $data['data_atendimento']);
                            @endphp

                            @if ($data['numero_vagas'] > 0)
                                @if ($atendimentos < $data['numero_vagas'])

                                    @php
                                    $descricaoVaga = str_pad(($data['numero_vagas'] - $atendimentos), 2, 0, STR_PAD_LEFT) . " Vagas Disponíveis";
                                    $situacaoVaga = 1;
                                    @endphp


                                @else
                                    @if ($atendimentosFila < $data['numero_vagas_espera'])
                                        @php
                                        $descricaoVaga = str_pad(($data['numero_vagas_espera'] - $atendimentosFila), 2, 0, STR_PAD_LEFT) . " Vagas Em Espera Disponíveis <br />* Vagas Em Espera ficam aguardando o cancelamento ou desistência de algum atendimento no dia.";
                                        $situacaoVaga = 2;
                                        @endphp

                                    @else
                                        @php
                                        $descricaoVaga = "NÃO HÁ VAGAS DISPONÍVEIS NO MOMENTO. POR FAVOR AGUARDE...";
                                        $situacaoVaga = 0;
                                        @endphp
                                    @endif
                                @endif
                            @else
                                @php
                                $descricaoVaga = "NÃO HÁ VAGAS DISPONÍVEIS NO MOMENTO. POR FAVOR AGUARDE...";
                                $situacaoVaga = 0;
                                @endphp
                            @endif


                        @if ($situacaoVaga != 0)
                        <button type="button" class="btn btn-outline-secondary btn-lg btn-block" onclick="abrirAtendimento('{{$data['horario_id']}}', {{$situacaoVaga}}, '{{$data['data_atendimento']}}')">
                        @else
                        <button type="button" class="btn btn-outline-secondary btn-lg btn-block">
                        @endif
                            <div>{{$data['texto1']}}</div>
                            <div>{{$data['texto2']}}</div>
                            <div>{{$data['texto3']}}</div>
                            <div>{{$descricaoVaga}}</div>
                        </button>
                        @endforeach

                    </form>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
