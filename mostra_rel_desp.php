<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
    include './inc/header.php';
    include './inc/conexao.php'; 

    $tipo = @$_POST["relatorio"];
    $valor = @$_POST["valor"];

    if ($tipo == "D"){
      $valorbanco = DtToDB($valor);
      $sql = "select g.data_gasto,g.valor_gasto,g.tipo,g.placa_veiculo from gastos as g
      where g.data_gasto = '".$valorbanco."' and g.deletado='N'";
      $result = $conexao->query($sql);
      $rel_tipo = "pagas em ".$valor;
    }
    if ($tipo == "T"){
      if ($valor){
        $sql = "select g.data_gasto,g.valor_gasto,g.tipo,g.placa_veiculo from gastos as g
        where g.tipo = '".$valor."' and g.deletado='N'";
      } else {
        $sql = "select g.data_gasto,g.valor_gasto,g.tipo,g.placa_veiculo from gastos as g
        where g.deletado='N'";
      }
      $result = $conexao->query($sql);

      if ($valor == 'c')
        $rel_tipo = "de Combustível";
      if ($valor == 'i')
        $rel_tipo = "de IPVA";
      if ($valor == 'o')
        $rel_tipo = "de Oficina";
      if ($valor == "") 
        $rel_tipo = " de todos os tipos";

    }
    if ($tipo == "V"){
      $sql = "select g.data_gasto,g.valor_gasto,g.tipo,g.placa_veiculo from gastos as g
      where g.placa_veiculo = '".$valor."' and g.deletado='N'";
      $result = $conexao->query($sql);
      $rel_tipo = "do veículo ".$valor;
    }
    $total = 0;
?>
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu imprime">Despesas <?php print $rel_tipo;?>
               <button class="btn-criar nao-imprime" id="print">Imprimir</button>

              </p>
        
              <div class="row imprime">
                <table width="100%" style="border:none;">
                  <tr>
                    <td width="30%">
                      <p class="formu-letra">Data</p>
                    </td>
                    <td width="20%">
                      <p class="formu-letra">Valor Pago</p>
                    </td>
                    <td width="20%">
                      <p class="formu-letra">Tipo</p>
                    </td>
                    <td width="30%">
                      <p class="formu-letra">Veículo</p>
                    </td>
                </tr>
                <?php while ($row = @mysqli_fetch_array($result)){ ?>
                  <tr>
                    <td width="30%">
                      <p class="letra-fi "><?php print DbtoDt($row["data_gasto"]);?></p>
                    </td>
                    <td width="20%">
                      <p class="letra-fi "><?php print $row["valor_gasto"];  $total += $row["valor_gasto"];?></p>
                    </td>
                    <td width="20%">
                      <p class="letra-fi "><?php if ($row["tipo"] == 'c') print "Combustível"; if ($row["tipo"] == 'i') print "IPVA"; if ($row["tipo"] == 'o') print "Oficina";?></p>
                    </td>
                    <td width="30%">
                      <p class="letra-fi "><?php print $row["placa_veiculo"];?></p>
                    </td>
                  </tr>
                <?php } ?>
              </table> 
              <table  width="10%">
                  <tr>
                    <td width="5%">
                      <p class="formu-letra">Total</p>
                    </td>
                    <td width="5%">
                      <p class="formu-letra"><?php print $total;?></p>
                    </td>
                  </tr>
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

<?php } ?>