<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
    include './inc/header.php'; 
    include './inc/conexao.php';

      $enablechave = "readonly";

      $id = $_GET['id'];
      $sql = "select * from gastos where id=".$id;
      $result = $conexao->query($sql);
      $row = @mysqli_fetch_array($result);

      $id             = $row["id"];
      $placa_veiculo  = $row["placa_veiculo"];
      $data_gasto     = DbtoDt($row["data_gasto"]);
      $valor_gasto    = $row["valor_gasto"];
      $tipo           = $row["tipo"];
      $observacao     = $row["observacao"];

      $veicsql = "select placa from veiculo where placa = '".$placa_veiculo."'";
      $veicresult = $conexao->query($veicsql);
      $veicrow = @mysqli_fetch_array($veicresult)
 ?>

      <div class="row">
      <div class="row">
        <ol class="breadcrumb">
          <li><a href="index.php">
            <em class="fa fa-home"></em>
          </a></li>
          <li class="active">Controle</li>
          <li class="active">Despesa</li>
        </ol>
      </div>
       <form id="despesa" method="post" role="form"> 
        <input type="hidden" name="acao" id="acao" value="ALTERAR" />
         <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <h1 class="page-header">Ajudante</h1>
             
              <div class="row">
                <div class="col-md-4">
                  <div id="placa_veiculo-form" class="form-group">
                    <input type="hidden" name="id" value="<?php echo $id;?>"/>
                    <p class="formu-letra">Veiculo</p>
                    <h4><?php print $veicrow['placa'];?></h4>
                  </div>
                </div>
                <div class="col-md-4">
                  <div id="data_gasto-form" class="form-group">
                    <p class="formu-letra">Data da Despesa</p>
                    <h4><?php print $data_gasto;?></h4>
                  </div>
                </div>
                <div class="col-md-4">
                  <div id="valor_gasto-form" class="form-group">
                    <p class="formu-letra">Valor da Despesa</p>
                    <h4><?php print $valor_gasto;?></h4>
                  </div>
                </div>
              </div>   
              <div class="row">
                <div class="col-md-3">
                  <div id="tipo-form" class="form-group">
                    <p class="formu-letra">Tipo</p>
                    <h4><?php if ($tipo == 'c') print 'Combustível'; if ($tipo == 'i') print 'IPVA'; if ($tipo == 'o') print 'Oficina'; ?></h4>
                  </div>
                </div>
                <div class="col-md-9">
                  <div id="observacao-form" class="form-group">
                    <p class="formu-letra">Observação</p>
                    <h4><?php print $observacao; ?></h4>
                  </div>
                </div>
              </div>       
              <div class="row">
                <div class="col-md-12">
                  <a href="visu_despesas.php" class="btn btn-link  btn-right" type="button">Voltar</a>                  
                </div>
              </div>

              
            </div>         
          </div>
        </form>

<?php include './inc/footer.php'; ?>

<script src="js/despesas.js"></script>

<?php } ?>