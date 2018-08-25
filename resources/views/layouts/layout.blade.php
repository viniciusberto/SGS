@php
    use App\User;
@endphp
        <!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistema de gerênciamento de ordem de serviço">
    <meta name="author" content="Vinícius Berto">
    <!-- Bootstrap Core CSS -->
    <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    {{--JQuery UI--}}
    <link href="/vendor/jquery/css/jquery-ui.min.css" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link href="/vendor/morrisjs/morris.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">
    <link rel="shortcut icon" href="/favicon.png"/>
    <!-- Custom CSS -->
    <link href="/css/sistema.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <title>Sistema HávilaInfo - @yield('title')</title>
</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top navegacao" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Menu</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand link-layout" href="{{ route('dashboard.index') }}"><img class="logo"
                                                                                           src="/imagens/logo.png"></a>
        </div>


        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle link-layout" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a class="link-layout">{{ Auth::user()->name }}</a></li>
                    <li class="divider"></li>
                    <li><a class="link-layout" href="#"><i class="fa fa-user"></i> Perfil</a>
                    </li>
                    <li><a class="link-layout" href="#"><i class="fa fa fa-cogs"></i> Sistema</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a class="link-layout" href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"><i class="fa fa-sign-out-alt"></i>
                            Sair</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    {{--<li class="sidebar-search">--}}
                    {{--<div class="input-group custom-search-form">--}}
                    {{--<input type="text" class="form-control" placeholder="Pesquisa...">--}}
                    {{--<span class="input-group-btn">--}}
                    {{--<button class="btn btn-default" type="button">--}}
                    {{--<i class="fa fa-search"></i>--}}
                    {{--</button>--}}
                    {{--</span>--}}
                    {{--</div>--}}
                    {{--<!-- /input-group -->--}}
                    {{--</li>--}}
                    <li>
                        <a class="link-layout" href="{{route('dashboard.index')}}"><i class="fa fa-tachometer-alt"></i>
                            Painel de Controle</a>
                    </li>

                    <li>
                        <a class="link-layout" href="#"><i class="fa fa-phone-volume"></i> Chamado<span
                                    class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">

                            <li>
                                <a class="link-layout" href="{{route('chamado.create')}}"><i
                                            class="fa fa-folder-open"></i> Abrir</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>

                    @if(Auth::user()->tipo != \App\User::TIPO_SOLICITANTE)
                        <li class="teste">
                            <a class="link-layout" href="#"><i class="fa fa-briefcase"></i> Gerenciamento<span
                                        class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                @if(Auth::user()->tipo == \App\User::TIPO_ADMIN)
                                    <li>
                                        <a class="link-layout" href="{{route('empresa.index')}}"><i
                                                    class="fa fa-industry"></i> Empresas</a>
                                    </li>
                                    <li>
                                        <a class="link-layout" href="{{route('usuario.index')}}"><i
                                                    class="fa fa-users"></i> Usuários</a>
                                    </li>
                                    <li>
                                        <a class="link-layout" href="{{route('sla.index')}}"><i
                                                    class="fa fa-clock"></i> SLA's</a>
                                    </li>
                                @endif
                                <li>
                                    <a class="link-layout" href="{{route('prioridade.index')}}"><i
                                                class="fa fa-flag-checkered"></i> Prioridades</a>
                                </li>
                                <li>
                                    <a class="link-layout" href="{{route('dispositivo.index')}}"><i
                                                class="fa fa-desktop"></i> Dispositivos</a>
                                </li>
                                <li>
                                    <a class="link-layout" href="{{route('produto.index')}}"><i
                                                class="fa fa-cogs"></i> Produtos</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                    @endif

                    <li>
                        <a class="link-layout" href="#"><i class="fa fa-chart-pie"></i> Relatórios<span
                                    class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">

                            <li>
                                <a class="link-layout" href="{{route('relatorio.novo')}}"><i
                                            class="fa fa-chart-bar "></i> Gerar</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <!-- Page Content -->
    <div id="page-wrapper" class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">@yield('title')</h1>
                    <div class="row">
                        <div class="col-md-12 alertas">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    <strong>{{ session('status') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>

                    @yield('content')

                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="/vendor/jquery/js/jquery.min.js"></script>
<script src="/vendor/jquery/js/jquery-ui.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>

<script src="/vendor/popper/popper.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="/vendor/metisMenu/metisMenu.min.js"></script>

<!-- Validação de formulários -->
<script src="/js/validator.js"></script>

<!-- Custom Theme JavaScript -->
<script src="/js/sistema.js"></script>


</body>
</html>