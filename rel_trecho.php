<?php include './inc/header.php'; ?>
   <form id="rel_crianca" method="post" action="mostra_rel_trecho.php"> 
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu">Relatório de Transportes</p>
        
              <div class="row">
                <div class="col-md-12">
                  <p class="formu-letra">Filtrar por veiculo:</p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <p class="letra-fi">Placa do veículo</p>
                  <input class="input-formu" type="text" name="valor" />
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