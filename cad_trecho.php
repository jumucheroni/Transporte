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

  $id_crianca       = @$_POST["crianca"];
  if (!$id_crianca) {
   $id_crianca       = @$_GET["id_crianca"]; 
  }

  $id_trecho        = @$_POST["id_trecho"];
  if (!$id_trecho) {
   $id_trecho       = @$_GET["id_trecho"]; 
  }

  $tipo             = @$_POST["tipo"];

  $conducao = @$_POST["conducao"];
  if (!empty($conducao)) {
    $conducao = explode(";", $conducao);
    $cpf_condutor = $conducao[0];
    $placa_veiculo = $conducao[1];
    $periodo = $conducao[2];    
  } else {
    $cpf_condutor = "";
    $placa_veiculo = "";
    $periodo = "";
  }

  $cep_origem         = str_replace("-", "", @$_POST["cep_origem"]);
  $logradouro_origem  = @$_POST["logradouro_origem"];
  $numero_origem      = @$_POST["numero_origem"];
  $complemento_origem = @$_POST["complemento_origem"];
  $bairro_origem      = @$_POST["bairro_origem"];
  $cidade_origem      = @$_POST["cidade_origem"];
  $estado_origem      = @$_POST["estado_origem"];

  $cep_destino         = str_replace("-", "", @$_POST["cep_destino"]);
  $logradouro_destino  = @$_POST["logradouro_destino"];
  $numero_destino      = @$_POST["numero_destino"];
  $complemento_destino = @$_POST["complemento_destino"];
  $bairro_destino      = @$_POST["bairro_destino"];
  $cidade_destino      = @$_POST["cidade_destino"];
  $estado_destino      = @$_POST["estado_destino"];

if ($acao=="SALVARCADASTRO"){
    $selectsql = "select periodo_conducao,id_crianca from criancatrecho where periodo_conducao= '".$periodo."' and id_crianca = ".$id_crianca;
    $selectsqlresult = $conexao->query($selectsql);

    if ($selectsqlresult->num_rows > 0) {
        $mensagem = "Transporte já cadastrado para essa criança!";
    } else {
      $insertsql = "insert into trecho (tipo,logradouro_origem,cep_origem,numero_origem,bairro_origem,complemento_origem,cidade_origem,estado_origem,logradouro_destino,cep_destino,numero_destino,bairro_destino,complemento_destino,cidade_destino,estado_destino) values ('".$tipo."','".$logradouro_origem."','".$cep_origem."','".$numero_origem."','".$bairro_origem."','".$complemento_origem."','".$cidade_origem."','".$estado_origem."','".$logradouro_destino."','".$cep_destino."','".$numero_destino."','".$bairro_destino."','".$complemento_destino."','".$cidade_destino."','".$estado_destino."')";

      $insertresult = $conexao->query($insertsql);

      if ($insertresult) {
        $id_trecho = $conexao->insert_id;

        $insertcritrechosql = "insert into criancatrecho (id_trecho,id_crianca,cpf_condutor,placa_veiculo,periodo_conducao,id_contrato) values (".$id_trecho.",".$id_crianca.",'".$cpf_condutor."','".$placa_veiculo."','".$periodo."',null)";

        $insertcritrechoresult = $conexao->query($insertcritrechosql);
      }

      if ($insertresult && $insertcritrechoresult){
          $mensagem = "Transporte cadastrado com sucesso!";
      }else{
          $mensagem = "Erro ao cadastrar o Transporte!";
      }
    }

}else if ($acao =="SALVARUPDATE"){
      
      $updatesql = "update trecho set tipo = '".$tipo."', cep_origem = '".$cep_origem."', logradouro_origem = '".$logradouro_origem."', numero_origem = '".$numero_origem."', bairro_origem = '".$bairro_origem."', complemento_origem = '".$complemento_origem."', cidade_origem = '".$cidade_origem."', estado_origem = '".$estado_origem."', cep_destino = '".$cep_destino."', logradouro_destino = '".$logradouro_destino."', numero_destino = '".$numero_destino."', bairro_destino = '".$bairro_destino."', complemento_destino = '".$complemento_destino."', cidade_destino = '".$cidade_destino."', estado_destino = '".$estado_destino."' where id=".$id_trecho;

      $updatecritrechosql = "update criancatrecho set cpf_condutor = '".$cpf_condutor."', placa_veiculo = '".$placa_veiculo."', periodo_conducao = '".$periodo."' where id_trecho = ".$id_trecho." and id_crianca = ".$id_crianca;

      $updateresult = $conexao->query($updatesql);
      $updatecritrechoresult = $conexao->query($updatecritrechosql);

      if ($updateresult && $updatecritrechoresult){
          $mensagem = "Transporte atualizado com sucesso!";
      }else{
          $mensagem = "Erro ao atualizar o Transporte!";
      }
    } 

if (!$id_trecho && $id_crianca){
  $id_trecho = @$_GET["id_trecho"]; 
  $id_crianca = @$_GET["id_crianca"];
}

