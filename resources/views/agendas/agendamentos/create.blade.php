@extends('layouts.app')

@section('javascript')
<script>
    top.routeCarregarHorarios = '{{ route('horarios.carregar-horarios-atividade-json') }}';
    top.valorSelectAtividade = '{{ old('atividade_id') }}';
    top.valorSelectHorario = '{{ old('horario_id') }}';

    $('#atividade_id').val(top.valorSelectAtividade);
</script>
<script type="text/javascript" 
    src="{{ asset('/js/plugins/jquery.maskedinput.js') }}"></script>
<script type="text/javascript" 
    src="{{ asset('/js/agendas/agendamentos/create-edit-agendamento.js') }}"></script>
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
                    Adicionar Agendamento
                    <a href="{{ url('agendamentos') }}" class="float-right">
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

                    <form method="post" action="{{ route('agendamentos.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="atividade_id">Atividade</label>
                            <select class="form-control @error('atividade_id') is-invalid @enderror" id="atividade_id" name="atividade_id" required autofocus>
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
                            <select class="form-control @error('horario_id') is-invalid @enderror" id="horario_id" name="horario_id" required>
                                <option value=""> - - SELECIONE - - </option>
                            </select>
                            @error('horario_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="data_agendamento">Data Atividade</label>
                            <input type='text' class="form-control @error('data_agendamento') is-invalid @enderror" id="data_agendamento" name="data_agendamento" value="{{ old('data_agendamento') }}" required autocomplete="data_agendamento">
                            @error('data_agendamento')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="numero_vagas_virtual">Número Vagas Virtual</label>
                            <input id="numero_vagas_virtual" type="text" class="form-control @error('numero_vagas_virtual') is-invalid @enderror" name="numero_vagas_virtual" value="{{ old('numero_vagas_virtual') }}" required autocomplete="numero_vagas_virtual">
                            @error('numero_vagas_virtual')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="numero_vagas_presencial">Número Vagas Presencial</label>
                            <input id="numero_vagas_presencial" type="text" class="form-control @error('numero_vagas_presencial') is-invalid @enderror" name="numero_vagas_presencial" value="{{ old('numero_vagas_presencial') }}" required autocomplete="numero_vagas_presencial">
                            @error('numero_vagas_presencial')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="numero_vagas_distancia">Número Vagas à Distância</label>
                            <input id="numero_vagas_distancia" type="text" class="form-control @error('numero_vagas_distancia') is-invalid @enderror" name="numero_vagas_distancia" value="{{ old('numero_vagas_distancia') }}" required autocomplete="numero_vagas_distancia">
                            @error('numero_vagas_distancia')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="numero_espera_virtual">Número Lista de Espera Virtual</label>
                            <input id="numero_espera_virtual" type="text" class="form-control @error('numero_espera_virtual') is-invalid @enderror" name="numero_espera_virtual" value="{{ old('numero_espera_virtual') }}" required autocomplete="numero_espera_virtual">
                            @error('numero_espera_virtual')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="numero_espera_presencial">Número Lista de Espera Presencial</label>
                            <input id="numero_espera_presencial" type="text" class="form-control @error('numero_espera_presencial') is-invalid @enderror" name="numero_espera_presencial" value="{{ old('numero_espera_presencial') }}" required autocomplete="numero_espera_presencial">
                            @error('numero_espera_presencial')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="numero_espera_distancia">Número Lista de Espera à Distância</label>
                            <input id="numero_espera_distancia" type="text" class="form-control @error('numero_espera_distancia') is-invalid @enderror" name="numero_espera_distancia" value="{{ old('numero_espera_distancia') }}" required autocomplete="numero_espera_distancia">
                            @error('numero_espera_distancia')
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