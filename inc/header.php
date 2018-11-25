<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:600,400' rel='stylesheet' type='text/css'>
        <link href="css/style.css" rel="stylesheet">
        <link href="css/jquery-ui-1.10.3.css" rel="stylesheet">
        <link href="css/jquery.gritter.css" rel="stylesheet">
        <link href="css/datepicker3.css" rel="stylesheet">
        <link href="css/styles.css" rel="stylesheet">
        <link href="css/index.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link rel="shortcut icon" href="images/icon.png">
        <link href="css/animate.min.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="css/magnific-popup/magnific-popup.css" rel="stylesheet">
        
        <title>Transporte Escolar</title>
    
    </head>

    <body>
    <div id="modal" class="modal fade bd-example-modal-lg" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="width: 48px">
            <span class="fa fa-spinner fa-spin fa-3x"></span>
        </div>
    </div>
</div>
        <header id="header" class="header-fixed">
            <div class="container">

              <div id="logo" class="pull-left">
                <h1><a href="./index.php"><img src="img/logo.png" alt="" title="" width="90px" height="55px"></a></h1>
              </div>

              <nav id="nav-menu-container">
                <ul class="nav-menu">
                  <li class="menu-has-children"><a href="">Controle</a>
                    <ul>
                        <li><a href="./visu_ajudante.php">Ajudante</a></li>
                        <li><a href="./visu_condutor.php">Condutor</a></li>
                        <li><a href="./visu_condveic.php">Condução</a></li>
                        <li><a href="./visu_crianca.php">Criança</a></li>
                        <li><a href="./visu_escola.php">Escola</a></li>
                        <li><a href="./visu_responsavel.php">Responsável</a></li>
                        <li><a href="./visu_trecho.php">Transportes</a></li>
                        <li><a href="./visu_veiculo.php">Veículo</a></li>
                    </ul>
                  </li>
                  <li class="menu-has-children"><a href="">Financeiro</a>
                    <ul>
                        <li><a href="./visu_contrato.php">Contratos</a></li>
                        <li><a href="./visu_recebimentos.php">Recebimentos</a></li>
                        <li><a href="./visu_despesas.php">Despesas</a></li>
                        <li><a href="./recibo.php">Recibos</a></li>
                    </ul>
                  </li>
                  <li class="menu-has-children"><a href="">Relatórios</a>
                    <ul>
                        <li><a href="./rel_crianca.php">Crianças</a></li>
                        <li><a href="./rel_pag.php">Pagamentos</a></li>
                        <li><a href="./rel_desp.php">Despesas</a></li>
                    </ul>
                  </li>
                  <li class="menu-has-children"><a href="">Itinerários</a>
                    <ul>
                        <li><a href="./visu_itinerario.php?id=pontos">Mapa de pontos</a></li>
                        <li><a href="./visu_itinerario.php?id=roteiro">Itinerário Otimizado</a></li>
                    </ul>
                  </li> 
                  <li class="menu-has-children"><a href="">Configurações</a>
                    <ul>
                        <li><a href="./cad_conta.php">Cadastrar Conta</a></li>
                        <li><a href="logout.php">Sair</a></li>
                    </ul>
                  </li> 
                 
                </ul>
              </nav>
            </div>
          </header>
            <div class="container-fluid section-bg">
                <div id="canvas1" class="row">
                    <div class="col-xs-12 col-md-12 col-lg-10 col-lg-offset-1">
