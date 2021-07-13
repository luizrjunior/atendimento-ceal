@php
    $arrSituacao = array(
        '1' => "ATIVADO",
        '2' => "DESATIVADO"
    );
    $bgColor = array(
        '1' => "success",
        '2' => "danger"
    );
    $nome_psq = $data['nome_psq'] ? $data['nome_psq'] : "";
    $situacao_psq = $data['situacao_psq'] ? $data['situacao_psq'] : "";
    $totalPage = $data['totalPage'] ? $data['totalPage'] : 25;
@endphp

@extends('layouts.app')

@section('javascript')
    <script>
        top.urlListaColaboradores = "{{ url('colaboradores') }}";
        top.urlAtivarDesativarColaborador = "{{ url('colaboradores/ativar-desativar-colaborador') }}";
        $('#situacao_psq').val({{$situacao_psq}});
    </script>
    <script type="text/javascript" src="{{ asset('/js/pessoas/colaboradores/index-colaborador.js') }}"></script>
@endsection

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="container">

        <form method="post" action="{{ route('colaboradores.index') }}">
            @csrf

            <div class="card uper">
                <div class="card-header">
                    Filtro de Colaboradores
                </div>
                <div class="card-body">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nome_psq">{{ __('Name') }}</label>
                            <input id="nome_psq" type="text"
                                   class="form-control @error('nome_psq') is-invalid @enderror maiuscula"
                                   name="nome_psq" value="{{ $nome_psq }}" autocomplete="nome_psq">
                            @error('nome_psq')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="situacao_psq">Situação</label>
                            <select class="form-control @error('situacao_psq') is-invalid @enderror" id="situacao_psq"
                                    name="situacao_psq">
                                <option value=""> - - TODAS - -</option>
                                <option value="1">ATIVADOS</option>
                                <option value="2">DESATIVADOS</option>
                            </select>
                            @error('situacao_psq')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <button type="submit" class="btn btn-primary">
                                Pesquisar
                            </button>
                        </div>
                    </div>

                    <div class="card uper">
                        <div class="card-header">
                            Lista de Colaboradores
                            <a href="{{ url('colaboradores/create') }}" class="float-right">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-plus" fill="currentColor"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M4 1h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H4z"/>
                                    <path fill-rule="evenodd"
                                          d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z"/>
                                </svg>
                                Adicionar Colaborador
                            </a>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <td><b>Nome</b></td>
                                    <td><b>Telefone</b></td>
                                    <td><b>Bairro</b></td>
                                    <td><b>Situação</b></td>
                                    <td colspan="2"><b>Ações</b></td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($colaboradores as $colaborador)
                                    <tr>
                                        <td>{{$colaborador->nome}}</td>
                                        <td>{{$colaborador->telefone}}</td>
                                        <td>{{$colaborador->bairro}}</td>
                                        <td>
                            <span class="badge badge-{{$bgColor[$colaborador->situacao]}}"
                                  data-toggle="tooltip" title="{{$arrSituacao[$colaborador->situacao]}}">
                                {{$arrSituacao[$colaborador->situacao]}}
                            </span>
                                        </td>
                                        <td><a href="{{ route('colaboradores.edit', $colaborador->id) }}"
                                               class="btn btn-primary btn-sm">Visualizar</a></td>
                                        <td>
                                            @if ($colaborador->situacao == 1)
                                                <button class="btn btn-danger btn-sm" type="button" title="Desativar"
                                                        onclick="ativarDesativarColaborador({{ $colaborador->id }})"> Desativar
                                                </button>
                                            @else
                                                <button class="btn btn-success btn-sm" type="button" title="Ativar"
                                                        onclick="ativarDesativarColaborador({{ $colaborador->id }})"> Ativar
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                @if (count($colaboradores) == 0)
                                    <tr>
                                        <td colspan="6">Nenhum registro encontrado!</td>
                                    </tr>
                                @endif

                                @if (isset($data))
                                    <tr>
                                        <td>
                                            <input id="totalPage" name="totalPage" type="text" value="{{ $totalPage }}"
                                                   class="form-control" size="10" style="text-align: right;">
                                            Registros por página
                                        </td>
                                        <td colspan="6">
                                            {{  $colaboradores->appends($data)->links() }}
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>
                                            <input id="totalPage" name="totalPage" type="text" value="{{ $totalPage }}"
                                                   class="form-control" size="10" style="text-align: right;">
                                            Registros por página
                                        </td>
                                        <td colspan="6">
                                            {{ $colaboradores->links() }}
                                        </td>
                                    </tr>
                                @endif

                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
            </div>


        </form>

    </div>
@endsection