if ($acao == "DELETAR"){
  $select = "select c.id from contrato c inner join criancatrecho ct on ct.id_contrato = c.id and ct.id_trecho = ".$id_trecho." and id_crianca = ".$id_crianca." where c.deletado = 'N'";
  $selectresult = $conexao->query($select);

  if ($selectresult->num_rows == 0) {      
      
    $deletesql = "update criancatrecho set deletado = 'S' where id_trecho = ".$id_trecho." and id_crianca = ".$id_crianca;
    $deletesql2 = "update trecho set deletado = 'S' where id = ".$id_trecho;

    $deleteresult = $conexao->query($deletesql);
    $deleteresult2 = $conexao->query($deletesql2);
    
    if ($deleteresult and $deleteresult2){
        $mensagem = "Transporte deletado com sucesso!";
    }else{
        $mensagem = "Erro ao deletar o Transporte!";
    }
  } else {
    $mensagem = "Erro ao deletar o Transporte! Transporte já associado a um contrato ";
  }
}

  if ($acao == "ALTERAR" or $acao == "DETALHES"){
    $sql = "select t.*,ct.* from criancatrecho ct
    inner join crianca c on c.id = ct.id_crianca
    inner join condutor o on o.cpf = ct.cpf_condutor
    inner join veiculo v on v.placa = ct.placa_veiculo
    inner join trecho t on t.id = ct.id_trecho 
    where ct.id_trecho = ".$id_trecho." and ct.id_crianca = ".$id_crianca;

    $result = $conexao->query($sql);
    $row = @mysqli_fetch_array($result);

    $id_crianca       = $row["id_crianca"];
    $id_trecho        = $row["id_trecho"];
    $tipo             = $row["tipo"];
    $cpf_condutor     = $row["cpf_condutor"];
    $placa_veiculo    = $row["placa_veiculo"];
    $periodo          = $row["periodo_conducao"];

    $cep_origem         = $row["cep_origem"];
    $logradouro_origem  = $row["logradouro_origem"];
    $numero_origem      = $row["numero_origem"];
    $complemento_origem = $row["complemento_origem"];
    $bairro_origem      = $row["bairro_origem"];
    $cidade_origem      = $row["cidade_origem"];
    $estado_origem      = $row["estado_origem"];

    $cep_destino         = $row["cep_destino"];
    $logradouro_destino  = $row["logradouro_destino"];
    $numero_destino      = $row["numero_destino"];
    $complemento_destino = $row["complemento_destino"];
    $bairro_destino      = $row["bairro_destino"];
    $cidade_destino      = $row["cidade_destino"];
    $estado_destino      = $row["estado_destino"];
  }

  if ($acao == "ALTERAR"){
    $enablechave = "readonly";
  }
  if ($acao == "DETALHES"){
    $enablechave = "readonly";
    $enablecampos = "readonly";
  }

  $criancasql = "select id,nome from crianca where deletado = 'N' ";
  $criancaresult = $conexao->query($criancasql);

  $conducaosql = "select * from condutorveiculo where deletado = 'N' ";
  $conducaoresult = $conexao->query($conducaosql);

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
        <input type="hidden" name="id_trecho" id="id_trecho" value="<?php print $id_trecho; ?>" />
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu">Cadastrar Transporte</p>

              <div class="row">
                <div class="col-md-4">
                  <p class="formu-letra">Tipo</p>
                    <select disabled="true" class="input-formu" type="text" name="tipo" id="tipo" >
                        <option></option>
                        <option value="im" <?php if ($tipo == 'im') { echo 'selected="true"'; } ?> id="im">Ida-Manhã</option>
                        <option value="it" <?php if ($tipo == 'it') { echo 'selected="true"'; } ?> id="it">Ida-Tarde</option>
                        <option value="vm" <?php if ($tipo == 'vm') { echo 'selected="true"'; } ?> id="vm">Volta-Manhã</option>
                        <option value="vt" <?php if ($tipo == 'vt') { echo 'selected="true"'; } ?> id="vt">Volta-Tarde</option>
                    </select>
                  </div> 
                <div class="col-md-8">
                  <p class="formu-letra">Criança</p>
                   <select <?php print $enablechave; ?> class="input-formu" type="text" name="crianca" id="crianca" >
                    <?php while ($criancarow = @mysqli_fetch_array($criancaresult)){ ?>
                      <option <?php if ($id_crianca == $criancarow['id'])  { echo 'selected="true"'; } ?> value="<?php print $criancarow['id'];?>"><?php print $criancarow['nome'];?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="row">
                
                <div class="col-md-6">
                  <p class="formu-letra">Condução</p>
                   <select <?php print $enablecampos; ?> class="input-formu" type="text" name="conducao" id="conducao" >
                   <option></option>
                    <?php while ($conducaorow = @mysqli_fetch_array($conducaoresult)){ ?>
                      <option <?php if ($cpf_condutor == $conducaorow['cpf_condutor'] && $placa_veiculo == $conducaorow['placa_veiculo'] && $periodo == $conducaorow['periodo'])  { echo 'selected="true"'; } ?> value="<?php print $conducaorow['cpf_condutor'].';'.$conducaorow['placa_veiculo'].';'.$conducaorow['periodo'];?>"><?php print $conducaorow['cpf_condutor']."-".$conducaorow['placa_veiculo']."-".$conducaorow['periodo'];?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <p class="formu-letra">Cep - Origem</p>
                  <input <?php print $enablecampos; ?> class="input-formu cep" type="text" name="cep_origem" id="cep_origem" maxlength="9" value="<?php print $cep_origem; ?>"/>
                </div>
                <div class="col-md-7">
                  <p class="formu-letra">Logradouro - Origem</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="logradouro_origem" id="logradouro_origem" maxlength="100" value="<?php print $logradouro_origem; ?>"/>
                </div>
                <div class="col-md-2">
                  <p class="formu-letra">Nº - Origem</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="numero_origem" id="numero_origem" maxlength="8" value="<?php print $numero_origem; ?>"/>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <p class="formu-letra">Bairro - Origem</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="bairro_origem" id="bairro_origem" maxlength="30" value="<?php print $bairro_origem; ?>"/>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">Complemento - Origem</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="complemento_origem" id="complemento_origem" maxlength="60" value="<?php print $complemento_origem; ?>"/>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">Estado - Origem</p>
                  <input type="hidden" name="uf_origem" id="uf_origem" value="<?php print $estado_origem?>" /> 
                  <select <?php print $enablecampos; ?> class="input-formu" type="text" name="estado_origem" id="estado_origem">
                  </select>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">Cidade - Origem</p>
                  <input type="hidden" name="cid_origem" id="cid_origem" value="<?php print $cidade_origem?>" /> 
                   <select <?php print $enablecampos; ?> class="input-formu" type="text" name="cidade_origem" id="cidade_origem">
                   </select>
                </div>
              </div>  

              <div class="row">
                <div class="col-md-3">
                  <p class="formu-letra">Cep - Destino</p>
                  <input <?php print $enablecampos; ?> class="input-formu cep" type="text" name="cep_destino" id="cep_destino" maxlength="9" value="<?php print $cep_destino; ?>"/>
                </div>
                <div class="col-md-7">
                  <p class="formu-letra">Logradouro - Destino</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="logradouro_destino" id="logradouro_destino" maxlength="100" value="<?php print $logradouro_destino; ?>"/>
                </div>
                <div class="col-md-2">
                  <p class="formu-letra">Nº - Destino</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="numero_destino" id="numero_destino" maxlength="8" value="<?php print $numero_destino; ?>"/>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <p class="formu-letra">Bairro - Destino</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="bairro_destino" id="bairro_destino" maxlength="30" value="<?php print $bairro_destino; ?>"/>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">Complemento - Destino</p>
                  <input <?php print $enablecampos; ?> class="input-formu" type="text" name="complemento_destino" id="complemento_destino" maxlength="60" value="<?php print $complemento_destino; ?>"/>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">Estado - Destino</p>
                  <input type="hidden" name="uf_destino" id="uf_destino" value="<?php print $estado_destino?>" /> 
                  <select <?php print $enablecampos; ?> class="input-formu" type="text" name="estado_destino" id="estado_destino">
                  </select>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">Cidade - Destino</p>
                  <input type="hidden" name="cid_destino" id="cid_destino" value="<?php print $cidade_destino?>" /> 
                   <select <?php print $enablecampos; ?> class="input-formu" type="text" name="cidade_destino" id="cidade_destino">
                   </select>
                </div>
              </div>             
          
              <div class="row">
                <div class="col-md-12">
                 <?php if ($acao!="DETALHES"){ ?>
                  <button class="btn-salvar" id="trecho-salvar" type="button">Salvar</button>  
                 <?php } ?>
                  <a href="visu_trecho.php" class="btn-cancelar" type="button">Cancelar</a>                  
                </div>
              </div>

              
            </div>         
          </div>
        </form>


<?php } ?>

<?php include './inc/footer.php'; ?>

<script>
  $(document).ready(function(){
    var cep_origem = $("#cep_origem").val();
    if (cep_origem) {
      cep_origem = cep_origem.replace("-","");
      var estado_origem = $("#uf_origem").val();
      var cidade_origem = $("#cid_origem").val();
      carregaestadocidade_origem(cep_origem,estado_origem,cidade_origem);
    }

    var cep_destino = $("#cep_destino").val();
    if (cep_destino) {
      cep_destino = cep_destino.replace("-","");
      var estado_destino = $("#uf_destino").val();
      var cidade_destino = $("#cid_destino").val();
      carregaestadocidade_destino(cep_destino,estado_destino,cidade_destino);
    }
  });
</script>
