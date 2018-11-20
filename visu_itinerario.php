<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
    include './inc/header.php'; 
    include './inc/conexao.php';
    $sql = "select distinct e.id as id_escola,e.nome as escola from escola e
    inner join crianca c 
    inner join criancatrecho ct on ct.id_crianca = c.id
    inner join condutor o on o.cpf = ct.cpf_condutor
    inner join veiculo v on v.placa = ct.placa_veiculo
    inner join trecho t on t.id = ct.id_trecho and e.id = t.id_escola
    where ct.deletado ='N'";
    $result = $conexao->query($sql);

    $sqlveiculo = "select distinct v.placa as placa_veiculo from escola e
    inner join crianca c on c.id_escola = e.id
    inner join criancatrecho ct on ct.id_crianca = c.id
    inner join condutor o on o.cpf = ct.cpf_condutor
    inner join veiculo v on v.placa = ct.placa_veiculo
    inner join trecho t on t.id = ct.id_trecho
    where ct.deletado ='N'";
    $resultveiculo = $conexao->query($sqlveiculo);

    $sqlescola = "select t.id_escola from trecho t where t.deletado = 'N' group by id_escola";
    $resultescola = $conexao->query($sqlescola);
    while ($rowescola = @mysqli_fetch_array($resultescola)) {
      $escolas[$rowescola['id_escola']] = $rowescola['id_escola'];
    }

    $escolas = json_encode($escolas);

    $action = "index.php";
    $tipo = @$_GET['id'];
    if ($tipo == 'pontos') {
      $action = "mapapontos.php";
    } 
    if ($tipo == 'roteiro') {
      $action ="mapa.php";
    }
?>
            <div class="row">
              <ol class="breadcrumb">
                <li><a href="index.php">
                  <em class="fa fa-home"></em>
                </a></li>
                <li class="active">Itinerário</li>
              </ol>
            </div>
        <form id="itinerario" method="post" action="<?php print $action; ?>"> 
         <input type="hidden" name="escola" id="escola" value='<?php print $escolas; ?>' />
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <?php if ($tipo != "roteiro") { ?>
                <h1 class="page-header">Mapa de pontos</h1>
              <?php } else { ?>
                <h1 class="page-header">Itinerário otimizado</h1>
              <?php } ?>
        
              <div class="row">
                <div class="col-md-12">
                  <p class="formu-letra">Otimizar por:</p>
                </div>
              </div>
              <div class="row">
                <div id="opcoes" class="col-md-6">
                  <div style="padding: 20px;" class="btn-group" data-toggle="buttons">
                    <?php if ($tipo != "roteiro") { ?>
                      <label class="btn btn-default">
                        <input checked type="radio" name="relatorio" value="T">Todos<br>
                      </label>
                    <?php } ?>
                    <label class="btn btn-default">
                      <input class="input" type="radio" name="relatorio" value="E"> Escola<br>
                    </label>
                  </div>
                </div> 
                <div class="col-md-6">
                  <p class="letra-fi">Veículo</p>
                  <select class="input-formu" id="select" name="veiculo" >
                    <?php while ($rowveiculo = @mysqli_fetch_array($resultveiculo)){ ?>
                      <option value="<?php print $rowveiculo['placa_veiculo'];?>" id="<?php print $rowveiculo['placa_veiculo'];?>" ><?php print $rowveiculo["placa_veiculo"];?></option>
                    <?php } ?>
                  </select>
                  <p class="letra-fi">Periodo</p>
                  <select class="input-formu" id="select" name="periodo" >
                        <option value="m" id="m">Manhã</option>
                        <option value="a" id="a">Almoço</option>
                        <option value="t" id="t">Tarde</option>
                  </select>
                  <div hidden id="escolas" >
                    <p class="letra-fi">Escola</p>
                    <?php if ($tipo != "roteiro") { ?>
                      <select multiple class="input-formu" id="select" name="valor[]" >
                        <?php while ($row = @mysqli_fetch_array($result)){ ?>
                          <option value="<?php print $row['id_escola'];?>" id="<?php print $row['id_escola'];?>" ><?php print $row["escola"];?></option>
                        <?php } ?>
                      </select>
                    <?php } else {?>
                      <select class="input-formu" id="select" name="valor" >
                        <?php while ($row = @mysqli_fetch_array($result)){ ?>
                          <option value="<?php print $row['id_escola'];?>" id="<?php print $row['id_escola'];?>" ><?php print $row["escola"];?></option>
                        <?php } ?>
                      </select>
                    <?php } ?>
                  </div>
                </div>  

              </div>   
              <div class="row">
                <div class="col-md-12">
                    <button class="btn-salvar" id="gerar" type="Submit">Gerar</button>               
                </div>
              </div>             
            </div>         
          </div>
        </form>

<?php include './inc/footer.php'; ?>
<script src="js/itinerario.js"></script>

  <?php } ?>