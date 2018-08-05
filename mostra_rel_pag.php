<?php include './inc/header.php';
include './inc/conexao.php'; 

$valor = @$_POST["valor"];

$sql = "select c.Nome as Crianca ,r.Nome as Responsavel,c.Mensalidade as Valor from crianca as c,responsavel as r where c.CPF_Responsavel=r.CPF and  c.Dia_Pagamento= '".$valor."'";
$result = $conexao->query($sql);

?>
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu imprime">Pagamentos do dia <?php print $valor;?>
               <button class="btn-criar nao-imprime" id="print">Imprimir</button>

              </p>
        
              <div class="row imprime">
                <table width="100%" style="border:none;">
                  <tr>
                    <td width="40%">
                      <p class="formu-letra">Responsável</p>
                    </td>
                    <td width="40%">
                      <p class="formu-letra">Criança</p>
                    </td>
                    <td width="20%">
                      <p class="formu-letra">Valor</p>
                    </td>
                </tr>
                <?php while ($row = @mysqli_fetch_array($result)){ ?>
                  <tr>
                    <td width="40%">
                      <p class="letra-fi "><?php print $row["Responsavel"];?></p>
                    </td>
                    <td width="40%">
                      <p class="letra-fi "><?php print $row["Crianca"];?></p>
                    </td>
                    <td width="20%">
                      <p class="letra-fi "><?php print $row["Valor"];?></p>
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