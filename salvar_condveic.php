<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
    include './inc/header.php'; 
    include './inc/conexao.php';

    if (!$acao){
      $acao = @$_POST["acao"];
    }

    $veiculo        = @$_POST["veiculo"];
    $condutor       = @$_POST["condutor"];
    $periodo        = @$_POST["periodo"];

    if ($acao=="SALVARCADASTRO"){

        $selectsql = "select placa_veiculo,cpf_condutor,periodo from condutorveiculo where placa_veiculo = '".$veiculo."' and cpf_condutor = '".$condutor."' and periodo ='".$periodo."' and deletado = 'N' ";
        $selectsqlresult = $conexao->query($selectsql);

        if ($selectsqlresult->num_rows > 0) {
          $retorno = [
              'success' => false,
              'mensagem' => "Condução já está cadastrada!"
          ];
        } else {
          $insertsql = "insert into condutorveiculo (placa_veiculo,cpf_condutor,periodo) values ('".$veiculo."','".$condutor."','".$periodo."')";
          $insertresult = $conexao->query($insertsql);
          if ($insertresult){
              $retorno = [
                  'success' => true,
                  'mensagem' => "Condução cadastrado com sucesso!"
              ];
          }else{
              $retorno = [
                  'success' => false,
                  'mensagem' => "Erro ao cadastrar o Condução!"
              ];
          }
        }

    }

    if ($acao =="SALVARUPDATE"){
          
          $updatesql = "update condutorveiculo set periodo = '".$periodo."' where placa_veiculo='".$veiculo."' and cpf_condutor='".$condutor."'";
          $updateresult = $conexao->query($updatesql);
          if ($updateresult){
            $retorno = [
                'success' => true,
                'mensagem' => "Condução atualizada com sucesso!"
            ];
          }else{
              $retorno = [
                  'success' => false,
                  'mensagem' => "Erro ao atualizar a Condução!"
              ];
          }
    } 

    if (!$veiculo && !$condutor) {
      $conducao = @$_GET["id"];
      if ($conducao){
      	$conducao = explode("-", $conducao);
      	$veiculo = $conducao[1];
      	$condutor = $conducao[0]; 
        $periodo = $conducao[2];
      }
    }

    if ($acao == "SALVARDELETE"){
      
      $select = "select cpf_condutor,placa_veiculo,periodo_conducao from criancatrecho where deletado = 'N' and placa_veiculo='".$veiculo."' and cpf_condutor='".$condutor."' and periodo_conducao='".$periodo."'";
      $selectresult = $conexao->query($select);

      if ($selectresult->num_rows == 0) { 
        $deletesql = "update condutorveiculo set deletado = 'S' where placa_veiculo='".$veiculo."' and cpf_condutor='".$condutor."' and periodo='".$periodo."'";
        $deleteresult = $conexao->query($deletesql);
        if ($deleteresult){
            $retorno = [
                'success' => true,
                'mensagem' => "Condução deletada com sucesso!"
            ];
        }else{
            $retorno = [
                'success' => false,
                'mensagem' => "Erro ao deletar a Condução!"
            ];
        }
      } else {
          $retorno = [
              'success' => false,
              'mensagem' => "Erro ao deletar a Condução! Condução já associada a transportes"
          ];
      }
    }

    echo json_encode($retorno);

?>
