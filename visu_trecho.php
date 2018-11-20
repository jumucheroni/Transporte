<?php session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
    include './inc/header.php'; 
    include './inc/conexao.php';
    $sql = "select t.id as id_trecho,t.tipo as Tipo,c.nome as Crianca,c.id as id_crianca,o.nome as Condutor,v.placa as Veiculo,ct.id_contrato as Contrato,ct.deletado from criancatrecho ct
    inner join crianca c on c.id = ct.id_crianca
    inner join condutor o on o.cpf = ct.cpf_condutor
    inner join veiculo v on v.placa = ct.placa_veiculo
    inner join trecho t on t.id = ct.id_trecho ";
    
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
              
              <table class="table table-responsive" style="background-color: #eff5f5">
                <thead>
                  <th>Nome da Criança</th>
                  <th>Veiculo</th>
                  <th>Contudor</th>
                  <th>Tipo</th>
                  <th>Opções</th>
                </thead> 
                <tbody>
                  <?php while ($row = @mysqli_fetch_array($result)){ ?>
                  <tr>
                    <form id="<?php print $row['id_trecho']?>" method="POST">
                      <input type="hidden" name="id_trecho" value ="<?php print $row['id_trecho'] ?>" />
                      <input type="hidden" name="crianca" value ="<?php print $row['id_crianca'] ?>" />
                      <input type="hidden" name="acao" id="acao" value="SALVARDELETE"/>
                      <input type="hidden" name="inativo" id="inativo" value="<?php print $row['deletado']; ?>" />
                      <td><?php print $row["Crianca"];?></td>
                      <td><?php print $row["Veiculo"];?></td>
                      <td><?php print $row["Condutor"];?></td>
                      <td><?php if($row["Tipo"]=='im') print "Ida-Manhã"; if($row["Tipo"]=='vm') print "Volta-Manhã"; if($row["Tipo"]=='it') print "Ida-Tarde"; if($row["Tipo"]=='vt') print "Volta-Tarde"; ?>
                          </td>
                      <td>    <?php if (!$row["Contrato"]) { ?>
                                <a href="alt_trecho.php?id_trecho=<?php print $row["id_trecho"];?>&id_crianca=<?php print $row["id_crianca"];?>"><button class="btn btn-sm btn-info fa fa-pencil" id="manu-trecho" type="button"></button></a>
                                <?php if ($row["deletado"] == "N"){ $class="remove";$color="danger";} else { $class="check";$color="success"; } ?>
                                  <button class="btn btn-sm btn-<?php print $color; ?> fa fa-<?php print $class; ?> dele-trecho" id="<?php print $row['id_trecho'].'-dele'; ?>" type="button"></button>
                            <?php } ?>
                            <a href="deta_trecho.php?id_trecho=<?php print $row["id_trecho"];?>&id_crianca=<?php print $row["id_crianca"];?>"><button class="btn btn-sm btn-warning fa fa-plus" id="deta-trecho" type="button"></button></a>
                          </td>
                      </form>
                      </tr>
                    <?php }?>
                    </tbody>
              </table>              
            </div>         
          </div>
<?php include './inc/footer.php'; ?>
<script src="js/trecho.js"></script>
<?php }?>