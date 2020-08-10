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

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="container">
    <div class="card uper">
        <div class="card-header">
            Participantes - Lista de Atividades, Horários e Locais
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td><b>Atividade</b></td>
                        <td><b>Dia Semana</b></td>
                        <td><b>Horário</b></td>
                        <td><b>Local</b></td>
                        <td><b>Ações</b></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($horarios as $horario)
                    <tr>
                        <td>{{$horario->atividade->nome}}</td>
                        <td>{{$arrDiaSemana[$horario->dia_semana]}}</td>
                        <td>De {{substr($horario->hora_inicio, 0, -3)}} às {{substr($horario->hora_termino, 0, -3)}}</td>
                        <td>{{$horario->local->nome}}</td>
                        <td><a href="{{ route('participantes.edit', $horario->id) }}" class="btn btn-primary btn-sm">Participantes</a></td>
                    </tr>
                    @endforeach
                    @if (count($horarios) == 0)
                    <tr>
                        <td colspan="5">Nenhum registro encontrado!</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        <div>
    <div>
<div>
@endsection