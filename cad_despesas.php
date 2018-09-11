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

  $id             = @$_POST["id"];
  $placa_veiculo  = @$_POST["placa_veiculo"];
  $data_gasto     = DtToDb(@$_POST["data_gasto"]);
  $valor_gasto    = @$_POST["valor_gasto"];
  $tipo           = @$_POST["tipo"];
  $observacao     = @$_POST["observacao"];

if ($acao=="SALVARCADASTRO"){

    $insertsql = "insert into gastos (placa_veiculo,data_gasto,valor_gasto,tipo,observacao) values ('".$placa_veiculo."','".$data_gasto."',".$valor_gasto.",'".$tipo."','".$observacao."')";
    print_r($insertsql);
    $insertresult = $conexao->query($insertsql);
    if ($insertresult){
        $mensagem = "Despesa cadastrada com sucesso!";
    }else{
        $mensagem = "Erro ao cadastrar a Despesa!";
    }

}else if ($acao =="SALVARUPDATE"){
      
      $updatesql = "update gastos set placa_veiculo = '".$placa_veiculo."',data_gasto = '".$data_gasto."',valor_gasto = ".$valor_gasto.",tipo = '".$tipo."',observacao = '".$observacao."' where id = ".$id;
      $updateresult = $conexao->query($updatesql);
      if ($updateresult){
          $mensagem = "Despesa atualizada com sucesso!";
      }else{
          $mensagem = "Erro ao atualizar a Despesa!";
      }
    } 

if (!$id){
  $id = @$_GET["id"];
}

if ($acao == "DELETAR"){
      
  $deletesql = "update gastos set deletado = 'S' where id = ".$id;
  $deleteresult = $conexao->query($deletesql);
  if ($deleteresult){
      $mensagem = "Despesa deletada com sucesso!";
  }else{
      $mensagem = "Erro ao deletar a Despesa!";
  }
}

  if ($acao == "ALTERAR" or $acao == "DETALHES"){
    $sql = "select * from gastos where id=".$id;
    $result = $conexao->query($sql);
    $row = @mysqli_fetch_array($result);

  $id             = $row["id"];
  $placa_veiculo  = $row["placa_veiculo"];
  $data_gasto     = DbToDt($row["data_gasto"]);
  $valor_gasto    = $row["valor_gasto"];
  $tipo           = $row["tipo"];
  $observacao     = $row["observacao"];
  }

  if ($acao == "ALTERAR"){
    $enablechave = "disabled";
  }
  if ($acao == "DETALHES"){
    $enablechave = "disabled";
    $enablecampos = "disabled";
  }

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

       <form id="despesa" method="post" action="cad_despesas.php"> 
        <input type="hidden" name="acao" id="acao" value="<?php print $acao; ?>" />
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu">Cadastrar Despesa</p>
             
              <div class="row">
                <div class="col-md-4">
                  <input type="hidden" name="id" value="<?php echo $id;?>"/>
                  <p class="formu-letra">Veiculo</p>
                  <select <?php print $enablecampos ?> class="input-formu" type="text" name="placa_veiculo" id="placa_veiculo">
                  <?php while ($veicrow = @mysqli_fetch_array($veicresult)){ ?>
                      <option <?php if ($placa_veiculo == $veicrow['placa']) { echo 'selected="true"'; } ?> value="<?php print $veicrow['placa'];?>"><?php print $veicrow['placa'];?></option>
                  <?php } ?>
                  </select>
                </div>
                <div class="col-md-4">
                  <p class="formu-letra">Data da Despesa</p>
                  <input <?php print $enablecampos ?> class="input-formu nasc" type="text" name="data_gasto" id="data_gasto" value="<?php print $data_gasto; ?>"/>
                </div>
                <div class="col-md-4">
                  <p class="formu-letra">Valor da Despesa</p>
                  <input <?php print $enablecampos ?> class="input-formu money" type="text" name="valor_gasto" id="valor_gasto" value="<?php print $valor_gasto; ?>"/>
                </div>
              </div>   
              <div class="row">
                <div class="col-md-3">
                  <p class="formu-letra">Tipo</p>
                  <select <?php print $enablecampos; ?> class="input-formu" type="text" name="tipo" id="tipo" >
                    <option value="c"<?php if ($tipo == 'c') { echo 'selected="true"'; } ?> id="c">Combustível</option>
                    <option value="i"<?php if ($tipo == 'i') { echo 'selected="true"'; } ?> id="i">IPVA</option>
                    <option value="o"<?php if ($tipo == 'o') { echo 'selected="true"'; } ?> id="o">Oficina</option>
                  </select>
                </div>
                <div class="col-md-9">
                  <p class="formu-letra">Observação</p>
                  <input <?php print $enablecampos ?> class="input-formu" type="text" name="observacao" id="observacao" maxlength="255" value="<?php print $observacao; ?>"/>
                </div>
              </div>       
              <div class="row">
                <div class="col-md-12">
                <?php if ($acao!="DETALHES"){ ?>
                  <button class="btn-salvar" id="despesa-salvar" type="button">Salvar</button>  
                <?php }?>
                  <a href="visu_despesas.php" class="btn-cancelar" type="button">Cancelar</a>                  
                </div>
              </div>

              
            </div>         
          </div>
        </form>


<?php } ?>


<?php include './inc/footer.php'; ?>


  <script type="text/javascript">
    $(document).ready(function(){
      $("#despesa-salvar").click(function(){

          if ($("#acao").val()=="CADASTRAR"){
              $("#acao").val("SALVARCADASTRO");
          }
          if ($("#acao").val()=="ALTERAR"){
              $("#acao").val("SALVARUPDATE");
          }
          $( "#despesa" ).submit();
      });
    });

  </script>