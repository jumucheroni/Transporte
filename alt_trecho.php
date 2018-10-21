<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {

    include './inc/header.php'; 
    include './inc/conexao.php';

      $acao = 'ALTERAR';

      $id_trecho = @$_GET["id_trecho"]; 
      $id_crianca = @$_GET["id_crianca"];

      $sql = "select t.*,ct.* from criancatrecho ct
        inner join crianca c on c.id = ct.id_crianca
        inner join condutor o on o.cpf = ct.cpf_condutor
        inner join veiculo v on v.placa = ct.placa_veiculo
        inner join trecho t on t.id = ct.id_trecho 
        where ct.id_trecho = ".$id_trecho." and ct.id_crianca = ".$id_crianca;

        $result = $conexao->query($sql);
        $row = @mysqli_fetch_array($result);

        $id_crianca       = $row["id_crianca"];
        $id_trecho        = $row["id_trecho"];
        $tipo             = $row["tipo"];
        $cpf_condutor     = $row["cpf_condutor"];
        $placa_veiculo    = $row["placa_veiculo"];
        $periodo          = $row["periodo_conducao"];

        $cep_origem         = $row["cep_origem"];
        $logradouro_origem  = $row["logradouro_origem"];
        $numero_origem      = $row["numero_origem"];
        $complemento_origem = $row["complemento_origem"];
        $bairro_origem      = $row["bairro_origem"];
        $cidade_origem      = $row["cidade_origem"];
        $estado_origem      = $row["estado_origem"];

        $cep_destino         = $row["cep_destino"];
        $logradouro_destino  = $row["logradouro_destino"];
        $numero_destino      = $row["numero_destino"];
        $complemento_destino = $row["complemento_destino"];
        $bairro_destino      = $row["bairro_destino"];
        $cidade_destino      = $row["cidade_destino"];
        $estado_destino      = $row["estado_destino"];


        $enablechave = "readonly";

      $criancasql = "select id,nome from crianca where deletado = 'N' ";
      $criancaresult = $conexao->query($criancasql);

      $conducaosql = "select * from condutorveiculo where deletado = 'N' ";
      $conducaoresult = $conexao->query($conducaosql);

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
                <h1 class="page-header">Alterar Transporte</h1>
              </div>

              <div class="row">
                <div class="col-md-4">
                  <div id="tipo-form" class="form-group">
                    <p class="formu-letra">Tipo</p>
                      <select disabled="true" class="form-control" type="text" name="tipo" id="tipo" >
                         <option></option>
                        <option value="im" <?php if ($tipo == 'im') { echo 'selected="true"'; } ?> id="im">Ida-Manhã</option>
                        <option value="it" <?php if ($tipo == 'it') { echo 'selected="true"'; } ?> id="it">Ida-Tarde</option>
                        <option value="vm" <?php if ($tipo == 'vm') { echo 'selected="true"'; } ?> id="vm">Volta-Manhã</option>
                        <option value="vt" <?php if ($tipo == 'vt') { echo 'selected="true"'; } ?> id="vt">Volta-Tarde</option>
                      </select>
                    </div> 
                  </div>
                <div class="col-md-8">
                  <div id="crianca-form" class="form-group">
                    <p class="formu-letra">Criança</p>
                     <select <?php print $enablechave; ?> class="form-control" type="text" name="crianca" id="crianca" >
                      <?php while ($criancarow = @mysqli_fetch_array($criancaresult)){ ?>
                        <option <?php if ($id_crianca == $criancarow['id'])  { echo 'selected="true"'; } ?> value="<?php print $criancarow['id'];?>"><?php print $criancarow['nome'];?></option>
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
                        <option <?php if ($cpf_condutor == $conducaorow['cpf_condutor'] && $placa_veiculo == $conducaorow['placa_veiculo'] && $periodo == $conducaorow['periodo'])  { echo 'selected="true"'; } ?> value="<?php print $conducaorow['cpf_condutor'].';'.$conducaorow['placa_veiculo'].';'.$conducaorow['periodo'];?>"><?php print $conducaorow['cpf_condutor']."-".$conducaorow['placa_veiculo']."-".$conducaorow['periodo'];?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div id="cep_origem-form" class="form-group">
                    <p class="formu-letra">Cep - Origem</p>
                    <input class="form-control cep" type="text" name="cep_origem" id="cep_origem" maxlength="9" value="<?php print $cep_origem; ?>" />
                  </div>
                </div>
                <div class="col-md-7">
                  <div id="logradouro_origem-form" class="form-group">
                    <p class="formu-letra">Logradouro - Origem</p>
                    <input class="form-control" type="text" name="logradouro_origem" id="logradouro_origem" maxlength="100" value="<?php print $logradouro_origem; ?>" />
                  </div>
                </div>
                <div class="col-md-2">
                  <div id="numero_origem-form" class="form-group">
                    <p class="formu-letra">Nº - Origem</p>
                    <input class="form-control" type="text" name="numero_origem" id="numero_origem" maxlength="8" value="<?php print $numero_origem; ?>" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div id="bairro_origem-form" class="form-group">
                    <p class="formu-letra">Bairro - Origem</p>
                    <input class="form-control" type="text" name="bairro_origem" id="bairro_origem" maxlength="30" value="<?php print $bairro_origem; ?>" />
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="complemento_origem-form" class="form-group">
                    <p class="formu-letra">Complemento - Origem</p>
                    <input class="form-control" type="text" name="complemento_origem" id="complemento_origem" maxlength="60" value="<?php print $complemento_origem; ?>" />
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="estado_origem-form" class="form-group">
                    <p class="formu-letra">Estado - Origem</p>
                    <input type="hidden" name="uf_origem" id="uf_origem" value="<?php print $estado_origem; ?>" /> 
                    <select class="form-control" type="text" name="estado_origem" id="estado_origem">
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="cidade_origem-form" class="form-group">
                    <p class="formu-letra">Cidade - Origem</p>
                    <input type="hidden" name="cid_origem" id="cid_origem" value="<?php print $cidade_origem; ?>" /> 
                     <select class="form-control" type="text" name="cidade_origem" id="cidade_origem">
                     </select>
                  </div>
                </div>
              </div>  

              <div class="row">
                <div class="col-md-3">
                  <div id="cep_destino-form" class="form-group">
                    <p class="formu-letra">Cep - Destino</p>
                    <input class="form-control cep" type="text" name="cep_destino" id="cep_destino" maxlength="9" value="<?php print $cep_destino; ?>" />
                  </div>
                </div>
                <div class="col-md-7">
                  <div id="logradouro_destino-form" class="form-group">
                    <p class="formu-letra">Logradouro - Destino</p>
                    <input class="form-control" type="text" name="logradouro_destino" id="logradouro_destino" maxlength="100" value="<?php print $logradouro_destino; ?>" />
                  </div>
                </div>
                <div class="col-md-2">
                  <div id="numero_destino-form" class="form-group">
                    <p class="formu-letra">Nº - Destino</p>
                    <input class="form-control" type="text" name="numero_destino" id="numero_destino" maxlength="8" value="<?php print $numero_destino; ?>" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div id="bairro_destino-form" class="form-group">
                    <p class="formu-letra">Bairro - Destino</p>
                    <input class="form-control" type="text" name="bairro_destino" id="bairro_destino" maxlength="30" value="<?php print $bairro_destino; ?>" />
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="complemento_destino-form" class="form-group">
                    <p class="formu-letra">Complemento - Destino</p>
                    <input class="form-control" type="text" name="complemento_destino" id="complemento_destino" maxlength="60" value="<?php print $complemento_destino; ?>" />
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="estado_destino-form" class="form-group">
                    <p class="formu-letra">Estado - Destino</p>
                    <input type="hidden" name="uf_destino" id="uf_destino"  value="<?php print $estado_destino; ?>" /> 
                    <select class="form-control" type="text" name="estado_destino" id="estado_destino">
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="cidade_destino-form" class="form-group">
                    <p class="formu-letra">Cidade - Destino</p>
                    <input type="hidden" name="cid_destino" id="cid_destino" value="<?php print $cidade_destino; ?>"  /> 
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
