<?php session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
    include './inc/header.php'; 
    include './inc/conexao.php';
    $sql = "select t.id as id_trecho,t.tipo as Tipo,c.nome as Crianca,c.id as id_crianca,o.nome as Condutor,v.placa as Veiculo,ct.id_contrato as Contrato from criancatrecho ct
    inner join crianca c on c.id = ct.id_crianca
    inner join condutor o on o.cpf = ct.cpf_condutor
    inner join veiculo v on v.placa = ct.placa_veiculo
    inner join trecho t on t.id = ct.id_trecho
    where ct.deletado ='N' ";
    
    $result = $conexao->query($sql);
?>

        <div class="row">
            <div class="row">
              <ol class="breadcrumb">
                <li><a href="index.php">
                  <em class="fa fa-home"></em>
                </a></li>
                <li class="active">Controle</li>
                <li class="active">Transporte</li>
              </ol>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <h1 class="page-header">Listagem de Transportes</h1>
              </div> 
              <div class="col-lg-6">  
                <a href="cad_trecho.php"><button class="btn btn-criar" id="novo-trecho">Novo Transporte</button></a>
              </div>
            </div>
            <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
                <div hidden id="alert"></div>
            </div>
              
              <div class="row">
                <div class="caixa-f">
                  <div class="col-md-3">
                    <p class="formu-letra">Nome da Criança</p>
                  </div>
                  <div class="col-md-3">
                    <p class="formu-letra">Veiculo</p>
                  </div>
                  <div class="col-md-2">
                    <p class="formu-letra">Contudor</p>
                  </div>
                  <div class="col-md-2">
                    <p class="formu-letra">Tipo</p>
                  </div>
                  <div class="col-md-2">
                    <p class="formu-letra">Opções</p>
                  </div>
                </div>
              </div>
              <div id="resultado" class="row">
                <?php while ($row = @mysqli_fetch_array($result)){ ?>
                <form id="<?php print $row['id_trecho']?>" method="POST">
                  <input type="hidden" name="id_trecho" value ="<?php print $row['id_trecho'] ?>" />
                  <input type="hidden" name="crianca" value ="<?php print $row['id_crianca'] ?>" />
                  <input type="hidden" name="acao" id="acao" value="SALVARDELETE"/>
                  <div class="caixa-fl">
                    <div class="col-md-3">
                      <p class="letra-fi "><?php print $row["Crianca"];?></p>
                    </div>
                    <div class="col-md-3">
                      <p class="letra-fi "><?php print $row["Veiculo"];?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi "><?php print $row["Condutor"];?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi "><?php if($row["Tipo"]=='im') print "Ida-Manhã"; if($row["Tipo"]=='vm') print "Volta-Manhã"; if($row["Tipo"]=='it') print "Ida-Tarde"; if($row["Tipo"]=='vt') print "Volta-Tarde"; ?>
                      </p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi">
                        <?php if (!$row["Contrato"]) { ?>
                            <a href="alt_trecho.php?id_trecho=<?php print $row["id_trecho"];?>&id_crianca=<?php print $row["id_crianca"];?>"><button class="btn btn-sm btn-info fa fa-pencil" id="manu-trecho" type="button"></button></a>
                            <button class="btn btn-sm btn-danger fa fa-trash dele-trecho" id="<?php print $row['id_trecho'].'-dele'; ?>" type="button"></button>
                        <?php } ?>
                        <a href="deta_trecho.php?id_trecho=<?php print $row["id_trecho"];?>&id_crianca=<?php print $row["id_crianca"];?>"><button class="btn btn-sm btn-warning fa fa-plus" id="deta-trecho" type="button"></button></a>
                      </p>
                    </div>
                  </div>
                  </form>
                  <?php }?>
                </div>
          

              
            </div>         
          </div>
<?php include './inc/footer.php'; ?>
<script src="js/trecho.js"></script>
<?php }?>