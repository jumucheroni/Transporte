<?php 

include './inc/header.php';
include './inc/conexao.php'; 

  $mes                = @$_POST["mes"];
  $id_crianca       = @$_POST["crianca"];

  $primeirodia = date("Y")."-".$mes."-01";
  $ultimodia = date("Y")."-".$mes."-31";

  $acao               = @$_POST["acao"];

  $tipo = "";

  if ($acao == "GERARRECIBO") {

    $valorpagototal = 0;
 
     $sql = "Select r.nome as Responsavel,p.valor_pago,co.mensalidade,p.data_realizada_pgto,c.nome as Crianca, ct.periodo_conducao from crianca as c
     INNER JOIN responsavel r ON c.cpf_responsavel = r.cpf
     INNER JOIN contrato co ON co.id_crianca = c.id
     INNER JOIN pagamentos p ON p.id_contrato = co.id 
     INNER JOIN criancatrecho ct ON ct.id_contrato = co.id
     where 
        c.id='".$id_crianca."' and p.data_realizada_pgto between '".$primeirodia."' and '".$ultimodia."' and p.status in('F','P') 
      order by ct.periodo_conducao";

     $result = $conexao->query($sql);

     while( $row = @mysqli_fetch_array($result)){
      $responsavel = $row["Responsavel"];
      $mensalidade = $row["mensalidade"];
      $crianca     = $row["Crianca"];
      $data_realizada_pgto = $row["data_realizada_pgto"];
      $valorpagototal += $row["valor_pago"];
      if ($tipo==""){ 
       	if (($row["periodo_conducao"]=="im") || ($row["periodo_conducao"]=="it")){
       			$tipo="Ida";
       	}
      }
      if (($tipo=="") || ($tipo == "Ida")){
       	if (($row["periodo_conducao"]=="vm") || ($row["periodo_conducao"]=="vt")){
       		if ($tipo==""){
       			$tipo="Volta";
       		}else{
       			$tipo.="/Volta";
       		}
       	}
      }
    }
 }

 ?>

 <?php if ($valorpagototal) { ?>

         <div id="p1" class="row imprime">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
            	 <button class="btn-criar nao-imprime" id="print">Imprimir</button>
              <p class="titulo-formu">Recibo</p>
        
              <div class="row">
              	<p> Valor R$ <?php print $valorpagototal; ?></p>
              	<p> Recebemos de <?php print $responsavel; ?>, a importancia de <?php print $valorpagototal; ?> para pagamento de transporte escolar de <?php print $crianca; ?>.</p>
              	<p> O valor acima corresponde à mensalidade com vencimento em <?php print DbtoDt($data_realizada_pgto); ?> no trajeto de <?php print $tipo; ?>.</p>
              	<p> Por ser verdade firmo o presente.</p>
              	<p> Bauru, __ de _____________ de _____.</p>
              	<br>
              	<p> Assinatura: ___________________________</p>
              </div>
             </div>

             
<?php } else { ?>
    <div id="p1" class="row imprime">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
              <p class="titulo-formu">Recibo</p>
              <h1> Não existe recibo para o período solicitado </h1>
            </div>
          </div>
        

<?php  }include './inc/footer.php'; ?>

