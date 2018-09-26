<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
    include './inc/header.php'; 
    include './inc/conexao.php';

      $acao = @$_GET["acao"];

      $mensagem = "";
      $enablechave = "";
      $enablecampos = "";

    if (!$acao){
      $acao = @$_POST["acao"];
    }

      $veiculo        = @$_POST["veiculo"];
      $condutor       = @$_POST["condutor"];
      $periodo        = @$_POST["periodo"];

    if ($acao=="SALVARCADASTRO"){

        $selectsql = "select placa_veiculo,cpf_condutor,periodo from condutorveiculo where placa_veiculo = '".$veiculo."' and cpf_condutor = '".$condutor."' and periodo ='".$periodo."' and deletado = 'N' ";
        $selectsqlresult = $conexao->query($selectsql);

        if ($selectsqlresult->num_rows > 0) {
           $mensagem = "Condução já está cadastrada!";
        } else {
          $insertsql = "insert into condutorveiculo (placa_veiculo,cpf_condutor,periodo) values ('".$veiculo."','".$condutor."','".$periodo."')";
          $insertresult = $conexao->query($insertsql);
          if ($insertresult){
              $mensagem = "Condução cadastrada com sucesso!";
          }else{
              $mensagem = "Erro ao cadastrar a Condução!";
          }
        }

    }else if ($acao =="SALVARUPDATE"){
          
          $updatesql = "update condutorveiculo set periodo = '".$periodo."' where placa_veiculo='".$veiculo."' and cpf_condutor='".$condutor."'";
          $updateresult = $conexao->query($updatesql);
          if ($updateresult){
              $mensagem = "Condução atualizado com sucesso!";
          }else{
              $mensagem = "Erro ao atualizar a Condução!";
          }
        } 

    if (!$veiculo && !$condutor) {
      $conducao = @$_GET["id"];
      if ($conducao){
      	$conducao = explode("-", $conducao);
      	$veiculo = $conducao[1];
      	$condutor = $conducao[0]; 
        $periodo = $conducao[2];
      }
    }

    if ($acao == "DELETAR"){
      
      $select = "select cpf_condutor,placa_veiculo,periodo_conducao from criancatrecho where deletado = 'N' and placa_veiculo='".$veiculo."' and cpf_condutor='".$condutor."' and periodo_conducao='".$periodo."'";
      $selectresult = $conexao->query($select);

      if ($selectresult->num_rows == 0) { 
        $deletesql = "update condutorveiculo set deletado = 'S' where placa_veiculo='".$veiculo."' and cpf_condutor='".$condutor."' and periodo='".$periodo."'";
        $deleteresult = $conexao->query($deletesql);
        if ($deleteresult){
            $mensagem = "Condução deletada com sucesso!";
        }else{
            $mensagem = "Erro ao deletar a Condução!";
        }
      } else {
        $mensagem = "Erro ao deletar a Condução! Condução já associada a transportes";
      }
    }

      if ($acao == "ALTERAR" or $acao == "DETALHES"){
        $sql = "select * from condutorveiculo where placa_veiculo='".$veiculo."' and cpf_condutor='".$condutor."' and periodo='".$periodo."'";
        $result = $conexao->query($sql);
        $row = @mysqli_fetch_array($result);

      $veiculo        = @$row["placa_veiculo"];
      $condutor       = @$row["cpf_condutor"];
      $periodo        = @$row["periodo"];
    }

      if ($acao == "ALTERAR"){
        $enablechave = "disabled";
      }
      if ($acao == "DETALHES"){
        $enablechave = "disabled";
        $enablecampos = "disabled";
      }

      $condsql = "select cpf,nome from condutor where deletado = 'N' ";
      $condresult = $conexao->query($condsql);

      $veicsql = "select placa from veiculo where deletado = 'N' ";
      $veicresult = $conexao->query($veicsql);

    if ($mensagem){
?>
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p style="text-align: center;" class="titulo-formu"><?php print $mensagem?></p>
            </div>         
          </div>

<?php } else { ?>

       <form id="condveic" method="post" action="cad_condveic.php"> 
        <input type="hidden" name="acao" id="acao" value="<?php print $acao; ?>" />
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu">Cadastrar Condução</p>
          
              <div class="row">
                <div class="col-md-4">
                  <p class="formu-letra">Veículo</p>
                  <select <?php print $enablecampos; ?> class="input-formu" type="text" name="veiculo" id="veiculo" maxlength="14">
                    <?php while ($veicrow = @mysqli_fetch_array($veicresult)){ ?>
                      <option <?php if ($veiculo == $veicrow['placa']) { echo 'selected="true"'; } ?> value="<?php print $veicrow['placa'];?>"><?php print $veicrow['placa'];?></option>
                  <?php } ?>
                  </select>
                </div>
                <div class="col-md-4">
                  <p class="formu-letra">Condutor</p>
                  <select <?php print $enablecampos; ?> class="input-formu" type="text" name="condutor" id="condutor" maxlength="14">
                    <?php while ($condrow = @mysqli_fetch_array($condresult)){ ?>
                      <option <?php if ($condutor == $condrow['cpf']) { echo 'selected="true"'; } ?> value="<?php print $condrow['cpf'];?>"><?php print $condrow['cpf']." - ".$condrow['nome'];?></option>
                  <?php } ?>
                  </select>
                </div>
                <div class="col-md-4">
                  <p class="formu-letra">Periodo</p>
                  <select <?php print $enablecampos; ?> class="input-formu" type="text" name="periodo" id="periodo" maxlength="1">
                      <option value="im" <?php if ($periodo == 'im') { echo 'selected="true"'; } ?> id="im">Ida-Manhã</option>
                      <option value="it" <?php if ($periodo == 'it') { echo 'selected="true"'; } ?> id="it">Ida-Tarde</option>
                      <option value="vm" <?php if ($periodo == 'vm') { echo 'selected="true"'; } ?> id="vm">Volta-Manhã</option>
                      <option value="vt" <?php if ($periodo == 'vt') { echo 'selected="true"'; } ?> id="vt">Volta-Tarde</option>
                  </select>
                </div>
              </div>                 
          
              <div class="row">
                <div class="col-md-12">
                  <?php if ($acao!="DETALHES"){ ?>
                    <button class="btn-salvar" id="condveic-salvar" type="button">Salvar</button>  
                  <?php } ?> 
                  <a href="visu_condveic.php" class="btn-cancelar" type="button">Cancelar</a>                  
                </div>
              </div>

              
            </div>         
          </div>
        </form>

<?php } ?>

<?php include './inc/footer.php'; ?>
<script src="js/condveic.js"></script>
<?php } ?>

