@php
    $urlAtendimentos = url('atendimentos');
    if (Session::get('tela') == 'create_atendimento_admin') {
        $urlAtendimentos = url('atendimentos-admin');
    }
    $arrDiaSemana = array(
        '1' => "Segunda-feira",
        '2' => "Terça-feira",
        '3' => "Quarta-feira",
        '4' => "Quinta-feira",
        '5' => "Sexta-feira",
        '6' => "Sábado",
        '7' => "Domingo",
    );
    $arrForma = array(
        '0' => "INDEFINIDO",
        '1' => "VIRTUAL",
        '2' => "PRESENCIAL",
        '3' => "À DISTÂNCIA"
    );
    $bgColor = array(
        '1' => "primary",
        '2' => "danger",
        '3' => "warning",
        '4' => "success",
        '5' => "default",
        '6' => "default"
    );
    $arrSituacao = array(
        '1' => "AGENDADO",
        '2' => "FILA DE ESPERA",
        '3' => "CANCELADO",
        '4' => "CONCLUÍDO",
        '5' => "LIBERADO",
        '6' => "EM ANDAMENTO",
    );
    $data_atendimento = date('d/m/Y', strtotime($atendimento->data_atendimento));
@endphp

@extends('layouts.app')

@section('javascript')
    <script>
        top.routeCarregarHorarios = '{{ route('horarios.carregar-horarios-atividade-json') }}';
        top.valorSelectAtividade = '{{ $atendimento->horario->atividade_id }}';
        top.valorSelectHorario = '{{ $atendimento->horario_id }}';
        top.valorSelectSituacao = '{{ $atendimento->situacao }}';
        top.valorSelectForma = '{{ $atendimento->forma }}';
        top.valorSelectColaborador = '{{ $atendimento->atendente_id }}';

        $('#atividade_id').val(top.valorSelectAtividade);
        $('#situacao').val(top.valorSelectSituacao);
        $('#forma').val(top.valorSelectForma);
        $('#atendente_id').val(top.valorSelectColaborador);
    </script>
    <script type="text/javascript"
            src="{{ asset('/js/plugins/jquery.maskedinput.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('/js/atendimentos/create-edit-atendimento.js') }}"></script>
