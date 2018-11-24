<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
    include './inc/header.php';
    include './inc/conexao.php'; 

    $tipo = @$_POST["relatorio"];
    $valor = @$_POST["valor"];
    $rel_tipo = "";

    if ($tipo == "D"){
      $valorbanco = DtToDB($valor);
      $sql = "select g.data_gasto,g.valor_gasto,g.tipo,g.placa_veiculo from gastos as g
      where g.data_gasto = '".$valorbanco."' and g.deletado='N'";
      $result = $conexao->query($sql);
      $rel_tipo = "pagas em ".$valor;
    }
    if ($tipo == "T"){
      $val = @$_POST['val'];
        
        $whereperiodo = "";
        foreach ($val as $periodo) {
          $whereperiodo .= "'".$periodo."',";

          if ($periodo == 'c')
            $rel_tipo .= "de Combustível,";
          if ($periodo == 'i')
            $rel_tipo .= "de IPVA,";
          if ($periodo == 'o')
            $rel_tipo .= "de Oficina,";
        }

        $tam = strlen($whereperiodo);
        $whereperiodo = substr($whereperiodo,0, $tam-1);
        $tamr = strlen($rel_tipo);
        $rel_tipo = substr($rel_tipo,0,$tamr-1);

        $sql = "select g.data_gasto,g.valor_gasto,g.tipo,g.placa_veiculo from gastos as g
        where g.tipo in (".$whereperiodo.") and g.deletado='N'";
    
      $result = $conexao->query($sql);

    }
    if ($tipo == "V"){
      $sql = "select g.data_gasto,g.valor_gasto,g.tipo,g.placa_veiculo from gastos as g
      where g.placa_veiculo like '%".$valor."%' and g.deletado='N'";
      $result = $conexao->query($sql);
      $rel_tipo = "do veículo ".$valor;
    }
    $total = 0;
?>
   <div class="row">
      <div class="row">
        <ol class="breadcrumb">
          <li><a href="index.php">
            <em class="fa fa-home"></em>
          </a></li>
          <li class="active">Relatorio</li>
          <li class="active">Despesas</li>
        </ol>
      </div>
         <div class="row">
              <div class="col-xs-12 col-md-10 col-md-offset-1">
                <div class="row imprime">
                  <div class="col-lg-6">
                    <h3 class="page-header imprime">Despesas <?php print $rel_tipo;?></h3>
                  </div>
                  <div class="col-lg-6">
                    <button class="btn-criar nao-imprime" id="print">Imprimir</button>
                  </div>
                </div>
        
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
                      <p class="formu-letra">Total </p>
                    </td>
                    <td width="5%">
                      <p class="formu-letra"><?php print $total;?></p>
                    </td>
                  </tr>
              </table>                    
            </div>         
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

<?php } ?>