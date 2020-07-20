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
                        <a class="nav-link" href="{{ url('colaboradores') }}">Colaboradores</a>
                    </li>
                    @endcan
                    
                    @can('Menu_Cadastros')
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown1" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Cadastros <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown1">
                            <a class="dropdown-item" href="{{ url('funcoes') }}">
                                Funções
                            </a>
                            <a class="dropdown-item" href="{{ url('locais') }}">
                                Locais
                            </a>
                            <a class="dropdown-item" href="{{ url('atividades') }}">
                                Atividades
                            </a>
                            <a class="dropdown-item" href="{{ url('motivos') }}">
                                Motivos
                            </a>
                            <a class="dropdown-item" href="{{ url('orientacoes') }}">
                                Orientações
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
