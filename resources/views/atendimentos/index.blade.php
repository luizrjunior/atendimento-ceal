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
        '2' => "FILA DE ESPERA",
        '3' => "CANCELADO",
        '4' => "CONCLUÍDO",
        '5' => "LIBERADO",
        '6' => "EM ANDAMENTO",
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
                <a href="{{ url('home') }}" class="float-right">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-house-door-fill" fill="currentColor"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.5 10.995V14.5a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .146-.354l6-6a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 .146.354v7a.5.5 0 0 1-.5.5h-4a.5.5 0 0 1-.5-.5V11c0-.25-.25-.5-.5-.5H7c-.25 0-.5.25-.5.495z"/>
                        <path fill-rule="evenodd" d="M13 2.5V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
                    </svg>
                    Home
                </a>
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
                            <td>{{date('d/m/Y', strtotime($atendimento->data_atendimento))}}</td>
                            <td>{{$atendimento->horario->atividade->nome}}</td>
                            <td>{{$arrDiaSemana[$atendimento->horario->dia_semana]}}
                                - {{substr($atendimento->horario->hora_inicio, 0, -3)}}
                                às {{substr($atendimento->horario->hora_termino, 0, -3)}}</td>
                            <td>{{$atendimento->horario->local->nome}} - {{$atendimento->horario->local->numero}}</td>
                            <td>{{$arrForma[$atendimento->forma]}}</td>
                            <td>
                            <span class="badge badge-{{$bgColor[$atendimento->situacao]}}"
                                  data-toggle="tooltip" title="{{$arrSituacao[$atendimento->situacao]}}">
                                {{$arrSituacao[$atendimento->situacao]}}
                            </span>
                            </td>
                            <td><a href="{{ route('atendimentos.edit', $atendimento->id) }}"
                                   class="btn btn-primary btn-sm">Visualizar</a></td>
                        </tr>
                    @endforeach
                    @if (count($atendimentos) == 0)
                        <tr>
                            <td colspan="7">Nenhum registro encontrado!</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

