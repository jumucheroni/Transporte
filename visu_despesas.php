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
              <table class="table table-responsive" style="background-color: #eff5f5">
                <thead>
                  <th>Data</th>
                  <th>Valor</th>
                  <th>Vaículo</th>
                  <th>Opções</th>
                </thead> 
                <tbody>
              <?php while ($row = @mysqli_fetch_array($result)){ ?>
              <tr>
              <form id="<?php print $row['id']?>" method="POST">
                  <input type="hidden" name="id" value ="<?php print $row['id'] ?>" />
                  <input type="hidden" name="acao" id="acao" value="SALVARDELETE"/>
                  <td><?php print DbtoDt($row["data_gasto"]);?></td>
                    <td><?php print $row["valor_gasto"];?></td>
                    <td><?php print $row["placa"];?></td>
                    <td>
                        <a href="alt_despesas.php?id=<?php print $row["id"];?>"><button class="btn btn-sm btn-info fa fa-pencil" id="manu-despesas" type="button"></button></a>
                        <button class="btn btn-sm btn-danger fa fa-trash dele-despesas" id="<?php print $row['id'].'-dele'; ?>" type="button"></button>
                        <a href="deta_despesas.php?id=<?php print $row["id"];?>"><button class="btn btn-sm btn-warning fa fa-plus" id="deta-despesas" type="button"></button></a>
                      </td>
                </form>
              </tr>
                  <?php }?>
                </tbody>
              </table>
          

              
            </div>         
          </div>
        </form>

<?php include './inc/footer.php'; ?>

<script src="js/despesas.js"></script>

<?php } ?>