@endsection

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('components.alertas')
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">

                @include('atendimentos-components.dados-atendimento')

                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a id="linkAba1" class="nav-link active" href="#" onclick="abrirAbas('1')">Atendimento</a>
                    </li>
                    @if ($atendimento->situacao != 1 && $atendimento->situacao != 2)
                    <li class="nav-item">
                        <a id="linkAba2" class="nav-link" href="#" onclick="abrirAbas('2')">Motivos</a>
                    </li>
                    <li class="nav-item">
                        <a id="linkAba3" class="nav-link" href="#" onclick="abrirAbas('3')">Orientações</a>
                    </li>
                    <li class="nav-item">
                        <a id="linkAba4" class="nav-link" href="#" onclick="abrirAbas('4')">Observações</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a id="linkAba5" class="nav-link" href="#" onclick="abrirAbas('5')">Histórico</a>
                    </li>
                </ul>

                <div id="divAtendimento" class="card uper">
                    <div class="card-header">
                        Dados do Atendimento
                        <a href="{{ $urlAtendimentos }}" class="float-right">
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
                        <form method="post" action="{{ route('atendimentos.update', $atendimento->id) }}">
                            @method('PATCH')
                            @csrf

                            <input type="hidden" id="agendamento_id" name="agendamento_id" value="{{$atendimento->id}}">
                            <input type="hidden" id="paciente_id" name="paciente_id" value="{{$paciente->id}}">

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
                                @error('data_atendimento')
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

                            <div class="form-group">
                                <label for="situacao">Situação Atendimento</label>
                                <select class="form-control @error('situacao') is-invalid @enderror" id="situacao"
                                        name="situacao" disabled>
                                    <option value="1"> AGENDADO</option>
                                    <option value="2"> FILA DE ESPERA</option>
                                    <option value="3"> CANCELADO</option>
                                    <option value="4"> CONCLUÍDO</option>
                                    <option value="5"> LIBERADO</option>
                                    <option value="6"> EM ANDAMENTO</option>
                                </select>
                                @error('situacao')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="forma">Forma de Atendimento</label>
                                <select class="form-control @error('forma') is-invalid @enderror" id="forma"
                                        name="forma" disabled>
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

                            @if ($atendimento->atendente_id != null)
                                <div class="form-group">
                                    <label for="atendente_id">Atendente Responsável</label>
                                    <select class="form-control @error('atendente_id') is-invalid @enderror"
                                            id="atendente_id" name="atendente_id" required disabled>
                                        <option value=""> - - NENHUM - -</option>
                                        @php
                                            $colaboradorController = new \App\Http\Controllers\Pessoas\ColaboradorController();
                                            $colaboradores = $colaboradorController->carregarComboColaboradores();
                                        @endphp

                                        @foreach ($colaboradores as $colaborador)
                                            <option value="{{$colaborador->pessoa_id}}">{{$colaborador->pessoa->nome}}</option>
                                        @endforeach
                                    </select>
                                    @error('atendente_id')
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                    @enderror
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="nome">Assistida(o)</label>
                                <div class='input-group date'>
                                    <input type='text' class="form-control @error('nome') is-invalid @enderror"
                                           id="nome" name="nome" value="{{ $paciente->nome }}" disabled
                                           autocomplete="nome">
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

                            @if ($atendimento->situacao == 1 || $atendimento->situacao == 2)
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-danger" onclick="return validar();">
                                        Cancelar Atendimento
                                    </button>
                                </div>
                            @endif

                        </form>

                    </div>
                </div>


                @if ($atendimento->situacao != 1 && $atendimento->situacao != 2)
                    <div id="divMotivos" class="card uper" style="display: none;">
                        <div class="card-header">
                            Motivos do Atendimento
                            <a href="{{ url('atendimentos') }}" class="float-right">
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

                            <form method="post" action="{{ route('atendimentos.store-atendimento-has-motivo') }}">
                                @csrf

                                <input type="hidden" id="atendimento_id" name="atendimento_id"
                                       value="{{ $atendimento->id }}">

                                <div class="DocumentList">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td><b>Descrição do Motivo</b></td>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @php
                                            $motivoController = new \App\Http\Controllers\Cadastros\MotivoController();
                                            $motivos = $motivoController->carregarMotivos();

                                            $atendimentoHasMotivoController = new \App\Http\Controllers\Atendimentos\AtendimentoHasMotivoController();
                                            $atendimentosHasMotivos = $atendimentoHasMotivoController->loadMotivosAtendimento($atendimento->id);

                                            $arrMotivosId = [];
                                            foreach ($atendimentosHasMotivos as $atendimentoHasMotivo) {
                                                $arrMotivosId[] = $atendimentoHasMotivo->motivo_id;
                                            }
                                        @endphp

                                        @foreach($motivos as $motivo)
                                            @php
                                                $checked = "";
                                            @endphp
                                            @if (count($atendimentosHasMotivos) > 0)
                                                @if (in_array($motivo->id, $arrMotivosId))
                                                    @php
                                                        $checked = "checked";
                                                    @endphp
                                                @endif
                                            @endif
                                            @if ($checked == "checked")
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="permissao"
                                                               value="{{ $motivo->id }}"
                                                               name="motivo_id[]" {{ $checked }}>
                                                    </td>
                                                    <td>{{$motivo->descricao}}</td>
                                                </tr>
                                            @endif
                                        @endforeach

                                        @if (count($motivos) == 0 || $motivos == null)
                                            <tr>
                                                <td colspan="2">Nenhum registro encontrado!</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>

                            </form>

                        </div>
                    </div>

                    <div id="divOrientacoes" class="card uper" style="display: none;">
                        <div class="card-header">
                            Orientações do Atendimento
                            <a href="{{ url('atendimentos') }}" class="float-right">
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

                            <form method="post" action="{{ route('atendimentos.store-atendimento-has-orientacao') }}">
                                @csrf

                                <input type="hidden" id="atendimento_id" name="atendimento_id"
                                       value="{{ $atendimento->id }}">

                                <div class="DocumentList">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td><b>Descrição da Orientações</b></td>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @php
                                            $orientacaoController = new \App\Http\Controllers\Cadastros\OrientacaoController();
                                            $orientacoes = $orientacaoController->carregarOrientacoes();

                                            $atendimentoHasOrientacaoController = new \App\Http\Controllers\Atendimentos\AtendimentoHasOrientacaoController();
                                            $atendimentosHasOrientacoes = $atendimentoHasOrientacaoController->loadOrientacoesAtendimento($atendimento->id);

                                            $arrOrientacoesId = [];
                                            foreach ($atendimentosHasOrientacoes as $atendimentoHasOrientacao) {
                                                $arrOrientacoesId[] = $atendimentoHasOrientacao->orientacao_id;
                                            }
                                        @endphp

                                        @foreach($orientacoes as $orientacao)
                                            @php
                                                $checked = "";
                                            @endphp
                                            @if (count($atendimentosHasOrientacoes) > 0)
                                                @if (in_array($orientacao->id, $arrOrientacoesId))
                                                    @php
                                                        $checked = "checked";
                                                    @endphp
                                                @endif
                                            @endif
                                            @if ($checked == "checked")
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="permissao2"
                                                               value="{{ $orientacao->id }}"
                                                               name="orientacao_id[]" {{ $checked }}>
                                                    </td>
                                                    <td>{{$orientacao->descricao}}</td>
                                                </tr>
                                            @endif
                                        @endforeach

                                        @if (count($orientacoes) == 0)
                                            <tr>
                                                <td colspan="2">Nenhum registro encontrado!</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>

                            </form>

                        </div>
                    </div>

                    <div id="divObservacoes" class="card uper" style="display: none;">
                        <div class="card-header">
                            Observações do Atendimento
                            <a href="{{ url('atendimentos') }}" class="float-right">
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
                            <form method="post" action="{{ route('atendimentos.store-atendimento-has-orientacao') }}">
                                @csrf
                                <input type="hidden" id="atendimento_id" name="atendimento_id"
                                       value="{{ $atendimento->id }}">

                                <div class="form-group">
                                    <label for="exampleFormControlTextarea2">Observações</label>
                                    <textarea class="form-control rounded-0" id="exampleFormControlTextarea2"
                                              rows="3">{{ $atendimento->observacoes }}</textarea>
                                </div>
                            </form>

                        </div>
                    </div>

                @endif

                <div id="divHistorico" class="card uper" style="display: none;">
                    @include('atendimentos-components.historico-atendimentos-por-paciente')
                </div>

            </div>
        </div>
    </div>
@endsection