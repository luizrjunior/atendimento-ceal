@php
$data_inicio = '';
$data_fim = '';
@endphp

@extends('layouts.app')

@section('javascript')
<script>
    top.routeCarregarHorarios = '{{ route('horarios.carregar-horarios-atividade-json') }}';
    top.valorSelectAtividade = '';
    top.valorSelectHorario = '';
    $('#atividade_id').val(top.valorSelectAtividade);
</script>
<script type="text/javascript"
        src="{{ asset('/js/plugins/jquery.maskedinput.js') }}"></script>
<script type="text/javascript"
        src="{{ asset('/js/cadastros/bloqueios/create-edit-bloqueio.js') }}"></script>
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
                    Adicionar Bloqueio de Atendimento
                    <a href="{{ url('bloqueios') }}" class="float-right">
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

                    <form method="post" action="{{ route('bloqueios.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="nome">{{ __('Name') }}</label>
                            <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror maiuscula" name="nome" value="{{ old('nome') }}" required autocomplete="nome">
                            @error('nome')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="descricao">Descrição (Objetivo do Bloqueio)</label>
                            <textarea class="form-control rounded-0" name="descricao" id="descricao" rows="3">{{ old('descricao') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="atividade_id">Atividade</label>
                            <select class="form-control @error('atividade_id') is-invalid @enderror" id="atividade_id" name="atividade_id">
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
                            <label for="horario_id">Dia, Horário e Local</label>
                            <select class="form-control @error('horario_id') is-invalid @enderror" id="horario_id" name="horario_id">
                                <option value=""> - - SELECIONE - - </option>
                            </select>
                            @error('horario_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="data_inicio">Data Inicio</label>
                            <div class='input-group date'>
                                <input type='text' class="form-control @error('data_inicio') is-invalid @enderror" id="data_inicio" name="data_inicio" value="{{ $data_inicio }}" autocomplete="data_inicio" required>
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            </div>
                            @error('data_inicio')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="data_fim">Data Fim</label>
                            <div class='input-group date'>
                                <input type='text' class="form-control @error('data_fim') is-invalid @enderror" id="data_fim" name="data_fim" value="{{ $data_fim }}" autocomplete="data_fim">
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            </div>
                            @error('data_fim')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                Adicionar
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
