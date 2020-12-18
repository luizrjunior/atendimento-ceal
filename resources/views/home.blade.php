@extends('layouts.app')

@section('javascript')
<script type="text/javascript" src="{{ asset('/js/home.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Atividades Disponíveis') }}
                    <a href="{{ url('atendimentos') }}" class="float-right">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4 1h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H4z"/>
                            <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z"/>
                        </svg>
                        Meus Atendimentos
                    </a>
                </div>

                <div class="card-body">
                    
                    @include('components.alertas')

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Agende seu atendimento clicando na atividade desejada!') }}

                    <br />&nbsp;

                    <form id="formListarAtividades" method="post" action="{{ route('horarios.listar-horarios-por-atividade') }}">
                        @csrf
                        <input type="hidden" id="atividade_id" name="atividade_id" value="">

                        @php
                        $atividade_id_old = null;
                        @endphp

                        @foreach ($agendamentos as $agendamento)

                        @if ($agendamento->horario->atividade->id != $atividade_id_old)

                            @if ($agendamento->horario->atividade->somente_colaborador == 1)
                        <button type="button" class="btn btn-outline-secondary btn-lg btn-block" onclick="abrirHorarios({{$agendamento->horario->atividade->id}})">
                            {{$agendamento->horario->atividade->nome}}
                        </button>
                            @else
                                @if (Session::get('colaborador_id'))
                        <button type="button" class="btn btn-outline-secondary btn-lg btn-block" onclick="abrirHorarios({{$agendamento->horario->atividade->id}})">
                            {{$agendamento->horario->atividade->nome}}
                        </button>
                                @endif
                            @endif

                        @endif

                        @php
                        $atividade_id_old = $agendamento->horario->atividade->id;
                        @endphp

                        @endforeach

                        @if (count($agendamentos) == 0)
                        <button type="button" class="btn btn-outline-secondary btn-lg btn-block">
                            NENHUMA ATIVIDADE DISPONÍVEL NO MOMENTO
                        </button>
                        @endif

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
