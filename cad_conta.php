<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {

    include './inc/header.php'; 
    include './inc/conexao.php';

?>
    <div class="row">
      <div class="row">
        <ol class="breadcrumb">
          <li><a href="index.php">
            <em class="fa fa-home"></em>
          </a></li>
          <li class="active">Configurações</li>
          <li class="active">Nova Conta</li>
        </ol>
      </div>
             
        <div id="cadastro" class="row">
            <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">Cadastrar</div>
                    <div class="panel-body">
                        <form id="form-cadastro" role="form">
                            <fieldset>
                            <div class="form-group">
                                <input class="form-control" type="text" name="nome" id="nome" maxlength="100" value="" placeholder="Nome" />
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="email" id="email" type="email" maxlength="255" value="" placeholder="E-mail" />
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" name="usuario" id="usuario-cadastro" maxlength="100" value="" placeholder="Usuário" />
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="senha" id="senha-cadastro" type="password" maxlength="12" value="" placeholder="Senha" />
                            </div>
                            <button class="btn btn-primary" type="button" name="salvar" value="Cadastrar" id="salvar">Cadastrar</button>
                            </fieldset>
                         </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
            <div hidden id="alert">
                
            </div>
        </div>

<?php include './inc/footer.php'; ?>

<script src="js/login.js"></script>

<?php } ?>