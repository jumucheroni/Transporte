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

      $cpf           = str_replace("-", "", @$_POST["cpf"]);
      $nome          = @$_POST["nome"];
      $rg            = str_replace("-", "", @$_POST["rg"]);
      $parentesco    = @$_POST["parentesco"];
      $telefone      = @$_POST["telefone"];
      if  ($telefone != "") {
        $telefone      = explode(";", $telefone); 
      }
      $logradouro    = @$_POST["logradouro"];
      $numero        = @$_POST["numero"];
      $bairro        = @$_POST["bairro"];
      $cep           = str_replace("-", "", @$_POST["cep"]);
      $complemento   = @$_POST["complemento"];
      $cidade        = @$_POST["cidade"];
      $estado        = @$_POST["estado"];

      $cpf = str_replace(".", "", $cpf);

      if ($acao=="SALVARCADASTRO"){

        $insertsql = "insert into responsavel (cpf,nome,parentesco,rg,logradouro, cep, numero, bairro, complemento,cidade,estado) values ('".$cpf."','".$nome."','".$parentesco."','".$rg."','".$logradouro."','".$cep."','".$numero."','".$bairro."','".$complemento."','".$cidade."','".$estado."')";
        $insertresult = $conexao->query($insertsql);

        for ($i=0;$i<sizeof($telefone); $i++) {
          $telefonesql = "insert into telefone (telefone,cpf_responsavel) values ('".$telefone[$i]."','".$cpf."')";
          $telefoneresult = $conexao->query($telefonesql);
        }
        if ($insertresult){
            $mensagem = "Responsável cadastrado com sucesso!";
        }else{
            $mensagem = "Erro ao cadastrar o Responsável!";
        }

    }else if ($acao =="SALVARUPDATE"){
          
          $updatesql = "update responsavel set nome = '".$nome."', logradouro = '".$logradouro."' , numero = '".$numero."' , bairro = '".$bairro."' , cep = '".$cep."' , complemento = '".$complemento."', rg = '".$rg."', parentesco = '".$parentesco."', cidade = '".$cidade."', estado = '".$estado."' where cpf='".$cpf."'";
          $updateresult = $conexao->query($updatesql);

          $deletetelefone = "delete from telefone where cpf_responsavel = '".$cpf."'";
          $telefonedelete = $conexao->query($deletetelefone);
          for ( $i=0;$i<sizeof($telefone); $i++) {
            if ($telefone[$i] != ""){
              $telefonesql = "insert into telefone (telefone,cpf_responsavel) values ('".$telefone[$i]."','".$cpf."')";
              $telefoneresult = $conexao->query($telefonesql);
            }
          }
          if ($updateresult){
              $mensagem = "Responsável atualizado com sucesso!";
          }else{
              $mensagem = "Erro ao atualizar o Responsável!";
          }
        } 

    if (!$cpf){
      $cpf = @$_GET["id"]; 
    }

    if ($acao == "DELETAR"){
      $select = "select cpf_responsavel from crianca where deletado = 'N' and cpf_responsavel=".$cpf."";
      $selectresult = $conexao->query($select);

      if ($selectresult->num_rows == 0) {       
          
        $deletesql = "update responsavel set deletado = 'S' where cpf = '".$cpf."'";
        $deleteresult = $conexao->query($deletesql);

        $deletetelefone = "update telefone set deletado = 'S' where cpf_responsavel = '".$cpf."'";
        $telefonedelete = $conexao->query($deletetelefone);

        if ($deleteresult){
            $mensagem = "Responsável deletado com sucesso!";
        }else{
            $mensagem = "Erro ao deletar o Responsável!";
        }
      } else {
        $mensagem = "Erro ao deletar o Responsável! Responsável já possui crianças";
      }
    }

      if ($acao == "ALTERAR" or $acao == "DETALHES"){
        $sql = "select * from responsavel where cpf='" . $cpf ."'";
        $result = $conexao->query($sql);
        $row = @mysqli_fetch_array($result);

        $cpf           = $row["cpf"];
        $nome          = $row["nome"];
        $rg            = $row["rg"];
        $parentesco    = $row["parentesco"];
        $logradouro    = $row["logradouro"];
        $numero        = $row["numero"];
        $bairro        = $row["bairro"];
        $cep           = $row["cep"];
        $complemento   = $row["complemento"];
        $cidade        = $row["cidade"];
        $estado        = $row["estado"];

        $sqltelefone = "select * from telefone where cpf_responsavel='" . $cpf ."'";
        $resultelefone = $conexao->query($sqltelefone);
        while ($rowtelefone = @mysqli_fetch_array($resultelefone)) {
            $telefone .= $rowtelefone["telefone"].";";
        }
      }

      if ($acao == "ALTERAR"){
        $enablechave = "readonly";
      }
      if ($acao == "DETALHES"){
        $enablechave = "readonly";
        $enablecampos = "readonly";
      }

    if ($mensagem){
?>
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p style="text-align: center;" class="titulo-formu"><?php print $mensagem?></p>
            </div>         
          </div>
<?php } else { ?>

       <form id="responsavel" method="post" action="cad_responsavel.php"> 
        <input type="hidden" name="acao" id="acao" value="<?php print $acao;?>" />
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu">Cadastrar Responsável</p>
       
              <div class="row">
                <div class="col-md-6">
                  <p class="formu-letra">CPF</p>
                  <input <?php print $enablecampos; ?> class="input-formu cpf" type="text" name="cpf" id="cpf" maxlength="14" value="<?php print $cpf;?>"/>
                </div>
                <div class="col-md-6">
                  <p class="formu-letra">Nome</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="nome" id="nome" maxlength="100" value="<?php print $nome;?>"/>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <p class="formu-letra">RG</p>
                  <input <?php print $enablecampos; ?> class="input-formu rg" type="text" name="rg" id="rg" maxlength="10" value="<?php print $rg;?>"/>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">Parentesco</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="parentesco" id="parentesco" maxlength="60" value="<?php print $parentesco;?>"/>
                </div>
                <div class="col-md-6">
                  <p class="formu-letra">Telefone</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="telefone" id="telefone" maxlength="255" value="<?php print $telefone;?>"/>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <p class="formu-letra">CEP</p>
                  <input <?php print $enablecampos; ?> class="input-formu cep" type="text" name="cep" id="cep" maxlength="9" value="<?php print $cep;?>"/>
                </div>
                <div class="col-md-6">
                  <p class="formu-letra">Logradouro</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="logradouro" id="logradouro" maxlength="100" value="<?php print $logradouro;?>"/>
                </div>
                <div class="col-md-2">
                  <p class="formu-letra">Numero</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="numero" id="numero" maxlength="8" value="<?php print $numero;?>"/>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <p class="formu-letra">Bairro</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="bairro" id="bairro" maxlength="30" value="<?php print $bairro;?>"/>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">Complemento</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="complemento" id="complemento" maxlength="60" value="<?php print $complemento;?>"/>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">Estado</p>
                  <select <?php print $enablecampos; ?> class="input-formu" type="text" name="estado" id="estado">
                  <input type="hidden" name="uf" id="uf" value="<?php print $estado?>" />
                  </select>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">Cidade</p>
                  <input type="hidden" name="cid" id="cid" value="<?php print $cidade?>" />
                   <select <?php print $enablecampos; ?> class="input-formu" type="text" name="cidade" id="cidade">
                   </select>
                </div>
              </div>
              
          
              <div class="row">
                <div class="col-md-12">
                <?php if ($acao!="DETALHES"){ ?>
                  <button class="btn-salvar" id="responsavel-salvar" type="button">Salvar</button>  
                <?php } ?>
                  <a href="visu_responsavel.php" class="btn-cancelar" type="button">Voltar</a>                  
                </div>
              </div>

              
            </div>         
          </div>
        </form>

<?php } ?>


<?php include './inc/footer.php'; ?>

<script>
  $(document).ready(function(){
    var cep = $("#cep").val();
    if (cep) {
      cep = cep.replace("-","");
      var estado = $("#uf").val();
      var cidade = $("#cid").val();
      carregaestadocidade(cep,estado,cidade);
    }
  });
</script>
<script src="js/responsavel.js"></script>
<?php } ?>