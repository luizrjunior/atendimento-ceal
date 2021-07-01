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
$arrSituacao = array(
    '1' => "ATIVADO",
    '2' => "DESATIVADO"
);
$bgColor = array(
    '1' => "success",
    '2' => "danger"
);
@endphp

@extends('layouts.app')

@section('javascript')
<script>
    top.urlListaBloqueios = "{{ url('bloqueios') }}";
    top.urlAtivarDesativarBloqueio = "{{ url('bloqueios/ativar-desativar-bloqueio') }}";
</script>
<script type="text/javascript" src="{{ asset('/js/cadastros/bloqueios/index-bloqueio.js') }}"></script>
@endsection

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="container">
    <div class="card uper">
        <div class="card-header">
            Lista de Bloqueios de Atendimento
            <a href="{{ url('bloqueios/create') }}" class="float-right">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4 1h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H4z"/>
                    <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z"/>
                </svg>
                Adicionar Bloqueio de Atendimento
            </a>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td><b>Cadastrado em</b></td>
                        <td><b>Bloqueio</b></td>
                        <td><b>Atividade</b></td>
                        <td><b>Horário</b></td>
                        <td><b>Local</b></td>
                        <td><b>Inicio</b></td>
                        <td><b>Fim</b></td>
                        <td><b>Situação</b></td>
                        <td colspan="2"><b>Ações</b></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bloqueios as $bloqueio)
                    <tr>
                        <td>{{date('d/m/Y H:i:s', strtotime($bloqueio->created_at))}}</td>
                        <td>{{$bloqueio->nome}}</td>
                        <td>{{$bloqueio->horario->atividade->nome}}</td>
                        <td>{{$arrDiaSemana[$bloqueio->horario->dia_semana]}} - {{substr($bloqueio->horario->hora_inicio, 0, -3)}} às {{substr($bloqueio->horario->hora_termino, 0, -3)}}</td>
                        <td>{{$bloqueio->horario->local->nome}} - {{$bloqueio->horario->local->numero}}</td>
                        <td>{{date('d/m/Y', strtotime($bloqueio->data_inicio))}}</td>
                        <td>{{date('d/m/Y', strtotime($bloqueio->data_fim))}}</td>
                        <td>
                            <span class="badge badge-{{$bgColor[$bloqueio->situacao]}}"
                                data-toggle="tooltip" title="{{$arrSituacao[$bloqueio->situacao]}}">
                                {{$arrSituacao[$bloqueio->situacao]}}
                            </span>
                        </td>
                        <td><a href="{{ route('bloqueios.edit', $bloqueio->id) }}" class="btn btn-primary btn-sm">Editar</a></td>
                        <td>
                            @if ($bloqueio->situacao == 1)
                            <button class="btn btn-danger btn-sm" type="button" title="Desativar"
                                onclick="ativarDesativarBloqueio({{ $bloqueio->id }})"> Desativar
                            </button>
                            @else
                            <button class="btn btn-success btn-sm" type="button" title="Ativar"
                                onclick="ativarDesativarBloqueio({{ $bloqueio->id }})"> Ativar
                            </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @if (count($bloqueios) == 0)
                    <tr>
                        <td colspan="9">Nenhum registro encontrado!</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        <div>
    <div>
<div>
@endsection
