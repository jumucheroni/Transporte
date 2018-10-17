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
              
              <div class="row">
                <div class="caixa-f">
                <div class="col-md-2">
                  <p class="formu-letra">Criança</p>
                </div>
                <div class="col-md-2">
                  <p class="formu-letra">Mensalidade</p>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">Data de Vencimento</p>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">Status</p>
                </div>
                <div class="col-md-2">
                  <p class="formu-letra">Opções</p>
                </div>
              </div>
              </div>
              <div id="resultado" class="row">
              <?php while ($row = @mysqli_fetch_array($result)){ ?>
                  <div class="caixa-fl">
                    <div class="col-md-2">
                      <p class="letra-fi "><?php print $row["nome"];?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi "><?php print $row["mensalidade"];?></p>
                    </div>
                    <div class="col-md-3">
                      <p class="letra-fi "><?php print DbtoDt($row["data_pagamento"]);?></p>
                    </div>
                    <div class="col-md-3">
                      <p class="letra-fi "><?php if ($row["status"] == "N") print "Em aberto"; if ($row["status"] == "A") print "Em atraso"; if ($row["status"] == "F") print "Falta Valor"; if ($row["status"] == "P") print "Pagamento recebido";?></p>
                    </div>
                    <div class="col-md-2">
                      <?php if ($row["status"] != "P") { ?>
                        <p class="letra-fi">
                          <a href="cad_recebimentos.php?id=<?php print $row["id"];?>"><button class="btn btn-sm btn-info fa fa-money" id="manu-recebimento" type="button"></button></a>
                        </p>
                      <?php } ?>
                    </div>
                  </div>
                  <?php }?>
                </div>
          

              
            </div>         
          </div>
        </form>

<?php include './inc/footer.php'; ?>

<script src="js/recebimentos.js"></script>

<?php }?>