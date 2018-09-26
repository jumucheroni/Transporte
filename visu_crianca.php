<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
    include './inc/header.php'; 
    include './inc/conexao.php';
    $sql = "select c.id as id,c.nome as Crianca,r.nome as Responsavel,e.nome as Escola from crianca c, responsavel r, escola e where c.cpf_responsavel=r.cpf and c.id_escola=e.id and c.deletado = 'N' ";
    $result = $conexao->query($sql);

?>

         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu">
                  Listagem de Criança
                  <a href="cad_crianca.php?acao=CADASTRAR"><button class="btn-criar" id="novo-alvara">Nova Criança</button></a>
              </p>
              
              <div class="row">
                <div class="caixa-f">
                <div class="col-md-4">
                  <p class="formu-letra">Responsavel</p>
                </div>
                <div class="col-md-4">
                  <p class="formu-letra">Nome</p>
                </div>
                <div class="col-md-2">
                  <p class="formu-letra">Escola</p>
                </div>
                <div class="col-md-2">
                  <p class="formu-letra">Opções</p>
                </div>
              </div>
              </div>
              <div id="resultado" class="row">
              <?php while ($row = @mysqli_fetch_array($result)){ ?>
                  <div class="caixa-fl">
                    <div class="col-md-4">
                      <p class="letra-fi "><?php print $row["Responsavel"];?></p>
                    </div>
                    <div class="col-md-4">
                      <p class="letra-fi "><?php print $row["Crianca"];?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi "><?php print $row["Escola"];?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi">
                        <a href="cad_crianca.php?acao=ALTERAR&id=<?php print $row["id"];?>"><button class="btn-alterar glyphicon glyphicon-pencil" id="manu-crianca"></button></a>
                        <a href="cad_crianca.php?acao=DELETAR&id=<?php print $row["id"];?>"><button class="btn-deletar glyphicon glyphicon-trash" id="dele-crianca"></button></a>
                        <a href="cad_crianca.php?acao=DETALHES&id=<?php print $row["id"];?>"><button class="btn-detalhes glyphicon glyphicon-plus" id="deta-crianca"></button></a>
                      </p>
                    </div>
                  </div>
                  <?php }?>
                </div>
          

              
            </div>         
          </div>
        </form>

<?php include './inc/footer.php'; ?>
<script src="js/crianca.js"></script>
<?php }?>