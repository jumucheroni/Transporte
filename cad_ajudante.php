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

  $cpf         = str_replace("-", "", @$_POST["cpf"]);
  $nome        = @$_POST["nome"];
  $rg          = str_replace("-", "", @$_POST["rg"]);
  $salario     = str_replace(",",".",@$_POST["salario"]);
  $email       = @$_POST["email"];
  $cep         = str_replace("-", "", @$_POST["cep"]);
  $logradouro  = @$_POST["logradouro"];
  $numero      = @$_POST["numero"];
  $complemento = @$_POST["complemento"];
  $bairro      = @$_POST["bairro"];
  $cidade      = @$_POST["cidade"];
  $estado      = @$_POST["estado"];

  $cpf = str_replace(".", "", $cpf);

if ($acao=="SALVARCADASTRO"){

    $insertsql = "insert into ajudante (cpf,nome,rg,email,salario,logradouro,cep,numero,bairro,complemento,cidade,estado) values ('".$cpf."','".$nome."','".$rg."','".$email."',".$salario.",'".$logradouro."','".$cep."','".$numero."','".$bairro."','".$complemento."','".$cidade."','".$estado."')";

    $insertresult = $conexao->query($insertsql);
    if ($insertresult){
        $mensagem = "Ajudante cadastrado com sucesso!";
    }else{
        $mensagem = "Erro ao cadastrar o Ajudante!";
    }

}else if ($acao =="SALVARUPDATE"){
      
      $updatesql = "update ajudante set nome = '".$nome."', rg = '".$rg."', salario = ".$salario.", email = '".$email."', cep = '".$cep."', logradouro = '".$logradouro."', numero = '".$numero."', complemento = '".$complemento."', bairro = '".$bairro."', cidade = '".$cidade."', estado = '".$estado."' where cpf='".$cpf."'";
      $updateresult = $conexao->query($updatesql);
      if ($updateresult){
          $mensagem = "Ajudante atualizado com sucesso!";
      }else{
          $mensagem = "Erro ao atualizar o Ajudante!";
      }
} 

if (!$cpf){
  $cpf = @$_GET["id"]; 
}

if ($acao == "DELETAR"){

  $select = "select cpf_ajudante from veiculo where deletado = 'N' and cpf_ajudante = '".$cpf."'";
  $selectresult = $conexao->query($select);

  if ($selectresult->num_rows == 0) {
      
    $deletesql = "update ajudante set deletado = 'S' where cpf = '".$cpf."'";
    $deleteresult = $conexao->query($deletesql);
    if ($deleteresult){
        $mensagem = "Ajudante deletado com sucesso!";
    }else{
        $mensagem = "Erro ao deletar o Ajudante!";
    }
  } else {
    $mensagem = "Erro ao deletar o Ajudante! Ajudante já vinculado a um veículo";
  }
}

  if ($acao == "ALTERAR" or $acao == "DETALHES"){
    $sql = "select * from ajudante where cpf='" . $cpf ."'";
    $result = $conexao->query($sql);
    $row = @mysqli_fetch_array($result);

    $nome        = $row["nome"];
    $rg          = $row["rg"];
    $salario     = $row["salario"];
    $email       = $row["email"];
    $cep         = $row["cep"];
    $logradouro  = $row["logradouro"];
    $numero      = $row["numero"];
    $complemento = $row["complemento"];
    $bairro      = $row["bairro"];
    $cidade      = $row['cidade'];
    $estado      = $row['estado'];
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

       <form id="ajudante" method="post" action="cad_ajudante.php"> 
        <input type="hidden" name="acao" id="acao" value="<?php print $acao; ?>" />
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu">Cadastrar Ajudante</p>
        
              <div class="row">
                <div class="col-md-6">
                  <p class="formu-letra">Nome</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="nome" id="nome" maxlength="100" value="<?php print $nome; ?>" />
                </div>
                <div class="col-md-6">
                  <p class="formu-letra">E-mail</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="email" name="email" id="email" maxlength="100" value="<?php print $email; ?>" />
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <p class="formu-letra">CPF</p>
                  <input <?php print $enablechave; ?> class="input-formu cpf" type="text" name="cpf" id="cpf" maxlength="14" value="<?php print $cpf; ?>"/>
                </div>
                <div class="col-md-4">
                  <p class="formu-letra">RG</p>
                  <input <?php print $enablecampos; ?> class="input-formu rg" type="text" name="rg" id="rg" maxlength="10" value="<?php print $rg; ?>"/>
                </div>
                <div class="col-md-4">
                  <p class="formu-letra">Salario</p>
                  <input <?php print $enablecampos; ?> class="input-formu money" type="text" name="salario" id="salario" value="<?php print $salario; ?>" />
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <p class="formu-letra">Cep</p>
                  <input <?php print $enablecampos; ?> class="input-formu cep" type="text" name="cep" id="cep" maxlength="9" value="<?php print $cep; ?>"/>
                </div>
                <div class="col-md-7">
                  <p class="formu-letra">Logradouro</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="logradouro" id="logradouro" maxlength="100" value="<?php print $logradouro; ?>"/>
                </div>
                <div class="col-md-2">
                  <p class="formu-letra">Número</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="numero" id="numero" maxlength="8" value="<?php print $numero; ?>"/>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <p class="formu-letra">Bairro</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="bairro" id="bairro" maxlength="30" value="<?php print $bairro; ?>"/>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">Complemento</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="complemento" id="complemento" maxlength="60" value="<?php print $complemento; ?>"/>
                </div>
                <div class="col-md-3">
                  <input type="hidden" name="uf" id="uf" value="<?php print $estado?>" /> 
                  <p class="formu-letra">Estado</p>
                  <select <?php print $enablecampos; ?> class="input-formu" type="text" name="estado" id="estado">
                  </select>
                </div>
                <div class="col-md-3">
                  <input type="hidden" name="cid" id="cid" value="<?php print $cidade?>" /> 
                  <p class="formu-letra">Cidade</p>
                   <select <?php print $enablecampos; ?> class="input-formu" type="text" name="cidade" id="cidade">
                   </select>
                </div>
              </div>
                
            </div>
              
          
              <div class="row">
                <div class="col-md-12">
                  <?php if ($acao!="DETALHES"){ ?>
                    <button class="btn-salvar" id="ajudante-salvar" type="button">Salvar</button> 
                  <?php } ?> 
                  <a href="visu_ajudante.php" class="btn-cancelar" type="button">Voltar</a>                  
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