<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {

    include './inc/header.php'; 
    include './inc/conexao.php';

      $acao = @$_POST["acao"];

      $n_ident       = @$_POST["n_ident"];
      $nome          = @$_POST["nome"];
      $tipo          = @$_POST["tipo"];
      $logradouro    = @$_POST["logradouro"];
      $numero        = @$_POST["numero"];
      $bairro        = @$_POST["bairro"];
      $cep           =  str_replace("-", "", @$_POST["cep"]);
      $complemento   = @$_POST["complemento"];
      $estado        = @$_POST["estado"];
      $cidade        = @$_POST["cidade"];

    if ($acao=="SALVARCADASTRO"){

        $insertsql = "insert into escola (nome,tipo,logradouro, numero, bairro, cep, complemento,cidade,estado) values ('".$nome."','".$tipo."','".$logradouro."','".$numero."','".$bairro."','".$cep."','".$complemento."','".$cidade."','".$estado."')";
        $insertresult = $conexao->query($insertsql);

        if ($insertresult){
          $retorno = [
              'success' => true,
              'mensagem' => "Escola cadastrada com sucesso!"
            ];
        }else{
            $retorno = [
              'success' => false,
              'mensagem' => "Erro ao cadastrar a Escola!"
            ];
        }

    }
    if ($acao =="SALVARUPDATE"){
          
          $updatesql = "update escola set nome = '".$nome."', tipo = '".$tipo."', logradouro = '".$logradouro."' , numero = '".$numero."' , bairro = '".$bairro."' , cep = '".$cep."' , complemento = '".$complemento."' , estado = '".$estado."' , cidade = '".$cidade."' where id='".$n_ident."'";
          $updateresult = $conexao->query($updatesql);

          if ($updateresult){
            $retorno = [
              'success' => true,
              'mensagem' => "Escola atualizada com sucesso!"
            ];
          }else{
            $retorno = [
              'success' => false,
              'mensagem' => "Erro ao atualizar a Escola!"
            ];
          }
        } 

    if ($acao == "SALVARDELETE"){
      $select = "select id_escola from crianca where deletado = 'N' and id_escola=".$n_ident."";
      $selectresult = $conexao->query($select);

      if ($selectresult->num_rows == 0) {         
      
        $deletesql = "update escola set deletado = 'S' where id = '".$n_ident."'";
        $deleteresult = $conexao->query($deletesql);
        if ($deleteresult){
            $retorno = [
              'success' => true,
              'mensagem' => "Escola deletada com sucesso!"
            ];
        }else{
            $retorno = [
              'success' => false,
              'mensagem' => "Erro ao deletar a Escola!"
            ];
        }
      } else {
        $retorno = [
              'success' => false,
              'mensagem' => "Erro ao deletar a Escola! Escola já possui crianças"
            ];
      }
    }

    echo json_encode($retorno);
 } ?>

