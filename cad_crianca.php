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

      $id                  = @$_POST["id"];
      $cpf_responsavel     = @$_POST["cpf_responsavel"];
      $nome                = @$_POST["nome"];
      $data_nascimento     = DtToDb(@$_POST["data_nascimento"]);
      $n_ident_escola      = @$_POST["n_ident_escola"];
      $nome_professor      = @$_POST["nome_professor"];

    if ($acao=="SALVARCADASTRO"){
        $insertsql = "insert into crianca (cpf_responsavel,nome,data_nascimento,id_escola,nome_professor) values ('".$cpf_responsavel."','".$nome."','".$data_nascimento."',".$n_ident_escola.",'".$nome_professor."')";
        $insertresult = $conexao->query($insertsql);
        if ($insertresult){
            $mensagem = "Criança cadastrada com sucesso!";
        }else{
            $mensagem = "Erro ao cadastrar a Criança!";
        }

    }else if ($acao =="SALVARUPDATE"){
          
          $updatesql = "update crianca set cpf_responsavel='".$cpf_responsavel."', nome='".$nome."', data_nascimento = '".$data_nascimento."', id_escola= ".$n_ident_escola.", nome_professor = ".$nome_professor." where id = ".$id;
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

      $select = "select id_crianca from criancatrecho where deletado = 'N' and id_crianca=".$id."";
      $selectresult = $conexao->query($select);

      if ($selectresult->num_rows == 0) { 
          
        $deletesql = "update crianca set deletado = 'S' where id = ".$id;
        $deleteresult = $conexao->query($deletesql);
        if ($deleteresult){
            $mensagem = "Criança deletada com sucesso!";
        }else{
            $mensagem = "Erro ao deletar a Criança!";
        }
      } else {
        $mensagem = "Erro ao deletar a Criança! Criança já associada a transportes";
      }
    }

      if ($acao == "ALTERAR" or $acao == "DETALHES"){
        $sql = "select * from crianca where id=".$id;
        $result = $conexao->query($sql);
        $row = @mysqli_fetch_array($result);

      $id                  = $row["id"];
      $cpf_responsavel     = $row["cpf_responsavel"];
      $nome                = $row["nome"];
      $data_nascimento     = DbtoDt($row["data_nascimento"]);
      $n_ident_escola      = $row["id_escola"];
      $nome_professor      = $row["nome_professor"];
      }

      if ($acao == "ALTERAR"){
        $enablechave = "readonly";
      }
      if ($acao == "DETALHES"){
        $enablechave = "readonly";
        $enablecampos = "readonly";
      }

      $respsql = "select cpf,nome from responsavel where deletado = 'N' ";
      $respresult = $conexao->query($respsql);

      $escolasql = "select id,nome from escola where deletado = 'N' ";
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
                  <select <?php print $enablecampos ?> class="input-formu" type="text" name="cpf_responsavel" id="cpf_responsavel">
                  <?php while ($resprow = @mysqli_fetch_array($respresult)){ ?>
                      <option <?php if ($cpf_responsavel == $resprow['cpf']) { echo 'selected="true"'; } ?> value="<?php print $resprow['cpf'];?>"><?php print $resprow['cpf']." - ".$resprow['nome'];?></option>
                  <?php } ?>
                  </select>
                </div>
                <div class="col-md-6">
                  <p class="formu-letra">Nome</p>
                  <input <?php print $enablecampos ?> class="input-formu" type="text" name="nome" id="nome" maxlength="100" value="<?php print $nome; ?>"/>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <p class="formu-letra">Nome do Professor</p>
                  <input <?php print $enablecampos ?> class="input-formu" type="text" name="nome_professor" id="nome_professor" maxlength="100" value="<?php print $nome_professor; ?>"/>
                </div>
                <div class="col-md-6">
                  <p class="formu-letra">Escola</p>
                   <select <?php print $enablecampos ?> class="input-formu" type="text" name="n_ident_escola" id="n_ident_escola">
                   <?php while ($escolarow = @mysqli_fetch_array($escolaresult)){ ?>
                      <option <?php if ($n_ident_escola == $escolarow['id']) { echo 'selected="true"'; } ?> value="<?php print $escolarow['id'];?>"><?php print $escolarow['id']." - ".$escolarow['nome'];?></option>
                  <?php } ?>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <p class="formu-letra">Data Nascimento</p>
                  <input <?php print $enablecampos ?> class="input-formu nasc" type="text" name="data_nascimento" id="data_nascimento" value="<?php print $data_nascimento; ?>"/>
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
<script src="js/crianca.js"></script>

<?php } ?>