<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {

    include './inc/header.php'; 
    include './inc/conexao.php';

        $enablechave = "readonly";

        $id = $_GET['id'];

      $sql = "select * from crianca where id=".$id;
        $result = $conexao->query($sql);
        $row = @mysqli_fetch_array($result);

      $id                  = $row["id"];
      $cpf_responsavel     = $row["cpf_responsavel"];
      $nome                = $row["nome"];
      $data_nascimento     = DbtoDt($row["data_nascimento"]);
      $n_ident_escola      = $row["id_escola"];
      $nome_professor      = $row["nome_professor"];

      $respsql = "select cpf,nome from responsavel where deletado = 'N' and cpf = ".$cpf_responsavel;
      $respresult = $conexao->query($respsql);
      $resprow = @mysqli_fetch_array($respresult);

      $escolasql = "select id,nome from escola where deletado = 'N' and id = ".$id_escola;
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
          <li class="active">Criança</li>
        </ol>
      </div>

       <form id="crianca" method="post" role="form"> 
        <input type="hidden" name="acao" id="acao" value="<?php print $acao; ?>" />
         <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
              <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
                <div hidden id="alert"></div>
              </div>
              <div class="col-xs-12 col-sm-8 col-md-10 ">
                <h1 class="page-header">Criança</h1>
              </div>
             
              <div class="row">
                <div class="col-md-6">
                  <div id="cpf_responsavel-form" class="form-group">
                    <p class="formu-letra">CPF Responsável</p>
                    <h4><?php print $resprow['cpf']." - ".$resprow['nome'];?></h4>
                  </div>
                </div>
                <div class="col-md-6">
                  <div id="nome-form" class="form-group">
                    <p class="formu-letra">Nome</p>
                    <h4><?php print $nome; ?></h4>
                    <input class="form-control" type="text" name="nome" id="nome" maxlength="100" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div id="nome_professor-form" class="form-group">
                    <p class="formu-letra">Nome do Professor</p>
                    <h4><?php print $nome_professor; ?></h4>
                  </div>
                </div>
                <div class="col-md-6">
                  <div id="n_ident_escola-form" class="form-group">
                    <p class="formu-letra">Escola</p>
                     <select class="form-control" type="text" name="n_ident_escola" id="n_ident_escola">
                     <h4><?php print $escolarow['id']." - ".$escolarow['nome'];?></h4>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div id="data_nascimento-form" class="form-group">
                    <p class="formu-letra">Data Nascimento</p>
                    <h4><?php print $data_nascimento?></h4>
                  </div>   
                </div>            
              </div>              
          
              <div class="row">
                <div class="col-md-12">
                  <a href="visu_crianca.php" class="btn btn-link  btn-right" type="button">Voltar</a>                  
                </div>
              </div>

              
            </div>         
          </div>
        </form>


<?php } ?>


<?php include './inc/footer.php'; ?>
<script src="js/crianca.js"></script>

<?php } ?>