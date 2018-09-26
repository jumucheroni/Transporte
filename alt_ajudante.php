<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {

    include './inc/header.php'; 
    include './inc/conexao.php';

    $enablechave = "readonly";

    $cpf = $_GET['id'];

    $sql = "select * from ajudante where cpf='" . $cpf ."'";
    $result = $conexao->query($sql);
    $row = @mysqli_fetch_array($result);

    $nome        = $row["nome"];
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
          <li class="active">Ajudante</li>
        </ol>
      </div>

      <form id="ajudante" method="post" role="form"> 
        <input type="hidden" name="acao" id="acao" value="ALTERAR" />
         <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
              <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
                <div hidden id="alert"></div>
              </div>

              <h1 class="page-header">Alterar Ajudante</h1>
        
              <div class="row">
                <div class="col-md-6">
                  <div id="nome-form" class="form-group">
                    <p class="formu-letra">Nome</p>
                    <input class="form-control" type="text" name="nome" id="nome" maxlength="100" value="<?php print $nome; ?>" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div id="email-form" class="form-group">
                    <p class="formu-letra">E-mail</p>
                    <input class="form-control" type="email" name="email" id="email" maxlength="100" value="<?php print $email; ?>" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div id="cpf-form" class="form-group">
                    <p class="formu-letra">CPF</p>
                    <input <?php print $enablechave; ?> class="form-control cpf" type="text" name="cpf" id="cpf" maxlength="14" value="<?php print $cpf; ?>"/>
                  </div>
                </div>
                <div class="col-md-4">
                  <div id="rg-form" class="form-group">
                    <p class="formu-letra">RG</p>
                    <input class="form-control rg" type="text" name="rg" id="rg" maxlength="10" value="<?php print $rg; ?>"/>
                  </div>
                </div>
                <div class="col-md-4">
                  <div id="salario-form" class="form-group">
                    <p class="formu-letra">Salario</p>
                    <input class="form-control money" type="text" name="salario" id="salario" value="<?php print $salario; ?>" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div id="cep-form" class="form-group">
                    <p class="formu-letra">Cep</p>
                    <input class="form-control cep" type="text" name="cep" id="cep" maxlength="9" value="<?php print $cep; ?>"/>
                  </div>
                </div>
                <div class="col-md-7">
                  <div id="logradouro-form" class="form-group">
                    <p class="formu-letra">Logradouro</p>
                    <input class="form-control" type="text" name="logradouro" id="logradouro" maxlength="100" value="<?php print $logradouro; ?>"/>
                  </div>
                </div>
                <div class="col-md-2">
                  <div id="numero-form" class="form-group">
                    <p class="formu-letra">Número</p>
                    <input class="form-control" type="text" name="numero" id="numero" maxlength="8" value="<?php print $numero; ?>"/>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div id="bairro-form" class="form-group">
                    <p class="formu-letra">Bairro</p>
                    <input class="form-control" type="text" name="bairro" id="bairro" maxlength="30" value="<?php print $bairro; ?>"/>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="complemento-form" class="form-group">
                    <p class="formu-letra">Complemento</p>
                    <input class="form-control" type="text" name="complemento" id="complemento" maxlength="60" value="<?php print $complemento; ?>"/>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="estado-form" class="form-group">  
                    <input type="hidden" name="uf" id="uf" value="<?php print $estado?>" /> 
                    <p class="formu-letra">Estado</p>
                    <select class="form-control" type="text" name="estado" id="estado">
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="cidade-form" class="form-group">
                    <input type="hidden" name="cid" id="cid" value="<?php print $cidade?>" /> 
                    <p class="formu-letra">Cidade</p>
                     <select class="form-control" type="text" name="cidade" id="cidade">
                     </select>
                  </div>
                </div>
              </div>
                
            </div>
              
          
              <div class="row">
                <div class="col-md-12">
                  <button class="btn btn-success btn-right" id="ajudante-salvar" type="button">Salvar</button> 
                  <a href="visu_ajudante.php" class="btn btn-link  btn-right" type="button">Voltar</a>                  
                </div>
              </div>

              
            </div>         
          </div>
        </form>
      </div>

<?php include './inc/footer.php'; ?>

<script src="js/ajudante.js"></script>

<?php } ?>