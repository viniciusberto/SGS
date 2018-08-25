<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistema de gerênciamento de ordem de serviço">
    <meta name="author" content="Vinícius Berto">

    <title>Sistema HávilaInfo - @yield('titulo')</title>

    <!-- Bootstrap Core CSS -->
    <link href="/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/css/sistema.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="/vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">


    <link rel="shortcut icon" href="/favicon.png" />


</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top navegacao" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ route('dashboard.index') }}"><img class="logo" src="/imagens/logo.png"></a>
            </div>
            <!-- /.navbar-header -->
        </nav>


        @yield('content')


    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="/vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sistema.js"></script>

</body>

</html>