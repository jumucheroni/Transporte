<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
    include './inc/conexao.php';

      $acao = @$_POST["acao"];

      $cpf           = str_replace("-", "", @$_POST["cpf"]);
      $nome          = @$_POST["nome"];
      $rg            = str_replace("-", "", @$_POST["rg"]);
      $parentesco    = @$_POST["parentesco"];
      $telefone      = @$_POST["telefone"];
      if  ($telefone != "") {
        $telefone      = explode(";", $telefone); 
      }
      $logradouro    = @$_POST["logradouro"];
      $numero        = @$_POST["numero"];
      $bairro        = @$_POST["bairro"];
      $cep           = str_replace("-", "", @$_POST["cep"]);
      $complemento   = @$_POST["complemento"];
      $cidade        = @$_POST["cidade"];
      $estado        = @$_POST["estado"];

      $cpf = str_replace(".", "", $cpf);

      if ($acao=="SALVARCADASTRO"){

        $insertsql = "insert into responsavel (cpf,nome,parentesco,rg,logradouro, cep, numero, bairro, complemento,cidade,estado) values ('".$cpf."','".$nome."','".$parentesco."','".$rg."','".$logradouro."','".$cep."','".$numero."','".$bairro."','".$complemento."','".$cidade."','".$estado."')";
        $insertresult = $conexao->query($insertsql);

        for ($i=0;$i<sizeof($telefone); $i++) {
          $telefonesql = "insert into telefone (telefone,cpf_responsavel) values ('".$telefone[$i]."','".$cpf."')";
          $telefoneresult = $conexao->query($telefonesql);
        }
        if ($insertresult){
            $retorno = [
              'success' => true,
              'mensagem' => "Responsável cadastrado com sucesso!"
            ];
        }else{
            $retorno = [
              'success' => false,
              'mensagem' => "Erro ao cadastrar o Responsável!"
            ];
        }

    } 
    
    if ($acao =="SALVARUPDATE"){
          
          $updatesql = "update responsavel set nome = '".$nome."', logradouro = '".$logradouro."' , numero = '".$numero."' , bairro = '".$bairro."' , cep = '".$cep."' , complemento = '".$complemento."', rg = '".$rg."', parentesco = '".$parentesco."', cidade = '".$cidade."', estado = '".$estado."' where cpf='".$cpf."'";
          $updateresult = $conexao->query($updatesql);

          $deletetelefone = "delete from telefone where cpf_responsavel = '".$cpf."'";
          $telefonedelete = $conexao->query($deletetelefone);
          for ( $i=0;$i<sizeof($telefone); $i++) {
            if ($telefone[$i] != ""){
              $telefonesql = "insert into telefone (telefone,cpf_responsavel) values ('".$telefone[$i]."','".$cpf."')";
              $telefoneresult = $conexao->query($telefonesql);
            }
          }
          if ($updateresult){
              $retorno = [
                'success' => true,
                'mensagem' => "Responsável atualizado com sucesso!"
              ];
          }else{
            $retorno = [
              'success' => false,
              'mensagem' => "Erro ao atualizar o Responsável!"
            ];
          }
        } 

    if ($acao == "SALVARDELETE"){
      $select = "select cpf_responsavel from crianca where deletado = 'N' and cpf_responsavel=".$cpf."";
      $selectresult = $conexao->query($select);

      if ($selectresult->num_rows == 0) {       
          
        $deletesql = "update responsavel set deletado = 'S' where cpf = '".$cpf."'";
        $deleteresult = $conexao->query($deletesql);

        $deletetelefone = "update telefone set deletado = 'S' where cpf_responsavel = '".$cpf."'";
        $telefonedelete = $conexao->query($deletetelefone);

        if ($deleteresult){
            $retorno = [
                'success' => true,
                'mensagem' => "Responsável deletado com sucesso!"
              ];
        }else{
            $retorno = [
              'success' => false,
              'mensagem' => "Erro ao deletar o Responsável!"
            ];
        }
      } else {
         $retorno = [
              'success' => false,
              'mensagem' => "Erro ao deletar o Responsável! Responsável já possui crianças"
            ];
      }
    }

    echo json_encode($retorno);

 } ?>