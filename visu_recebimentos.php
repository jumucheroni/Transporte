<?php include './inc/header.php'; 
include './inc/conexao.php';
    $sql = "select p.id,a.nome,c.mensalidade,COALESCE(p.data_realizada_pgto,p.data_prevista_pgto) as data_pagamento, p.status from contrato c
    inner join crianca a on c.id_crianca = a.id
    inner join pagamentos p on c.id = p.id_contrato";
    $result = $conexao->query($sql);

?>

         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu">
                  Listagem de Contrato
              </p>
              
              <div class="row">
                <div class="caixa-f">
                <div class="col-md-4">
                  <p class="formu-letra">Criança</p>
                </div>
                <div class="col-md-2">
                  <p class="formu-letra">Mensalidade</p>
                </div>
                <div class="col-md-2">
                  <p class="formu-letra">Data de Vencimento</p>
                </div>
                <div class="col-md-2">
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
                    <div class="col-md-4">
                      <p class="letra-fi "><?php print $row["nome"];?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi "><?php print $row["mensalidade"];?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi "><?php print DbtoDt($row["data_pagamento"]);?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi "><?php $row["status"] == "N" ? print "Em aberto" : print "Pagamento recebido";?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi">
                        <a href="cad_recebimentos.php?acao=PAGAR&id=<?php print $row["id"];?>"><button class="btn-pagar glyphicon glyphicon-pencil" id="manu-contrato"></button></a>
                      </p>
                    </div>
                  </div>
                  <?php }?>
                </div>
          

              
            </div>         
          </div>
        </form>

<?php include './inc/footer.php'; ?>