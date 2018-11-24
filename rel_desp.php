<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
  include './inc/header.php'; ?>
  <div class="row">
      <div class="row">
        <ol class="breadcrumb">
          <li><a href="index.php">
            <em class="fa fa-home"></em>
          </a></li>
          <li class="active">Relatorio</li>
          <li class="active">Despesas</li>
        </ol>
      </div>
   <form id="rel_desp" method="post" action="mostra_rel_desp.php"> 
          <div class="col-xs-12 col-md-10 col-md-offset-1">
              <div class="col-xs-12 col-sm-8 col-md-10 ">
                <h1 class="page-header">Relatório de Despesas</h1>
              </div>
        
              <div class="row">
                <div class="col-md-12">
                  <p class="formu-letra">Filtrar por:</p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div style="padding: 20px;" class="btn-group" data-toggle="buttons">
                    <label class="btn btn-default">
                      <input checked type="radio" name="relatorio" value="D">Data<br>
                    </label>
                    <label class="btn btn-default">
                      <input class="input" type="radio" name="relatorio" value="T"> Tipo<br>
                    </label>
                    <label class="btn btn-default">
                      <input class="input" type="radio" name="relatorio" value="V"> Veículo<br>
                    </label>
                  </div>
                </div> 
                <div class="col-md-6">
                  <p class="letra-fi">Data</p>
                  <input class="input-formu" id="text" type="text" name="valor" />
                  <select hidden multiple class="input-formu" id="select" name="val[]" >
                      <option value="c" id="c">Combustível</option>
                      <option value="i" id="i">IPVA</option>
                      <option value="o" id="o">Oficina</option>
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
              $("#select").hide();
              $("#text").show();
              $("#text").addClass("dtrel");
              $(".dtrel").mask("99/99/9999");
          }
          if (this.value == 'T') {
              $(".letra-fi").html("Tipo");
              $("#select").show();
              $("#text").hide();
              $(".dtrel").unmask();
              $("#text").removeClass("dtrel");
          }
          if (this.value == 'V') {
              $(".letra-fi").html("Veículo");
              $("#select").hide();
              $("#text").show();
              $(".dtrel").unmask();
              $("#text").removeClass("dtrel");
          }
      });
    });

  </script>

  <?php } ?>