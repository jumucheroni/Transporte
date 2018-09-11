<?php include './inc/header.php'; 
include './inc/conexao.php';
    $sql = "select c.nome,v.placa,cv.* from condutorveiculo cv
            inner join condutor c on c.cpf = cv.cpf_condutor
            inner join veiculo v on v.placa = cv.placa_veiculo
            where cv.deletado = 'N' ";
    $result = $conexao->query($sql);
?>
          
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu">
                  Listagem de Condução
                  <a href="cad_condveic.php?acao=CADASTRAR"><button class="btn-criar" id="novo-condveic">Nova Condução</button></a>
              </p>
              
              <div class="row">
                <div class="caixa-f">
                <div class="col-md-5">
                  <p class="formu-letra">Condutor</p>
                </div>
                <div class="col-md-3">
                  <p class="formu-letra">Veiculo</p>
                </div>
                <div class="col-md-2">
                  <p class="formu-letra">Periodo</p>
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
                      <p class="letra-fi "><?php print $row["nome"];?></p>
                    </div>
                    <div class="col-md-3">
                      <p class="letra-fi "><?php print $row["placa"];?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi "><?php if($row["periodo"]=='im') print "Ida-Manhã"; if($row["periodo"]=='vm') print "Volta-Manhã"; if($row["periodo"]=='it') print "Ida-Tarde"; if($row["periodo"]=='vt') print "Volta-Tarde"; ?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="letra-fi">
                         <a href="cad_condveic.php?acao=ALTERAR&id=<?php print $row["cpf_condutor"].'-'.$row["placa_veiculo"].'-'.$row["periodo"];?>"><button class="btn-alterar glyphicon glyphicon-pencil" id="manu-condutor"></button></a>
                         <a href="cad_condveic.php?acao=DELETAR&id=<?php print $row["cpf_condutor"].'-'.$row["placa_veiculo"].'-'.$row["periodo"];?>"><button class="btn-deletar glyphicon glyphicon-trash" id="dele-condutor"></button></a>
                        <a href="cad_condveic.php?acao=DETALHES&id=<?php print $row["cpf_condutor"].'-'.$row["placa_veiculo"].'-'.$row["periodo"];?>"><button class="btn-detalhes glyphicon glyphicon-plus" id="deta-condutor"></button></a>
                      </p>
                    </div>
                  </div>
                <?php }?>
                </div>
          

              
            </div>         
          </div>

<?php include './inc/footer.php'; ?>