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
            <li class="active">Controle</li>
            <li class="active">Responsável</li>
          </ol>
        </div>
       <form id="responsavel" method="post" role="form"> 
        <input type="hidden" name="acao" id="acao" value="CADASTRAR" />
         <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
              <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
                <div hidden id="alert"></div>
              </div>
              <div class="col-xs-12 col-sm-8 col-md-10 ">
                <h1 class="page-header">Cadastrar Responsável</h1>
              </div>
       
              <div class="row">
                <div class="col-md-6">
                  <div id="cpf-form" class="form-group">
                    <p class="formu-letra">CPF</p>
                    <input class="form-control cpf" type="text" name="cpf" id="cpf" maxlength="14" />
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
                <div class="col-md-3">
                  <div id="rg-form" class="form-group">
                    <p class="formu-letra">RG</p>
                    <input class="form-control rg" type="text" name="rg" id="rg" maxlength="10" />
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="parentesco-form" class="form-group">
                    <p class="formu-letra">Parentesco</p>
                    <input class="form-control" type="text" name="parentesco" id="parentesco" maxlength="60" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div id="telefone-form" class="form-group">
                    <p class="formu-letra">Telefone</p>
                    <input class="form-control" type="text" name="telefone" id="telefone" maxlength="255" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div id="cep-form" class="form-group">
                    <p class="formu-letra">CEP</p>
                    <input class="form-control cep" type="text" name="cep" id="cep" maxlength="9" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div id="logradouro-form" class="form-group">
                    <p class="formu-letra">Logradouro</p>
                    <input class="form-control" type="text" name="logradouro" id="logradouro" maxlength="100" />
                  </div>
                </div>
                <div class="col-md-2">
                  <div id="numero-form" class="form-group">
                    <p class="formu-letra">Numero</p>
                    <input class="form-control" type="text" name="numero" id="numero" maxlength="8" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div id="bairro-form" class="form-group">
                    <p class="formu-letra">Bairro</p>
                    <input class="form-control" type="text" name="bairro" id="bairro" maxlength="30" />
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="complemento-form" class="form-group">
                    <p class="formu-letra">Complemento</p>
                    <input class="form-control" type="text" name="complemento" id="complemento" maxlength="60" />
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="estado-form" class="form-group">
                    <p class="formu-letra">Estado</p>
                    <select class="form-control" type="text" name="estado" id="estado">
                    <input type="hidden" name="uf" id="uf" />
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div id="cidade-form" class="form-group">
                    <p class="formu-letra">Cidade</p>
                    <input type="hidden" name="cid" id="cid" />
                     <select class="form-control" type="text" name="cidade" id="cidade">
                     </select>
                  </div>
                </div>
              </div>
              
          
              <div class="row">
                <div class="col-md-12">
                  <button class="btn btn-success btn-right" id="responsavel-salvar" type="button">Salvar</button> 
                  <a href="visu_responsavel.php" class="btn btn-link  btn-right" type="button">Voltar</a>                  
                </div>
              </div>

              
            </div>         
          </div>
        </form>

<?php include './inc/footer.php'; ?>

<script src="js/responsavel.js"></script>
<?php } ?>