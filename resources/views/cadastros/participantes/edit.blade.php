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

$urlVoltar = url('participantes');
if (Session::get('tela') == 'edit_horario') {
    $urlVoltar = route('horarios.edit', $horario->id);
}
@endphp
                    
@extends('layouts.app')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="container">
    <h4>{{$horario->atividade->nome}}</h4>
    <h4>{{$arrDiaSemana[$horario->dia_semana]}} - De {{substr($horario->hora_inicio, 0, -3)}} às {{substr($horario->hora_termino, 0, -3)}} - {{$horario->local->numero}} - {{$horario->local->nome}}</h4>
    <div class="card uper">
        <div class="card-header">
            Participantes
            <a href="{{ $urlVoltar }}" class="float-right">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-left-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                    <path fill-rule="evenodd" d="M8.354 11.354a.5.5 0 0 0 0-.708L5.707 8l2.647-2.646a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708 0z"/>
                    <path fill-rule="evenodd" d="M11.5 8a.5.5 0 0 0-.5-.5H6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 .5-.5z"/>
                </svg>
                Voltar
            </a>
            <span class="float-right">&nbsp;|&nbsp;</span>
            <a href="{{ url('participantes/create') }}" class="float-right">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4 1h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H4z"/>
                    <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z"/>
                </svg>
                Adicionar Participante
            </a>
        </div>
        <div class="card-body">
            @include('components.alertas')
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td><b>Colaborador</b></td>
                        <td><b>Função</b></td>
                        <td><b>Ações</b></td>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $participanteController = new \App\Http\Controllers\Cadastros\ParticipanteController();
                    $participantes = $participanteController->loadParticipantes($horario->atividade->id);
                    @endphp

                    @foreach($participantes as $participante)
                    <tr>
                        <td>{{$participante->colaborador->pessoa->nome}}</td>
                        <td>{{$participante->funcao->nome}}</td>
                        <td>
                            <form action="{{ route('participantes.destroy', $horario->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" id="partic_colaborador_id" name="partic_colaborador_id" value="{{ $participante->colaborador->id }}">
                                <button class="btn btn-danger btn-sm" type="submit">Remover</button>
                              </form>
                        </td>
                    </tr>
                    @endforeach
                    @if (count($participantes) == 0)
                    <tr>
                        <td colspan="3">Nenhum registro encontrado!</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection