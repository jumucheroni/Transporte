<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {

    include './inc/header.php'; 
    include './inc/conexao.php';

      $acao = 'CADASTRAR';

      $respsql = "select cpf,nome from responsavel where deletado = 'N' ";
      $respresult = $conexao->query($respsql);

      $escolasql = "select id,nome from escola where deletado = 'N' ";
      $escolaresult = $conexao->query($escolasql);
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
                <h1 class="page-header">Cadastrar Criança</h1>
              </div>
             
              <div class="row">
                <div class="col-md-6">
                  <div id="cpf_responsavel-form" class="form-group">
                    <p class="formu-letra">CPF Responsável</p>
                    <select class="form-control" type="text" name="cpf_responsavel" id="cpf_responsavel">
                    <?php while ($resprow = @mysqli_fetch_array($respresult)){ ?>
                        <option value="<?php print $resprow['cpf'];?>"><?php print $resprow['cpf']." - ".$resprow['nome'];?></option>
                    <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div id="nome-form" class="form-group">
                    <p class="formu-letra">Nome</p>
                    <input class="form-control" type="text" name="nome" id="nome" maxlength="100" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div id="nome_professor-form" class="form-group">
                    <p class="formu-letra">Nome do Professor</p>
                    <input class="form-control" type="text" name="nome_professor" id="nome_professor" maxlength="100"/>
                  </div>
                </div>
                <div class="col-md-6">
                  <div id="n_ident_escola-form" class="form-group">
                    <p class="formu-letra">Escola</p>
                     <select class="form-control" type="text" name="n_ident_escola" id="n_ident_escola">
                     <?php while ($escolarow = @mysqli_fetch_array($escolaresult)){ ?>
                        <option value="<?php print $escolarow['id'];?>"><?php print $escolarow['id']." - ".$escolarow['nome'];?></option>
                    <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div id="data_nascimento-form" class="form-group">
                    <p class="formu-letra">Data Nascimento</p>
                    <input class="form-control nasc" type="text" name="data_nascimento" id="data_nascimento" />
                  </div>   
                </div>            
              </div>              
          
              <div class="row">
                <div class="col-md-12">
                  <button class="btn btn-success btn-right" id="crianca-salvar" type="button">Salvar</button> 
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