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
  $id_trecho                  = @$_POST['trecho'];

if ($acao=="SALVARCADASTRO"){

    $dtfim = new DateTime($data_fim_contrato);
    $dtini = new DateTime($data_inicio_contrato);

    $intervalo = $dtfim->diff($dtini);
    $meses =  $intervalo->m + ($intervalo->y * 12);

    $insertsql = "insert into contrato (id_crianca,data_inicio_contrato,data_fim_contrato,dia_vencimento_mensalidade, mensalidade) values (".$id_crianca.",'".$data_inicio_contrato."','".$data_fim_contrato."',".$dia_vencimento_mensalidade.",".$mensalidade.")";

    $insertresult = $conexao->query($insertsql);
        //ir nos trechos selecionados e salvar o id do contrato criado 

      $data = $dtini;
      for ($i = 1 ; $i <= $meses; $i++) {
        $data = date('Y-m-d', strtotime("+1 month", strtotime($data_inicio_contrato)));
        // pega essa data converte para texto no data_inicio_contrato e salva no pagamentos 
      }
    if ($insertresult){
        $mensagem = "Contrato cadastrado com sucesso!";
    }else{
        $mensagem = "Erro ao cadastrar o Contrato!";
    }

}else if ($acao =="SALVARUPDATE"){
      // pode alterar a mensalidade, mas os pagamentos que já passaram nao altera
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
   // quando deletar o contrato apagar os pagamentos posteriores e alterar a data final do contrato    
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
  $rowcrianca = @mysqli_fetch_all($crianresult,MYSQLI_ASSOC);

  $criancas = "";
  foreach ($rowcrianca as $value) {
    $criancas .= $value["id"];
    $criancas .= ",";
  }
  $criancas = substr_replace($criancas, '', -1);

  //carregar as crianças com trechos 

  $trechosql = "select t.*,ct.* from criancatrecho ct
    inner join crianca c on c.id = ct.id_crianca
    inner join condutor o on o.cpf = ct.cpf_condutor
    inner join veiculo v on v.placa = ct.placa_veiculo
    inner join trecho t on t.id = ct.id_trecho 
    left join contrato co on co.id = ct.id_contrato
    where ct.id_crianca in (".$criancas.") and iSNULL(ct.id_contrato)";

  $trechoresult = $conexao->query($trechosql);

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
                  <?php foreach ($rowcrianca as $value) { ?>
                      <option <?php if ($id_crianca == $value['id']) { echo 'selected="true"'; } ?> value="<?php print $value['id'];?>"><?php print $value['id']." - ".$value['nome'];?></option>
                  <?php } ?>
                  </select>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">Data Inicio do Contrato</p>
                  <input <?php print $enablecampos ?> class="input-formu nasc" type="text" name="data_inicio_contrato" maxlength="60" value="<?php print $data_inicio_contrato; ?>"/>
                </div>
                <div class="col-md-3">
                <!-- data fim não pode ser maior que data começo -->
                  <p class="formu-letra">Data Final do Contrato</p>
                  <input <?php print $enablecampos ?> class="input-formu nasc" type="text" name="data_fim_contrato" maxlength="20" value="<?php print $data_fim_contrato; ?>"/>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">Dia Vencimento</p>
                  <input <?php print $enablecampos ?> class="input-formu" type="text" name="dia_vencimento_mensalidade" maxlength="20" value="<?php print $dia_vencimento_mensalidade; ?>"/>
                </div>
              </div>  
              <div class="row">
                <div class="col-md-6">
                  <input type="hidden" name="id" value="<?php echo $id;?>"/>
                  <p class="formu-letra">Transportes</p>
                  <!-- ver qual crianca ta selecionada e mostrar os trechos diponiveis dela -->
                  <!-- ao selecionar um trecho de um tipo não deixar selecionar mais de um desse tipo -->
                  <select <?php print $enablecampos ?> class="input-formu" type="text" name="trecho[]" maxlength="14" multiple>
                  <?php while ($trechorow = @mysqli_fetch_array($trechoresult)){ ?>
                      <option <?php if ($id_trecho == $trechorow['id']) { echo 'selected="true"'; } ?> value="<?php print $trechorow['id'];?>"><?php print $trechorow['cep_origem']." - ".$trechorow['cep_destino']." - ".$trechorow["periodo_conducao"];?></option>
                  <?php } ?>
                  </select>
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