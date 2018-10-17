<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
    include './inc/header.php'; 
    include './inc/conexao.php';

    $acao="CADASTRAR";

    $veicsql = "select placa from veiculo";
    $veicresult = $conexao->query($veicsql);

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
        <input type="hidden" name="acao" id="acao" value="<?php print $acao; ?>" />
         <div class="row">
           <div class="col-xs-12 col-md-10 col-md-offset-1">
              <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
                <div hidden id="alert"></div>
              </div>
              <div class="col-xs-12 col-sm-8 col-md-10 ">
                <h1 class="page-header">Cadastrar Despesa</h1>
              </div>
             
              <div class="row">
                <div class="col-md-4">
                  <div id="placa_veiculo-form" class="form-group">
                    <input type="hidden" name="id" value="<?php echo $id;?>"/>
                    <p class="formu-letra">Veiculo</p>
                    <select class="form-control" type="text" name="placa_veiculo" id="placa_veiculo">
                    <?php while ($veicrow = @mysqli_fetch_array($veicresult)){ ?>
                        <option value="<?php print $veicrow['placa'];?>"><?php print $veicrow['placa'];?></option>
                    <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div id="data_gasto-form" class="form-group">
                    <p class="formu-letra">Data da Despesa</p>
                    <input class="form-control nasc" type="text" name="data_gasto" id="data_gasto" />
                  </div>
                </div>
                <div class="col-md-4">
                  <div id="valor_gasto-form" class="form-group">
                    <p class="formu-letra">Valor da Despesa</p>
                    <input class="form-control money" type="text" name="valor_gasto" id="valor_gasto" />
                  </div>
                </div>
              </div>   
              <div class="row">
                <div class="col-md-3">
                  <div id="tipo-form" class="form-group">
                    <p class="formu-letra">Tipo</p>
                    <select <?php print $enablecampos; ?> class="form-control" type="text" name="tipo" id="tipo" >
                      <option value="c" id="c">Combustível</option>
                      <option value="i" id="i">IPVA</option>
                      <option value="o" id="o">Oficina</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-9">
                  <div id="observacao-form" class="form-group">
                    <p class="formu-letra">Observação</p>
                    <input class="form-control" type="text" name="observacao" id="observacao" maxlength="255" />
                  </div>
                </div>
              </div>       
              <div class="row">
                <div class="col-md-12">
                  <button class="btn btn-success btn-right" id="despesa-salvar" type="button">Salvar</button> 
                  <a href="visu_despesas.php" class="btn btn-link  btn-right" type="button">Voltar</a>                  
                </div>
              </div>

              
            </div>         
          </div>
        </form>

<?php include './inc/footer.php';  ?>

<script src="js/despesas.js"></script>

<?php } ?>