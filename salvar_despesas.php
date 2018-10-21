<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
    include './inc/conexao.php';

      $acao = @$_POST["acao"];

      $id             = @$_POST["id"];
      $placa_veiculo  = @$_POST["placa_veiculo"];
      $data_gasto     = DtToDb(@$_POST["data_gasto"]);
      $valor_gasto    = str_replace(",", ".", @$_POST["valor_gasto"]);
      $tipo           = @$_POST["tipo"];
      $observacao     = @$_POST["observacao"];

    if ($acao=="SALVARCADASTRO"){

        $insertsql = "insert into gastos (placa_veiculo,data_gasto,valor_gasto,tipo,observacao) values ('".$placa_veiculo."','".$data_gasto."',".$valor_gasto.",'".$tipo."','".$observacao."')";
        $insertresult = $conexao->query($insertsql);
        if ($insertresult){
          $retorno = [
              'success' => true,
              'mensagem' => "Despesa cadastrada com sucesso!"
            ];
        }else{
            $retorno = [
              'success' => false,
              'mensagem' => "Erro ao cadastrar Despesa!"
            ];
        }

    }
    if ($acao =="SALVARUPDATE"){
          
          $updatesql = "update gastos set placa_veiculo = '".$placa_veiculo."',data_gasto = '".$data_gasto."',valor_gasto = ".$valor_gasto.",tipo = '".$tipo."',observacao = '".$observacao."' where id = ".$id;
          $updateresult = $conexao->query($updatesql);
          if ($updateresult){
            $retorno = [
              'success' => true,
              'mensagem' => "Despesa atualizada com sucesso!"
            ];
          }else{
            $retorno = [
              'success' => false,
              'mensagem' => "Erro ao atualizar Despesa!"
            ];
          }
    } 

    if ($acao == "SALVARDELETE"){
          
      $deletesql = "update gastos set deletado = 'S' where id = ".$id;
      $deleteresult = $conexao->query($deletesql);
      if ($deleteresult){
        $retorno = [
              'success' => true,
              'mensagem' => "Despesa deletada com sucesso!"
        ];
      }else{
        $retorno = [
              'success' => false,
              'mensagem' => "Erro ao deletar despesa!"
        ];
      }
    }

      echo json_encode($retorno);
 } ?>