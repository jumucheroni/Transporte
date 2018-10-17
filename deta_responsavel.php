<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
    include './inc/header.php'; 
    include './inc/conexao.php';

    $enablechave = "readonly";

    $cpf = $_GET['id'];

    $sql = "select * from responsavel where cpf='" . $cpf ."'";
    $result = $conexao->query($sql);
    $row = @mysqli_fetch_array($result);

    $cpf           = $row["cpf"];
    $nome          = $row["nome"];
    $rg            = $row["rg"];
    $parentesco    = $row["parentesco"];
    $logradouro    = $row["logradouro"];
    $numero        = $row["numero"];
    $bairro        = $row["bairro"];
    $cep           = $row["cep"];
    $complemento   = $row["complemento"];
    $cidade        = $row["cidade"];
    $estado        = $row["estado"];

    $sqltelefone = "select * from telefone where cpf_responsavel='" . $cpf ."'";
    $resultelefone = $conexao->query($sqltelefone);
    while ($rowtelefone = @mysqli_fetch_array($resultelefone)) {
        $telefone .= $rowtelefone["telefone"].";";
    }
 
?>
    <div class="row">
      <div class="row">
        <ol class="breadcrumb">
          <li><a href="index.php">
            <em class="fa fa-home"></em>
          </a></li>
          <li class="active">Controle</li>
          <li class="active">Responsável</li>
        </ol>
      </div>

       <form id="responsavel" method="post" role="form"> 
        <input type="hidden" name="acao" id="acao" value="ALTERAR" />
         <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
              <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
                <div hidden id="alert"></div>
              </div>
              <div class="col-xs-12 col-sm-8 col-md-10 ">
                <h1 class="page-header">Alterar Responsável</h1>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div id="cpf-form" class="form-group">
                    <p class="formu-letra">CPF</p>
                    <h4><?php print $cpf;?></h4>
                  </div>
                </div>
                <div class="col-md-6">
                  <div id="nome-form" class="form-group">
                    <p class="formu-letra">Nome</p>
                    <h4><?php print $nome;?></h4>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div id="rg-form" class="form-group">
                    <p class="formu-letra">RG</p>
                    <h4><?php print $rg;?></h4>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="parentesco-form" class="form-group">
                    <p class="formu-letra">Parentesco</p>
                    <h4><?php print $parentesco;?></h4>
                  </div>
                </div>
                <div class="col-md-6">
                  <div id="telefone-form" class="form-group">
                    <p class="formu-letra">Telefone</p>
                    <h4><?php print $telefone;?></h4>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div id="cep-form" class="form-group">
                    <p class="formu-letra">CEP</p>
                    <h4><?php print $cep;?></h4>
                  </div>
                </div>
                <div class="col-md-6">
                  <div id="logradouro-form" class="form-group">
                    <p class="formu-letra">Logradouro</p>
                    <h4><?php print $logradouro;?></h4>
                  </div>
                </div>
                <div class="col-md-2">
                  <div id="numero-form" class="form-group">
                    <p class="formu-letra">Numero</p>
                    <h4><?php print $numero;?></h4>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div id="bairro-form" class="form-group">
                    <p class="formu-letra">Bairro</p>
                    <h4><?php print $bairro;?></h4>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="complemento-form" class="form-group">
                    <p class="formu-letra">Complemento</p>
                    <h4><?php print $complemento;?></h4>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="estado-form" class="form-group">
                    <p class="formu-letra">Estado</p>
                    <h4><?php print $estado?></h4>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="cidade-form" class="form-group">
                    <p class="formu-letra">Cidade</p>
                    <h4><?php print $cidade?></h4>
                  </div>
                </div>
              </div>
              
          
              <div class="row">
                <div class="col-md-12">
                  <a href="visu_responsavel.php" class="btn btn-link  btn-right" type="button">Voltar</a>                  
                </div>
              </div>

              
            </div>         
          </div>
        </form>

<?php include './inc/footer.php'; ?>

<script src="js/responsavel.js"></script>
<?php } ?>