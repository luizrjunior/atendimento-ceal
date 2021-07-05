@php
    $pessoa = isset($pessoa) ? $pessoa : null;
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
    <script>
        top.routeCarregarPessoaCPF = "{{ route('pessoas.carrregar-pessoa-cpf') }}";
        top.routeSelecionarPessoaAtendimento = '{{ url('/pessoas-admin/' . $pessoa->id . '/selecionar') }}';
    </script>
    <script type="text/javascript"
            src="{{ asset('/js/plugins/jquery.maskedinput.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('/js/pessoas/admin/create-edit-pessoa.js') }}"></script>
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
            <div class="col-md-12">
                @include('components.alertas')
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card uper">
                    <div class="card-header">
                        Editar Dados Cadastrais
                        <a href="{{ url('pessoas-admin') }}" class="float-right">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-left-square"
                                 fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                <path fill-rule="evenodd"
                                      d="M8.354 11.354a.5.5 0 0 0 0-.708L5.707 8l2.647-2.646a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708 0z"/>
                                <path fill-rule="evenodd"
                                      d="M11.5 8a.5.5 0 0 0-.5-.5H6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 .5-.5z"/>
                            </svg>
                            Voltar
                        </a>
                    </div>
                    <div class="card-body">

                        <form id="formPessoaEdit" method="post"
                              action="{{ route('pessoas.admin.update', $pessoa->id) }}">
                            @method('PATCH')
                            @csrf
                            <input type="hidden" id="paciente_id" name="paciente_id" value="{{ $pessoa->id }}">

                            @include('pessoas.partials.edit-pessoa')

                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary" onclick="return validar();">
                                    Atualizar
                                </button>
                                @if (Session::get('tela') == 'create_atendimento_admin' && Session::get('horario_id') != '' && Session::get('situacao') != '' && Session::get('data_atendimento') != '')
                                <button id="btnSelecionarPessoa" type="button" class="btn btn-info"
                                        onclick="selecionarPessoaParaAtendimento();">
                                    Selecionar
                                </button>
                                @endif
                            </div>

                        </form>

                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection

