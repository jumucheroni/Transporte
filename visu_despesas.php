<?php include './inc/header.php'; 
include './inc/conexao.php';
    $sql = "select g.id,g.data_gasto,g.valor_gasto,v.placa from gastos g, veiculo v where v.placa = g.placa_veiculo and g.deletado = 'N' ";
    $result = $conexao->query($sql);

?>

         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu">
                  Listagem de Despesas
                  <a href="cad_despesas.php?acao=CADASTRAR"><button class="btn-criar" id="novo-alvara">Nova Despesa</button></a>
              </p>
              
              <div class="row">
                <div class="caixa-f">
                <div class="col-md-4">
                  <p class="formu-letra">Data</p>
                </div>
                <div class="col-md-4">
                  <p class="formu-letra">Valor</p>
                </div>
                <div class="col-md-2">
                  <p class="formu-letra">Veiculo</p>
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
                      <p class="letra-fi "><?php print DbtoDt($row["data_gasto"]);?></p>
                    </div>
                    <div class="col-md-4">
                      <p class="letra-fi "><?php print $row["valor_gasto"];?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi "><?php print $row["placa"];?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi">
                        <a href="cad_despesas.php?acao=ALTERAR&id=<?php print $row["id"];?>"><button class="btn-alterar glyphicon glyphicon-pencil" id="manu-despesas"></button></a>
                        <a href="cad_despesas.php?acao=DELETAR&id=<?php print $row["id"];?>"><button class="btn-deletar glyphicon glyphicon-trash" id="dele-despesas"></button></a>
                        <a href="cad_despesas.php?acao=DETALHES&id=<?php print $row["id"];?>"><button class="btn-detalhes glyphicon glyphicon-plus" id="deta-despesas"></button></a>
                      </p>
                    </div>
                  </div>
                  <?php }?>
                </div>
          

              
            </div>         
          </div>
        </form>

<?php include './inc/footer.php'; ?>