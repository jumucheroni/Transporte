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
  $periodo       = @$_POST["periodo"];

if ($acao=="SALVARCADASTRO"){

    $insertsql = "insert into escola (nome,tipo,logradouro, numero, bairro, cep, complemento) values ('".$nome."','".$tipo."','".$logradouro."','".$numero."','".$bairro."','".$cep."','".$complemento."')";
    $insertresult = $conexao->query($insertsql);
    $n_ident = @mysqli_insert_id();
    if ($periodo != ""){
      for ($i = 0; $i<sizeof($periodo); $i++){
        $insertperido = "insert into periodo (periodo,id_escola) values ('".$periodo[$i]."',".$n_ident.")";
        $insertperiodoresult = $conexao->query($insertperido);
      }
    }
    if ($insertresult){
        $mensagem = "Escola cadastrada com sucesso!";
    }else{
        $mensagem = "Erro ao cadastrar a Escola!";
    }

}else if ($acao =="SALVARUPDATE"){
      
      $updatesql = "update escola set nome = '".$nome."', tipo = '".$tipo."', logradouro = '".$logradouro."' , numero = '".$numero."' , bairro = '".$bairro."' , cep = '".$cep."' , complemento = '".$complemento."' where id='".$n_ident."'";
      $updateresult = $conexao->query($updatesql);

      $deleteperiodo = "delete from periodo where id_escola = '".$n_ident."'";
      $periododelete = $conexao->query($deleteperiodo);
      if ($periodo != ""){
        for ($i = 0; $i<sizeof($periodo); $i++){
          $insertperido = "insert into periodo (periodo,id_escola) values ('".$periodo[$i]."',".$n_ident.")";
          $insertperiodoresult = $conexao->query($insertperido);
        }
      }
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
      
  $deletesql = "delete from escola where id = '".$n_ident."'";
  $deleteresult = $conexao->query($deletesql);
  $deleteperiodo = "delete from periodo where id_escola = '".$n_ident."'";
  $periododelete = $conexao->query($deleteperiodo);
  if ($deleteresult){
      $mensagem = "Escola deletada com sucesso!";
  }else{
      $mensagem = "Erro ao deletar a Escola!";
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
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="nome" maxlength="100"  value="<?php print $nome;?>"/>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <p class="formu-letra">Tipo</p>
                  <select <?php print $enablecampos; ?> class="input-formu" type="text" name="tipo" >
                    <option value="Estadual"<?php if ($tipo == 'E') { echo 'selected="true"'; } ?> id="e">Estadual</option>
                    <option value="Municipal"<?php if ($tipo == 'M') { echo 'selected="true"'; } ?> id="m">Municipal</option>
                    <option value="Particular"<?php if ($tipo == 'P') { echo 'selected="true"'; } ?> id="p">Particular</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <p class="formu-letra">Periodo</p>
                  <select <?php print $enablecampos; ?> class="input-formu" type="text" name="periodo" multiple>
                    <option value="m"<?php if ($periodo == 'm') { echo 'selected="true"'; } ?> id="m">Manhã</option>
                    <option value="t"<?php if ($periodo == 't') { echo 'selected="true"'; } ?> id="t">Tarde</option>
                  </select>
                </div>         
              </div>
              <div class="row">
                <div class="col-md-4">
                  <p class="formu-letra">CEP</p>
                  <input <?php print $enablecampos; ?> class="input-formu cep" type="text" name="cep" maxlength="9" value="<?php print $cep;?>"/>
                </div>
                <div class="col-md-6">
                  <p class="formu-letra">Logradouro</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="logradouro" maxlength="100" value="<?php print $logradouro;?>"/>
                </div>
                <div class="col-md-2">
                  <p class="formu-letra">Numero</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="numero" maxlength="8" value="<?php print $numero;?>"/>
                </div>
              </div>
              <div class="row">
                <div class="col-md-8">
                  <p class="formu-letra">Complemento</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="complemento" maxlength="60" value="<?php print $complemento;?>"/>
                </div>
                <div class="col-md-4">
                  <p class="formu-letra">Bairro</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="bairro" maxlength="30" value="<?php print $bairro;?>"/>
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


  <script type="text/javascript">
    $(document).ready(function(){
      $("#escola-salvar").click(function(){

          if ($("#acao").val()=="CADASTRAR"){
              $("#acao").val("SALVARCADASTRO");
          }
          if ($("#acao").val()=="ALTERAR"){
              $("#acao").val("SALVARUPDATE");
          }
          $( "#escola" ).submit();
      });
    });

  </script>
