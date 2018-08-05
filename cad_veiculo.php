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

  $placa         = @$_POST["placa"];
  $marca         = @$_POST["marca"];
  $modelo        = @$_POST["modelo"];
  $ano           = @$_POST["ano"];
  $lotacao       = @$_POST["lotacao"];
  $cpf_ajudante  = @$_POST["cpf_ajudante"];

if ($acao=="SALVARCADASTRO"){

    $insertsql = "insert into veiculo (placa,marca,modelo,ano,lotacao,cpf_ajudante) values ('".$placa."','".$marca."','".$modelo."','".$ano."',".$lotacao.",'".$cpf_ajudante."')";
    $insertresult = $conexao->query($insertsql);
    if ($insertresult){
        $mensagem = "Veículo cadastrado com sucesso!";
    }else{
        $mensagem = "Erro ao cadastrar o Veículo!";
    }

}else if ($acao =="SALVARUPDATE"){
      
      $updatesql = "update veiculo set marca = '".$marca."', modelo = '".$modelo."', ano = '".$ano."', lotacao = ".$lotacao.", cpf_ajudante = '".$cpf_ajudante."' where placa='".$placa."'";
      $updateresult = $conexao->query($updatesql);
      if ($updateresult){
          $mensagem = "Veículo atualizado com sucesso!";
      }else{
          $mensagem = "Erro ao atualizar o Veículo!";
      }
    } 

if (!$placa){
  $placa = @$_GET["id"]; 
}

if ($acao == "DELETAR"){
      
  $deletesql = "delete from veiculo where placa = '".$placa."'";
  $deleteresult = $conexao->query($deletesql);
  if ($deleteresult){
      $mensagem = "Veículo deletado com sucesso!";
  }else{
      $mensagem = "Erro ao deletar o Veículo!";
  }
}

  if ($acao == "ALTERAR" or $acao == "DETALHES"){
    $sql = "select * from veiculo where placa='" . $placa ."'";
    $result = $conexao->query($sql);
    $row = @mysqli_fetch_array($result);

    $placa         = $row["placa"];
    $marca         = $row["marca"];
    $modelo        = $row["modelo"];
    $ano           = $row["ano"];
    $lotacao       = $row["lotacao"];
    $cpf_ajudante  = $row["cpf_ajudante"];
  }

  if ($acao == "ALTERAR"){
    $enablechave = "disabled";
  }
  if ($acao == "DETALHES"){
    $enablechave = "disabled";
    $enablecampos = "disabled";
  }

  $ajudsql = "select cpf,nome from ajudante where cpf not in (select cpf_ajudante from veiculo)";
  $ajudresult = $conexao->query($ajudsql);

if ($mensagem){
?>
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p style="text-align: center;" class="titulo-formu"><?php print $mensagem?></p>
            </div>         
          </div>

<?php } else { ?>

       <form id="veiculo" method="post" action="cad_veiculo.php"> 
        <input type="hidden" name="acao" id="acao" value="<?php print $acao; ?>" />
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu">Cadastrar Veículo</p>
          
              <div class="row">
                <div class="col-md-4">
                  <p class="formu-letra">Placa</p>
                  <input <?php print $enablechave; ?> class="input-formu" type="text" name="placa" maxlength="8" value="<?php print $placa; ?>"/>
                </div>
                <div class="col-md-4">
                  <p class="formu-letra">Marca</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="marca" maxlength="20" value="<?php print $marca; ?>"/>
                </div>
                <div class="col-md-4">
                  <p class="formu-letra">Modelo</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="modelo" maxlength="20" value="<?php print $modelo; ?>"/>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <p class="formu-letra">Lotação</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="lotacao" maxlength="11" value="<?php print $lotacao; ?>"/>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">Ano</p>
                   <input <?php print $enablecampos; ?> class="input-formu" type="text" name="ano" maxlength="4" value="<?php print $ano; ?>"/>
                </div>
                <div class="col-md-6">
                  <p class="formu-letra">CPF do Ajudante</p>
                  <select <?php print $enablecampos; ?> class="input-formu" type="text" name="cpf_ajudante" maxlength="14">
                    <?php while ($ajudrow = @mysqli_fetch_array($ajudresult)){ ?>
                      <option <?php if ($cpf_ajudante == $ajudrow['cpf']) { echo 'selected="true"'; } ?> value="<?php print $ajudrow['cpf'];?>"><?php print $ajudrow['cpf']." - ".$ajudrow['nome'];?></option>
                  <?php } ?>
                  </select>
                </div>
              </div>                 
          
              <div class="row">
                <div class="col-md-12">
                  <?php if ($acao!="DETALHES"){ ?>
                    <button class="btn-salvar" id="veiculo-salvar" type="button">Salvar</button>  
                  <?php } ?> 
                  <a href="visu_veiculo.php" class="btn-cancelar" type="button">Cancelar</a>                  
                </div>
              </div>

              
            </div>         
          </div>
        </form>

<?php } ?>

<?php include './inc/footer.php'; ?>


  <script type="text/javascript">
    $(document).ready(function(){
      $("#veiculo-salvar").click(function(){

          if ($("#acao").val()=="CADASTRAR"){
              $("#acao").val("SALVARCADASTRO");
          }
          if ($("#acao").val()=="ALTERAR"){
              $("#acao").val("SALVARUPDATE");
          }
          $( "#veiculo" ).submit();
      });
    });

  </script>