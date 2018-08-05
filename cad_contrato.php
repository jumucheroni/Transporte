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

  $id                         = @$_POST["id"];
  $id_crianca                 = @$_POST["id_crianca"];
  $data_inicio_contrato       = DtToDb(@$_POST["data_inicio_contrato"]);
  $data_fim_contrato          = DtToDb(@$_POST["data_fim_contrato"]);
  $dia_vencimento_mensalidade = @$_POST["dia_vencimento_mensalidade"];
  $mensalidade                = @$_POST["mensalidade"];

if ($acao=="SALVARCADASTRO"){

    $insertsql = "insert into contrato (id_crianca,data_inicio_contrato,data_fim_contrato,dia_vencimento_mensalidade) values (".$id_crianca.",'".$data_inicio_contrato."','".$data_fim_contrato."',".$dia_vencimento_mensalidade.")";
    $insertresult = $conexao->query($insertsql);
    if ($insertresult){
        $mensagem = "Contrato cadastrado com sucesso!";
    }else{
        $mensagem = "Erro ao cadastrar o Contrato!";
    }

}else if ($acao =="SALVARUPDATE"){
      
      $updatesql = "update contrato set dia_vencimento_mensalidade = ".$dia_vencimento_mensalidade." where id = ".$id;
      $updateresult = $conexao->query($updatesql);
      if ($updateresult){
          $mensagem = "Contrato atualizada com sucesso!";
      }else{
          $mensagem = "Erro ao atualizar o Contrato!";
      }
    } 

if (!$id){
  $id = @$_GET["id"];
}

if ($acao == "DELETAR"){
      
  $deletesql = "delete from contrato where id = ".$id;
  $deleteresult = $conexao->query($deletesql);
  if ($deleteresult){
      $mensagem = "Contrato deletada com sucesso!";
  }else{
      $mensagem = "Erro ao deletar o Contrato!";
  }
}

  if ($acao == "ALTERAR" or $acao == "DETALHES"){
    $sql = "select * from contrato where id=".$id;
    $result = $conexao->query($sql);
    $row = @mysqli_fetch_array($result);

  $id                         = $row["id"];
  $id_crianca                 = $row["id_crianca"];
  $data_inicio_contrato       = DbToDt($row["data_inicio_contrato"]);
  $data_fim_contrato          = DbToDt($row["data_fim_contrato"]);
  $dia_vencimento_mensalidade = $row["dia_vencimento_mensalidade"];
  $mensalidade                = $row["mensalidade"];
  }

  if ($acao == "ALTERAR"){
    $enablechave = "disabled";
  }
  if ($acao == "DETALHES"){
    $enablechave = "disabled";
    $enablecampos = "disabled";
  }

  $criansql = "select id,nome from crianca";
  $crianresult = $conexao->query($criansql);

if ($mensagem){
?>
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p style="text-align: center;" class="titulo-formu"><?php print $mensagem?></p>
            </div>         
          </div>
<?php } else { ?>

       <form id="contrato" method="post" action="cad_contrato.php"> 
        <input type="hidden" name="acao" id="acao" value="<?php print $acao; ?>" />
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu">Cadastrar Contrato</p>
             
              <div class="row">
                <div class="col-md-3">
                  <input type="hidden" name="id" value="<?php echo $id;?>"/>
                  <p class="formu-letra">Criança</p>
                  <select <?php print $enablecampos ?> class="input-formu" type="text" name="id_crianca" maxlength="14">
                  <?php while ($crianrow = @mysqli_fetch_array($crianresult)){ ?>
                      <option <?php if ($id_crianca == $crianrow['id']) { echo 'selected="true"'; } ?> value="<?php print $crianrow['id'];?>"><?php print $crianrow['id']." - ".$crianrow['nome'];?></option>
                  <?php } ?>
                  </select>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">Data Inicio do Contrato</p>
                  <input <?php print $enablecampos ?> class="input-formu" type="text" name="data_inicio_contrato" maxlength="60" value="<?php print $data_inicio_contrato; ?>"/>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">Data Final do Contrato</p>
                  <input <?php print $enablecampos ?> class="input-formu" type="text" name="data_fim_contrato" maxlength="20" value="<?php print $data_fim_contrato; ?>"/>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">Dia Vencimento</p>
                  <input <?php print $enablecampos ?> class="input-formu" type="text" name="dia_vencimento_mensalidade" maxlength="20" value="<?php print $dia_vencimento_mensalidade; ?>"/>
                </div>
              </div>          
              <div class="row">
                <div class="col-md-12">
                <?php if ($acao!="DETALHES"){ ?>
                  <button class="btn-salvar" id="contrato-salvar" type="button">Salvar</button>  
                <?php }?>
                  <a href="visu_contrato.php" class="btn-cancelar" type="button">Cancelar</a>                  
                </div>
              </div>

              
            </div>         
          </div>
        </form>


<?php } ?>


<?php include './inc/footer.php'; ?>


  <script type="text/javascript">
    $(document).ready(function(){
      $("#contrato-salvar").click(function(){

          if ($("#acao").val()=="CADASTRAR"){
              $("#acao").val("SALVARCADASTRO");
          }
          if ($("#acao").val()=="ALTERAR"){
              $("#acao").val("SALVARUPDATE");
          }
          $( "#contrato" ).submit();
      });
    });

  </script>