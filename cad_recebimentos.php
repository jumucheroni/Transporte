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

  $id = @$_POST["id"];
  if (!$id) {
   $id = @$_GET["id"]; 
  }

  $valor_pago  = @$_POST["valor_pago"];
  $status      = @$_POST["status"];
  $datahoje    = DtToDb(@$_POST["data_pgto"]);

 if ($acao =="SALVARPAGAMENTO"){

      $updatesql = "update pagamentos set data_realizada_pgto = '".$datahoje."' and valor_pago = ".$valor_pago." and status =  '".$status."' where id = ".$id;
      $updateresult = $conexao->query($updatesql);

      if ($updateresult){
          $mensagem = "Recebimento realizado com sucesso!";
      }else{
          $mensagem = "Erro ao realizar o recebimento!";
      }
    } 

  if ($acao == "PAGAR"){
    $sql = "select * from pagamentos where id=".$id;
    $result = $conexao->query($sql);
    $row = @mysqli_fetch_array($result);

  $valor_pago = $row["valor_pago"];
  $status = $row["status"];
  $data_pgto = $row["data_realizada_pgto"];
  }

if ($mensagem){
?>
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p style="text-align: center;" class="titulo-formu"><?php print $mensagem?></p>
            </div>         
          </div>
<?php } else { ?>

       <form id="recebimento" method="post" action="cad_recebimentos.php"> 
        <input type="hidden" name="acao" id="acao" value="<?php print $acao; ?>" />
        <input type="hidden" name="id" id="id" value="<?php print $id; ?>" />
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu">Cadastrar Recebimento</p>
            
              <div class="row">
                <div class="col-md-3">
                  <p class="formu-letra">Data do Pagamento</p>
                  <input <?php print $enablecampos ?> class="input-formu nasc" type="text" name="data_pgto" value="<?php print $data_pgto; ?>"/>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">Valor pago</p>
                  <input <?php print $enablecampos ?> class="input-formu money" type="text" name="valor_pago" value="<?php print $valor_pago; ?>"/>
                </div>
                <div class="col-md-3">
                  <input type="hidden" name="id" value="<?php echo $id;?>"/>
                  <p class="formu-letra">Status</p>
                  <select <?php print $enablecampos ?> class="input-formu" type="text" name="status" >
                      <option <?php if ($status == "N") { echo 'selected="true"'; } ?>  value="N">Em aberto</option>
                      <option <?php if ($status == "A") { echo 'selected="true"'; } ?>  value="A">Em atraso</option>
                      <option <?php if ($status == "F") { echo 'selected="true"'; } ?>  value="F">Falta valor</option>
                      <option <?php if ($status == "P") { echo 'selected="true"'; } ?>  value="P">Pago</option>
                  </select>
                </div>
              </div>        
              <div class="row">
                <div class="col-md-12">
                <?php if ($acao!="DETALHES"){ ?>
                  <button class="btn-salvar" id="recebimento-salvar" type="button">Salvar</button>  
                <?php }?>
                  <a href="visu_recebimentos.php" class="btn-cancelar" type="button">Cancelar</a>                  
                </div>
              </div>

              
            </div>         
          </div>
        </form>


<?php } ?>


<?php include './inc/footer.php'; ?>


  <script type="text/javascript">
    $(document).ready(function(){
      $("#recebimento-salvar").click(function(){

          if ($("#acao").val()=="PAGAR"){
              $("#acao").val("SALVARPAGAMENTO");
          }

          $( "#recebimento" ).submit();
      });
    });

  </script>