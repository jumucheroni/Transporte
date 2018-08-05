<?php include './inc/header.php'; 
include './inc/conexao.php';
    $sql = "select t.Numero_Identificacao,t.Tipo,c.Nome as Crianca,t.N_Alvara as Alvara from crianca c, alvara a, trecho t where c.CPF_Responsavel=t.CPF_Responsavel and c.Nome=t.Nome_Crianca and a.Numero_Identificacao=t.N_Alvara";
    
    $result = $conexao->query($sql);
?>

        <input type="hidden" name="acao" value="" />
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu">
                  Listagem de Transporte
                  <a href="cad_trecho.php?acao=CADASTRAR"><button class="btn-criar" id="novo-alvara">Novo Transporte</button></a>
              </p>
              
              <div class="row">
                <div class="caixa-f">
                <div class="col-md-3">
                  <p class="formu-letra">Número Identificação</p>
                </div>
                <div class="col-md-4">
                  <p class="formu-letra">Nome da Criança</p>
                </div>
                <div class="col-md-2">
                  <p class="formu-letra">Alvará</p>
                </div>
                <div class="col-md-1">
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
                      <p class="letra-fi "><?php print $row["Numero_Identificacao"];?></p>
                    </div>
                    <div class="col-md-4">
                      <p class="letra-fi "><?php print $row["Crianca"];?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi "><?php print $row["Alvara"];?></p>
                    </div>
                    <div class="col-md-1">
                      <p class="letra-fi "><?php if($row["Tipo"]=='I') print "Ida"; else print "Volta";?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi">
                        <a href="cad_trecho.php?acao=ALTERAR&id=<?php print $row["Numero_Identificacao"];?>"><button class="btn-alterar glyphicon glyphicon-pencil" id="manu-trecho"></button></a>
                        <a href="cad_trecho.php?acao=DELETAR&id=<?php print $row["Numero_Identificacao"];?>"><button class="btn-deletar glyphicon glyphicon-trash" id="dele-trecho"></button></a>
                        <a href="cad_trecho.php?acao=DETALHES&id=<?php print $row["Numero_Identificacao"];?>"><button class="btn-detalhes glyphicon glyphicon-plus" id="deta-trecho"></button></a>
                      </p>
                    </div>
                  </div>
                  <?php }?>
                </div>
          

              
            </div>         
          </div>
<?php include './inc/footer.php'; ?>