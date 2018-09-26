<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {

    include './inc/conexao.php';

    $acao = @$_POST["acao"];

    $cpf         = str_replace("-", "", @$_POST["cpf"]);
    $nome        = @$_POST["nome"];
    $rg          = str_replace("-", "", @$_POST["rg"]);
    $salario     = str_replace(",",".",@$_POST["salario"]);
    $email       = @$_POST["email"];
    $cep         = str_replace("-", "", @$_POST["cep"]);
    $logradouro  = @$_POST["logradouro"];
    $numero      = @$_POST["numero"];
    $complemento = @$_POST["complemento"];
    $bairro      = @$_POST["bairro"];
    $cidade      = @$_POST["cidade"];
    $estado      = @$_POST["estado"];

    $cpf = str_replace(".", "", $cpf);

    if ($acao=="SALVARCADASTRO"){
        $insertsql = "insert into ajudante (cpf,nome,rg,email,salario,logradouro,cep,numero,bairro,complemento,cidade,estado) values ('".$cpf."','".$nome."','".$rg."','".$email."',".$salario.",'".$logradouro."','".$cep."','".$numero."','".$bairro."','".$complemento."','".$cidade."','".$estado."')";

        $insertresult = $conexao->query($insertsql);
        if ($insertresult){
            $retorno = [
              'success' => true,
              'mensagem' => "Ajudante cadastrado com sucesso!"
            ];
        }else{
            $retorno = [
                'success' => false,
                'mensagem' => "Erro ao cadastrar o Ajudante!"
            ];
        }
    }
    
    if ($acao =="SALVARUPDATE"){          
        $updatesql = "update ajudante set nome = '".$nome."', rg = '".$rg."', salario = ".$salario.", email = '".$email."', cep = '".$cep."', logradouro = '".$logradouro."', numero = '".$numero."', complemento = '".$complemento."', bairro = '".$bairro."', cidade = '".$cidade."', estado = '".$estado."' where cpf='".$cpf."'";
        $updateresult = $conexao->query($updatesql);
        if ($updateresult){
            $retorno = [
                'success' => true,
                'mensagem' => "Ajudante atualizado com sucesso!"
            ];
        }else{
            $retorno = [
                'success' => false,
                'mensagem' => "Erro ao atualizar o Ajudante!"
            ];
        }
    } 

    if ($acao == "SALVARDELETE"){

        $select = "select cpf_ajudante from veiculo where deletado = 'N' and cpf_ajudante = '".$cpf."'";
        $selectresult = $conexao->query($select);

        if ($selectresult->num_rows == 0) {  
            $deletesql = "update ajudante set deletado = 'S' where cpf = '".$cpf."'";
            $deleteresult = $conexao->query($deletesql);
            if ($deleteresult){
                $retorno = [
                    'success' => true,
                    'mensagem' => "Ajudante deletado com sucesso!"
                ];
            }else{
                $retorno = [
                    'success' => false,
                    'mensagem' => "Erro ao deletar o Ajudante!"
                ];
            }
        } else {
            $retorno = [
                'success' => false,
                'mensagem' => "Erro ao deletar o Ajudante! Ajudante já vinculado a um veículo"
            ];
        }
    }

    echo json_encode($retorno);
 } 