<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {

    include './inc/conexao.php';

      $acao = @$_POST["acao"];

      $n_ident       = @$_POST["id"];
      $nome          = @$_POST["nome"];
      $tipo          = @$_POST["tipo"];
      $logradouro    = @$_POST["logradouro"];
      $numero        = @$_POST["numero"];
      $bairro        = @$_POST["bairro"];
      $cep           =  str_replace("-", "", @$_POST["cep"]);
      $complemento   = @$_POST["complemento"];
      $estado        = @$_POST["estado"];
      $cidade        = @$_POST["cidade"];
      $emanha        = @$_POST['e-manha'];
      $smanha        = @$_POST['s-manha'];
      $etarde        = @$_POST['e-tarde'];
      $starde        = @$_POST['s-tarde'];

    if ($acao=="SALVARCADASTRO"){

        $insertsql = "insert into escola (nome, tipo, logradouro, numero, bairro, cep, complemento, cidade, estado, entrada_manha, saida_manha, entrada_tarde, saida_tarde) values ('".$nome."','".$tipo."','".$logradouro."','".$numero."','".$bairro."','".$cep."','".$complemento."','".$cidade."','".$estado."','".$emanha."','".$smanha."','".$etarde."','".$starde."')";
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
          
          $updatesql = "update escola set nome = '".$nome."', tipo = '".$tipo."', logradouro = '".$logradouro."' , numero = '".$numero."' , bairro = '".$bairro."' , cep = '".$cep."' , complemento = '".$complemento."' , estado = '".$estado."' , cidade = '".$cidade."' , entrada_manha = '".$emanha."' , saida_manha = '".$smanha."' , entrada_tarde = '".$etarde."' , saida_tarde = '".$starde."' where id='".$n_ident."'";
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

