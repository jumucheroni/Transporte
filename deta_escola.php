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
    $emanha        = $row["entrada_manha"];
    $smanha        = $row["saida_manha"];
    $etarde        = $row["entrada_tarde"];
    $starde        = $row["saida_tarde"];

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
        <input type="hidden" name="acao" id="acao" value="CADASTRAR" />
         <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
              <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
                <div hidden id="alert"></div>
              </div>
              <div class="col-xs-12 col-sm-8 col-md-10 ">
                <h1 class="page-header">Escola</h1>
              </div>
            
              <div class="row">
                <div class="col-md-12">
                <div id="nome-form" class="form-group">
                  <input type="hidden" name="n_ident" value="<?php echo $n_ident; ?>" />
                    <p class="formu-letra">Nome</p>
                    <h4><?php print $nome;?></h4>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div id="tipo-form" class="form-group">
                    <p class="formu-letra">Tipo</p>
                    <h4><?php if ($tipo == 'E') print 'Estadual'; if ($tipo == 'M') print 'Municipal'; if ($tipo == 'P') print 'Particular' ?>
                    </h4>
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
                  <div id="complemento-form" class="form-group">
                    <p class="formu-letra">Complemento</p>
                    <h4><?php print $complemento;?></h4>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="bairro-form" class="form-group">
                    <p class="formu-letra">Bairro</p>
                    <h4><?php print $bairro;?></h4>
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
              <div class="row">
                <div class="col-md-3">
                  <div id="e-manha-form" class="form-group">
                    <p class="formu-letra">Entrada da manhã</p>
                   <?php print $emanha;?>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="s-manha-form" class="form-group">
                    <p class="formu-letra">Saída da manhã</p>
                    <?php print $smanha;?>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="e-tarde-form" class="form-group">
                    <p class="formu-letra">Entrada da tarde</p>
                    <?php print $etarde;?>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="s-tarde-form" class="form-group">
                    <p class="formu-letra">Saída da tarde</p>
                    <?php print $starde;?>
                  </div>
                </div>
              </div>
              
          
              <div class="row">
                <div class="col-md-12">
                  <a href="visu_escola.php" class="btn btn-link  btn-right" type="button">Voltar</a>                  
                </div>
              </div>

              
            </div>         
          </div>
        </form>

<?php include './inc/footer.php'; ?>

<script src="js/escola.js"></script>
<?php } ?>
