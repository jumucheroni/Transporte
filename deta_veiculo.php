<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
    include './inc/header.php'; 
    include './inc/conexao.php';

    $placa = $_GET['id'];

    $sql = "select * from veiculo where placa='" . $placa ."'";
    $result = $conexao->query($sql);
    $row = @mysqli_fetch_array($result);

    $placa         = $row["placa"];
    $marca         = $row["marca"];
    $modelo        = $row["modelo"];
    $ano           = $row["ano"];
    $lotacao       = $row["lotacao"];
    $cpf_ajudante  = $row["cpf_ajudante"];

    $ajudsql = "select cpf,nome from ajudante where cpf = ".$cpf_ajudante;
    $ajudresult = $conexao->query($ajudsql);
    $ajudrow = @mysqli_fetch_array($ajudresult);

?>
      <div class="row">
        <div class="row">
          <ol class="breadcrumb">
            <li><a href="index.php">
              <em class="fa fa-home"></em>
            </a></li>
            <li class="active">Controle</li>
            <li class="active">Veículo</li>
          </ol>
        </div>
       <form id="veiculo" method="post" role="form"> 
        <input type="hidden" name="acao" id="acao" value="<?php print $acao; ?>" />
         <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
              <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
                <div hidden id="alert"></div>
              </div>
              <div class="col-xs-12 col-sm-8 col-md-10 ">
                <h1 class="page-header">Veículo</h1>
              </div>
          
              <div class="row">
                <div class="col-md-4">
                  <div id="placa-form" class="form-group">
                    <p class="formu-letra">Placa</p>
                    <h4><?php print $placa ?></h4>
                  </div>
                </div>
                <div class="col-md-4">
                  <div id="marca-form" class="form-group">
                    <p class="formu-letra">Marca</p>
                    <h4><?php print $marca ?></h4>
                  </div>
                </div>
                <div class="col-md-4">
                  <div id="modelo-form" class="form-group">
                    <p class="formu-letra">Modelo</p>
                    <h4><?php print $modelo ?></h4>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div id="lotacao-form" class="form-group">
                    <p class="formu-letra">Lotação</p>
                    <h4><?php print $lotacao ?></h4>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="ano-form" class="form-group">
                    <p class="formu-letra">Ano</p>
                     <h4><?php print $ano ?></h4>
                  </div>
                </div>
                <div class="col-md-6">
                <div id="cpf_ajudante-form" class="form-group">
                  <p class="formu-letra">CPF do Ajudante</p>
                  <h4><?php print $ajudrow['cpf']." - ".$ajudrow['nome'];?></h4>
                </div>
              </div>                 
          
             <div class="row">
                <div class="col-md-12">
                  <a href="visu_veiculo.php" class="btn btn-link  btn-right" type="button">Voltar</a>                  
                </div>
              </div>

              
            </div>         
          </div>
        </form>

<?php include './inc/footer.php'; ?>
<script src="js/veiculo.js"></script>
<?php } ?>