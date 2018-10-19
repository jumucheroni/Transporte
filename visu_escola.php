<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
    include './inc/header.php'; 
    include './inc/conexao.php';
    $sql = "select id,nome,tipo from escola where deletado = 'N' ";
    $result = $conexao->query($sql);

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
         <div class="row">
              <div class="col-lg-6">
                <h1 class="page-header">Listagem de Escola</h1>
              </div> 
              <div class="col-lg-6">  
                <a href="cad_escola.php"><button class="btn btn-criar" id="novo-escola">Nova Escola</button></a>
              </div>
            </div>
            <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2">
                <div hidden id="alert"></div>
            </div>
              <div class="row">
                <div class="caixa-f">
                <div class="col-md-3">
                  <p class="formu-letra">Número Identificação</p>
                </div>
                <div class="col-md-4">
                  <p class="formu-letra">Nome</p>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">Tipo</p>
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
                    <div class="col-md-3">
                      <p class="letra-fi "><?php print $row["id"];?></p>
                    </div>
                    <div class="col-md-4">
                      <p class="letra-fi "><?php print $row["nome"];?></p>
                    </div>
                    <div class="col-md-3">
                      <p class="letra-fi "><?php 
                        if ($row["tipo"] == 'P'){ 
                          print "Particular";
                       } else { 
                          if ($row["tipo"] == 'E'){
                              print "Estadual";
                          } else {
                            print "Municipal";
                          }
                        }?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi">
                        <a href="alt_escola.php?id=<?php print $row["id"];?>"><button class="btn btn-sm btn-info fa fa-pencil" id="manu-escola" type="button"></button></a>
                        <button class="btn btn-sm btn-danger fa fa-trash dele-escola" id="<?php print $row['id'].'-dele'; ?>" type="button"></button>
                        <a href="deta_escola.php?id=<?php print $row["id"];?>"><button class="btn btn-sm btn-warning fa fa-plus" id="deta-escola" type="button"></button></a>
                      </p>
                    </div>
                  </div>
                </form>
                     <?php }?>
                </div>
          

              
            </div>         
          </div>

<?php include './inc/footer.php'; ?>
<script src="js/escola.js"></script>
<?php } ?>