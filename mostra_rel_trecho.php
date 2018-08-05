<?php include './inc/header.php';
include './inc/conexao.php'; 

$valor = @$_POST["valor"];

$sql = "select e.Logradouro as Escola ,r.Logradouro as Responsavel,t.Tipo,c.Nome as Crianca from crianca as c,escola as e,responsavel as r,trecho as t where (t.n_alvara in (select Numero_Identificacao from alvara where Placa='".$valor."')) and c.CPF_Responsavel=t.CPF_Responsavel and c.Nome=t.Nome_Crianca and c.CPF_Responsavel=r.CPF and e.Numero_Identificacao=c.Numero_Identificacao_Escola";
$result = $conexao->query($sql);


?>
         <div id="p1" class="row ">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu imprime">Transportes do veículo <?php print $valor;?>
                <button class="btn-criar nao-imprime" id="print">Imprimir</button>

              </p>
        
              <div class="row imprime">
                <table width="100%" style="border:none;">
                  <tr>
                    <td width="33%">
                      <p class="formu-letra">Origem</p>
                    </td>
                    <td width="33%">
                      <p class="formu-letra">Destino</p>
                    </td>
                    <td width="34%">
                      <p class="formu-letra">Criança</p>
                    </td>
                  </tr>
                <?php while ($row = @mysqli_fetch_array($result)){ ?>
                   <tr>
                    <td width="33%">
                      <p class="letra-fi "><?php if ($row["Tipo"]=="I") print $row["Responsavel"]; else print $row["Escola"];?></p>
                    </td>
                    <td width="33%">
                      <p class="letra-fi "><?php if ($row["Tipo"]=="I") print $row["Escola"]; else print $row["Responsavel"];?></p>
                    </td>
                    <td width="34%">
                      <p class="letra-fi "><?php print $row["Crianca"];?></p>
                    </td>
                  </tr>
                <?php } ?>
              </table>              
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