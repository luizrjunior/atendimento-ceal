@php
$nome_psq = $data['nome_psq'] ? $data['nome_psq'] : "";
$cpf_psq = $data['cpf_psq'] ? $data['cpf_psq'] : "";
$totalPage = $data['totalPage'] ? $data['totalPage'] : 25;
@endphp
                    
@extends('layouts.app')

@section('javascript')
<script type="text/javascript" 
    src="{{ asset('/js/plugins/jquery.maskedinput.js') }}"></script>
<script type="text/javascript" 
    src="{{ asset('/js/pessoas/admin/index-pessoa.js') }}"></script>
@endsection

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="container">

    <form method="post" action="{{ route('pessoas.admin.index') }}">
        @csrf

    <div class="card uper">
        <div class="card-header">
            Filtro de Pessoas
        </div>
        <div class="card-body">

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nome_psq">{{ __('Name') }}</label>
                    <input id="nome_psq" type="text" class="form-control maiuscula" name="nome_psq" value="{{ $nome_psq }}" autocomplete="nome_psq">
                </div>
                <div class="form-group col-md-6">
                    <label for="cpf_psq">CPF</label>
                    <input id="cpf_psq" type="text" class="form-control" name="cpf_psq" value="{{ $cpf_psq }}" autocomplete="cpf_psq">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-primary">
                        Pesquisar
                    </button>
                </div>
            </div>

        </div>
    </div>

    <div class="card uper">
        <div class="card-header">
            Lista de Pessoas
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td><b>Cadastrado em</b></td>
                        <td><b>Nome</b></td>
                        <td><b>Telefone</b></td>
                        <td><b>Bairro</b></td>
                        <td><b>Ações</b></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pessoas as $pessoa)
                    <tr>
                        <td>{{date('d/m/Y H:i:s', strtotime($pessoa->created_at))}}</td>
                        <td>{{$pessoa->nome}}</td>
                        <td>{{$pessoa->telefone}}</td>
                        <td>{{$pessoa->bairro}}</td>
                        <td><a href="{{ route('pessoas.admin.edit', $pessoa->id) }}" class="btn btn-primary btn-sm">Editar</a></td>
                    </tr>
                    @endforeach

                    @if (count($pessoas) == 0)
                    <tr>
                        <td colspan="5">Nenhum registro encontrado!</td>
                    </tr>
                    @endif

                    @if (isset($data))
                    <tr>
                        <td>
                            <input id="totalPage" name="totalPage" type="text" value="{{ $totalPage }}" 
                                class="form-control" size="10" style="text-align: right;">
                                Registros por página
                        </td>
                        <td colspan="4">
                            {{  $pessoas->appends($data)->links() }}
                        </td>
                    </tr>
                    @else
                    <tr>
                        <td>
                            <input id="totalPage" name="totalPage" type="text" value="{{ $totalPage }}" 
                                class="form-control" size="10" style="text-align: right;">
                                Registros por página
                        </td>
                        <td colspan="4">
                            {{ $pessoas->links() }}
                        </td>
                    </tr>
                    @endif
                    
                </tbody>
            </table>
        <div>
    <div>
    </form>

<div>
@endsection