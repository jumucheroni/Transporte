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

  $cpf = str_replace(".", "", $cpf);

  if ($acao=="SALVARCADASTRO"){

    $insertsql = "insert into responsavel (cpf,nome,parentesco,rg,logradouro, cep, numero, bairro, complemento) values ('".$cpf."','".$nome."','".$parentesco."','".$rg."','".$logradouro."','".$cep."','".$numero."','".$bairro."','".$complemento."')";
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
      
      $updatesql = "update responsavel set nome = '".$nome."', logradouro = '".$logradouro."' , numero = '".$numero."' , bairro = '".$bairro."' , cep = '".$cep."' , complemento = '".$complemento."', rg = '".$rg."', parentesco = '".$parentesco."' where cpf='".$cpf."'";
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
      
  $deletesql = "delete from responsavel where cpf = '".$cpf."'";
  $deleteresult = $conexao->query($deletesql);

  $deletetelefone = "delete from telefone where cpf_respreadonlyonsavel = '".$cpf."'";
  $telefonedelete = $conexao->query($deletetelefone);

  if ($deleteresult){
      $mensagem = "Responsável deletado com sucesso!";
  }else{
      $mensagem = "Erro ao deletar o Responsável!";
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
                  <input <?php print $enablecampos; ?> class="input-formu cpf" type="text" name="cpf" maxlength="14" value="<?php print $cpf;?>"/>
                </div>
                <div class="col-md-6">
                  <p class="formu-letra">Nome</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="nome" maxlength="100" value="<?php print $nome;?>"/>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <p class="formu-letra">RG</p>
                  <input <?php print $enablecampos; ?> class="input-formu rg" type="text" name="rg" maxlength="10" value="<?php print $rg;?>"/>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">Parentesco</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="parentesco" maxlength="60" value="<?php print $parentesco;?>"/>
                </div>
                <div class="col-md-6">
                  <p class="formu-letra">Telefone</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="telefone" maxlength="100" value="<?php print $telefone;?>"/>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <p class="formu-letra">Logradouro</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="logradouro" maxlength="100" value="<?php print $logradouro;?>"/>
                </div>
                <div class="col-md-2">
                  <p class="formu-letra">Numero</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="numero" maxlength="8" value="<?php print $numero;?>"/>
                </div>
                <div class="col-md-4">
                  <p class="formu-letra">Bairro</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="bairro" maxlength="30" value="<?php print $bairro;?>"/>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <p class="formu-letra">CEP</p>
                  <input <?php print $enablecampos; ?> class="input-formu cep" type="text" name="cep" maxlength="9" value="<?php print $cep;?>"/>
                </div>
                <div class="col-md-8">
                  <p class="formu-letra">Complemento</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="complemento" maxlength="60" value="<?php print $complemento;?>"/>
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


  <script type="text/javascript">
    $(document).ready(function(){
      $("#responsavel-salvar").click(function(){

          if ($("#acao").val()=="CADASTRAR"){
              $("#acao").val("SALVARCADASTRO");
          }
          if ($("#acao").val()=="ALTERAR"){
              $("#acao").val("SALVARUPDATE");
          }
          $( "#responsavel" ).submit();
      });
    });

  </script>
