<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {

    include './inc/header.php'; 
    include './inc/conexao.php';

    $enablechave = "readonly";

    $id = explode("-", $_GET['id']);

    $sql = "select * from condutorveiculo where placa_veiculo='".$id[1]."' and cpf_condutor='".$id[0]."' and periodo='".$id[2]."'";
    $result = $conexao->query($sql);
    $row = @mysqli_fetch_array($result);

    $veiculo        = @$row["placa_veiculo"];
    $condutor       = @$row["cpf_condutor"];
    $periodo        = @$row["periodo"];

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

      <form id="condveic" method="post" role="form"> 
         <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <h1 class="page-header">Condução</h1>
        
              <div class="row">
                <div class="col-md-4">
                  <div id="veic-form" class="form-group">
                    <p class="formu-letra">Veículo</p>
                    <h4><?php print $veiculo; ?></h4>
                  </div>
                </div>
                <div class="col-md-4">
                  <div id="condutor-form" class="form-group">
                    <p class="formu-letra">Condutor</p>
                    <h4><?php print $condutor; ?></h4>
                  </div>
                </div>
                <div class="col-md-4">
                  <div id="periodo-form" class="form-group">
                    <p class="formu-letra">Período</p>
                    <h4><?php if ($periodo == 'im') print "Ida-Manhã";
                              if ($periodo == 'it') print "Ida-Tarde";
                              if ($periodo == 'vm') print "Volta-Manhã";
                              if ($periodo == 'vt') print "Volta-Tarde"; ?>
                    </h4>
                  </div>
                </div>
              </div>     
            </div>
              
          
              <div class="row">
                <div class="col-md-12">
                  <a href="visu_condveic.php" class="btn btn-link  btn-right" type="button">Voltar</a>                  
                </div>
              </div>

              
            </div>         
          </div>
        </form>
      </div>

<?php include './inc/footer.php'; ?>

<script src="js/condveic.js"></script>

<?php } ?>