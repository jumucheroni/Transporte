<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {

    include './inc/conexao.php';

    $acao = @$_POST["acao"];

    $id                  = @$_POST["id"];
    $cpf_responsavel     = @$_POST["cpf_responsavel"];
    $nome                = @$_POST["nome"];
    $data_nascimento     = DtToDb(@$_POST["data_nascimento"]);
    $n_ident_escola      = @$_POST["n_ident_escola"];
    $nome_professor      = @$_POST["nome_professor"];

    if ($acao=="SALVARCADASTRO"){
        $insertsql = "insert into crianca (cpf_responsavel,nome,data_nascimento,id_escola,nome_professor) values ('".$cpf_responsavel."','".$nome."','".$data_nascimento."',".$n_ident_escola.",'".$nome_professor."')";
        $insertresult = $conexao->query($insertsql);
        if ($insertresult){
            $retorno = [
                'success' => true,
                'mensagem' => "Criança cadastrada com sucesso!"
            ];
        }else{
            $retorno = [
                'success' => false,
                'mensagem' => "Erro ao cadastrar a Criança!"
            ];
        }

    }

    if ($acao =="SALVARUPDATE"){
          
          $updatesql = "update crianca set cpf_responsavel='".$cpf_responsavel."', nome='".$nome."', data_nascimento = '".$data_nascimento."', id_escola= ".$n_ident_escola.", nome_professor = '".$nome_professor."' where id = ".$id;

          $updateresult = $conexao->query($updatesql);
          if ($updateresult){
            $retorno = [
                'success' => true,
                'mensagem' => "Criança atualizada com sucesso!"
            ];
          }else{
            $retorno = [
                'success' => false,
                'mensagem' => "Erro ao atualizar a Criança!"
            ];
          }
        } 

    if ($acao == "SALVARDELETE"){

      $select = "select id_crianca from criancatrecho where deletado = 'N' and id_crianca=".$id."";
      $selectresult = $conexao->query($select);

      if ($selectresult->num_rows == 0) { 
          
        $deletesql = "update crianca set deletado = 'S' where id = ".$id;
        $deleteresult = $conexao->query($deletesql);
        if ($deleteresult){
            $retorno = [
                'success' => true,
                'mensagem' => "Criança deletada com sucesso!"
            ];
        }else{
          $retorno = [
              'success' => false,
              'mensagem' => "Erro ao deletar a Criança!"
          ];
        }
      } else {
        $retorno = [
              'success' => true,
              'mensagem' => "Erro ao deletar a Criança! Criança já associada a transportes"
        ];
      }
    }

   echo json_encode($retorno);

 } 

?>