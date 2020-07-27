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

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card uper">
                <div class="card-header">
                    Editar Atividade
                    <a href="{{ url('atividades') }}" class="float-right">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-left-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                            <path fill-rule="evenodd" d="M8.354 11.354a.5.5 0 0 0 0-.708L5.707 8l2.647-2.646a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708 0z"/>
                            <path fill-rule="evenodd" d="M11.5 8a.5.5 0 0 0-.5-.5H6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 .5-.5z"/>
                        </svg>
                        Voltar
                    </a>
                    <span class="float-right">&nbsp;|&nbsp;</span>
                    <a href="{{ url('horarios') }}" class="float-right">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4 1h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H4z"/>
                            <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z"/>
                        </svg>
                        Cadastrar Horário
                    </a>
                </div>
                <div class="card-body">

                    @include('components.alertas')

                    <form method="post" action="{{ route('atividades.update', $atividade->id) }}">
                        @method('PATCH')
                        @csrf

                        <div class="form-group">
                            <label for="nome">{{ __('Name') }}</label>
                            <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror maiuscula" name="nome" value="{{ $atividade->nome }}" required autocomplete="nome" autofocus>
                            @error('nome')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                Atualizar
                            </button>
                            <a href="{{ url('atividades/create') }}" class="btn btn-secondary">
                                Novo
                            </a>
                        </div>
                    </form>

                </div>
            </div>

            <div class="card uper">
                <div class="card-header">
                    Horários da Atividade
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td><b>Dia Semana</b></td>
                                <td><b>Horário</b></td>
                                <td><b>Local</b></td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $horarioController = new \App\Http\Controllers\Cadastros\HorarioController();
                            $horarios = $horarioController->loadHorarios($atividade->id);
                            @endphp

                            @foreach($horarios as $horario)
                            <tr>
                                <td>{{$arrDiaSemana[$horario->dia_semana]}}</td>
                                <td>De {{substr($horario->hora_inicio, 0, -3)}} às {{substr($horario->hora_termino, 0, -3)}}</td>
                                <td>{{$horario->local->nome}}</td>
                            </tr>
                            @endforeach
        
                            @if (count($horarios) == 0)
                            <tr>
                                <td colspan="3">Nenhum registro encontrado!</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection