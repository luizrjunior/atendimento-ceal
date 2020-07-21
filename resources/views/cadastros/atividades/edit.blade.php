@php
$arrDiaSemana = array(
    '1' => "Segunda-Feira",
    '2' => "Terça-Feira",
    '3' => "Quarta-Feira",
    '4' => "Quinta-Feira",
    '5' => "Sexta-Feira",
    '6' => "Sábado",
    '7' => "Domingo",
);
$arrSituacao = array(
    '1' => "Ativado",
    '2' => "Desativado"
);
$bgColor = array(
    '1' => "success",
    '2' => "danger"
);
$atividade_id = $atividade->id;
@endphp
                    
@extends('layouts.app')

@section('javascript')
<script>
    top.urlEditAtividade = "{{ url('atividades/' . $atividade_id . '/edit') }}";
    top.routeEditAtividadeTemDiaHoraJson = "{{ route('atividades.edit-atividade-tem-dia-hora-json') }}";
    top.urlAtivarDesativarAtividadeTemDiaHora = "{{ url('atividades-tem-dias-horas/ativar-desativar-atividade-tem-dia-hora') }}";
</script>
<script type="text/javascript" src="{{ asset('/js/plugins/jquery.maskedinput.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/cadastros/atividades/edit-atividade.js') }}"></script>
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
                    Editar Atividade
                    <a href="{{ url('atividades') }}" class="float-right">
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

                    <form method="post" action="{{ route('atividades.update', $atividade->id) }}">
                        @method('PATCH')
                        @csrf

                        <div class="form-group">
                            <label for="nome">{{ __('Name') }}</label>
                            <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ $atividade->nome }}" required autocomplete="nome" autofocus>
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

            <div id="divCardListRolesUser" class="card uper">
                <div class="card-header">
                    Dias e Horários da Atividade
                    <a href="#" onclick="abrirCard(2)" class="float-right">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4 1h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H4z"/>
                            <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z"/>
                        </svg>
                        Associar Novo Dia e Horário
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>Dia Semana</td>
                                <td>Hora Início</td>
                                <td>Hora Término</td>
                                <td>Situação</td>
                                <td colspan="2">Ações</td>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                            $atividadeTemDiaHoraController = new \App\Http\Controllers\Cadastros\AtividadeTemDiaHoraController();
                            $atividadesTemDiasHoras = $atividadeTemDiaHoraController->loadAtividadeTemDiasHoras($atividade->id);
                            @endphp

                            @foreach($atividadesTemDiasHoras as $atividadeTemDiaHora)
                            <tr>
                                <td>{{$arrDiaSemana[$atividadeTemDiaHora->dia_semana]}}</td>
                                <td>{{$atividadeTemDiaHora->hora_inicio}}</td>
                                <td>{{$atividadeTemDiaHora->hora_termino}}</td>
                                <td>
                                    <h4>
                                        <span class="badge badge-{{$bgColor[$atividadeTemDiaHora->situacao]}}"
                                            data-toggle="tooltip" title="{{$arrSituacao[$atividadeTemDiaHora->situacao]}}">
                                            {{$arrSituacao[$atividadeTemDiaHora->situacao]}}
                                        </span>
                                    </h4>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm" type="button" title="Editar" 
                                        onclick="editAtividadeTemDiaHora({{ $atividadeTemDiaHora->id }})">Editar</button>
                                </td>
                                <td>
                                    @if ($atividadeTemDiaHora->situacao == 1)
                                    <button class="btn btn-danger btn-sm" type="button" title="Desativar" 
                                        onclick="ativarDesativarAtividadeTemDiaHora({{ $atividadeTemDiaHora->id }})"> Desativar
                                    </button>
                                    @else
                                    <button class="btn btn-success btn-sm" type="button" title="Ativar" 
                                        onclick="ativarDesativarAtividadeTemDiaHora({{ $atividadeTemDiaHora->id }})"> Ativar
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
        
                            @if (count($atividadesTemDiasHoras) == 0)
                            <tr>
                                <td colspan="5">Nenhum registro encontrado!</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="divCardAddRoleUser" class="card uper">
                <div class="card-header">
                    Adicionar/Editar Dia e Hora da Atividade
                    <a href="#" onclick="abrirCard(1)" class="float-right">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-left-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                            <path fill-rule="evenodd" d="M8.354 11.354a.5.5 0 0 0 0-.708L5.707 8l2.647-2.646a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708 0z"/>
                            <path fill-rule="evenodd" d="M11.5 8a.5.5 0 0 0-.5-.5H6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 .5-.5z"/>
                        </svg>
                        Voltar
                    </a>
                </div>
                <div class="card-body">

                    <form method="post" action="{{ route('atividades.store-atividade-tem-dia-hora') }}">
                        @csrf

                        <input type="hidden" id="atividade_tem_dia_hora_id" name="atividade_tem_dia_hora_id" value="">
                        <input type="hidden" id="atividade_id" name="atividade_id" value="{{ $atividade->id }}">

                        <div class="form-group">
                            <label for="dia_semana">Dia da Semana</label>
                            <select class="form-control @error('dia_semana') is-invalid @enderror" id="dia_semana" name="dia_semana" required>
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
                            <input id="hora_inicio" type="text" class="form-control @error('hora_inicio') is-invalid @enderror" name="hora_inicio" value="" required autocomplete="hora_inicio">
                            @error('hora_inicio')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="hora_termino">Hora Término</label>
                            <input id="hora_termino" type="text" class="form-control @error('hora_termino') is-invalid @enderror" name="hora_termino" value="" required autocomplete="hora_termino">
                            @error('hora_termino')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button id="btnAdEdDiaHora" type="submit" class="btn btn-primary">
                                Adicionar
                            </button>
                            <a id="btnCancelDiaHora" href="{{ url('atividades/' . $atividade_id . '/edit') }}" class="btn btn-danger" style="display: none;">
                                Cancelar
                            </a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection