<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!-- Styles Extras -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('bootstrap/4.4.1/css/bootstrap-datepicker.css') }}" rel="stylesheet"/>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item active">
                                <a class="nav-link" href="{{ url('home') }}">Home <span class="sr-only">(current)</span></a>
                            </li>
                            
                            @can('Menu_Colaboradors')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('colaboradors') }}">Colaboradores</a>
                            </li>
                            @endcan
                            
                            @can('Menu_Cadastros')
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown1" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Cadastros <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown1">
                                    <a class="dropdown-item" href="{{ url('funcaos') }}">
                                        Funções
                                    </a>
                                    <a class="dropdown-item" href="{{ url('locals') }}">
                                        Locais
                                    </a>
                                    <a class="dropdown-item" href="{{ url('atividades') }}">
                                        Atividades
                                    </a>
                                </div>
                            </li>
                            @endcan

                            @can('Menu_Acl')
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown6" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Controle de Acesso <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown6">
                                    <a class="dropdown-item" href="{{ url('permissions') }}">
                                        Permissões
                                    </a>
                                    <a class="dropdown-item" href="{{ url('roles') }}">
                                        Perfis
                                    </a>
                                    <a class="dropdown-item" href="{{ url('users') }}">
                                        Usuários
                                    </a>
                                </div>
                            </li>
                            @endcan

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @if (Session::get('pessoa_id') != "")
                                    <a class="dropdown-item" href="{{ url('pessoas/' . Session::get('pessoa_id') . '/edit') }}">
                                        Meus Dados Cadastrais
                                    </a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>   
    
    <!-- Modal Alerta -->
    <div id="modalAlerta" style="display: none;" class="modal fade" 
            tabindex="-1" role="dialog" aria-labelledby="modalAlertaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalAlertaLabel">
                        <i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;Alerta
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                        <span class="sr-only">Fechar</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div id="conteudoModalAlerta" style="color: #000000;"></div>
                        &nbsp;<br>&nbsp;
                        <div class="col-lg-6 col-md-6 center">
                            <button type="button" id="btnOk" class="btn btn-primary">
                                <i class="glyphicon glyphicon-ok"></i> Ok
                            </button>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- Fim Modal -->

    <!-- Modal -->
    <div class="modal fade" id="confirmModalLong" tabindex="-1"
            role="dialog" aria-labelledby="confirmModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="confirmModalLongTitle">
                        <i class="fa fa-question-circle"></i>&nbsp;&nbsp;Confirmação
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="conteudoConfirmModalLong">
                    <p>One fine body&hellip;</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Não</button>
                    <button type="button" id="btnSim" class="btn btn-primary">Sim</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- Progess bar -->
    <div id="carregando" style="display: none;">
        <div id="conteudoCarregando">
            <div>
                <i class="fa fa-spin fa-spinner"></i> Processando...
            </div>
            <div class="progress progress-striped active">
                <div class="progress-bar" role="progressbar" 
                        aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
            </div>
        </div>
    </div>
    <!-- /.progress bar -->

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- JavaScripts Extras -->
    <script type="text/javascript" src="{{ asset('js/componentes.js') }}"></script>
		
    <script src="{{ asset('bootstrap/4.4.1/js/bootstrap-datepicker.min.js') }}"></script> 
    <script src="{{ asset('bootstrap/4.4.1/js/bootstrap-datepicker.pt-BR.min.js') }}" charset="UTF-8"></script>
    
    @yield('javascript')

</body>
</html>
