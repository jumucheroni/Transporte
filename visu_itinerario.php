<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
    include './inc/header.php'; 
    include './inc/conexao.php';
    $sql = "select distinct e.id as id_escola,e.nome as escola from escola e
    inner join crianca c on c.id_escola = e.id
    inner join criancatrecho ct on ct.id_crianca = c.id
    inner join condutor o on o.cpf = ct.cpf_condutor
    inner join veiculo v on v.placa = ct.placa_veiculo
    inner join trecho t on t.id = ct.id_trecho
    where ct.deletado ='N'";
    $result = $conexao->query($sql);
?>
            <div class="row">
              <ol class="breadcrumb">
                <li><a href="index.php">
                  <em class="fa fa-home"></em>
                </a></li>
                <li class="active">Itinerário</li>
              </ol>
            </div>
        <form id="itinerario" method="post" action="mapa.php"> 
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <h1 class="page-header">Itinerário otimizado</h1>
        
              <div class="row">
                <div class="col-md-12">
                  <p class="formu-letra">Otimizar por:</p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div style="padding: 20px;" class="btn-group" data-toggle="buttons">
                    <label class="btn btn-default">
                      <input checked type="radio" name="relatorio" value="T">Todos<br>
                    </label>
                    <label class="btn btn-default">
                      <input class="input" type="radio" name="relatorio" value="E"> Escola<br>
                    </label>
                  </div>
                </div> 
                <div hidden id="escolas" class="col-md-6">
                  <p class="letra-fi">Escola</p>
                  <select class="input-formu" id="select" name="valor" >
                    <?php while ($row = @mysqli_fetch_array($result)){ ?>
                      <option value="<?php print $row['id_escola'];?>" id="<?php print $row['id_escola'];?>" ><?php print $row["escola"];?></option>
                    <?php } ?>
                  </select>
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
        <!-- selecionar o periodo -->

<?php include './inc/footer.php'; ?>

<script type="text/javascript">
    $(document).ready(function(){
      $('input[type=radio][name=relatorio]').change(function() {
          if (this.value == 'T') {
              $("#escolas").hide();
          }
          if (this.value == 'E') {
              $("#escolas").show();
          }
      });
    });

  </script>

  <?php } ?>