<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {

    include './inc/header.php'; 
    include './inc/conexao.php';

    $enablechave = "readonly";

    $id = $_GET['id'];

    $sql = "select * from contrato where id=".$id;
    $result = $conexao->query($sql);
    $row = @mysqli_fetch_array($result);

      $id                         = $row["id"];
      $id_crianca                 = $row["id_crianca"];
      $data_inicio_contrato       = DbToDt($row["data_inicio_contrato"]);
      $data_fim_contrato          = DbToDt($row["data_fim_contrato"]);
      $dia_vencimento_mensalidade = $row["dia_vencimento_mensalidade"];
      $mensalidade                = $row["mensalidade"];

?>
    <div class="row">
      <div class="row">
        <ol class="breadcrumb">
          <li><a href="index.php">
            <em class="fa fa-home"></em>
          </a></li>
          <li class="active">Controle</li>
          <li class="active">Condução</li>
        </ol>
      </div>

      <form id="contrato" method="post" role="form"> 
         <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <h1 class="page-header">Contrato</h1>

               <div class="row">
                <div class="col-md-3">
                  <div id="id_crianca-form" class="form-group">
                    <p class="formu-letra">Criança</p>
                    <h4><?php print $id_crianca; ?></h4>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="data_inicio_contrato-form" class="form-group">
                    <p class="formu-letra">Data Inicio do Contrato</p>
                    <h4><?php print $data_inicio_contrato; ?></h4>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="data_fim_contrato-form" class="form-group">
                    <p class="formu-letra">Data Final do Contrato</p>
                    <h4><?php print $data_fim_contrato; ?></h4>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="dia_vencimento_mensalidade-form" class="form-group">
                    <p class="formu-letra">Dia Vencimento</p>
                    <h4><?php print $dia_vencimento_mensalidade; ?></h4>
                  </div>
                </div>
              </div>  
              <div class="row">
                <div class="col-md-3">
                  <div id="mensalidade-form" class="form-group">
                    <p class="formu-letra">Mensalidade</p>
                    <h4><?php print $mensalidade; ?></h4>
                  </div>
                </div>
                <div class="col-md-6">
                  <div id="trecho-form" class="form-group">
                    <p class="formu-letra">Transportes</p>
                    <!-- carregar os transportes deste contrato -->
                  </div>
                </div>
              </div>        
              
          
              <div class="row">
                <div class="col-md-12">
                  <a href="visu_contrato.php" class="btn btn-link  btn-right" type="button">Voltar</a>                  
                </div>
              </div>

              
            </div>         
          </div>
        </form>
      </div>

<?php include './inc/footer.php'; ?>

<script src="js/contrato.js"></script>

<?php } ?>