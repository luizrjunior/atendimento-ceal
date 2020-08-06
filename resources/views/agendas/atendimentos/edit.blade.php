@php
$data = date('d/m/Y', strtotime($agendamento->data));
@endphp

@extends('layouts.app')

@section('javascript')
<script>
    top.routeCarregarHorarios = '{{ route('horarios.carregar-horarios-atividade-json') }}';
    top.valorSelectAtividade = '{{ $agendamento->horario->atividade_id }}';
    top.valorSelectHorario = '{{ $agendamento->horario_id }}';
    top.valorSelectSituacao = '{{ $atendimento->situacao }}';
    top.valorSelectForma = '{{ $atendimento->forma }}';

    $('#atividade_id').val(top.valorSelectAtividade);
    $('#situacao').val(top.valorSelectSituacao);
    $('#forma').val(top.valorSelectForma);
</script>
<script type="text/javascript" 
    src="{{ asset('/js/plugins/jquery.maskedinput.js') }}"></script>
<script type="text/javascript" 
    src="{{ asset('/js/agendas/atendimentos/create-edit-atendimento.js') }}"></script>
@endsection

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
                    Visualizar Atendimento
                    <a href="{{ url('home') }}" class="float-right">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-left-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                            <path fill-rule="evenodd" d="M8.354 11.354a.5.5 0 0 0 0-.708L5.707 8l2.647-2.646a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708 0z"/>
                            <path fill-rule="evenodd" d="M11.5 8a.5.5 0 0 0-.5-.5H6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 .5-.5z"/>
                        </svg>
                        Home
                    </a>
                </div>
                <div class="card-body">

                    @include('components.alertas')

                    <form method="post" action="{{ route('atendimentos.store') }}">
                        @csrf

                        <input type="hidden" id="agendamento_id" name="agendamento_id" value="{{$agendamento->id}}">
                        <input type="hidden" id="pessoa_id" name="pessoa_id" value="{{$pessoa->id}}">

                        <div class="form-group">
                            <label for="atividade_id">Atividade</label>
                            <select class="form-control @error('atividade_id') is-invalid @enderror" id="atividade_id" name="atividade_id" disabled>
                                <option value=""> - - SELECIONE - - </option>
                                @php
                                $atividadeController = new \App\Http\Controllers\Cadastros\AtividadeController();
                                $atividades = $atividadeController->carregarComboAtividades();
                                @endphp

                                @foreach ($atividades as $atividade)
                                <option value="{{$atividade->id}}">{{$atividade->nome}}</option>
                                @endforeach
                            </select>
                            @error('atividade_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="horario_id">Horário e Local</label>
                            <select class="form-control @error('horario_id') is-invalid @enderror" id="horario_id" name="horario_id" disabled>
                                <option value=""> - - SELECIONE - - </option>
                            </select>
                            @error('horario_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="data">Data Atendimento</label>
                            <div class='input-group date'>
                                <input type='text' class="form-control @error('data') is-invalid @enderror" id="data" name="data" value="{{ $data }}" disabled autocomplete="data">
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            </div>
                            @error('data')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="situacao">Situação Atendimento</label>
                            <select class="form-control @error('situacao') is-invalid @enderror" id="situacao" name="situacao" disabled>
                                <option value="1"> AGENDADO </option>
                                <option value="2"> CANCELADO </option>
                                <option value="3"> CONTINUA </option>
                                <option value="4"> LIBERADO </option>
                                <option value="5"> FILA DE ESPERA </option>
                            </select>
                            @error('situacao')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="forma">Forma de Atendimento</label>
                            <select class="form-control @error('forma') is-invalid @enderror" id="forma" name="forma" disabled>
                                <option value="1"> ATENDIMENTO VIRTUAL </option>
                                <option value="2"> ATENDIMENTO PRESENCIAL </option>
                                <option value="3"> ATENDIMENTO A DISTÂNCIA </option>
                            </select>
                            @error('forma')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nome">Nome Atendido</label>
                            <div class='input-group date'>
                                <input type='text' class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ $pessoa->nome }}" disabled autocomplete="nome">
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            </div>
                            @error('nome')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        
                        @if ($atendimento->situacao == 1)
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-danger" onclick="return validar();">
                                Cancelar Atendimento
                            </button>
                        </div>
                        @endif

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection