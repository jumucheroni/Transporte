<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
    include './inc/header.php'; 
    include './inc/conexao.php';
    $sql = "select g.id,g.data_gasto,g.valor_gasto,v.placa from gastos g, veiculo v where v.placa = g.placa_veiculo and g.deletado = 'N' ";
    $result = $conexao->query($sql);

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
            <div class="row">
              <div class="col-lg-6">
                <h1 class="page-header">Listagem de Despesas</h1>
              </div> 
              <div class="col-lg-6">  
                <a href="cad_despesas.php"><button class="btn btn-criar" id="novo-ajudante">Nova Despesa</button></a>
              </div>
            </div>
            <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
                <div hidden id="alert"></div>
            </div>
              <div class="row">
                <div class="caixa-f">
                <div class="col-md-4">
                  <p class="formu-letra">Data</p>
                </div>
                <div class="col-md-4">
                  <p class="formu-letra">Valor</p>
                </div>
                <div class="col-md-2">
                  <p class="formu-letra">Veiculo</p>
                </div>
                <div class="col-md-2">
                  <p class="formu-letra">Opções</p>
                </div>
              </div>
              </div>
              <div id="resultado" class="row">
              <?php while ($row = @mysqli_fetch_array($result)){ ?>
                  <div class="caixa-fl">
                    <div class="col-md-4">
                      <p class="letra-fi "><?php print DbtoDt($row["data_gasto"]);?></p>
                    </div>
                    <div class="col-md-4">
                      <p class="letra-fi "><?php print $row["valor_gasto"];?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi "><?php print $row["placa"];?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi">
                        <a href="alt_despesas.php?id=<?php print $row["id"];?>"><button class="btn btn-sm btn-info fa fa-pencil" id="manu-despesas" type="button"></button></a>
                        <button class="btn btn-sm btn-danger fa fa-trash dele-despesas" id="<?php print $row['id'].'-dele'; ?>" type="button"></button>
                        <a href="deta_despesas.php?id=<?php print $row["id"];?>"><button class="btn btn-sm btn-warning fa fa-plus" id="deta-despesas" type="button"></button></a>
                      </p>
                    </div>
                  </div>
                  <?php }?>
                </div>
          

              
            </div>         
          </div>
        </form>

<?php include './inc/footer.php'; ?>

<script src="js/despesas.js"></script>

<?php } ?>