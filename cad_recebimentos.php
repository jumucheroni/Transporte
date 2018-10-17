<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {

    include './inc/header.php'; 
    include './inc/conexao.php';

      $acao = "PAGAR"

      $id = @$_GET["id"]; 

      $sql = "select * from pagamentos where id=".$id;
      $result = $conexao->query($sql);
      $row = @mysqli_fetch_array($result);

      $valor_pago = $row["valor_pago"];
      $status = $row["status"];
      $data_pgto = DbtoDt($row["data_realizada_pgto"]);

?>
          <div class="row">
            <div class="row">
              <ol class="breadcrumb">
                <li><a href="index.php">
                  <em class="fa fa-home"></em>
                </a></li>
                <li class="active">Financeiro</li>
                <li class="active">Recebimentos</li>
              </ol>
            </div>
       <form id="recebimentos" method="post" role="form"> 
        <input type="hidden" name="acao" id="acao" value="<?php print $acao; ?>" />
        <input type="hidden" name="id" id="id" value="<?php print $id; ?>" />
            <div class="col-xs-12 col-md-10 col-md-offset-1">
              <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
                <div hidden id="alert"></div>
              </div>
              <div class="col-xs-12 col-sm-8 col-md-10 ">
                <h1 class="page-header">Cadastrar Recebimento</h1>
              </div>
            
              <div class="row">
                <div class="col-md-3">
                  <div id="data_pgto-form" class="form-group">
                    <p class="formu-letra">Data do Pagamento</p>
                    <input <?php print $enablecampos ?> class="input-formu nasc" type="text" name="data_pgto" value="<?php print $data_pgto; ?>"/>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="valor_pago-form" class="form-group">
                    <p class="formu-letra">Valor pago</p>
                    <input <?php print $enablecampos ?> class="input-formu money" type="text" name="valor_pago" value="<?php print $valor_pago; ?>"/>
                  </div>
                </div>
              </div>        
               <div class="row">
                <div class="col-md-12">
                  <button class="btn btn-success btn-right" id="recebimento-salvar" type="button">Salvar</button> 
                  <a href="visu_recebimentos.php" class="btn btn-link  btn-right" type="button">Voltar</a>                  
                </div>
              </div>


              
            </div>         
          </div>
        </form>

<?php include './inc/footer.php'; ?>
<script src="js/recebimentos.js"></script>

<?php } ?>