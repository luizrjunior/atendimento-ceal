@php
$cpf = $colaborador->pessoa->cpf;
$nome = $colaborador->pessoa->nome;
$nascimento = date('d/m/Y', strtotime($colaborador->pessoa->nascimento));
$sexo = $colaborador->pessoa->sexo;
$telefone = $colaborador->pessoa->telefone;
$profissao = $colaborador->pessoa->profissao;
$socio = $colaborador->pessoa->socio;
$bairro = $colaborador->pessoa->bairro;
@endphp

@extends('layouts.app')

@section('javascript')
<script type="text/javascript" 
    src="{{ asset('/js/plugins/jquery.maskedinput.js') }}"></script>
<script type="text/javascript" 
    src="{{ asset('/js/pessoas/create-edit-pessoa.js') }}"></script>
<script type="text/javascript" 
    src="{{ asset('/js/pessoas/colaboradores/create-edit-colaborador.js') }}"></script>
<script>
    $("#cpf").prop('disabled', true);
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
        <div class="col-md-8">

            <div class="card uper">
                <div class="card-header">
                    Editar Colaborador
                    <a href="{{ url('colaboradores') }}" class="float-right">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-left-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                            <path fill-rule="evenodd" d="M8.354 11.354a.5.5 0 0 0 0-.708L5.707 8l2.647-2.646a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708 0z"/>
                            <path fill-rule="evenodd" d="M11.5 8a.5.5 0 0 0-.5-.5H6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 .5-.5z"/>
                        </svg>
                        Voltar
                    </a>
                </div>
                <div class="card-body">

                    @include('components.alertas')

                    <form method="post" action="{{ route('colaboradores.update', $colaborador->id) }}">
                        @method('PATCH')
                        @csrf

                        @include('pessoas.partials.edit-pessoa')

                    </form>

                </div>
            </div>

            <div class="card uper">
                <div class="card-header">
                    Funções do Colaborador
                </div>
                <div class="card-body">

                    <form method="post" action="{{ route('colaboradores.store-colaborador-tem-funcao') }}">
                        @csrf
                        <input type="hidden" id="colaborador_id" name="colaborador_id" value="{{ $colaborador->id }}">
                        <div class="DocumentList">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td><input type="checkbox" id="checkTodos" name="checkTodos"></td>
                                        <td><b>Função</b></td>
                                    </tr>
                                </thead>
                                <tbody>

                                    @php
                                    $funcaoController = new \App\Http\Controllers\Cadastros\FuncaoController();
                                    $funcoes = $funcaoController->carregarFuncoes();

                                    $colaboradorTemFuncaoController = new \App\Http\Controllers\Pessoas\ColaboradorTemFuncaoController();
                                    $colaboradoresTemFuncoes = $colaboradorTemFuncaoController->carregarFuncoesColaborador($colaborador->id);

                                    $arrFuncoesId = [];
                                    foreach ($colaboradoresTemFuncoes as $colaboradorTemFuncao) {
                                        $arrFuncoesId[] = $colaboradorTemFuncao->funcao_id;
                                    }
                                    @endphp

                                    @foreach($funcoes as $funcao)
                                        @php
                                        $checked = "";
                                        @endphp
                                        @if (count($colaboradoresTemFuncoes) > 0)
                                            @if (in_array($funcao->id, $arrFuncoesId))
                                                @php
                                                $checked = "checked";
                                                @endphp
                                            @endif
                                        @endif
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="funcao" value="{{ $funcao->id }}" name="funcao_id[]" {{ $checked }}>
                                        </td>
                                        <td>{{$funcao->nome}}</td>
                                    </tr>
                                    @endforeach
                
                                    @if (count($funcoes) == 0)
                                    <tr>
                                        <td colspan="4">Nenhum registro encontrado!</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                Salvar  
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection