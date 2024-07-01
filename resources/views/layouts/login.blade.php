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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- MetisMenu CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/3.0.7/metisMenu.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/css/sistema.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css" rel="stylesheet">

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
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/3.0.7/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sistema.js"></script>

</body>

</html>
