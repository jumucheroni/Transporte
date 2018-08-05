<?php 

include './inc/header.php';
include './inc/conexao.php'; 

?>

<form id="recibo" method="post" action="mostra_recibo.php"> 
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu">Recibos</p>
        
              <div class="row">
               <div class="col-md-4">
                  <p class="letra-fi">CPF do Responsável</p>
                  <input class="input-formu" type="text" name="cpf_responsavel" />
                </div>
                    <div class="col-md-4">
                  <p class="letra-fi">Nome da Criança</p>
                  <input class="input-formu" type="text" name="nome" />
                </div>
                <div class="col-md-4">
                  <p class="letra-fi">Mês</p>
                  <input class="input-formu" type="text" name="mes" />
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