<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) { 
    include './inc/conexao.php';

    $acao = @$_POST["acao"];

    $placa         = str_replace("-", "", @$_POST["placa"]);
    $marca         = @$_POST["marca"];
    $modelo        = @$_POST["modelo"];
    $ano           = @$_POST["ano"];
    $lotacao       = @$_POST["lotacao"];
    $cpf_ajudante  = @$_POST["cpf_ajudante"];

    if ($acao=="SALVARCADASTRO"){

        $insertsql = "insert into veiculo (placa,marca,modelo,ano,lotacao,cpf_ajudante) values ('".$placa."','".$marca."','".$modelo."','".$ano."',".$lotacao.",'".$cpf_ajudante."')";

        $insertresult = $conexao->query($insertsql);
        if ($insertresult){
          $retorno = [
              'success' => true,
              'mensagem' => "Veículo cadastrado com sucesso!"
          ];
        }else{
          $retorno = [
              'success' => false,
              'mensagem' => "Erro ao cadastrar o Veículo!"
          ];
        }

    }else if ($acao =="SALVARUPDATE"){
          
          $updatesql = "update veiculo set marca = '".$marca."', modelo = '".$modelo."', ano = '".$ano."', lotacao = ".$lotacao.", cpf_ajudante = '".$cpf_ajudante."' where placa='".$placa."'";
          $updateresult = $conexao->query($updatesql);
          if ($updateresult){
            $retorno = [
                'success' => true,
                'mensagem' => "Veículo atualizado com sucesso!"
            ];
          }else{
            $retorno = [
                'success' => false,
                'mensagem' => "Erro ao atualizar o Veículo!"
            ];
          }
        } 

    if ($acao == "SALVARDELETE"){
      $select = "select placa_veiculo from condutorveiculo where deletado = 'N' and placa_veiculo = '".$placa."'";
      $selectresult = $conexao->query($select);

      if ($selectresult->num_rows == 0) {
                
        $deletesql = "update veiculo set deletado = 'S' where placa = '".$placa."'";
        $deleteresult = $conexao->query($deletesql);
        if ($deleteresult){
            $retorno = [
                'success' => true,
                'mensagem' => "Veículo deletado com sucesso!"
            ];
          }else{
            $retorno = [
                'success' => false,
                'mensagem' => "Erro ao deletar o Veículo!"
            ];
          }
      } else {
        $retorno = [
            'success' => false,
            'mensagem' => "Erro ao deletar o Veículo! Veículo já associado a uma condução!"
        ];
      }
    }

    echo json_encode($retorno);
 } ?>