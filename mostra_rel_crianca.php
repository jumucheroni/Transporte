<?php include './inc/header.php';
include './inc/conexao.php'; 

$tipo = @$_POST["relatorio"];
$valor = @$_POST["valor"];

if ($tipo=='R'){
  $sql = "select Nome as Crianca from crianca where CPF_Responsavel = '".$valor."'";
  $rel_tipo = "Responsável ".$valor;
}
if ($tipo=='E'){
  $sql = "select c.Nome as Crianca from crianca as c,responsavel as r,escola as e where c.Numero_Identificacao_Escola=e.Numero_Identificacao and e.Nome like '%".$valor."%'";
  $rel_tipo = "Escola ".$valor;
}
if ($tipo=='P'){
  $sql = "select Nome as Crianca from crianca where Periodo = '".$valor."'";
  $rel_tipo = "Periodo ".$valor;
}
if ($tipo=='V'){
  $sql = "select c.Nome as Crianca, t.Tipo from crianca as c ,trecho as t,alvara as a where c.CPF_Responsavel=t.CPF_Responsavel and c.Nome=t.Nome_Crianca and t.n_alvara=a.Numero_Identificacao and a.Placa='".$valor."'";
  $rel_tipo = "Veículo ".$valor;
}

$result = $conexao->query($sql);

?>
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
              <div class="row imprime">
                <p class="titulo-formu imprime">Crianças do <?php print $rel_tipo;?>
                  <button class="btn-criar nao-imprime" id="print">Imprimir</button>
                </p>
              </div>
        
              <div class="row imprime">
                <table width="100%" style="border:none;">
                  <tr>
                    <td width="80%">
                      <p class="formu-letra">Nome</p>
                    </td>
                  <?php if ($tipo=="V"){ ?>
                    <td width="20%">
                      <p class="formu-letra">Tipo</p>
                    </td>
                  <?php } ?>
                </tr>
                <?php while ($row = @mysqli_fetch_array($result)){ ?>
                  <tr>
                    <td width="80%">
                      <p class="letra-fi "><?php print $row["Crianca"];?></p>
                    </td>
                     <?php if ($tipo=="V"){ ?>
                      <td width="20%">
                        <p class="letra-fi"><?php if($row["Tipo"]=='I') print "Ida"; else print "Volta";?></p>
                      </td>
                  <?php } ?>
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
