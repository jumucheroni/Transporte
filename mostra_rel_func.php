<?php include './inc/header.php';
include './inc/conexao.php'; 

$valor = @$_POST["valor"];

$sql = "select c.Nome as Condutor ,a.Nome as Ajudante,v.Lotacao as Lotacao from condutor as c,ajudante as a, veiculo as v, alvara as l where v.placa='".$valor."' and v.CPF_Ajudante=a.CPF and l.placa=v.placa and l.CPF_Condutor=c.CPF";
$result = $conexao->query($sql);


?>
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu imprime">Funcionários do veículo <?php print $valor;?>
                <button class="btn-criar nao-imprime" id="print">Imprimir</button>

              </p>
        
              <div class="row imprime">
                <table width="100%" style="border:none;">
                  <tr>
                    <td width="40%">
                      <p class="formu-letra">Condutor</p>
                    </td>
                    <td width="40%">
                      <p class="formu-letra">Ajudante</p>
                    </td>
                    <td width="20%">
                      <p class="formu-letra">Lotação</p>
                    </td>
                  </tr>
                <?php while ($row = @mysqli_fetch_array($result)){ ?>
                  <tr>
                    <td width="40%">
                      <p class="letra-fi "><?php print $row["Condutor"];?></p>
                    </td>
                    <td width="40%">
                      <p class="letra-fi "><?php print $row["Ajudante"];?></p>
                    </td>
                    <td width="20%">
                      <p class="letra-fi "><?php print $row["Lotacao"];?></p>
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