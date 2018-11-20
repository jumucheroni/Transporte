<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
	//include './inc/header.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Transporte Escolar</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

   <link href="css/bootstrap.css" rel="stylesheet">
   <link href='http://fonts.googleapis.com/css?family=Open+Sans:600,400' rel='stylesheet' type='text/css'>
  <link href="css/animate.min.css" rel="stylesheet">
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/magnific-popup/magnific-popup.css" rel="stylesheet">
  <link href="css/index.css" rel="stylesheet">

</head>

<body>

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
          <li><a href="logout.php">Sair</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <section id="intro">

    <div class="intro-text">
    <br>
      <h2>Bem vindo ao Rote</h2>
      <p>Faça seus roteiros de transporte escolar e organize pagamentos e recibos</p>
    </div>
  </section>

  <main id="main">

    <section id="about" class="section-bg">
      <div class="container-fluid">
        <div class="section-header">
          <h3 class="section-title">Sobre o ROTE</h3>
          <span class="section-divider"></span>
          <p class="section-description">
          	Roteirização Otimizada de Transporte Escolar
          </p>
        </div>

        <div class="row">

          <div class="col-12 content">
	          <div class="wow fadeInLeft" style="visibility: visible; animation-name: fadeInLeft;">
	            <p>
	              O ROTE é um sistema para auxiliar na montagem e controle do trajeto realizado por condutores no transporte escolar. 
	            </p>

	            <ul>
	              <li><i class="fa fa-pencil"></i> Cadastro personalizado dos transportes, crianças, condutores e escolas.</li>
	              <li><i class="fa fa-money"></i> Organização das despesas,pagamentos e recibos.</li>
	              <li><i class="fa fa-map-marker"></i> Geração de relatórios e mapas interativos e roteirizados.</li>
	            </ul>

	            <p>
	              Tudo desenvolvido para que seja a melhor forma de levar seus passageiros para os seus destinos. 
	            </p>
	          </div>
        </div>

      </div>
    </section>

    <section id="more-features" class="section-bg">
      <div class="container">

        <div class="section-header">
          <h3 class="section-title">Funcionalidades</h3>
          <span class="section-divider"></span>
          <p class="section-description">Abaixo há detalhadamente as funcionalidades que podem ser encontradas no ROTE</p>
        </div>

        <div class="row">

          <div class="col-lg-6">
            <div class="box wow fadeInLeft">
              <div class="icon"><i class="fa fa-pencil"></i></div>
              <h4 class="title"><a href="">Controle</a></h4>
              <p class="description">No menu Controle é possível fazer o cadastro de condutores, ajudantes, veículos, condução, responsáveis, crianças, escolas, transportes. Todos seguem o mesmo padrão, ao clicar no menu correspondente abrirá uma p[agina mostrando todos os cadastros daquele item, onde será possível editar, excluir e ver mais detalhes deles, também sendo possível criar novos.</p>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="box wow fadeInRight">
              <div class="icon"><i class="fa fa-money"></i></div>
              <h4 class="title"><a href="">Finaceiro</a></h4>
              <p class="description">No menu Financeiro é possível cadastrar as despesas com os veículos e também criar os contratos e assim posteriormente registrar o recebimento das mensalidades acordadas e assim imprimir recibos referentes aos meses. As mensalidades são criadas a partir do período de vigência do contrato e é possível fazer baixa parcial das mensalidades.</p>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="box wow fadeInLeft">
              <div class="icon"><i class="fa fa-file-archive-o"></i></div>
              <h4 class="title"><a href="">Relatórios</a></h4>
              <p class="description">No menu relatórios é possível imprimir relatórios de crianças, pagamentos e despesas. Das crianças é possível selecionar por responsável, por escola, por período ou veículo. Os pagamentos é possível selecionar por Data de pagamento, data de vencimento, status do pagamento e criança. E as despesas é possível por data, tipo da despesa e veículo.</p>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="box wow fadeInRight">
              <div class="icon"><i class="fa fa-map-marker"></i></div>
              <h4 class="title"><a href="">Itinerários</a></h4>
              <p class="description">No menu Itinerários há dois tipos de mapas para visualização, nos dois mapas é possível trazer os dados por escola ou todas as escolas, o primeiro é o mapa de pontos que mostra todos locais, onde o caminho pode ser montado e exportado pelo pelo usuário. O segundo é o mapa roteirizado que mostra um caminho otimizado levando em consideração as distâncias entre os locais. </p>
            </div>
          </div>

        </div>
      </div>
    </section>

    <section id="team" class="section-bg">
      <div class="container">
        <div class="section-header">
          <h3 class="section-title">Colaboradoras</h3>
          <span class="section-divider"></span>
          <p class="section-description"></p>
        </div>
        <div class="row wow fadeInUp">
          <div class="col-lg-6 col-md-6">
            <div class="member">
              <div class="pic"><img src="img/Juliana.jpeg" alt="" width="45%" height="100%"></div>
              <h4>Juliana Carvalho Mucheroni</h4>
              <span>151021121</span>
            </div>
          </div>

          <div class="col-lg-6 col-md-6">
            <div class="member">
              <div class="pic"><img src="img/Mariana.jpeg" alt="" width="45%" height="100%"></div>
              <h4>Mariana Xavier Moreira</h4>
              <span>151020531</span>
            </div>
          </div>
        </div>

      </div>
    </section>

  </main>

<?php include './inc/footer.php'; }
?>