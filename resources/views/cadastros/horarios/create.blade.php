@extends('layouts.app')

@section('javascript')
<script type="text/javascript" src="{{ asset('/js/plugins/jquery.maskedinput.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/cadastros/horarios/create-edit-horario.js') }}"></script>
<script>
    $('#dia_semana').val('{{old('dia_semana')}}');
    $('#local_id').val('{{old('local_id')}}');
</script>
@endsection

@endsection

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="container">
    
    <h4>{{$atividade->nome}}</h4>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card uper">
                <div class="card-header">
                    Adicionar Horário
                    <a href="{{ url('horarios') }}" class="float-right">
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

                    <form method="post" action="{{ route('horarios.store') }}">
                        @csrf

                        <input type="hidden" id="atividade_id" name="atividade_id" value="{{ $atividade->id }}">

                        <div class="form-group">
                            <label for="dia_semana">Dia da Semana</label>
                            <select class="form-control @error('dia_semana') is-invalid @enderror" id="dia_semana" name="dia_semana" required autofocus>
                                <option value=""> - - SELECIONE - - </option>
                                <option value="1"> SEGUNDA-FEIRA </option>
                                <option value="2"> TERÇA-FEIRA </option>
                                <option value="3"> QUARTA-FEIRA </option>
                                <option value="4"> QUINTA-FEIRA </option>
                                <option value="5"> SEXTA-FEIRA </option>
                                <option value="6"> SÁBADO </option>
                                <option value="7"> DOMINGO </option>
                            </select>
                            @error('dia_semana')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="hora_inicio">Hora Início</label>
                            <input id="hora_inicio" type="text" class="form-control @error('hora_inicio') is-invalid @enderror" name="hora_inicio" value="{{ old('hora_inicio') }}" required autocomplete="hora_inicio">
                            @error('hora_inicio')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="hora_termino">Hora Término</label>
                            <input id="hora_termino" type="text" class="form-control @error('hora_termino') is-invalid @enderror" name="hora_termino" value="{{ old('hora_termino') }}" required autocomplete="hora_termino">
                            @error('hora_termino')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="local_id">Local</label>
                            <select class="form-control @error('local_id') is-invalid @enderror" id="local_id" name="local_id" required>
                                <option value=""> - - SELECIONE - - </option>
                                @php
                                $localController = new \App\Http\Controllers\Cadastros\LocalController();
                                $locais = $localController->carregarComboLocais();
                                @endphp

                                @foreach ($locais as $local)
                                <option value="{{$local->id}}">{{$local->nome}}</option>
                                @endforeach
                            </select>
                            @error('local_id')
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