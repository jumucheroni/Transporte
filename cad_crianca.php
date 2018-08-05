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

  $id                  = @$_POST["id"];
  $cpf_responsavel     = @$_POST["cpf_responsavel"];
  $nome                = @$_POST["nome"];
  $data_nascimento     = DtToDb(@$_POST["data_nascimento"]);
  $n_ident_escola      = @$_POST["n_ident_escola"];
  $serie               = @$_POST["serie"];
  $dia_inicio          = @$_POST["dia_inicio"];
  $nome_professor      = @$_POST["nome_professor"];



if ($acao=="SALVARCADASTRO"){
    $insertsql = "insert into crianca (cpf_responsavel,nome,data_nascimento,id_escola,dia_iniciotransporte,serie,nome_professor) values ('".$cpf_responsavel."','".$nome."','".$data_nascimento."',".$n_ident_escola.",".$dia_inicio.",'".$serie."','".$nome_professor."')";
    $insertresult = $conexao->query($insertsql);
    if ($insertresult){
        $mensagem = "Criança cadastrada com sucesso!";
    }else{
        $mensagem = "Erro ao cadastrar a Criança!";
    }

}else if ($acao =="SALVARUPDATE"){
      
      $updatesql = "update crianca set cpf_responsavel='".$cpf_responsavel."', nome='".$nome."', data_nascimento = '".$data_nascimento."', id_escola= ".$n_ident_escola.", serie = '".$serie."', nome_professor = ".$nome_professor.", dia_iniciotransporte = ".$dia_inicio." where id = ".$id;
      $updateresult = $conexao->query($updatesql);
      if ($updateresult){
          $mensagem = "Criança atualizada com sucesso!";
      }else{
          $mensagem = "Erro ao atualizar a Criança!";
      }
    } 

if (!$id){
  $id = @$_GET["id"];
}

if ($acao == "DELETAR"){
      
  $deletesql = "delete from crianca where id = ".$id;
  $deleteresult = $conexao->query($deletesql);
  if ($deleteresult){
      $mensagem = "Criança deletada com sucesso!";
  }else{
      $mensagem = "Erro ao deletar a Criança!";
  }
}

  if ($acao == "ALTERAR" or $acao == "DETALHES"){
    $sql = "select * from crianca where id=".$id;
    $result = $conexao->query($sql);
    $row = @mysqli_fetch_array($result);

  $id                  = $row["id"];
  $cpf_responsavel     = $row["cpf_responsavel"];
  $nome                = $row["nome"];
  $data_nascimento     = DBtoDT($row["data_nascimento"]);
  $n_ident_escola      = $row["id_escola"];
  $serie               = $row["serie"];
  $dia_inicio          = $row["dia_iniciotransporte"];
  $nome_professor      = $row["nome_professor"];
  }

  if ($acao == "ALTERAR"){
    $enablechave = "readonly";
  }
  if ($acao == "DETALHES"){
    $enablechave = "readonly";
    $enablecampos = "readonly";
  }

  $respsql = "select cpf,nome from responsavel";
  $respresult = $conexao->query($respsql);

  $escolasql = "select id,nome from escola";
  $escolaresult = $conexao->query($escolasql);

if ($mensagem){
?>
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p style="text-align: center;" class="titulo-formu"><?php print $mensagem?></p>
            </div>         
          </div>
<?php } else { ?>

       <form id="crianca" method="post" action="cad_crianca.php"> 
        <input type="hidden" name="acao" id="acao" value="<?php print $acao; ?>" />
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu">Cadastrar Criança</p>
             
              <div class="row">
                <div class="col-md-6">
                  <p class="formu-letra">CPF Responsável</p>
                  <select <?php print $enablecampos ?> class="input-formu" type="text" name="cpf_responsavel" maxlength="14">
                  <?php while ($resprow = @mysqli_fetch_array($respresult)){ ?>
                      <option <?php if ($cpf_responsavel == $resprow['cpf']) { echo 'selected="true"'; } ?> value="<?php print $resprow['cpf'];?>"><?php print $resprow['cpf']." - ".$resprow['nome'];?></option>
                  <?php } ?>
                  </select>
                </div>
                <div class="col-md-6">
                  <p class="formu-letra">Nome</p>
                  <input <?php print $enablecampos ?> class="input-formu" type="text" name="nome" maxlength="100" value="<?php print $nome; ?>"/>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <p class="formu-letra">Nome do Professor</p>
                  <input <?php print $enablecampos ?> class="input-formu" type="text" name="nome_professor" maxlength="100" value="<?php print $nome_professor; ?>"/>
                </div>
                <div class="col-md-6">
                  <p class="formu-letra">Escola</p>
                   <select <?php print $enablecampos ?> class="input-formu" type="text" name="n_ident_escola" maxlength="11">
                   <?php while ($escolarow = @mysqli_fetch_array($escolaresult)){ ?>
                      <option <?php if ($n_ident_escola == $escolarow['id']) { echo 'selected="true"'; } ?> value="<?php print $escolarow['id'];?>"><?php print $escolarow['id']." - ".$escolarow['nome'];?></option>
                  <?php } ?>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <p class="formu-letra">Série</p>
                  <input <?php print $enablecampos ?> class="input-formu" type="text" name="serie" maxlength="20" value="<?php print $serie; ?>"/>
                </div>
                <div class="col-md-4">
                  <p class="formu-letra">Data Nascimento</p>
                  <input <?php print $enablecampos ?> class="input-formu nasc" type="text" name="data_nascimento" maxlength="10" value="<?php print $data_nascimento; ?>"/>
                </div>
                <div class="col-md-2">
                  <p class="formu-letra">Dia Inicio</p>
                  <input <?php print $enablecampos ?> class="input-formu" type="text" name="dia_inicio" maxlength="2" value="<?php print $dia_inicio; ?>"/>
                </div>
                
              </div>              
          
              <div class="row">
                <div class="col-md-12">
                <?php if ($acao!="DETALHES"){ ?>
                  <button class="btn-salvar" id="crianca-salvar" type="button">Salvar</button>  
                <?php }?>
                  <a href="visu_crianca.php" class="btn-cancelar" type="button">Cancelar</a>                  
                </div>
              </div>

              
            </div>         
          </div>
        </form>


<?php } ?>


<?php include './inc/footer.php'; ?>


  <script type="text/javascript">
    $(document).ready(function(){
      $("#crianca-salvar").click(function(){

          if ($("#acao").val()=="CADASTRAR"){
              $("#acao").val("SALVARCADASTRO");
          }
          if ($("#acao").val()=="ALTERAR"){
              $("#acao").val("SALVARUPDATE");
          }
          $( "#crianca" ).submit();
      });
    });

  </script>