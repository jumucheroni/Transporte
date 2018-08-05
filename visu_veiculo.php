<?php include './inc/header.php'; 
include './inc/conexao.php';
    $sql = "select placa,lotacao,ano from veiculo";
    $result = $conexao->query($sql);
?>

        <input type="hidden" name="acao" value="" />
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu">
                  Listagem de Veículo
                  <a href="cad_veiculo.php?acao=CADASTRAR"><button class="btn-criar" id="novo-veiculo">Novo Veículo</button></a>
              </p>
              
              <div class="row">
                <div class="caixa-f">
                <div class="col-md-5">
                  <p class="formu-letra">Placa</p>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">Lotação</p>
                </div>
                <div class="col-md-2">
                  <p class="formu-letra">Ano</p>
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
                      <p class="letra-fi "><?php print $row["placa"];?></p>
                    </div>
                    <div class="col-md-3">
                      <p class="letra-fi "><?php print $row["lotacao"];?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi "><?php print $row["ano"];?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi">
                        <a href="cad_ajudante.php?acao=ALTERAR&id=<?php print $row["placa"];?>"><button class="btn-alterar glyphicon glyphicon-pencil" id="manu-veiculo"></button></a>
                        <a href="cad_ajudante.php?acao=DELETAR&id=<?php print $row["placa"];?>"><button  id="dele-veiculo" class="btn-deletar glyphicon glyphicon-trash" ></button></a>
                        <a href="cad_ajudante.php?acao=DETALHES&id=<?php print $row["placa"];?>"><button class="btn-detalhes glyphicon glyphicon-plus" id="deta-veiculo"></button></a>
                      </p>
                    </div>
                  </div>
                <?php }?>
                </div>
          

              
            </div>         
          </div>

<?php include './inc/footer.php'; ?>