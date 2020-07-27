@php
$arrSituacao = array(
    '1' => "Ativado",
    '2' => "Desativado"
);
$bgColor = array(
    '1' => "success",
    '2' => "danger"
);
@endphp
                    
@extends('layouts.app')

@section('javascript')
<script>
    top.urlListaAtividades = "{{ url('atividades') }}";
    top.urlAtivarDesativarAtividade = "{{ url('atividades/ativar-desativar-atividade') }}";
</script>
<script type="text/javascript" src="{{ asset('/js/cadastros/atividades/index-atividade.js') }}"></script>
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
            Lista de Atividades
            <a href="{{ url('atividades/create') }}" class="float-right">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4 1h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H4z"/>
                    <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z"/>
                </svg>
                Adicionar Atividade
            </a>
        </div>

        <div class="card-body">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <td><b>Cadastrado em</b></td>
                        <td><b>Nome</b></td>
                        <td><b>Situação</b></td>
                        <td colspan="2"><b>Ações</b></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($atividades as $atividade)
                    <tr>
                        <td>{{date('d/m/Y H:i:s', strtotime($atividade->created_at))}}</td>
                        <td>{{$atividade->nome}}</td>
                        <td>
                            <span class="badge badge-{{$bgColor[$atividade->situacao]}}"
                                data-toggle="tooltip" title="{{$arrSituacao[$atividade->situacao]}}">
                                {{$arrSituacao[$atividade->situacao]}}
                            </span>
                        </td>
                        <td><a href="{{ route('atividades.edit', $atividade->id) }}" class="btn btn-primary btn-sm">Editar</a></td>
                        <td>
                            @if ($atividade->situacao == 1)
                            <button class="btn btn-danger btn-sm" type="button" title="Desativar" 
                                onclick="ativarDesativarAtividade({{ $atividade->id }})"> Desativar
                            </button>
                            @else
                            <button class="btn btn-success btn-sm" type="button" title="Ativar" 
                                onclick="ativarDesativarAtividade({{ $atividade->id }})"> Ativar
                            </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        <div>

    <div>
<div>
@endsection