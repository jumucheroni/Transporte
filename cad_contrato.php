<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
    include './inc/header.php'; 
    include './inc/conexao.php';

      $acao = 'CADASTRAR';

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
?>
      <div class="row">
        <div class="row">
          <ol class="breadcrumb">
            <li><a href="index.php">
              <em class="fa fa-home"></em>
            </a></li>
            <li class="active">Financeiro</li>
            <li class="active">Contrato</li>
          </ol>
        </div>

       <form id="contrato" method="post"> 
        <input type="hidden" name="acao" id="acao" value="<?php print $acao; ?>" />
        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
              <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
                <div hidden id="alert"></div>
              </div>
              <div class="col-xs-12 col-sm-8 col-md-10 ">
                <h1 class="page-header">Cadastrar Contrato</h1>
              </div>
             
              <div class="row">
                <div class="col-md-3">
                  <div id="id_crianca-form" class="form-group">
                    <p class="formu-letra">Criança</p>
                    <select  class="form-control" type="text" name="id_crianca" id="id_crianca">
                        <option></option>
                    <?php foreach ($rowcrianca as $value) { ?>
                        <option value="<?php print $value['id'];?>"><?php print $value['id']." - ".$value['nome'];?></option>
                    <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="data_inicio_contrato-form" class="form-group">
                    <p class="formu-letra">Data Inicio do Contrato</p>
                    <input  class="form-control nasc" type="text" name="data_inicio_contrato" id="data_inicio_contrato" />
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="data_fim_contrato-form" class="form-group">
                    <p class="formu-letra">Data Final do Contrato</p>
                    <input  class="form-control nasc" type="text" name="data_fim_contrato" id="data_fim_contrato" />
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="dia_vencimento_mensalidade-form" class="form-group">
                    <p class="formu-letra">Dia Vencimento</p>
                    <input  class="form-control" type="text" name="dia_vencimento_mensalidade" id="dia_vencimento_mensalidade" />
                  </div>
                </div>
              </div>  
              <div class="row">
                <div class="col-md-3">
                  <div id="mensalidade-form" class="form-group">
                    <p class="formu-letra">Mensalidade</p>
                    <input  class="form-control money" type="text" name="mensalidade" id="mensalidade" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div id="trecho-form" class="form-group">
                    <p class="formu-letra">Transportes</p>
                    <!-- ver qual crianca ta selecionada e mostrar os trechos diponiveis dela -->
                    <!-- ao selecionar um trecho de um tipo não deixar selecionar mais de um desse tipo -->
                    <select class="form-control" type="text" name="trecho[]" id="trecho" multiple>
                    <?php while ($trechorow = @mysqli_fetch_array($trechoresult)){ ?>
                        <option hidden value="<?php print $trechorow['id'].'-'.$trechorow['id_crianca'].'-'.$trechorow['periodo_conducao'];?>"><?php print $trechorow['cep_origem']." - ".$trechorow['cep_destino']." - ".$trechorow["periodo_conducao"];?></option>
                    <?php } ?>
                    </select>
                  </div>
                </div>
              </div>        
              <div class="row">
                <div class="col-md-12">
                  <button class="btn btn-success btn-right" id="contrato-salvar" type="button">Salvar</button> 
                  <a href="visu_contrato.php" class="btn btn-link  btn-right" type="button">Voltar</a>                  
                </div>
              </div>
              
            </div>         
          </div>
        </form>

<?php include './inc/footer.php'; ?>
<script src="js/contrato.js"></script>
<?php } ?>