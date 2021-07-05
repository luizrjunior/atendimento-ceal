@php
    $cpf = $pessoa->cpf;
    $nome = $pessoa->nome;
    $nascimento = date('d/m/Y', strtotime($pessoa->nascimento));
    $sexo = $pessoa->sexo;
    $telefone = $pessoa->telefone;
    $profissao = $pessoa->profissao;
    $socio = $pessoa->socio;
    $bairro = $pessoa->bairro;
@endphp

@extends('layouts.app')

@section('javascript')
    <script type="text/javascript"
            src="{{ asset('/js/plugins/jquery.maskedinput.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('/js/pessoas/create-edit-pessoa.js') }}"></script>
    <script>
        $('#sexo').val('{{ $sexo }}');
        $('#socio').val('{{ $socio }}');
    </script>
@endsection

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="container">
        <div class="row justify-content-center">
            @include('components.alertas')

            <div class="col-md-8">
                <div class="card uper">
                    <div class="card-header">
                        Editar Dados Cadastrais
                    </div>
                    <div class="card-body">

                        <form method="post" action="{{ route('pessoas.update', $pessoa->id) }}">
                            @method('PATCH')
                            @csrf

                            @include('pessoas.partials.edit-pessoa')

                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary">
                                    Atualizar
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
