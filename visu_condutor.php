<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
    include './inc/header.php'; 
    include './inc/conexao.php';
    $sql = "select nome,cpf,pgu from condutor where deletado = 'N' ";
    $result = $conexao->query($sql);
?>
          
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu">
                  Listagem de Condutor
                  <a href="cad_condutor.php?acao=CADASTRAR"><button class="btn-criar" id="novo-alvara">Novo Condutor</button></a>
              </p>
              
              <div class="row">
                <div class="caixa-f">
                <div class="col-md-5">
                  <p class="formu-letra">Nome</p>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">CPF</p>
                </div>
                <div class="col-md-2">
                  <p class="formu-letra">PGU</p>
                </div>
                <div class="col-md-2">
                  <p class="formu-letra">Opções</p>
                </div>
              </div>
              </div>
              <div id="resultado" class="row">
                <?php while ($row = @mysqli_fetch_array($result)){ ?>
                  <div class="caixa-fl">
                    <div class="col-md-5">
                      <p class="letra-fi "><?php print $row["nome"];?></p>
                    </div>
                    <div class="col-md-3">
                      <p class="letra-fi "><?php print $row["cpf"];?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi "><?php print $row["pgu"];?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi">
                         <a href="cad_condutor.php?acao=ALTERAR&id=<?php print $row["cpf"];?>"><button class="btn-alterar glyphicon glyphicon-pencil" id="manu-condutor"></button></a>
                         <a href="cad_condutor.php?acao=DELETAR&id=<?php print $row["cpf"];?>"><button class="btn-deletar glyphicon glyphicon-trash" id="dele-condutor"></button></a>
                        <a href="cad_condutor.php?acao=DETALHES&id=<?php print $row["cpf"];?>"><button class="btn-detalhes glyphicon glyphicon-plus" id="deta-condutor"></button></a>
                      </p>
                    </div>
                  </div>
                <?php }?>
                </div>
          

              
            </div>         
          </div>

<?php include './inc/footer.php'; ?>
<script src="js/condutor.js"></script>
<?php }?>