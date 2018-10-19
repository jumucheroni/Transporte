<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
    include './inc/header.php'; 
    include './inc/conexao.php';
    $sql = "select c.id as id,c.nome as Crianca,r.nome as Responsavel,e.nome as Escola from crianca c, responsavel r, escola e where c.cpf_responsavel=r.cpf and c.id_escola=e.id and c.deletado = 'N' ";
    $result = $conexao->query($sql);

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
            <div class="row">
              <div class="col-lg-6">
                <h1 class="page-header">Listagem de Criança</h1>
              </div> 
              <div class="col-lg-6">  
                <a href="cad_crianca.php"><button class="btn btn-criar" id="novo-crianca">Nova Criança</button></a>
              </div>
            </div>
            <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
                <div hidden id="alert"></div>
            </div>
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
               <form id="<?php print $row['id']?>" method="POST">
                  <input type="hidden" name="id" value ="<?php print $row['id'] ?>" />
                  <input type="hidden" name="acao" id="acao" value="SALVARDELETE"/>
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
                      <a href="alt_crianca.php?id=<?php print $row["id"];?>"><button class="btn btn-sm btn-info fa fa-pencil" id="manu-crianca" type="button"></button></a>
                        <button class="btn btn-sm btn-danger fa fa-trash dele-crianca" id="<?php print $row['id'].'-dele'; ?>" type="button"></button>
                        <a href="deta_crianca.php?id=<?php print $row["id"];?>"><button class="btn btn-sm btn-warning fa fa-plus" id="deta-crianca" type="button"></button></a>
                      </p>
                    </div>
                  </div>
                </form>
                  <?php }?>
                </div>
          

              
            </div>         
          </div>
        </form>

<?php include './inc/footer.php'; ?>
<script src="js/crianca.js"></script>
<?php }?>