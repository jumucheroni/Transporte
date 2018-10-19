<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
    include './inc/header.php'; 
    include './inc/conexao.php';
    $sql = "select c.nome,v.placa,cv.* from condutorveiculo cv
            inner join condutor c on c.cpf = cv.cpf_condutor
            inner join veiculo v on v.placa = cv.placa_veiculo
            where cv.deletado = 'N' ";
    $result = $conexao->query($sql);
?>
          
        <div class="row">
            <div class="row">
              <ol class="breadcrumb">
                <li><a href="index.php">
                  <em class="fa fa-home"></em>
                </a></li>
                <li class="active">Controle</li>
                <li class="active">Condução</li>
              </ol>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <h1 class="page-header">Listagem de Condução</h1>
              </div> 
              <div class="col-lg-6">  
                <a href="cad_condveic.php"><button class="btn btn-criar" id="novo-ajudante">Nova Condução</button></a>
              </div>
            </div>
            <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
                <div hidden id="alert"></div>
            </div>
              
              <div class="row">
                <div class="caixa-f">
                <div class="col-md-5">
                  <p class="formu-letra">Condutor</p>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">Veiculo</p>
                </div>
                <div class="col-md-2">
                  <p class="formu-letra">Periodo</p>
                </div>
                <div class="col-md-2">
                  <p class="formu-letra">Opções</p>
                </div>
              </div>
              </div>
              <div id="resultado" class="row">
                <?php while ($row = @mysqli_fetch_array($result)){ ?>
                <form id="<?php print $row["cpf_condutor"].'-'.$row["placa_veiculo"].'-'.$row["periodo"]?>" method="POST">
                    <input type="hidden" name="veiculo" value ="<?php print $row['placa_veiculo'] ?>" />
                    <input type="hidden" name="condutor" value ="<?php print $row['cpf_condutor'] ?>" />
                    <input type="hidden" name="periodo" value ="<?php print $row['periodo'] ?>" />
                    <input type="hidden" name="acao" id="acao" value="SALVARDELETE"/>
                  <div class="caixa-fl">
                    <div class="col-md-5">
                      <p class="letra-fi "><?php print $row["nome"];?></p>
                    </div>
                    <div class="col-md-3">
                      <p class="letra-fi "><?php print $row["placa"];?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi "><?php if($row["periodo"]=='im') print "Ida-Manhã"; if($row["periodo"]=='vm') print "Volta-Manhã"; if($row["periodo"]=='it') print "Ida-Tarde"; if($row["periodo"]=='vt') print "Volta-Tarde"; ?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi">
                        <a href="alt_condveic.php?id=<?php print $row["cpf_condutor"].'-'.$row["placa_veiculo"].'-'.$row["periodo"];?>"><button class="btn btn-sm btn-info fa fa-pencil" id="manu-condveic" type="button" ></button></a>
                        <button class="btn btn-sm btn-danger fa fa-trash dele-condveic" id="<?php print $row["cpf_condutor"].'-'.$row["placa_veiculo"].'-'.$row["periodo"].'-dele'; ?>" type="button"></button>
                        <a href="deta_condveic.php?id=<?php print $row["cpf_condutor"].'-'.$row["placa_veiculo"].'-'.$row["periodo"];?>"><button class="btn btn-sm btn-warning fa fa-plus" id="deta-condveic" type="button"></button></a>
                      </p>
                    </div>
                  </div>
                </form>
                <?php }?>
                </div>
          

              
            </div>         
          </div>

<?php include './inc/footer.php'; ?>
<script src="js/condveic.js"></script>
<?php }?>