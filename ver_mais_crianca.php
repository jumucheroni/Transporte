<?php include './inc/header.php';
include './inc/conexao.php'; 

$crianca = @$_GET["id"];

if ($crianca) {
  $sql = "select c.nome as crianca,c.cpf_responsavel,c.data_nascimento,r.nome as responsavel,e.nome as escola from crianca c
  inner join responsavel r on r.cpf = c.cpf_responsavel
  inner join escola e on e.id = c.id_escola
  where c.id = ". $crianca;

  $sqltrechos = "select ct.cpf_condutor,ct.placa_veiculo,ct.periodo_conducao, t.logradouro_origem,t.cep_origem,t.numero_origem,t.bairro_origem,t.complemento_origem,t.cidade_origem,t.estado_origem,t.logradouro_destino,t.cep_destino,t.numero_destino,t.bairro_destino,t.complemento_destino,t.cidade_destino,t.estado_destino from crianca c
  inner join trecho t
  inner join criancatrecho ct on c.id = ct.id_crianca and ct.id_trecho = t.id
  where c.id = ". $crianca;

}

$result = $conexao->query($sql);
$resultrecho = $conexao->query($sqltrechos);
$rowcrianca = @mysqli_fetch_array($result);

?>
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
              <div class="row imprime">
                <p class="titulo-formu imprime"><?php print $rowcrianca['crianca'];?>
                  <button class="btn-criar nao-imprime" id="print">Imprimir</button>
                </p>
              </div>
        
              <div class="row imprime">
                <table width="100%" style="border:none;">
                  <tr>
                    <td width="5%">
                      <p class="formu-letra">Nome</p>
                    </td>
                    <td width="5%">
                      <p class="formu-letra">Data de nascimento</p>
                    </td>
                    <td width="5%">
                      <p class="formu-letra">Cpf do responsável</p>
                    </td>
                    <td width="5%">
                      <p class="formu-letra">Responsável</p>
                    </td>
                    <td width="5%">
                      <p class="formu-letra">Escola</p>
                    </td>
                </tr>
                <tr>
                  <td width="5%">
                    <p class="letra-fi "><?php print $rowcrianca["crianca"];?></p>
                  </td>
                  <td width="5%">
                    <p class="letra-fi "><?php print DbtoDt($rowcrianca["data_nascimento"]);?></p>
                  </td>
                  <td width="5%">
                    <p class="letra-fi "><?php print $rowcrianca["cpf_responsavel"];?></p>
                  </td>
                  <td width="5%">
                    <p class="letra-fi "><?php print $rowcrianca["responsavel"];?></p>
                  </td>
                  <td width="5%">
                    <p class="letra-fi "><?php print $rowcrianca["escola"];?></p>
                  </td>
                </tr>
              </table>  
              <div id="trechos_crianca">
             <?php while ($row = @mysqli_fetch_array($resultrecho)){ ?>  
                <hr>
                <div class="row">
                    <div class="col-md-3">
                      <p class="formu-letra"><?php print $row['cpf_condutor']; ?></p>
                    </div>
                    <div class="col-md-7">
                      <p class="formu-letra"><?php print $row['placa_veiculo']; ?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="formu-letra"><?php if($row['periodo_conducao']=='im') print "Ida-Manhã"; if($row['periodo_conducao']=='vm') print "Volta-Manhã"; if($row['periodo_conducao']=='it') print "Ida-Tarde"; if($row['periodo_conducao']=='vt') print "Volta-Tarde"; ?></p>
                    </div>
                </div> 
                  <div class="row">
                    <div class="col-md-3">
                      <p class="formu-letra"><?php print $row['cep_origem']; ?></p>
                    </div>
                    <div class="col-md-7">
                      <p class="formu-letra"><?php print $row['logradouro_origem']; ?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="formu-letra"><?php print $row['numero_origem']; ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                      <p class="formu-letra"><?php print $row['bairro_origem']; ?></p>
                    </div>
                    <div class="col-md-3">
                      <p class="formu-letra"><?php print $row['complemento_origem']; ?></p>
                    </div>
                    <div class="col-md-3">
                     <p class="formu-letra"><?php print $row['estado_origem']; ?></p>
                    </div>
                    <div class="col-md-3">
                      <p class="formu-letra"><?php print $row['cidade_origem']; ?></p>
                    </div>
                </div>  

                <div class="row">
                    <div class="col-md-3">
                      <p class="formu-letra"><?php print $row['cep_destino']; ?></p>
                    </div>
                    <div class="col-md-7">
                      <p class="formu-letra"><?php print $row['logradouro_destino']; ?></p>
                    </div>
                    <div class="col-md-2">
                      <p class="formu-letra"><?php print $row['numero_destino']; ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                      <p class="formu-letra"><?php print $row['bairro_destino']; ?></p>
                    </div>
                    <div class="col-md-3">
                      <p class="formu-letra"><?php print $row['complemento_destino']; ?></p>
                    </div>
                    <div class="col-md-3">
                     <p class="formu-letra"><?php print $row['estado_destino']; ?></p>
                    </div>
                    <div class="col-md-3">
                      <p class="formu-letra"><?php print $row['cidade_destino']; ?></p>
                    </div>
                </div>  
              <?php } ?>
              </div>       
            </div>         
          </div>

<?php include './inc/footer.php'; ?>


  <script type="text/javascript">
    $(document).ready(function(){
      $("#print").click(function(){
        window.print();
      });
    });

  </script>
