<?php include './inc/header.php'; ?>
<form id="rel_crianca" method="post" action="mostra_rel_crianca.php"> 
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu">Relatório de Crianças</p>
        
              <div class="row">
                <div class="col-md-12">
                  <p class="formu-letra">Filtrar por:</p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div style="padding: 20px;" class="btn-group" data-toggle="buttons">
                    <label class="btn btn-default">
                      <input checked type="radio" name="relatorio" value="R">Responsável<br>
                    </label>
                    <label class="btn btn-default">
                      <input class="input" type="radio" name="relatorio" value="E"> Escola<br>
                    </label>
                    <label class="btn btn-default">
                      <input class="input" type="radio" name="relatorio" value="P"> Período<br>
                    </label>
                    <label class="btn btn-default">
                      <input class="input" type="radio" name="relatorio" value="V"> Veículo<br>
                    </label>
                  </div>
                </div>
                <div class="col-md-6">
                  <p class="letra-fi">CPF do Responsável</p>
                  <input class="input-formu" id="text" type="text" name="valor" />
                  <select hidden class="input-formu" id="select" name="valor" >
                        <option value="" id="todos">Todos</option>
                        <option value="im" id="im">Ida-Manhã</option>
                        <option value="it" id="it">Ida-Tarde</option>
                        <option value="vm" id="vm">Volta-Manhã</option>
                        <option value="vt" id="vt">Volta-Tarde</option>
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
          if (this.value == 'R') {
              $(".letra-fi").html("CPF do Responsavel");
              $("#select").hide();
              $("#text").show();
          }
          if (this.value == 'E') {
              $(".letra-fi").html("Nome da Escola");
              $("#select").hide();
              $("#text").show();
          }
          if (this.value == 'P') {
              $(".letra-fi").html("Periodo");
              $("#select").show();
              $("#text").hide();
          }
          if (this.value == 'V') {
              $(".letra-fi").html("Veiculo");
              $("#select").hide();
              $("#text").show();
          }
      });
    });

  </script>