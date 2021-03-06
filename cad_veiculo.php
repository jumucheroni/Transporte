<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
    include './inc/header.php'; 
    include './inc/conexao.php';

    $acao = "CADASTRAR";

    $ajudsql = "select cpf,nome from ajudante where cpf not in (select cpf_ajudante from veiculo) and deletado='N'";
    $ajudresult = $conexao->query($ajudsql);

?>
      <div class="row">
        <div class="row">
          <ol class="breadcrumb">
            <li><a href="index.php">
              <em class="fa fa-home"></em>
            </a></li>
            <li class="active">Controle</li>
            <li class="active">Veículo</li>
          </ol>
        </div>
       <form id="veiculo" method="post" role="form"> 
        <input type="hidden" name="acao" id="acao" value="<?php print $acao; ?>" />
         <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
              <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
                <div hidden id="alert"></div>
              </div>
              <div class="col-xs-12 col-sm-8 col-md-10 ">
                <h1 class="page-header">Cadastrar Veículo</h1>
              </div>
          
              <div class="row">
                <div class="col-md-4">
                  <div id="placa-form" class="form-group">
                    <p class="formu-letra">Placa</p>
                    <input class="form-control placa" type="text" name="placa" id="placa" maxlength="8"/>
                  </div>
                </div>
                <div class="col-md-4">
                  <div id="marca-form" class="form-group">
                    <p class="formu-letra">Marca</p>
                    <input class="form-control" type="text" name="marca" id="marca" maxlength="30" />
                  </div>
                </div>
                <div class="col-md-4">
                  <div id="modelo-form" class="form-group">
                    <p class="formu-letra">Modelo</p>
                    <input class="form-control" type="text" name="modelo" id="modelo" maxlength="30" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div id="lotacao-form" class="form-group">
                    <p class="formu-letra">Lotação</p>
                    <input class="form-control" type="text" name="lotacao" id="lotacao" />
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="ano-form" class="form-group">
                    <p class="formu-letra">Ano</p>
                     <input class="form-control" type="text" name="ano" id="ano" maxlength="4" />
                  </div>
                </div>
                <div class="col-md-6">
                <div id="cpf_ajudante-form" class="form-group">
                  <p class="formu-letra">CPF do Ajudante</p>
                  <select class="form-control" type="text" name="cpf_ajudante" id="cpf_ajudante">
                    <?php while ($ajudrow = @mysqli_fetch_array($ajudresult)){ ?>
                      <option value="<?php print $ajudrow['cpf'];?>"><?php print $ajudrow['cpf']." - ".$ajudrow['nome'];?></option>
                  <?php } ?>
                  </select>
                </div>
              </div> 
            </div>                
          
             <div class="row">
                <div class="col-md-12">
                  <button class="btn btn-success btn-right" id="veiculo-salvar" type="button">Salvar</button> 
                  <a href="visu_veiculo.php" class="btn btn-link  btn-right" type="button">Voltar</a>                  
                </div>
              </div>

              
            </div>         
          </div>
        </form>

<?php include './inc/footer.php'; ?>
<script src="js/veiculo.js"></script>
<?php } ?>