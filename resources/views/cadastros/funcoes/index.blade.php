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
    top.urlListaFuncoes = "{{ url('funcoes') }}";
    top.urlAtivarDesativarFuncao = "{{ url('funcoes/ativar-desativar-funcao') }}";
</script>
<script type="text/javascript" src="{{ asset('/js/cadastros/funcoes/index-funcao.js') }}"></script>
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
            Lista de Funções
            <a href="{{ url('funcoes/create') }}" class="float-right">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4 1h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H4z"/>
                    <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z"/>
                </svg>
                Adicionar Função
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
                    @foreach($funcoes as $funcao)
                    <tr>
                        <td>{{date('d/m/Y H:i:s', strtotime($funcao->created_at))}}</td>
                        <td>{{$funcao->nome}}</td>
                        <td>
                            <span class="badge badge-{{$bgColor[$funcao->situacao]}}"
                                data-toggle="tooltip" title="{{$arrSituacao[$funcao->situacao]}}">
                                {{$arrSituacao[$funcao->situacao]}}
                            </span>
                        </td>
                        <td><a href="{{ route('funcoes.edit', $funcao->id) }}" class="btn btn-primary btn-sm">Editar</a></td>
                        <td>
                            @if ($funcao->situacao == 1)
                            <button class="btn btn-danger btn-sm" type="button" title="Desativar" 
                                onclick="ativarDesativarFuncao({{ $funcao->id }})"> Desativar
                            </button>
                            @else
                            <button class="btn btn-success btn-sm" type="button" title="Ativar" 
                                onclick="ativarDesativarFuncao({{ $funcao->id }})"> Ativar
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