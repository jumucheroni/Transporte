<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
    include './inc/header.php';
    include './inc/conexao.php'; 

    $tipo = @$_POST["relatorio"];
    $valor = @$_POST["valor"];

    if ($tipo == "D"){
      $valorbanco = DtToDB($valor);
      $sql = "select c.nome as Crianca ,r.nome as Responsavel,p.valor_pago as Valor,p.status as Status from crianca as c
      inner join responsavel as r on c.cpf_responsavel=r.cpf  and r.deletado='N'
      inner join contrato as t on t.id_crianca = c.id and t.deletado='N'
      inner join pagamentos as p on p.id_contrato = t.id and p.deletado='N'
      where p.data_realizada_pgto = '".$valorbanco."' and c.deletado='N'";
      $result = $conexao->query($sql);
      $rel_tipo = "pagos em ".$valor;
    }
    if ($tipo == "V"){
      $valorbanco = DtToDB($valor);
      $sql = "select c.nome as Crianca ,r.nome as Responsavel,p.valor_pago as Valor,p.status as Status from crianca as c
      inner join responsavel as r on c.cpf_responsavel=r.cpf and r.deletado='N'
      inner join contrato as t on t.id_crianca = c.id and t.deletado='N'
      inner join pagamentos as p on p.id_contrato = t.id and p.deletado='N'
      where p.data_prevista_pgto = '".$valorbanco."' and c.deletado='N'";
      $result = $conexao->query($sql);
      $rel_tipo = "vencidos em ".$valor;
    }
    if ($tipo == "S"){
      if ($valor){
        $sql = "select c.nome as Crianca ,r.nome as Responsavel,p.valor_pago as Valor,p.status as Status from crianca as c
        inner join responsavel as r on c.cpf_responsavel=r.cpf and r.deletado='N'
        inner join contrato as t on t.id_crianca = c.id and t.deletado='N'
        inner join pagamentos as p on p.id_contrato = t.id and p.deletado='N'
        where p.status = '".$valor."' and c.deletado='N'";
      } else {
        $sql = "select c.nome as Crianca ,r.nome as Responsavel,p.valor_pago as Valor,p.status as Status from crianca as c
        inner join responsavel as r on c.cpf_responsavel=r.cpf and r.deletado='N'
        inner join contrato as t on t.id_crianca = c.id and t.deletado='N'
        inner join pagamentos as p on p.id_contrato = t.id and p.deletado='N'
        where c.deletado='N'";
      }
      $result = $conexao->query($sql);

      if ($valor == 'N')
        $rel_tipo = "em Aberto";
      if ($valor == 'A')
        $rel_tipo = "em Atraso";
      if ($valor == 'F')
        $rel_tipo = "Falta Valor";
      if ($valor == 'P')
        $rel_tipo = "Pago";
      if ($valor == "") 
        $rel_tipo = " em todos os status";
    }
    if ($tipo == "C"){
      $sql = "select c.nome as Crianca ,r.nome as Responsavel,p.valor_pago as Valor,p.status as Status from crianca as c
      inner join responsavel as r on c.cpf_responsavel=r.cpf and r.deletado='N'
      inner join contrato as t on t.id_crianca = c.id and t.deletado='N'
      inner join pagamentos as p on p.id_contrato = t.id and p.deletado='N'
      where c.nome like '%".$valor."%' and c.deletado='N'";
      $result = $conexao->query($sql);
      $rel_tipo = "de ".$valor;
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
          <li class="active">Pagamentos</li>
        </ol>
      </div>
         <div class="row">
              <div class="col-xs-12 col-md-10 col-md-offset-1">
                <div class="row imprime">
                  <div class="col-lg-6">
                    <h1 class="page-header imprime">Pagamentos <?php print $rel_tipo;?></h1>
                  </div>
                  <div class="col-lg-6">
                    <button class="btn-criar nao-imprime" id="print">Imprimir</button>
                  </div>
                </div>
        
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
                      <p class="letra-fi "><?php print $row["Valor"]; $total += $row["Valor"];?></p>
                    </td>
                    <td width="20%">
                      <p class="letra-fi "><?php if ($row["Status"] == 'N') print "Em Aberto"; if ($row["Status"] == 'A') print "Em Atraso"; if ($row["Status"] == 'F') print "Falta valor"; if ($row["Status"] == 'P') print "Pago";?></p>
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