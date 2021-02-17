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
    <h4>
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M10.146 4.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 8l-2.647-2.646a.5.5 0 0 1 0-.708z"/>
            <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5H13a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8z"/>
        </svg>
        {{$atividade->nome}}
    </h4>
    <div class="row justify-content-center">
        <div class="col-md-8">
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

                    <form id="formListarDatasPorHorario" method="post" action="{{ route('horarios.listar-vagas-disponiveis-por-horario') }}">
                        @csrf

                        <input type="hidden" id="horario_id" name="horario_id" value="">
                        <input type="hidden" id="data_atendimento" name="data_atendimento" value="">

                        @foreach($datas as $data)
                        <button type="button" class="btn btn-outline-secondary btn-lg btn-block" onclick="abrirVagasDisponiveisPorHorario('{{$data['data_atendimento']}}', {{$data['horario_id']}})">
                            <div>{{$data['texto1']}}</div>
                            <div>{{$data['texto2']}}</div>
                            <div>{{$data['texto3']}}</div>
                        </button>
                        @endforeach

                    </form>

                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection
