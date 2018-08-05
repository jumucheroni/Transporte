<?php include './inc/header.php'; 
include './inc/conexao.php';
    $sql = "select cpf,nome,parentesco from responsavel";
    $result = $conexao->query($sql);
?>

         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu">
                  Listagem de Responsável
                  <a href="cad_responsavel.php?acao=CADASTRAR"><button class="btn-criar" id="novo-alvara">Novo Responsável</button></a>
              </p>
              
              <div class="row">
                <div class="caixa-f">
                <div class="col-md-3">
                  <p class="formu-letra">CPF</p>
                </div>
                <div class="col-md-5">
                  <p class="formu-letra">Nome</p>
                </div>
                <div class="col-md-2">
                  <p class="formu-letra">Parentesco</p>
                </div>
                <div class="col-md-2">
                  <p class="formu-letra">Opções</p>
                </div>
              </div>
              </div>
              <div id="resultado" class="row">
                <?php while ($row = @mysqli_fetch_array($result)){ ?>
                  <div class="caixa-fl">
                    <div class="col-md-3">
                      <p class="letra-fi "><?php print $row["cpf"];?></p>
                    </div>
                    <div class="col-md-5">
                      <p class="letra-fi "><?php print $row["nome"];?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi "><?php print $row["parentesco"];?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi">
                        <a href="cad_responsavel.php?acao=ALTERAR&id=<?php print $row["cpf"];?>"><button class="btn-alterar glyphicon glyphicon-pencil" id="manu-responsavel"></button></a>
                         <a href="cad_responsavel.php?acao=DELETAR&id=<?php print $row["cpf"];?>"><button class="btn-deletar glyphicon glyphicon-trash" id="dele-responsavel"></button></a>
                        <a href="cad_responsavel.php?acao=DETALHES&id=<?php print $row["cpf"];?>"><button class="btn-detalhes glyphicon glyphicon-plus" id="deta-responsavel"></button></a>
                      </p>
                    </div>
                  </div>
                   <?php }?>
                </div>
          

              
            </div>         
          </div>

<?php include './inc/footer.php'; ?>