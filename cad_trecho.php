<?php 

include './inc/header.php'; 
include './inc/conexao.php';

  $acao = @$_GET["acao"];

  $mensagem = "";
  $enablechave = "";
  $enablecampos = "";
  $cpf_responsavel = "";

if (!$acao){
  $acao = @$_POST["acao"];
}

  $crianca          = @$_POST["crianca"];
  $n_ident          = @$_POST["n_ident"];
  $preco            = @$_POST["preco"];
  if ($crianca){
    $crianca          = explode(";", $crianca);
    $cpf_responsavel  = $crianca[0];
    $nome_crianca     = $crianca[1];
  }
  $n_alvara         = @$_POST["n_alvara"];
  $tipo             = @$_POST["tipo"];

if ($acao=="SALVARCADASTRO"){

    $insertsql = "insert into trecho (Numero_Identificacao,Preco,CPF_Responsavel,Nome_Crianca,N_Alvara ,Tipo) values (".$n_ident.",".$preco.",'".$cpf_responsavel."','".$nome_crianca."',".$n_alvara.",'".$tipo."')";
    $insertresult = $conexao->query($insertsql);
    if ($insertresult){
        $mensagem = "Transporte cadastrado com sucesso!";
    }else{
        $mensagem = "Erro ao cadastrar o Transporte!";
    }

    $sqltrecho = "select SUM(preco) as mensalidade from trecho where CPF_Responsavel='".$cpf_responsavel."' and Nome_Crianca='".$nome_crianca."'";
    $trechoresult = $conexao->query($sqltrecho);
    $trechorow = @mysqli_fetch_array($trechoresult);
    $updatemensalidade = "update crianca set Mensalidade = ".$trechorow['mensalidade']." where CPF_Responsavel='".$cpf_responsavel."' and Nome='".$nome_crianca."'";
    $mensalidaderesult = $conexao->query($updatemensalidade);

}else if ($acao =="SALVARUPDATE"){
      
      $updatesql = "update trecho set Preco = ".$preco.", CPF_Responsavel = '".$cpf_responsavel."', Nome_Crianca = '".$nome_crianca."', N_Alvara = '".$n_alvara."' , Tipo = '".$tipo."' where Numero_Identificacao=".$n_ident;
      $updateresult = $conexao->query($updatesql);
      if ($updateresult){
          $mensagem = "Transporte atualizado com sucesso!";
      }else{
          $mensagem = "Erro ao atualizar o Transporte!";
      }
    } 

if (!$n_ident){
  $n_ident = @$_GET["id"]; 
}

if ($acao == "DELETAR"){
      
  $deletesql = "delete from trecho where Numero_Identificacao = ".$n_ident;
  $deleteresult = $conexao->query($deletesql);
  if ($deleteresult){
      $mensagem = "Transporte deletado com sucesso!";
  }else{
      $mensagem = "Erro ao deletar o Transporte!";
  }
}

  if ($acao == "ALTERAR" or $acao == "DETALHES"){
    $sql = "select * from trecho where Numero_Identificacao=" . $n_ident;
    $result = $conexao->query($sql);
    $row = @mysqli_fetch_array($result);

    $n_ident          = $row["Numero_Identificacao"];
    $preco            = $row["Preco"];
    $cpf_responsavel  = $row["CPF_Responsavel"];
    $nome_crianca     = $row["Nome_Crianca"];
    $n_alvara         = $row["N_Alvara"];
    $tipo             = $row["Tipo"];
  }

  if ($acao == "ALTERAR"){
    $enablechave = "disabled";
  }
  if ($acao == "DETALHES"){
    $enablechave = "disabled";
    $enablecampos = "disabled";
  }

  $criancasql = "select CPF_Responsavel,Nome from crianca";
  $criancaresult = $conexao->query($criancasql);

  $alvasql = "select Numero_Identificacao from alvara";
  $alvaresult = $conexao->query($alvasql);

if ($mensagem){
?>
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p style="text-align: center;" class="titulo-formu"><?php print $mensagem?></p>
            </div>         
          </div>

<?php } else { ?>

       <form id="trecho" method="post" action="cad_trecho.php"> 
        <input type="hidden" name="acao" id="acao" value="<?php print $acao; ?>" />
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu">Cadastrar Transporte</p>

              <div class="row">
                <div class="col-md-8">
                  <p class="formu-letra">Número Identificação</p>
                  <input <?php print $enablechave; ?> class="input-formu" type="text" name="n_ident" maxlength="11" value="<?php print $n_ident?>"/>
                </div>
                <div class="col-md-4">
                  <p class="formu-letra">Valor</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="preco" maxlength="11" value="<?php print $preco?>"/>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <p class="formu-letra">Criança</p>
                   <select <?php print $enablecampos; ?> class="input-formu" type="text" name="crianca" maxlength="60">
                    <?php while ($criancarow = @mysqli_fetch_array($criancaresult)){ ?>
                      <option <?php if (($cpf_responsavel == $criancarow['CPF_Responsavel']) and ($nome_crianca == $criancarow['Nome'])) { echo 'selected="true"'; } ?> value="<?php print $criancarow['CPF_Responsavel'].';'.$criancarow['Nome'];?>"><?php print $criancarow['Nome'];?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <p class="formu-letra">Alvará</p>
                   <select <?php print $enablecampos; ?> class="input-formu" type="text" name="n_alvara" maxlength="8">
                    <?php while ($alvarow = @mysqli_fetch_array($alvaresult)){ ?>
                      <option <?php if ($n_alvara == $alvarow['Numero_Identificacao']) { echo 'selected="true"'; } ?> value="<?php print $alvarow['Numero_Identificacao'];?>"><?php print $alvarow['Numero_Identificacao'];?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-md-6">
                  <p class="formu-letra">Tipo</p>
                    <select <?php print $enablecampos; ?> class="input-formu" type="text" name="tipo" >
                        <option value="I" <?php if ($tipo == 'I') { echo 'selected="true"'; } ?> id="i">Ida</option>
                        <option value="V" <?php if ($tipo == 'V') { echo 'selected="true"'; } ?> id="v">Volta</option>
                    </select>
                  </div> 
              </div>             
          
              <div class="row">
                <div class="col-md-12">
                 <?php if ($acao!="DETALHES"){ ?>
                  <button class="btn-salvar" id="trecho-salvar" type="submit">Salvar</button>  
                 <?php } ?>
                  <a href="visu_trecho.php" class="btn-cancelar" type="button">Cancelar</a>                  
                </div>
              </div>

              
            </div>         
          </div>
        </form>


<?php } ?>

<?php include './inc/footer.php'; ?>


  <script type="text/javascript">
    $(document).ready(function(){
      $("#trecho-salvar").click(function(){

          if ($("#acao").val()=="CADASTRAR"){
              $("#acao").val("SALVARCADASTRO");
          }
          if ($("#acao").val()=="ALTERAR"){
              $("#acao").val("SALVARUPDATE");
          }
          $( "#trecho" ).submit();
      });
    });

  </script>
