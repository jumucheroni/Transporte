<?php include './inc/header.php'; 
include './inc/conexao.php';
    $sql = "select id,nome,tipo from escola where deletado = 'N' ";
    $result = $conexao->query($sql);

?>

        <input type="hidden" name="acao" value="" />
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu">
                  Listagem de Escola
                  <a href="cad_escola.php?acao=CADASTRAR"><button class="btn-criar" id="novo-escola">Nova Escola</button></a>
              </p>
              
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
                          print "Pública";
                        }?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi">
                        <a href="cad_escola.php?acao=ALTERAR&id=<?php print $row["id"];?>"><button class="btn-alterar glyphicon glyphicon-pencil" id="manu-escola"></button></a>
                        <a href="cad_escola.php?acao=DELETAR&id=<?php print $row["id"];?>"><button class="btn-deletar glyphicon glyphicon-trash" id="dele-escola"></button></a>
                        <a href="cad_escola.php?acao=DETALHES&id=<?php print $row["id"];?>"><button class="btn-detalhes glyphicon glyphicon-plus" id="deta-escola"></button></a>
                      </p>
                    </div>
                  </div>
                     <?php }?>
                </div>
          

              
            </div>         
          </div>

<?php include './inc/footer.php'; ?>