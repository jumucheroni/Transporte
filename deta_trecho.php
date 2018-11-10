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

        $escola              = $row["id_escola"];


        $enablechave = "readonly";

      $criancasql = "select id,nome from crianca where deletado = 'N' and id = ".$id_crianca;
      $criancaresult = $conexao->query($criancasql);
      $criancarow = @mysqli_fetch_array($criancaresult);

      $conducaosql = "select * from condutorveiculo where deletado = 'N' and periodo = '".$periodo."' and placa_veiculo = '".$placa_veiculo."' and cpf_condutor = '".$cpf_condutor."'";
      $conducaoresult = $conexao->query($conducaosql);
      $conducaorow = @mysqli_fetch_array($conducaoresult);

      $escolasql = "select * from escola where deletado = 'N' and id = ".$escola;
      $escolaresult = $conexao->query($escolasql);
      $escolarow = @mysqli_fetch_array($escolaresult);

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
                <h1 class="page-header">Transporte</h1>
              </div>

              <div class="row">
                <div class="col-md-4">
                  <div id="tipo-form" class="form-group">
                    <p class="formu-letra">Tipo</p>
                      <h4> <?php if ($tipo == 'im') print "Ida-Manhã"; if ($tipo == 'it') print "Ida-Tarde"; if ($tipo == 'vm') print "Volta-Manhã"; if ($tipo == 'vt') print "Volta-Tarde"; ?> </h4>
                    </div> 
                  </div>
                <div class="col-md-8">
                  <div id="crianca-form" class="form-group">
                    <p class="formu-letra">Criança</p>
                     <h4><?php print $criancarow['nome'];?></h4>
                  </div>
                </div>
              </div>
              <div class="row">
                
                <div class="col-md-6">
                  <div id="conducao-form" class="form-group">
                    <p class="formu-letra">Condução</p>
                     <h4><?php print $conducaorow['cpf_condutor']."-".$conducaorow['placa_veiculo'];?></h4>
                  </div>
                </div>
                <div class="col-md-6">
                  <div id="escola-form" class="form-group">
                    <p class="formu-letra">Escola</p>
                     <h4><?php print $escolarow['nome'];?></h4>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div id="cep_origem-form" class="form-group">
                    <p class="formu-letra">Cep - Origem</p>
                    <h4><?php print $cep_origem; ?></h4>
                  </div>
                </div>
                <div class="col-md-7">
                  <div id="logradouro_origem-form" class="form-group">
                    <p class="formu-letra">Logradouro - Origem</p>
                    <h4><?php print $logradouro_origem; ?></h4>
                  </div>
                </div>
                <div class="col-md-2">
                  <div id="numero_origem-form" class="form-group">
                    <p class="formu-letra">Nº - Origem</p>
                    <h4><?php print $numero_origem; ?></h4>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div id="bairro_origem-form" class="form-group">
                    <p class="formu-letra">Bairro - Origem</p>
                    <h4><?php print $bairro_origem; ?></h4>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="complemento_origem-form" class="form-group">
                    <p class="formu-letra">Complemento - Origem</p>
                    <h4><?php print $complemento_origem; ?></h4>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="estado_origem-form" class="form-group">
                    <p class="formu-letra">Estado - Origem</p>
                    <h4><?php print $estado_origem; ?></h4> 
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="cidade_origem-form" class="form-group">
                    <p class="formu-letra">Cidade - Origem</p>
                    <h4><?php print $cidade_origem; ?></h4> 
                  </div>
                </div>
              </div>  

              <div class="row">
                <div class="col-md-3">
                  <div id="cep_destino-form" class="form-group">
                    <p class="formu-letra">Cep - Destino</p>
                    <h4><?php print $cep_destino; ?></h4>
                  </div>
                </div>
                <div class="col-md-7">
                  <div id="logradouro_destino-form" class="form-group">
                    <p class="formu-letra">Logradouro - Destino</p>
                    <h4><?php print $logradouro_destino; ?></h4>
                  </div>
                </div>
                <div class="col-md-2">
                  <div id="numero_destino-form" class="form-group">
                    <p class="formu-letra">Nº - Destino</p>
                    <h4><?php print $numero_destino; ?></h4>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div id="bairro_destino-form" class="form-group">
                    <p class="formu-letra">Bairro - Destino</p>
                    <h4><?php print $bairro_destino; ?></h4>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="complemento_destino-form" class="form-group">
                    <p class="formu-letra">Complemento - Destino</p>
                    <h4><?php print $complemento_destino; ?></h4>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="estado_destino-form" class="form-group">
                    <p class="formu-letra">Estado - Destino</p>
                    <h4><?php print $estado_destino; ?></h4> 
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="cidade_destino-form" class="form-group">
                    <p class="formu-letra">Cidade - Destino</p>
                    <h4><?php print $cidade_destino; ?></h4> 
                  </div>
                </div>
              </div>             
          
              <div class="row">
                <div class="col-md-12">
                  <a href="visu_trecho.php" class="btn btn-link  btn-right" type="button">Voltar</a>                  
                </div>
              </div>

              
            </div>         
          </div>
        </form>

<?php include './inc/footer.php'; ?>

<script src="js/trecho.js"></script>
<?php } ?>
