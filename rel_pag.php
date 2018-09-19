<?php include './inc/header.php'; ?>
   <form id="rel_crianca" method="post" action="mostra_rel_pag.php"> 
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu">Relatório de Pagamentos</p>
        
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
                  <select hidden class="input-formu" id="select" name="valor" >
                      <option value="" >Todos</option>
                      <option value="N">Em aberto</option>
                      <option value="A">Em atraso</option>
                      <option value="F">Falta valor</option>
                      <option value="P">Pago</option>
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
          if (this.value == 'V') {
              $(".letra-fi").html("Data");
              $("#select").hide();
              $("#text").show();
              $("#text").addClass("dtrel");
              $(".dtrel").mask("99/99/9999");
          }
          if (this.value == 'S') {
              $(".letra-fi").html("Status");
              $("#select").show();
              $("#text").hide();
              $(".dtrel").unmask();
              $("#text").removeClass("dtrel");
          }
          if (this.value == 'C') {
              $(".letra-fi").html("Criança");
              $("#select").hide();
              $("#text").show();
              $(".dtrel").unmask();
              $("#text").removeClass("dtrel");
          }
      });
    });

  </script>