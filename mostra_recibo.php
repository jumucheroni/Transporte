<?php 

include './inc/header.php';
include './inc/conexao.php'; 

  $cpf_responsavel    = @$_POST["cpf_responsavel"];
  $mes                = @$_POST["mes"];
  $nome_crianca       = @$_POST["nome"];
 
 $sql = "Select r.Nome as Responsavel,c.Mensalidade,c.Dia_Pagamento,c.Nome as Crianca from crianca as c, responsavel as r where r.CPF=c.CPF_Responsavel and c.CPF_Responsavel='".$cpf_responsavel."' and c.Nome='".$nome_crianca."'";

 $result = $conexao->query($sql);
 $row = @mysqli_fetch_array($result);

 $trecho = "select Tipo from Trecho where CPF_Responsavel='".$cpf_responsavel."' and Nome_Crianca='".$nome_crianca."' order by Tipo";
 $trechoresult = $conexao->query($trecho);
 $tipo = "";
 while( $trechorow = @mysqli_fetch_array($trechoresult)){
 	if ($trechorow["Tipo"]=="I"){
 			$tipo.="Ida";
 	}
 	if ($trechorow["Tipo"]=="V"){
 		if ($tipo==""){
 			$tipo.="Volta";
 		}else{
 			$tipo.="/Volta";
 		}
 	}
 }

 ?>

         <div id="p1" class="row imprime">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
            	 <button class="btn-criar nao-imprime" id="print">Imprimir</button>
              <p class="titulo-formu">Recibo</p>
        
              <div class="row">
              	<p> Valor R$ <?php print $row["Mensalidade"]; ?></p>
              	<p> Recebemos de <?php print $row["Responsavel"]; ?>, a importancia de <?php print $row["Mensalidade"]; ?> para pagamento de transporte escolar de <?php print $row["Crianca"]; ?>.</p>
              	<p> O valor acima corresponde à mensalidade com vencimento em <?php print $row["Dia_Pagamento"]."/".$mes."/".date('Y'); ?> no trajeto de <?php print $tipo; ?>.</p>
              	<p> Por ser verdade firmo o presente.</p>
              	<p> Bauru, __ de _____________ de _____.</p>
              	<br>
              	<p> Assinatura: ___________________________</p>
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