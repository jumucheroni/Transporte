<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
    include './inc/header.php'; 
    include './inc/conexao.php';
    $sql = "select nome,cpf,pgu from condutor where deletado = 'N' ";
    $result = $conexao->query($sql);
?>
          
         <div class="row">
            <div class="row">
              <ol class="breadcrumb">
                <li><a href="index.php">
                  <em class="fa fa-home"></em>
                </a></li>
                <li class="active">Controle</li>
                <li class="active">Condutor</li>
              </ol>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <h1 class="page-header">Listagem de Condutor</h1>
              </div> 
              <div class="col-lg-6">  
                <a href="cad_condutor.php"><button class="btn btn-criar" id="novo-condutor">Novo Condutor</button></a>
              </div>
            </div>
            <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
                <div hidden id="alert"></div>
            </div>
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
                <form id="<?php print $row['cpf']?>" method="POST">
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
                        <a href="alt_condutor.php?id=<?php print $row["cpf"];?>"><button class="btn btn-sm btn-info fa fa-pencil" id="manu-condutor" type="button"></button></a>
                        <button class="btn btn-sm btn-danger fa fa-trash dele-condutor" id="<?php print $row['cpf'].'-dele'; ?>" type="button"></button>
                        <a href="deta_condutor.php?id=<?php print $row["cpf"];?>"><button class="btn btn-sm btn-warning fa fa-plus" id="deta-condutor" type="button"></button></a>
                      </p>
                    </div>
                  </div>
                </form>
                <?php }?>
                </div>
          

              
            </div>         
          </div>

<?php include './inc/footer.php'; ?>
<script src="js/condutor.js"></script>
<?php }?>