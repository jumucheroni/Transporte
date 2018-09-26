<?php session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
    include './inc/header.php'; 
    include './inc/conexao.php';
    $sql = "select t.id as id_trecho,t.tipo as Tipo,c.nome as Crianca,c.id as id_crianca,o.nome as Condutor,v.placa as Veiculo from criancatrecho ct
    inner join crianca c on c.id = ct.id_crianca
    inner join condutor o on o.cpf = ct.cpf_condutor
    inner join veiculo v on v.placa = ct.placa_veiculo
    inner join trecho t on t.id = ct.id_trecho
    where ct.deletado ='N' ";
    
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
                    <p class="formu-letra">Nome da Criança</p>
                  </div>
                  <div class="col-md-3">
                    <p class="formu-letra">Veiculo</p>
                  </div>
                  <div class="col-md-2">
                    <p class="formu-letra">Contudor</p>
                  </div>
                  <div class="col-md-2">
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
                      <p class="letra-fi "><?php print $row["Crianca"];?></p>
                    </div>
                    <div class="col-md-3">
                      <p class="letra-fi "><?php print $row["Veiculo"];?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi "><?php print $row["Condutor"];?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi "><?php if($row["Tipo"]=='im') print "Ida-Manhã"; if($row["Tipo"]=='vm') print "Volta-Manhã"; if($row["Tipo"]=='it') print "Ida-Tarde"; if($row["Tipo"]=='vt') print "Volta-Tarde"; ?>
                      </p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi">
                      <!-- não posso alterar nem deletar se tiver em um contrato -->
                        <a href="cad_trecho.php?acao=ALTERAR&id_trecho=<?php print $row["id_trecho"];?>&id_crianca=<?php print $row["id_crianca"];?>"><button class="btn-alterar glyphicon glyphicon-pencil" id="manu-trecho"></button></a>
                        <a href="cad_trecho.php?acao=DELETAR&id_trecho=<?php print $row["id_trecho"];?>&id_crianca=<?php print $row["id_crianca"];?>"><button class="btn-deletar glyphicon glyphicon-trash" id="dele-trecho"></button></a>
                        <a href="cad_trecho.php?acao=DETALHES&id_trecho=<?php print $row["id_trecho"];?>&id_crianca=<?php print $row["id_crianca"];?>"><button class="btn-detalhes glyphicon glyphicon-plus" id="deta-trecho"></button></a>
                      </p>
                    </div>
                  </div>
                  <?php }?>
                </div>
          

              
            </div>         
          </div>
<?php include './inc/footer.php'; ?>
<script src="js/trecho.js"></script>
<?php }?>