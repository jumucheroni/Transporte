<?php session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {

  include './inc/conexao.php';
  include './inc/header.php'; 

  $criancasql = "select id,nome from crianca where deletado = 'N' ";
  $criancaresult = $conexao->query($criancasql);

  ?>
  <div class="row">
      <div class="row">
        <ol class="breadcrumb">
          <li><a href="index.php">
            <em class="fa fa-home"></em>
          </a></li>
          <li class="active">Relatorio</li>
          <li class="active">Pagamentos</li>
        </ol>
      </div>
   <form id="rel_crianca" method="post" action="mostra_rel_pag.php"> 
         <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
              <div class="col-xs-12 col-sm-8 col-md-10 ">
                <h1 class="page-header">Relatório de Pagamentos</h1>
              </div>
        
              <div class="row">
                <div class="col-md-12">
                  <p class="formu-letra">Filtrar por:</p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-7">
                  <div style="padding: 20px;" class="btn-group" data-toggle="buttons">
                    <label class="btn btn-default">
                      <input checked="checked" type="radio" name="relatorio" value="D">Data de pagamento<br>
                    </label>
                    <label class="btn btn-default">
                      <input type="radio" name="relatorio" value="V">Data de vencimento<br>
                    </label>
                    <label class="btn btn-default">
                      <input class="input" type="radio" name="relatorio" value="S"> Status<br>
                    </label>
                    <label class="btn btn-default">
                      <input class="input" type="radio" name="relatorio" value="C"> Criança<br>
                    </label>
                  </div>
                </div> 
                <div class="col-md-5">
                  <p class="letra-fi">Data</p>
                  <input class="input-formu" id="text" type="text" name="valor" />
                  <select hidden multiple class="input-formu" id="select" name="val[]" >
                      <option value="N">Em aberto</option>
                      <option value="A">Em atraso</option>
                      <option value="F">Incompleto</option>
                      <option value="P">Pago</option>
                  </select>
                  <select hidden multiple class="input-formu" id="cri" name="cri[]" >
                     <?php while ($criancarow = @mysqli_fetch_array($criancaresult)){ ?>
                        <option  value="<?php print $criancarow['id'];?>"><?php print $criancarow['nome'];?></option>
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

<?php include './inc/footer.php'; ?>

<script type="text/javascript">
    $(document).ready(function(){
      $('input[type=radio][name=relatorio]').change(function() {
          if (this.value == 'D') {
              $(".letra-fi").html("Data");
              $("#cri").hide();
              $("#select").hide();
              $("#text").show();
              $("#text").addClass("dtrel");
              $(".dtrel").mask("99/99/9999");
          }
          if (this.value == 'V') {
              $(".letra-fi").html("Data");
              $("#cri").hide();
              $("#select").hide();
              $("#text").show();
              $("#text").addClass("dtrel");
              $(".dtrel").mask("99/99/9999");
          }
          if (this.value == 'S') {
              $(".letra-fi").html("Status");
              $("#cri").hide();
              $("#select").show();
              $("#text").hide();
              $(".dtrel").unmask();
              $("#text").removeClass("dtrel");
          }
          if (this.value == 'C') {
              $(".letra-fi").html("Criança");
              $("#cri").show();
              $("#select").hide();
              $("#text").hide();
              $(".dtrel").unmask();
              $("#text").removeClass("dtrel");
          }
      });
    });

  </script>

<?php } ?>