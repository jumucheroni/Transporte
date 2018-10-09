<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {

    include './inc/header.php'; 
    include './inc/conexao.php';

    $enablechave = "readonly";

    $cpf = $_GET['id'];

    $sql = "select * from condutor where cpf='" . $cpf ."'";
    $result = $conexao->query($sql);
    $row = @mysqli_fetch_array($result);

    $nome        = $row["nome"];
    $pgu         = $row["pgu"];
    $rg          = $row["rg"];
    $salario     = $row["salario"];
    $email       = $row["email"];
    $cep         = $row["cep"];
    $logradouro  = $row["logradouro"];
    $numero      = $row["numero"];
    $complemento = $row["complemento"];
    $bairro      = $row["bairro"];
    $cidade      = $row['cidade'];
    $estado      = $row['estado'];

?>
    <div class="row">
      <div class="row">
        <ol class="breadcrumb">
          <li><a href="index.php">
            <em class="fa fa-home"></em>
          </a></li>
          <li class="active">Controle</li>
          <li class="active">Condutor</li>
        </ol>
      </div>

      <form id="condutor" method="post" role="form"> 
         <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <h1 class="page-header">condutor</h1>
              
              <div class="row">
                <div class="col-md-6">
                  <div id="cpf-form" class="form-group">
                    <p class="formu-letra">CPF</p>
                    <h4><?php print $cpf; ?></h4>
                  </div>
                </div>
                <div class="col-md-6">
                  <div id="cpf-form" class="form-group">
                    <p class="formu-letra">PGU</p>
                    <h4><?php print $pgu; ?></h4>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div id="nome-form" class="form-group">
                    <p class="formu-letra">Nome</p>
                    <h4><?php print $nome; ?> </h4>
                  </div>
                </div>
                <div class="col-md-6">
                  <div id="email-form" class="form-group">
                    <p class="formu-letra">E-mail</p>
                    <h4><?php print $email; ?></h4>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div id="rg-form" class="form-group">
                    <p class="formu-letra">RG</p>
                    <h4><?php print $rg; ?></h4>
                  </div>
                </div>
                <div class="col-md-4">
                  <div id="salario-form" class="form-group">
                    <p class="formu-letra">Salario</p>
                    <h4><?php print $salario; ?></h4>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div id="cep-form" class="form-group">
                    <p class="formu-letra">Cep</p>
                    <h4><?php print $cep; ?></h4>
                  </div>
                </div>
                <div class="col-md-7">
                  <div id="logradouro-form" class="form-group">
                    <p class="formu-letra">Logradouro</p>
                    <h4><?php print $logradouro; ?></h4>
                  </div>
                </div>
                <div class="col-md-2">
                  <div id="numero-form" class="form-group">
                    <p class="formu-letra">Número</p>
                    <h4><?php print $numero; ?></h4>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div id="bairro-form" class="form-group">
                    <p class="formu-letra">Bairro</p>
                    <h4><?php print $bairro; ?></h4>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="complemento-form" class="form-group">
                    <p class="formu-letra">Complemento</p>
                    <h4><?php print $complemento; ?></h4>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="estado-form" class="form-group">  
                    <p class="formu-letra">Estado</p>
                    <h4><?php print $estado; ?></h4>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="cidade-form" class="form-group">
                    <p class="formu-letra">Cidade</p>
                     <h4><?php print $cidade; ?></h4>
                  </div>
                </div>
              </div>
                
            </div>
              
          
              <div class="row">
                <div class="col-md-12">
                  <a href="visu_condutor.php" class="btn btn-link  btn-right" type="button">Voltar</a>                  
                </div>
              </div>

              
            </div>         
          </div>
        </form>
      </div>

<?php include './inc/footer.php'; ?>

<script src="js/condutor.js"></script>

<?php } ?>