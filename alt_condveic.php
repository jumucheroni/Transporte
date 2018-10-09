<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {

    include './inc/header.php'; 
    include './inc/conexao.php';

    $acao="ALTERAR";

    $enablechave = "readonly";

    $id = explode("-", $_GET['id']);

    $sql = "select * from condutorveiculo where placa_veiculo='".$id[1]."' and cpf_condutor='".$id[0]."' and periodo='".$id[2]."'";
    $result = $conexao->query($sql);
    $row = @mysqli_fetch_array($result);

    $veiculo        = @$row["placa_veiculo"];
    $condutor       = @$row["cpf_condutor"];
    $periodo        = @$row["periodo"];

    $condsql = "select cpf,nome from condutor where deletado = 'N' ";
    $condresult = $conexao->query($condsql);

    $veicsql = "select placa from veiculo where deletado = 'N' ";
    $veicresult = $conexao->query($veicsql);

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
      
      <form id="ajudante" method="post" role="form"> 
        <input type="hidden" name="acao" id="acao" value="<?php print $acao; ?>" />
         <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
              <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
                <div hidden id="alert"></div>
              </div>
              <div class="col-xs-12 col-sm-8 col-md-10 ">
                <h1 class="page-header">Cadastrar Condução</h1>
              </div>

              <div class="row">
                <div class="col-md-4">
                  <div id="veic-form" class="form-group">
                    <p class="formu-letra">Veículo</p>
                    <select <?php print $enablechave; ?> class="form-control" name="veiculo" id="veiculo">
                      <?php while ($veicrow = @mysqli_fetch_array($veicresult)){ ?>
                        <option <?php if ($veiculo == $veicrow['placa']) { echo 'selected="true"'; } ?> value="<?php print $veicrow['placa'];?>"><?php print $veicrow['placa'];?></option>
                  <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div id="condutor-form" class="form-group">
                    <p class="formu-letra">Condutor</p>
                    <select <?php print $enablechave; ?> class="form-control" name="condutor" id="condutor">
                      <?php while ($condrow = @mysqli_fetch_array($condresult)){ ?>
                        <option <?php if ($condutor == $condrow['cpf']) { echo 'selected="true"'; } ?> value="<?php print $condrow['cpf'];?>"><?php print $condrow['cpf']." - ".$condrow['nome'];?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div id="periodo-form" class="form-group">
                    <p class="formu-letra">Periodo</p>
                    <select class="form-control" name="periodo" id="periodo" >
                      <option value="im" <?php if ($periodo == 'im') { echo 'selected="true"'; } ?> id="im">Ida-Manhã</option>
                      <option value="it" <?php if ($periodo == 'it') { echo 'selected="true"'; } ?> id="it">Ida-Tarde</option>
                      <option value="vm" <?php if ($periodo == 'vm') { echo 'selected="true"'; } ?> id="vm">Volta-Manhã</option>
                      <option value="vt" <?php if ($periodo == 'vt') { echo 'selected="true"'; } ?> id="vt">Volta-Tarde</option>
                    </select>
                  </div>
                </div>
              </div>            
          
              <div class="row">
                <div class="col-md-12">
                  <button class="btn btn-success btn-right" id="condveic-salvar" type="button">Salvar</button> 
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