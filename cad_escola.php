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

  $n_ident       = @$_POST["n_ident"];
  $nome          = @$_POST["nome"];
  $tipo          = @$_POST["tipo"];
  $logradouro    = @$_POST["logradouro"];
  $numero        = @$_POST["numero"];
  $bairro        = @$_POST["bairro"];
  $cep           =  str_replace("-", "", @$_POST["cep"]);
  $complemento   = @$_POST["complemento"];
  $estado        = @$_POST["estado"];
  $cidade        = @$_POST["cidade"];

if ($acao=="SALVARCADASTRO"){

    $insertsql = "insert into escola (nome,tipo,logradouro, numero, bairro, cep, complemento,cidade,estado) values ('".$nome."','".$tipo."','".$logradouro."','".$numero."','".$bairro."','".$cep."','".$complemento."','".$cidade."','".$estado."')";
    $insertresult = $conexao->query($insertsql);

    if ($insertresult){
        $mensagem = "Escola cadastrada com sucesso!";
    }else{
        $mensagem = "Erro ao cadastrar a Escola!";
    }

}else if ($acao =="SALVARUPDATE"){
      
      $updatesql = "update escola set nome = '".$nome."', tipo = '".$tipo."', logradouro = '".$logradouro."' , numero = '".$numero."' , bairro = '".$bairro."' , cep = '".$cep."' , complemento = '".$complemento."' , estado = '".$estado."' , cidade = '".$cidade."' where id='".$n_ident."'";
      $updateresult = $conexao->query($updatesql);

      if ($updateresult){
          $mensagem = "Escola atualizada com sucesso!";
      }else{
          $mensagem = "Erro ao atualizar a Escola!";
      }
    } 

if (!$n_ident){
  $n_ident = @$_GET["id"]; 
}

if ($acao == "DELETAR"){
  $select = "select id_escola from crianca where deletado = 'N' and id_escola=".$n_ident."";
  $selectresult = $conexao->query($select);

  if ($selectresult->num_rows == 0) {         
  
    $deletesql = "update escola set deletado = 'S' where id = '".$n_ident."'";
    $deleteresult = $conexao->query($deletesql);
    if ($deleteresult){
        $mensagem = "Escola deletada com sucesso!";
    }else{
        $mensagem = "Erro ao deletar a Escola!";
    }
  } else {
    $mensagem = "Erro ao deletar a Escola! Escola já possui crianças";
  }
}

  if ($acao == "ALTERAR" or $acao == "DETALHES"){
    $sql = "select * from escola where id='" . $n_ident ."'";
    $result = $conexao->query($sql);
    $row = @mysqli_fetch_array($result);

    $n_ident       = $row["id"];
    $nome          = $row["nome"];
    $tipo          = $row["tipo"];
    $logradouro    = $row["logradouro"];
    $numero        = $row["numero"];
    $bairro        = $row["bairro"];
    $cep           = $row["cep"];
    $complemento   = $row["complemento"];
    $cidade        = $row["cidade"];    
    $estado        = $row["estado"];
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

       <form id="escola" method="post" action="cad_escola.php"> 
        <input type="hidden" name="acao" id="acao" value="<?php print $acao; ?>" />
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu">Cadastrar Escola</p>
            
              <div class="row">
                <div class="col-md-12">
                <input type="hidden" name="n_ident" value="<?php echo $n_ident; ?>" />
                  <p class="formu-letra">Nome</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="nome" id="nome" maxlength="100"  value="<?php print $nome;?>"/>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <p class="formu-letra">Tipo</p>
                  <select <?php print $enablecampos; ?> class="input-formu" type="text" name="tipo" id="tipo" >
                    <option value="E"<?php if ($tipo == 'E') { echo 'selected="true"'; } ?> id="e">Estadual</option>
                    <option value="M"<?php if ($tipo == 'M') { echo 'selected="true"'; } ?> id="m">Municipal</option>
                    <option value="P"<?php if ($tipo == 'P') { echo 'selected="true"'; } ?> id="p">Particular</option>
                  </select>
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
                  <p class="formu-letra">Complemento</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="complemento" id="complemento" maxlength="60" value="<?php print $complemento;?>"/>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">Bairro</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="bairro" id="bairro" maxlength="30" value="<?php print $bairro;?>"/>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">Estado</p>
                  <input type="hidden" name="uf" id="uf" value="<?php print $estado?>" />
                  <select <?php print $enablecampos; ?> class="input-formu" type="text" name="estado" id="estado">
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
                  <button class="btn-salvar" id="escola-salvar" type="button">Salvar</button>  
                  <?php } ?>
                  <a href="visu_escola.php" class="btn-cancelar" type="button">Voltar</a>                  
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

