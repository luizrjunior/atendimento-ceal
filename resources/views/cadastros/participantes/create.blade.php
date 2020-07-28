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
<script>
    $('#colaborador_id').val('{{old('colaborador_id')}}');
    $('#funcao_id').val('{{old('funcao_id')}}');
</script>
@endsection

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="container">
    <h4>{{$horario->atividade->nome}}</h4>
    <h4>{{$arrDiaSemana[$horario->dia_semana]}} - De {{substr($horario->hora_inicio, 0, -3)}} às {{substr($horario->hora_termino, 0, -3)}} - {{$horario->local->numero}} - {{$horario->local->nome}}</h4>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card uper">
                <div class="card-header">
                    Adicionar Participante
                    <a href="{{ route('participantes.edit', $horario->id) }}" class="float-right">
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
                    <form method="post" action="{{ route('participantes.store') }}">
                        @csrf
                        <input type="hidden" id="horario_id" name="horario_id" value="{{ $horario->id }}">
                        <div class="form-group">
                            <label for="colaborador_id">Colaborador</label>
                            <select class="form-control @error('colaborador_id') is-invalid @enderror" id="colaborador_id" name="colaborador_id" required autofocus>
                                <option value=""> - - SELECIONE - - </option>
                                @php
                                $colaboradorController = new \App\Http\Controllers\Pessoas\ColaboradorController();
                                $colaboradores = $colaboradorController->carregarComboColaboradores();
                                @endphp

                                @foreach ($colaboradores as $colaborador)
                                <option value="{{$colaborador->id}}">{{$colaborador->pessoa->nome}}</option>
                                @endforeach
                            </select>
                            @error('colaborador_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="funcao_id">Função</label>
                            <select class="form-control @error('funcao_id') is-invalid @enderror" id="funcao_id" name="funcao_id" required>
                                <option value=""> - - SELECIONE - - </option>
                                @php
                                $funcaoController = new \App\Http\Controllers\Cadastros\FuncaoController();
                                $funcoes = $funcaoController->carregarComboFuncoes();
                                @endphp

                                @foreach ($funcoes as $funcao)
                                <option value="{{$funcao->id}}">{{strtoupper($funcao->nome)}}</option>
                                @endforeach
                            </select>
                            @error('funcao_id')
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