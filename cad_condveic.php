<?php 

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

    $insertsql = "insert into condutorveiculo (placa_veiculo,cpf_condutor,periodo) values ('".$veiculo."','".$condutor."','".$periodo."')";
    $insertresult = $conexao->query($insertsql);
    if ($insertresult){
        $mensagem = "Condução cadastrada com sucesso!";
    }else{
        $mensagem = "Erro ao cadastrar a Condução!";
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
  }
}

if ($acao == "DELETAR"){
      
  $deletesql = "delete from condutorveiculo where placa_veiculo='".$veiculo."' and cpf_condutor='".$condutor."' and periodo='".$periodo."'";
  if ($deleteresult){
      $mensagem = "Condução deletada com sucesso!";
  }else{
      $mensagem = "Erro ao deletar a Condução!";
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

  $condsql = "select cpf,nome from condutor";
  $condresult = $conexao->query($condsql);

  $veicsql = "select placa from veiculo";
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
                  <select <?php print $enablecampos; ?> class="input-formu" type="text" name="veiculo" maxlength="14">
                    <?php while ($veicrow = @mysqli_fetch_array($veicresult)){ ?>
                      <option <?php if ($veiculo == $veicrow['placa']) { echo 'selected="true"'; } ?> value="<?php print $veicrow['placa'];?>"><?php print $veicrow['placa'];?></option>
                  <?php } ?>
                  </select>
                </div>
                <div class="col-md-4">
                  <p class="formu-letra">Condutor</p>
                  <select <?php print $enablecampos; ?> class="input-formu" type="text" name="condutor" maxlength="14">
                    <?php while ($condrow = @mysqli_fetch_array($condresult)){ ?>
                      <option <?php if ($condutor == $condrow['cpf']) { echo 'selected="true"'; } ?> value="<?php print $condrow['cpf'];?>"><?php print $condrow['cpf']." - ".$condrow['nome'];?></option>
                  <?php } ?>
                  </select>
                </div>
                <div class="col-md-4">
                  <p class="formu-letra">Periodo</p>
                  <select <?php print $enablecampos; ?> class="input-formu" type="text" name="periodo" maxlength="14">
              			<option id="m" value='m'>Manhã</option>
                    <option id="a" value='a'>Almoço</option>
              			<option id="t" value='t'>Tarde</option>
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


  <script type="text/javascript">
    $(document).ready(function(){
      $("#condveic-salvar").click(function(){

          if ($("#acao").val()=="CADASTRAR"){
              $("#acao").val("SALVARCADASTRO");
          }
          if ($("#acao").val()=="ALTERAR"){
              $("#acao").val("SALVARUPDATE");
          }
          $( "#condveic" ).submit();
      });
    });

  </script> 

