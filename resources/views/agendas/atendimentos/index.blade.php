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
    '1' => "AGENDADO",
    '2' => "CANCELADO",
    '3' => "CONTINUA",
    '4' => "LIBERADO",
    '5' => "FILA DE ESPERA"
);
$arrForma = array(
    '1' => "VIRTUAL",
    '2' => "PRESENCIAL",
    '3' => "À DISTÂNCIA"
);
$bgColor = array(
    '1' => "primary",
    '2' => "danger",
    '3' => "primary",
    '4' => "success",
    '5' => "default"
);
@endphp
                    
@extends('layouts.app')

@section('javascript')
<script>
    top.urlListaAtendimentos = "{{ url('atendimentos') }}";
    top.urlAtivarDesativarAtendimento = "{{ url('atendimentos/ativar-desativar-atendimento') }}";
</script>
<script type="text/javascript" src="{{ asset('/js/agendas/atendimentos/index-atendimento.js') }}"></script>
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
            Lista dos Meus Atendimentos
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td><b>Data</b></td>
                        <td><b>Atividade</b></td>
                        <td><b>Dia e Horário</b></td>
                        <td><b>Local</b></td>
                        <td><b>Forma</b></td>
                        <td><b>Situação</b></td>
                        <td colspan="2"><b>Ações</b></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($atendimentos as $atendimento)
                    <tr>
                        <td>{{date('d/m/Y', strtotime($atendimento->agendamento->data))}}</td>
                        <td>{{$atendimento->agendamento->horario->atividade->nome}}</td>
                        <td>{{$arrDiaSemana[$atendimento->agendamento->horario->dia_semana]}} - {{substr($atendimento->agendamento->horario->hora_inicio, 0, -3)}} às {{substr($atendimento->agendamento->horario->hora_termino, 0, -3)}}</td>
                        <td>{{$atendimento->agendamento->horario->local->numero}} - {{$atendimento->agendamento->horario->local->nome}}</td>
                        <td>{{$arrForma[$atendimento->forma]}}</td>
                        <td>
                            <span class="badge badge-{{$bgColor[$atendimento->situacao]}}"
                                data-toggle="tooltip" title="{{$arrSituacao[$atendimento->situacao]}}">
                                {{$arrSituacao[$atendimento->situacao]}}
                            </span>
                        </td>
                        <td><a href="{{ route('atendimentos.edit', $atendimento->id) }}" class="btn btn-primary btn-sm">Visualizar</a></td>
                    </tr>
                    @endforeach
                    @if (count($atendimentos) == 0)
                    <tr>
                        <td colspan="7">Nenhum registro encontrado!</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        <div>
    <div>
<div>
@endsection