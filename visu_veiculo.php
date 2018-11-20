<?php session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
    include './inc/header.php'; 
    include './inc/conexao.php';
    $sql = "select placa,lotacao,ano from veiculo where deletado = 'N' ";
    $result = $conexao->query($sql);
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

         <div class="row">
              <div class="col-lg-6">
                <h1 class="page-header">Listagem de Veículo</h1>
              </div> 
              <div class="col-lg-6">  
                <a href="cad_veiculo.php"><button class="btn btn-criar" id="novo-veiculo">Novo Veículo</button></a>
              </div>
            </div>
            <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
                <div hidden id="alert"></div>
            </div>
              <table class="table table-responsive" style="background-color: #eff5f5">
                <thead>
                  <th>Placa</th>
                  <th>Lotação</th>
                  <th>Ano</th>
                  <th>Opções</th>
                </thead> 
                <tbody>
                <?php while ($row = @mysqli_fetch_array($result)){ ?>
                <tr>
                <form id="<?php print $row['placa']?>" method="POST">
                  <input type="hidden" name="placa" value ="<?php print $row['placa'] ?>" />
                  <input type="hidden" name="acao" id="acao" value="SALVARDELETE"/>
                  <td><?php print $row["placa"];?></td>
                    <td><?php print $row["lotacao"];?></td>
                    <td><?php print $row["ano"];?></td>
                    <td>
                        <a href="alt_veiculo.php?id=<?php print $row["placa"];?>"><button class="btn btn-sm btn-info fa fa-pencil" id="manu-veiculo" type="button"></button></a>
                        <button class="btn btn-sm btn-danger fa fa-trash dele-veiculo" id="<?php print $row['placa'].'-dele'; ?>" type="button"></button>
                        <a href="deta_veiculo.php?id=<?php print $row["placa"];?>"><button class="btn btn-sm btn-warning fa fa-plus" id="deta-veiculo" type="button"></button></a>
                      </td>
                </form>
                </tr>
                <?php }?>
                </tbody>
          </table>

              
            </div>         
          </div>

<?php include './inc/footer.php'; ?>
<script src="js/veiculo.js"></script>
<?php }?>