<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {

    include './inc/header.php'; 
    include './inc/conexao.php';

    $enablechave = "readonly";

    $n_ident = $_GET['id'];

    $sql = "select * from escola where id='" . $n_ident ."'";
    $result = $conexao->query($sql);
    $row = @mysqli_fetch_array($result);

    $n_ident       = $row["id"];
    $nome          = $row["nome"];
    $tipo          = $row["tipo"];
    $logradouro    = $row["logradouro"];
    $numero        = $row["numero"];
    $bairro        = $row["bairro"];
    $cep           = $row["cep"];
    $complemento   = $row["complemento"];
    $cidade        = $row["cidade"];    
    $estado        = $row["estado"];

 ?>

      <div class="row">
      <div class="row">
        <ol class="breadcrumb">
          <li><a href="index.php">
            <em class="fa fa-home"></em>
          </a></li>
          <li class="active">Controle</li>
          <li class="active">Escola</li>
        </ol>
      </div>
       <form id="escola" method="post" role="form"> 
        <input type="hidden" name="acao" id="acao" value="ALTERAR" />
         <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
              <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
                <div hidden id="alert"></div>
              </div>
              <div class="col-xs-12 col-sm-8 col-md-10 ">
                <h1 class="page-header">Alterar Escola</h1>
              </div>
            
              <div class="row">
                <div class="col-md-12">
                <div id="nome-form" class="form-group">
                  <input type="hidden" name="id" value="<?php echo $n_ident; ?>" />
                    <p class="formu-letra">Nome</p>
                    <input class="form-control" type="text" name="nome" id="nome" maxlength="100" value="<?php print $nome;?>" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div id="tipo-form" class="form-group">
                    <p class="formu-letra">Tipo</p>
                    <select class="form-control" type="text" name="tipo" id="tipo" >
                      <option value="E"<?php if ($tipo == 'E') { echo 'selected="true"'; } ?> id="e">Estadual</option>
                      <option value="M"<?php if ($tipo == 'M') { echo 'selected="true"'; } ?> id="m">Municipal</option>
                      <option value="P"<?php if ($tipo == 'P') { echo 'selected="true"'; } ?> id="p">Particular</option>
                    </select>
                  </div> 
                </div>       
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div id="cep-form" class="form-group">
                    <p class="formu-letra">CEP</p>
                    <input class="form-control cep" type="text" name="cep" id="cep" maxlength="9" value="<?php print $cep;?>" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div id="logradouro-form" class="form-group">
                    <p class="formu-letra">Logradouro</p>
                    <input class="form-control" type="text" name="logradouro" id="logradouro" maxlength="100" value="<?php print $logradouro;?>" />
                  </div>
                </div>
                <div class="col-md-2">
                  <div id="numero-form" class="form-group">
                    <p class="formu-letra">Numero</p>
                    <input  class="form-control" type="text" name="numero" id="numero" maxlength="8" value="<?php print $numero;?>" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div id="complemento-form" class="form-group">
                    <p class="formu-letra">Complemento</p>
                    <input class="form-control" type="text" name="complemento" id="complemento" maxlength="60" value="<?php print $complemento;?>" />
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="bairro-form" class="form-group">
                    <p class="formu-letra">Bairro</p>
                    <input class="form-control" type="text" name="bairro" id="bairro" maxlength="30" value="<?php print $bairro;?>" />
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="estado-form" class="form-group">
                    <p class="formu-letra">Estado</p>
                     <input type="hidden" name="uf" id="uf" value="<?php print $estado?>" />
                    <select class="form-control" type="text" name="estado" id="estado">
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="cidade-form" class="form-group">
                    <p class="formu-letra">Cidade</p>
                    <input type="hidden" name="cid" id="cid" value="<?php print $cidade?>" />
                     <select class="form-control" type="text" name="cidade" id="cidade">
                     </select>
                  </div>
                </div>
              </div>
              
          
              <div class="row">
                <div class="col-md-12">
                  <button class="btn btn-success btn-right" id="escola-salvar" type="button">Salvar</button> 
                  <a href="visu_escola.php" class="btn btn-link  btn-right" type="button">Voltar</a>                  
                </div>
              </div>

              
            </div>         
          </div>
        </form>

<?php include './inc/footer.php'; ?>

<script src="js/escola.js"></script>
<?php } ?>
