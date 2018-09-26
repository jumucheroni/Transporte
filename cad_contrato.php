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

      $id = @$_POST["id"];
      if (!$id) {
       $id = @$_GET["id"]; 
      }

      $id_crianca                 = @$_POST["id_crianca"];
      $data_inicio_contrato       = DtToDb(@$_POST["data_inicio_contrato"]);
      $data_fim_contrato          = DtToDb(@$_POST["data_fim_contrato"]);
      $dia_vencimento_mensalidade = @$_POST["dia_vencimento_mensalidade"];
      $mensalidade                = str_replace(",",".",@$_POST["mensalidade"]);
      $id_trecho                  = @$_POST['trecho'];

    if ($acao=="SALVARCADASTRO"){

        $dtfim = new DateTime($data_fim_contrato);
        $dtini = new DateTime($data_inicio_contrato);

        $intervalo = $dtfim->diff($dtini);
        $meses =  $intervalo->m + ($intervalo->y * 12);

        $insertsql = "insert into contrato (id_crianca,data_inicio_contrato,data_fim_contrato,dia_vencimento_mensalidade, mensalidade) values (".$id_crianca.",'".$data_inicio_contrato."','".$data_fim_contrato."',".$dia_vencimento_mensalidade.",".$mensalidade.")";
        print_r($insertsql);

        $insertresult = $conexao->query($insertsql); 

        $id_contrato = $conexao->insert_id;
        $data = $dtini;
        for ($i = 1 ; $i <= $meses; $i++) {
          $insertpagamentosql = "insert into pagamentos (data_prevista_pgto,status,id_contrato) values ('".$data_inicio_contrato."','N',".$id_contrato.")";
          $insertpagamentosresult = $conexao->query($insertpagamentosql);
          $data = date('Y-m-d', strtotime("+1 month", strtotime($data_inicio_contrato)));
          $data_inicio_contrato = $data;
        }

        foreach ($id_trecho as $value) {
          $trecho = explode("-", $value);
          $updatetrechosql = "update criancatrecho set id_contrato = ".$id_contrato." where id_crianca = ".$id_crianca." and id_trecho = ".$trecho[0];
          $updatetrechoresult = $conexao->query($updatetrechosql);
        }

        if ($insertresult){
            $mensagem = "Contrato cadastrado com sucesso!";
        }else{
            $mensagem = "Erro ao cadastrar o Contrato!";
        }

    }else if ($acao =="SALVARUPDATE"){

          $updatesql = "update contrato set dia_vencimento_mensalidade = ".$dia_vencimento_mensalidade.", mensalidade = ".$mensalidade." where id = ".$id;
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
      $hoje = date('Y-m-d');
      $deletesql = "update contrato set data_fim_contrato = '".$hoje."', deletado = 'S' where id = ".$id;
      $deleteresult = $conexao->query($deletesql);
      if ($deleteresult){
          $mensagem = "Contrato deletado com sucesso!";
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

      $criansql = "select id,nome from crianca where deletado = 'N' ";
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
        <input type="hidden" name="id" id="id" value="<?php print $id; ?>" />
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu">Cadastrar Contrato</p>
             
              <div class="row">
                <div class="col-md-3">
                  <input type="hidden" name="id" value="<?php echo $id;?>"/>
                  <p class="formu-letra">Criança</p>
                  <select <?php print $enablecampos ?> class="input-formu" type="text" name="id_crianca" id="id_crianca">
                      <option></option>
                  <?php foreach ($rowcrianca as $value) { ?>
                      <option <?php if ($id_crianca == $value['id']) { echo 'selected="true"'; } ?> value="<?php print $value['id'];?>"><?php print $value['id']." - ".$value['nome'];?></option>
                  <?php } ?>
                  </select>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">Data Inicio do Contrato</p>
                  <input <?php print $enablecampos ?> class="input-formu nasc" type="text" name="data_inicio_contrato" id="data_inicio_contrato" value="<?php print $data_inicio_contrato; ?>"/>
                </div>
                <div class="col-md-3">
                <!-- data fim não pode ser maior que data começo -->
                  <p class="formu-letra">Data Final do Contrato</p>
                  <input <?php print $enablecampos ?> class="input-formu nasc" type="text" name="data_fim_contrato" id="data_fim_contrato" value="<?php print $data_fim_contrato; ?>"/>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">Dia Vencimento</p>
                  <input <?php print $enablecampos ?> class="input-formu" type="text" name="dia_vencimento_mensalidade" id="dia_vencimento_mensalidade" value="<?php print $dia_vencimento_mensalidade; ?>"/>
                </div>
              </div>  
              <div class="row">
                <div class="col-md-3">
                  <p class="formu-letra">Mensalidade</p>
                  <input <?php print $enablecampos ?> class="input-formu money" type="text" name="mensalidade" id="mensalidade" value="<?php print $mensalidade; ?>"/>
                </div>
                <div class="col-md-6">
                  <input type="hidden" name="id" value="<?php echo $id;?>"/>
                  <p class="formu-letra">Transportes</p>
                  <!-- ver qual crianca ta selecionada e mostrar os trechos diponiveis dela -->
                  <!-- ao selecionar um trecho de um tipo não deixar selecionar mais de um desse tipo -->
                  <select <?php print $enablecampos ?> class="input-formu" type="text" name="trecho[]" id="trecho" multiple>
                  <?php while ($trechorow = @mysqli_fetch_array($trechoresult)){ ?>
                      <option hidden <?php if ($id_trecho == $trechorow['id']) { echo 'selected="true"'; } ?> value="<?php print $trechorow['id'].'-'.$trechorow['id_crianca'].'-'.$trechorow['periodo_conducao'];?>"><?php print $trechorow['cep_origem']." - ".$trechorow['cep_destino']." - ".$trechorow["periodo_conducao"];?></option>
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
<script src="js/contrato.js"></script>
<?php } ?>