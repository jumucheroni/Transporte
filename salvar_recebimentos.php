<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {

    include './inc/header.php'; 
    include './inc/conexao.php';

      $acao = @$_POST["acao"];

      $id = @$_POST["id"];
      $valor_pago  = str_replace(",", ".", @$_POST["valor_pago"]);
      $datahoje    = DtToDb(@$_POST["data_pgto"]);

     if ($acao =="SALVARPAGAMENTO"){

        $selectsql = "select c.mensalidade from contrato c 
                      inner join pagamentos p on p.id_contrato = c.id and p.id=".$id;
        $result = $conexao->query($selectsql);
        $row = @mysqli_fetch_array($result);

        if ($valor_pago < $row["mensalidade"]) {
          $status = "F";
        } else {
          $status = "P";
        }

        $updatesql = "update pagamentos set data_realizada_pgto = '".$datahoje."', valor_pago = ".$valor_pago.", status =  '".$status."' where id = ".$id;
        $updateresult = $conexao->query($updatesql);

        if ($updateresult){
          $retorno = [
              'success' => true,
              'mensagem' => "Recebimento realizado com sucesso!"
          ];
        }else{
          $retorno = [
              'success' => false,
              'mensagem' => "Erro ao realizar o recebimento!"
          ];
        }
      } 

 ?>

<script src="js/recebimentos.js"></script>

<?php } ?>