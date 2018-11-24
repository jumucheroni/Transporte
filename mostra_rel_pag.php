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
      $sql = "select c.nome as Crianca ,r.nome as Responsavel,p.valor_pago as Valor,t.mensalidade,p.status as Status from crianca as c
      inner join responsavel as r on c.cpf_responsavel=r.cpf  and r.deletado='N'
      inner join contrato as t on t.id_crianca = c.id and t.deletado='N'
      inner join pagamentos as p on p.id_contrato = t.id and p.deletado='N'
      where p.data_realizada_pgto = '".$valorbanco."' and c.deletado='N'";
      $result = $conexao->query($sql);
      $rel_tipo = "pagos em ".$valor;
    }
    if ($tipo == "V"){
      $valorbanco = DtToDB($valor);
      $sql = "select c.nome as Crianca ,r.nome as Responsavel,p.valor_pago as Valor,t.mensalidade,p.status as Status from crianca as c
      inner join responsavel as r on c.cpf_responsavel=r.cpf and r.deletado='N'
      inner join contrato as t on t.id_crianca = c.id and t.deletado='N'
      inner join pagamentos as p on p.id_contrato = t.id and p.deletado='N'
      where p.data_prevista_pgto = '".$valorbanco."' and c.deletado='N'";
      $result = $conexao->query($sql);
      $rel_tipo = "vencidos em ".$valor;
    }
    if ($tipo == "S"){
      $val = @$_POST['val'];
        
        $whereperiodo = "";
        foreach ($val as $periodo) {
          $whereperiodo .= "'".$periodo."',";

          if ($periodo == 'N')
            $rel_tipo .= "em Aberto,";
          if ($periodo == 'A')
            $rel_tipo .= "em Atraso,";
          if ($periodo == 'F')
            $rel_tipo .= "Incompletos,";
          if ($periodo == 'P')
            $rel_tipo .= "Pagos,";
        }
        $tam = strlen($whereperiodo);
        $whereperiodo = substr($whereperiodo,0, $tam-1);
        $tamr = strlen($rel_tipo);
        $rel_tipo = substr($rel_tipo,0,$tamr-1);

        $sql = "select c.nome as Crianca ,r.nome as Responsavel,p.valor_pago as Valor,t.mensalidade,p.status as Status from crianca as c
        inner join responsavel as r on c.cpf_responsavel=r.cpf and r.deletado='N'
        inner join contrato as t on t.id_crianca = c.id and t.deletado='N'
        inner join pagamentos as p on p.id_contrato = t.id and p.deletado='N'
        where p.status in (".$whereperiodo.") and c.deletado='N'";

      $result = $conexao->query($sql);

    }
    if ($tipo == "C"){
      $cri = @$_POST['cri'];
        
        $whereperiodo = "";
        foreach ($cri as $periodo) {
          $whereperiodo .= $periodo.",";
        }
        $tam = strlen($whereperiodo);
        $whereperiodo = substr($whereperiodo,0, $tam-1);

      $sql = "select c.nome as Crianca ,r.nome as Responsavel,p.valor_pago as Valor,t.mensalidade,p.status as Status from crianca as c
      inner join responsavel as r on c.cpf_responsavel=r.cpf and r.deletado='N'
      inner join contrato as t on t.id_crianca = c.id and t.deletado='N'
      inner join pagamentos as p on p.id_contrato = t.id and p.deletado='N'
      where c.id in (".$whereperiodo.") and c.deletado='N'";
      $result = $conexao->query($sql);
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
                  <div class="col-lg-8">
                    <h3 class="page-header imprime">Pagamentos <?php print $rel_tipo;?></h3>
                  </div>
                  <div class="col-lg-4">
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
                      <p class="letra-fi "><?php if ($row['Valor'] > 0 ) {print $row["Valor"]; $total += $row["Valor"]; } else { print $row["mensalidade"]; $total += $row["mensalidade"];}?></p>
                    </td>
                    <td width="20%">
                      <p class="letra-fi "><?php if ($row["Status"] == 'N') print "Em Aberto"; if ($row["Status"] == 'A') print "Em Atraso"; if ($row["Status"] == 'F') print "Incompleto"; if ($row["Status"] == 'P') print "Pago";?></p>
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