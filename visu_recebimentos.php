<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
    include './inc/header.php'; 
    include './inc/conexao.php';
    $sql = "select p.id,a.nome,c.mensalidade,COALESCE(p.data_realizada_pgto,p.data_prevista_pgto) as data_pagamento, p.status from contrato c
    inner join crianca a on c.id_crianca = a.id
    inner join pagamentos p on c.id = p.id_contrato";
    $result = $conexao->query($sql);

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
            <div class="row">
              <div class="col-lg-6">
                <h1 class="page-header">Listagem de Recebimentos</h1>
              </div> 
            </div>
            <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
                <div hidden id="alert"></div>
            </div>
              <table class="table table-responsive" style="background-color: #eff5f5">
                <thead>
                  <th>Criança</th>
                  <th>Mensalidade</th>
                  <th>Data de Vencimento</th>
                  <th>Status</th>
                  <th>Opções</th>
                </thead> 
                <tbody>
              <?php while ($row = @mysqli_fetch_array($result)){ ?>
              <tr>
              <form id="<?php print $row['id']?>" method="POST">
                  <input type="hidden" name="id" value ="<?php print $row['id'] ?>" />
                  <input type="hidden" name="acao" id="acao" value="SALVARDELETE"/>
                  <td><?php print $row["nome"];?></td>
                    <td><?php print $row["mensalidade"];?></td>
                    <td><?php print DbtoDt($row["data_pagamento"]);?></td>
                    <td>
                    <?php if ($row["status"] == "N") $class = "letra-fi-yellow";?>
                    <?php if ($row["status"] == "A") $class = "letra-fi-red";?>
                    <?php if ($row["status"] == "F") $class = "letra-fi-red";?>
                    <?php if ($row["status"] == "P") $class = "letra-fi-green";?>
                      <p class="<?php print $class;?>"><?php if ($row["status"] == "N") print "Em aberto"; if ($row["status"] == "A") print "Em atraso"; if ($row["status"] == "F") print "Falta Valor"; if ($row["status"] == "P") print "Pagamento recebido";?></p>
                    </td>
                    <td>
                      <?php if ($row["status"] != "P") { ?>
                          <a href="cad_recebimentos.php?id=<?php print $row["id"];?>"><button class="btn btn-sm btn-info fa fa-money" id="manu-recebimento" type="button"></button></a>
                        </td>
                      <?php } ?>
                  </form>
                  </tr>
                  <?php }?>
                </tbody>
              </table>
          

              
            </div>         
          </div>
        </form>

<?php include './inc/footer.php'; ?>

<script src="js/recebimentos.js"></script>

<?php }?>