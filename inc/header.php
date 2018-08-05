<DOCTYPE HTML>
<html leng="pt-br">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:600,400' rel='stylesheet' type='text/css'>
        <link href="css/style.css" rel="stylesheet">
        <link href="css/jquery-ui-1.10.3.css" rel="stylesheet">
        <link href="css/jquery.gritter.css" rel="stylesheet">
        <link rel="shortcut icon" href="images/icon.png">
        
        <title>Transporte Escolar</title>
    
    </head>

    <body>

        <div id="framework">

            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Transporte Escolar</a>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Controle <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="./visu_ajudante.php">Ajudante</a></li>
                                    <li><a href="./visu_condutor.php">Condutor</a></li>
                                    <li><a href="./visu_condveic.php">Condução</a></li>
                                    <li><a href="./visu_crianca.php">Criança</a></li>
                                    <li><a href="./visu_escola.php">Escola</a></li>
                                    <li><a href="./visu_responsavel.php">Responsável</a></li>
                                    <li><a href="./visu_trecho.php">Transportes</a></li>
                                    <li><a href="./visu_veiculo.php">Veículo</a></li>
                                    <li><a href="./visu_avisos.php">Avisos</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Financeiro <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="./visu_contrato.php">Contratos</a></li>
                                    <li><a href="./cad_recebimentos.php">Recebimentos</a></li>
                                    <li><a href="./visu_despesas.php">Despesas</a></li>
                                    <li><a href="./visu_recibos.php">Recibos</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Relatórios <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="./rel_crianca.php">Crianças</a></li> <!-- escola, responsavel, veiculo e periodo -->
                                    <li><a href="./rel_pagamentos.php">Pagamentos</a></li>
                                    <li><a href="./rel_despesas.php">Despesas</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Itinerários <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="./itinerarios.php">Mapa</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container-fluid">
                <div id="canvas1" class="row">
                    <div class="col-xs-12 col-md-12 col-lg-10 col-lg-offset-1">