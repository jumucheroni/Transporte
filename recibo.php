<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {

include './inc/header.php';
include './inc/conexao.php'; 

      $criancasql = "select id,nome from crianca where deletado = 'N' ";
      $criancaresult = $conexao->query($criancasql);

?>
  <div class="row">
      <div class="row">
        <ol class="breadcrumb">
          <li><a href="index.php">
            <em class="fa fa-home"></em>
          </a></li>
          <li class="active">Financeiro</li>
          <li class="active">Recibo</li>
        </ol>
      </div>
    <form id="recibo" method="post" role="form" action="mostra_recibo.php"> 
         <div class="col-xs-12 col-md-10 col-md-offset-1">
              <input type="hidden" name="acao" id="acao" value=""/>
              <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
                <div hidden id="alert"></div>
              </div>
              <div class="col-xs-12 col-sm-8 col-md-10 ">
                <h1 class="page-header">Recibos</h1>
              </div>
        
              <div class="row">
                <div class="col-md-4">
                  <div id="crianca-form" class="form-group">
                    <p class="letra-fi">Nome da Criança</p>
                    <select class="form-control" type="text" name="crianca" id="crianca" >
                      <?php while ($criancarow = @mysqli_fetch_array($criancaresult)){ ?>
                        <option  value="<?php print $criancarow['id'];?>"><?php print $criancarow['nome'];?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div id="mes-form" class="form-group">
                    <p class="letra-fi">Mês</p>
                    <select class="form-control" type="text" name="mes" id="mes" >
                        <option  value="01">Janeiro</option>
                        <option  value="02">Fevereiro</option>
                        <option  value="03">Março</option>
                        <option  value="04">Abril</option>
                        <option  value="05">Maio</option>
                        <option  value="06">Junho</option>
                        <option  value="07">Julho</option>
                        <option  value="08">Agosto</option>
                        <option  value="09">Setembro</option>
                        <option  value="10">Outubro</option>
                        <option  value="11">Novembro</option>
                        <option  value="12">Dezembro</option>
                    </select>
                  </div>
                </div>
              </div>       
              </div>        
              <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-success btn-right" id="gerar-recibo" type="button">Gerar</button>              
                </div>
              </div>

              
            </div>         
          </div>
        </form>

<?php include './inc/footer.php'; ?>

<script src="js/recibo.js"></script>

<?php } ?>