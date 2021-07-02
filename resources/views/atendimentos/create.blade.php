@php
    $arrDiaSemana = array(
        '1' => "Segunda-feira",
        '2' => "Terça-feira",
        '3' => "Quarta-feira",
        '4' => "Quinta-feira",
        '5' => "Sexta-feira",
        '6' => "Sábado",
        '7' => "Domingo",
    );
    $data = date('d/m/Y', strtotime($data_atendimento));
@endphp

@extends('layouts.app')

@section('javascript')
    <script>
        top.routeCarregarHorarios = '{{ route('horarios.carregar-horarios-atividade-json') }}';
        top.routeBuscarPessoaAtendimento = '{{ route('pessoas.buscar-pessoa-atendimento-json') }}';
        top.routeAbrirCadastroPessoas = '{{ route('pessoas.admin.index') }}';
        top.valorSelectAtividade = '{{ $horario->atividade_id }}';
        top.valorSelectHorario = '{{ $horario->id }}';

        $('#atividade_id').val(top.valorSelectAtividade);
    </script>
    <script type="text/javascript"
            src="{{ asset('/js/plugins/jquery.maskedinput.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('/js/atendimentos/create-edit-atendimento.js') }}"></script>
    <script>
        @if (Session::get('tela') != '')
        $("#nome").prop('disabled', false);
        @endif
    </script>
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

                <h4>
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right" fill="currentColor"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M10.146 4.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 8l-2.647-2.646a.5.5 0 0 1 0-.708z"/>
                        <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5H13a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8z"/>
                    </svg>
                    {{$horario->atividade->nome}}
                </h4>
                <h5>
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-return-right"
                         fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M10.146 5.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 9l-2.647-2.646a.5.5 0 0 1 0-.708z"/>
                        <path fill-rule="evenodd"
                              d="M3 2.5a.5.5 0 0 0-.5.5v4A2.5 2.5 0 0 0 5 9.5h8.5a.5.5 0 0 0 0-1H5A1.5 1.5 0 0 1 3.5 7V3a.5.5 0 0 0-.5-.5z"/>
                    </svg>
                    Dia {{$data_atendimento}} - {{$arrDiaSemana[$horario->dia_semana]}}
                </h5>
                <h5>
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-return-right"
                         fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M10.146 5.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 9l-2.647-2.646a.5.5 0 0 1 0-.708z"/>
                        <path fill-rule="evenodd"
                              d="M3 2.5a.5.5 0 0 0-.5.5v4A2.5 2.5 0 0 0 5 9.5h8.5a.5.5 0 0 0 0-1H5A1.5 1.5 0 0 1 3.5 7V3a.5.5 0 0 0-.5-.5z"/>
                    </svg>
                    De {{substr($horario->hora_inicio, 0, -3)}} horas às {{substr($horario->hora_termino, 0, -3)}} horas
                </h5>
                <h5>
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-return-right"
                         fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M10.146 5.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 9l-2.647-2.646a.5.5 0 0 1 0-.708z"/>
                        <path fill-rule="evenodd"
                              d="M3 2.5a.5.5 0 0 0-.5.5v4A2.5 2.5 0 0 0 5 9.5h8.5a.5.5 0 0 0 0-1H5A1.5 1.5 0 0 1 3.5 7V3a.5.5 0 0 0-.5-.5z"/>
                    </svg>
                    Local: {{$horario->local->nome}} - {{$horario->local->numero}}
                </h5>

                <div class="card">
                    <div class="card-header">
                        Adicionar Atendimento
                        <a href="javascript:history.back();" class="float-right">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-left-square"
                                 fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                <path fill-rule="evenodd"
                                      d="M8.354 11.354a.5.5 0 0 0 0-.708L5.707 8l2.647-2.646a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708 0z"/>
                                <path fill-rule="evenodd"
                                      d="M11.5 8a.5.5 0 0 0-.5-.5H6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 .5-.5z"/>
                            </svg>
                            Voltar
                        </a>
                    </div>
                    <div class="card-body">

                        @include('components.alertas')

                        <form method="post" action="{{ route('atendimentos.store') }}" id="formAtendimentosCreate" name="formAtendimentosCreate">
                            @csrf

                            <input type="hidden" id="atendimento_id" name="atendimento_id" value="">
                            <input type="hidden" id="paciente_id" name="paciente_id" value="{{$paciente->id}}">
                            <input type="hidden" id="nome_psq" name="nome_psq" value="">

                            <div class="form-group">
                                <label for="atividade_id">Atividade</label>
                                <select class="form-control @error('atividade_id') is-invalid @enderror"
                                        id="atividade_id" name="atividade_id" disabled>
                                    <option value=""> - - SELECIONE - -</option>
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
                                <label for="data">Data Atendimento</label>
                                <div class='input-group date'>
                                    <input type='text'
                                           class="form-control @error('data_atendimento') is-invalid @enderror"
                                           id="data_atendimento" name="data_atendimento" value="{{ $data_atendimento }}"
                                           disabled autocomplete="data_atendimento">
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
                                <label for="horario_id">Dia, Horário e Local</label>
                                <select class="form-control @error('horario_id') is-invalid @enderror" id="horario_id"
                                        name="horario_id" disabled>
                                    <option value=""> - - SELECIONE - -</option>
                                </select>
                                @error('horario_id')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>

                            <div class="form-group" style="display: none">
                                <label for="situacao">Situação</label>
                                <select class="form-control @error('situacao') is-invalid @enderror" id="situacao"
                                        name="situacao">
                                    <option value="1"> AGENDADO</option>
                                    <option value="2"> FILA DE ESPERA</option>
                                </select>
                                @error('situacao')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>

                            <div class="form-group" style="display: none;">
                                <label for="forma">Forma de Atendimento</label>
                                <select class="form-control @error('forma') is-invalid @enderror" id="forma"
                                        name="forma">
                                    <option value="0"> INDEFINIDO</option>
                                    <option value="1"> ATENDIMENTO VIRTUAL</option>
                                    <option value="2"> ATENDIMENTO PRESENCIAL</option>
                                    <option value="3"> ATENDIMENTO A DISTÂNCIA</option>
                                </select>
                                @error('forma')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="nome">
                                    Nome Completo (Pessoa Atendida/Paciente)
                                </label>
                                @if (Session::get('tela') != '')
                                    <a href="javascript:buscarPessoaAtendimento();" class="float-right">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                        </svg>
                                        Buscar
                                    </a>
                                @endif
                                <div class='input-group date'>
                                    <input type='text' class="form-control @error('paciente_id') is-invalid @enderror"
                                           id="nome" name="nome" value="{{ $paciente->nome }}"
                                           placeholder="Digite Nome ou CPF no formato: 999.999.999-99. Clique em buscar."
                                           disabled autocomplete="nome">
                                    <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                                </div>
                                @error('paciente_id')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary" onclick="return validar();">
                                    Confirmar Atendimento
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
