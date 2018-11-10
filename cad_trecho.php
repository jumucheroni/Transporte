<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {

    include './inc/header.php'; 
    include './inc/conexao.php';

      $acao = 'CADASTRAR';

      $criancasql = "select id,nome from crianca where deletado = 'N' ";
      $criancaresult = $conexao->query($criancasql);

      $conducaosql = "select * from condutorveiculo where deletado = 'N' ";
      $conducaoresult = $conexao->query($conducaosql);

      $escolasql = "select id,nome from escola where deletado = 'N'";
      $escolaresult = $conexao->query($escolasql);

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
       <form id="trecho" method="post" role="form"> 
        <input type="hidden" name="acao" id="acao" value="<?php print $acao; ?>" />
        <input type="hidden" name="id_trecho" id="id_trecho" value="<?php print $id_trecho; ?>" />
          <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
              <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
                <div hidden id="alert"></div>
              </div>
              <div class="col-xs-12 col-sm-8 col-md-10 ">
                <h1 class="page-header">Cadastrar Transporte</h1>
              </div>

              <div class="row">
                <div class="col-md-4">
                  <div id="tipo-form" class="form-group">
                    <p class="formu-letra">Tipo</p>
                      <select disabled="true" class="form-control" type="text" name="tipo" id="tipo" >
                          <option></option>
                          <option value="im" id="im">Ida-Manhã</option>
                          <option value="it" id="it">Ida-Tarde</option>
                          <option value="vm" id="vm">Volta-Manhã</option>
                          <option value="vt" id="vt">Volta-Tarde</option>
                      </select>
                    </div> 
                  </div>
                <div class="col-md-8">
                  <div id="crianca-form" class="form-group">
                    <p class="formu-letra">Criança</p>
                     <select class="form-control" type="text" name="crianca" id="crianca" >
                      <?php while ($criancarow = @mysqli_fetch_array($criancaresult)){ ?>
                        <option  value="<?php print $criancarow['id'];?>"><?php print $criancarow['nome'];?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                
                <div class="col-md-6">
                  <div id="conducao-form" class="form-group">
                    <p class="formu-letra">Condução</p>
                     <select class="form-control" type="text" name="conducao" id="conducao" >
                     <option></option>
                      <?php while ($conducaorow = @mysqli_fetch_array($conducaoresult)){ ?>
                        <option value="<?php print $conducaorow['cpf_condutor'].';'.$conducaorow['placa_veiculo'].';'.$conducaorow['periodo'];?>"><?php print $conducaorow['cpf_condutor']."-".$conducaorow['placa_veiculo']."-".$conducaorow['periodo'];?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div id="escola-form" class="form-group">
                    <p class="formu-letra">Escola</p>
                     <select class="form-control" type="text" name="escola" id="escola" >
                     <option></option>
                      <?php while ($escolarow = @mysqli_fetch_array($escolaresult)){ ?>
                        <option value="<?php print $escolarow['id'];?>"><?php print $escolarow['nome'];?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div id="cep_origem-form" class="form-group">
                    <p class="formu-letra">Cep - Origem</p>
                    <input class="form-control cep" type="text" name="cep_origem" id="cep_origem" maxlength="9" />
                  </div>
                </div>
                <div class="col-md-7">
                  <div id="logradouro_origem-form" class="form-group">
                    <p class="formu-letra">Logradouro - Origem</p>
                    <input class="form-control" type="text" name="logradouro_origem" id="logradouro_origem" maxlength="100" />
                  </div>
                </div>
                <div class="col-md-2">
                  <div id="numero_origem-form" class="form-group">
                    <p class="formu-letra">Nº - Origem</p>
                    <input class="form-control" type="text" name="numero_origem" id="numero_origem" maxlength="8" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div id="bairro_origem-form" class="form-group">
                    <p class="formu-letra">Bairro - Origem</p>
                    <input class="form-control" type="text" name="bairro_origem" id="bairro_origem" maxlength="30" />
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="complemento_origem-form" class="form-group">
                    <p class="formu-letra">Complemento - Origem</p>
                    <input class="form-control" type="text" name="complemento_origem" id="complemento_origem" maxlength="60" />
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="estado_origem-form" class="form-group">
                    <p class="formu-letra">Estado - Origem</p>
                    <input type="hidden" name="uf_origem" id="uf_origem" /> 
                    <select class="form-control" type="text" name="estado_origem" id="estado_origem">
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="cidade_origem-form" class="form-group">
                    <p class="formu-letra">Cidade - Origem</p>
                    <input type="hidden" name="cid_origem" id="cid_origem" /> 
                     <select class="form-control" type="text" name="cidade_origem" id="cidade_origem">
                     </select>
                  </div>
                </div>
              </div>  

              <div class="row">
                <div class="col-md-3">
                  <div id="cep_destino-form" class="form-group">
                    <p class="formu-letra">Cep - Destino</p>
                    <input class="form-control cep" type="text" name="cep_destino" id="cep_destino" maxlength="9" />
                  </div>
                </div>
                <div class="col-md-7">
                  <div id="logradouro_destino-form" class="form-group">
                    <p class="formu-letra">Logradouro - Destino</p>
                    <input class="form-control" type="text" name="logradouro_destino" id="logradouro_destino" maxlength="100" />
                  </div>
                </div>
                <div class="col-md-2">
                  <div id="numero_destino-form" class="form-group">
                    <p class="formu-letra">Nº - Destino</p>
                    <input class="form-control" type="text" name="numero_destino" id="numero_destino" maxlength="8" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div id="bairro_destino-form" class="form-group">
                    <p class="formu-letra">Bairro - Destino</p>
                    <input class="form-control" type="text" name="bairro_destino" id="bairro_destino" maxlength="30" />
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="complemento_destino-form" class="form-group">
                    <p class="formu-letra">Complemento - Destino</p>
                    <input class="form-control" type="text" name="complemento_destino" id="complemento_destino" maxlength="60" />
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="estado_destino-form" class="form-group">
                    <p class="formu-letra">Estado - Destino</p>
                    <input type="hidden" name="uf_destino" id="uf_destino"  /> 
                    <select class="form-control" type="text" name="estado_destino" id="estado_destino">
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="cidade_destino-form" class="form-group">
                    <p class="formu-letra">Cidade - Destino</p>
                    <input type="hidden" name="cid_destino" id="cid_destino"  /> 
                     <select class="form-control" type="text" name="cidade_destino" id="cidade_destino">
                     </select>
                  </div>
                </div>
              </div>             
          
              <div class="row">
                <div class="col-md-12">
                  <button class="btn btn-success btn-right" id="trecho-salvar" type="button">Salvar</button> 
                  <a href="visu_trecho.php" class="btn btn-link  btn-right" type="button">Voltar</a>                  
                </div>
              </div>

              
            </div>         
          </div>
        </form>

<?php include './inc/footer.php'; ?>

<script src="js/trecho.js"></script>
<?php } ?>
