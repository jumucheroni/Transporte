<?php include './inc/header.php'; 
include './inc/conexao.php';
    $sql = "select c.id,a.nome,c.mensalidade,c.dia_vencimento_mensalidade from contrato c, crianca a where c.id_crianca = a.id and c.deletado = 'N' ";
    $result = $conexao->query($sql);

?>

         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu">
                  Listagem de Contrato
                  <a href="cad_contrato.php?acao=CADASTRAR"><button class="btn-criar" id="novo-alvara">Novo Contrato</button></a>
              </p>
              
              <div class="row">
                <div class="caixa-f">
                <div class="col-md-4">
                  <p class="formu-letra">Criança</p>
                </div>
                <div class="col-md-4">
                  <p class="formu-letra">Mensalidade</p>
                </div>
                <div class="col-md-2">
                  <p class="formu-letra">Vencimento</p>
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
                      <p class="letra-fi "><?php print $row["nome"];?></p>
                    </div>
                    <div class="col-md-4">
                      <p class="letra-fi "><?php print $row["mensalidade"];?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi "><?php print $row["dia_vencimento_mensalidade"];?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi">
                        <a href="cad_contrato.php?acao=ALTERAR&id=<?php print $row["id"];?>"><button class="btn-alterar glyphicon glyphicon-pencil" id="manu-contrato"></button></a>
                        <a href="cad_contrato.php?acao=DELETAR&id=<?php print $row["id"];?>"><button class="btn-deletar glyphicon glyphicon-trash" id="dele-contrato"></button></a>
                        <a href="cad_contrato.php?acao=DETALHES&id=<?php print $row["id"];?>"><button class="btn-detalhes glyphicon glyphicon-plus" id="deta-contrato"></button></a>
                      </p>
                    </div>
                  </div>
                  <?php }?>
                </div>
          

              
            </div>         
          </div>
        </form>

<?php include './inc/footer.php'; ?>