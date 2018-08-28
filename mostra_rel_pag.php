<?php include './inc/header.php';
include './inc/conexao.php'; 

$tipo = @$_POST["relatorio"];
$valor = @$_POST["valor"];

if ($tipo == "D"){
  $valorbanco = DtToDB($valor);
  $sql = "select c.nome as Crianca ,r.nome as Responsavel,p.valor_pago as Valor,p.status as Status from crianca as c
  inner join responsavel as r on c.cpf_responsavel=r.cpf 
  inner join contrato as t on t.id_crianca = c.id
  inner join pagamentos as p on p.id_contrato = t.id 
  where p.data_realizada_pgto = '".$valorbanco."'";
  $result = $conexao->query($sql);
}
if ($tipo == "V"){
  $valorbanco = DtToDB($valor);
  $sql = "select c.nome as Crianca ,r.nome as Responsavel,p.valor_pago as Valor,p.status as Status from crianca as c
  inner join responsavel as r on c.cpf_responsavel=r.cpf 
  inner join contrato as t on t.id_crianca = c.id
  inner join pagamentos as p on p.id_contrato = t.id 
  where p.data_prevista_pgto = '".$valorbanco."'";
  $result = $conexao->query($sql);
}
if ($tipo == "S"){
  $sql = "select c.nome as Crianca ,r.nome as Responsavel,p.valor_pago as Valor,p.status as Status from crianca as c
  inner join responsavel as r on c.cpf_responsavel=r.cpf 
  inner join contrato as t on t.id_crianca = c.id
  inner join pagamentos as p on p.id_contrato = t.id 
  where p.status = '".$valor."'";
  $result = $conexao->query($sql);
}
if ($tipo == "C"){
  $sql = "select c.nome as Crianca ,r.nome as Responsavel,p.valor_pago as Valor,p.status as Status from crianca as c
  inner join responsavel as r on c.cpf_responsavel=r.cpf 
  inner join contrato as t on t.id_crianca = c.id
  inner join pagamentos as p on p.id_contrato = t.id 
  where c.nome like '%".$valor."%'";
  $result = $conexao->query($sql);
}

?>
         <div id="p1" class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">

              <p class="titulo-formu imprime">Pagamentos de <?php print $valor;?>
               <button class="btn-criar nao-imprime" id="print">Imprimir</button>

              </p>
        
              <div class="row imprime">
                <table width="100%" style="border:none;">
                  <tr>
                    <td width="30%">
                      <p class="formu-letra">Responsável</p>
                    </td>
                    <td width="30%">
                      <p class="formu-letra">Criança</p>
                    </td>
                    <td width="20%">
                      <p class="formu-letra">Valor Pago</p>
                    </td>
                    <td width="20%">
                      <p class="formu-letra">Status</p>
                    </td>
                </tr>
                <?php while ($row = @mysqli_fetch_array($result)){ ?>
                  <tr>
                    <td width="30%">
                      <p class="letra-fi "><?php print $row["Responsavel"];?></p>
                    </td>
                    <td width="30%">
                      <p class="letra-fi "><?php print $row["Crianca"];?></p>
                    </td>
                    <td width="20%">
                      <p class="letra-fi "><?php print $row["Valor"];?></p>
                    </td>
                    <td width="20%">
                      <p class="letra-fi "><?php if ($row["Status"] == 'N') print "Em Aberto"; if ($row["Status"] == 'A') print "Em Atraso"; if ($row["Status"] == 'F') print "Falta valor"; if ($row["Status"] == 'P') print "Pago";?></p>
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