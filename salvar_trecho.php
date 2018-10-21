<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {

    include './inc/conexao.php';

      $acao = @$_POST["acao"];

      $id_crianca       = @$_POST["crianca"];
      $id_trecho        = @$_POST["id_trecho"];
      $tipo             = @$_POST["tipo"];

      $conducao = @$_POST["conducao"];
      if (!empty($conducao)) {
        $conducao = explode(";", $conducao);
        $cpf_condutor = $conducao[0];
        $placa_veiculo = $conducao[1];
        $periodo = $conducao[2];    
      } else {
        $cpf_condutor = "";
        $placa_veiculo = "";
        $periodo = "";
      }

      $cep_origem         = str_replace("-", "", @$_POST["cep_origem"]);
      $logradouro_origem  = @$_POST["logradouro_origem"];
      $numero_origem      = @$_POST["numero_origem"];
      $complemento_origem = @$_POST["complemento_origem"];
      $bairro_origem      = @$_POST["bairro_origem"];
      $cidade_origem      = @$_POST["cidade_origem"];
      $estado_origem      = @$_POST["estado_origem"];

      $cep_destino         = str_replace("-", "", @$_POST["cep_destino"]);
      $logradouro_destino  = @$_POST["logradouro_destino"];
      $numero_destino      = @$_POST["numero_destino"];
      $complemento_destino = @$_POST["complemento_destino"];
      $bairro_destino      = @$_POST["bairro_destino"];
      $cidade_destino      = @$_POST["cidade_destino"];
      $estado_destino      = @$_POST["estado_destino"];

    if ($acao=="SALVARCADASTRO"){
        $selectsql = "select periodo_conducao,id_crianca from criancatrecho where periodo_conducao= '".$periodo."' and id_crianca = ".$id_crianca;
        $selectsqlresult = $conexao->query($selectsql);

        if ($selectsqlresult->num_rows > 0) {
          $retorno = [
              'success' => false,
              'mensagem' => "Transporte já cadastrado para essa criança!"
          ];
        } else {
          $insertsql = "insert into trecho (tipo,logradouro_origem,cep_origem,numero_origem,bairro_origem,complemento_origem,cidade_origem,estado_origem,logradouro_destino,cep_destino,numero_destino,bairro_destino,complemento_destino,cidade_destino,estado_destino) values ('".$tipo."','".$logradouro_origem."','".$cep_origem."','".$numero_origem."','".$bairro_origem."','".$complemento_origem."','".$cidade_origem."','".$estado_origem."','".$logradouro_destino."','".$cep_destino."','".$numero_destino."','".$bairro_destino."','".$complemento_destino."','".$cidade_destino."','".$estado_destino."')";

          $insertresult = $conexao->query($insertsql);

          if ($insertresult) {
            $id_trecho = $conexao->insert_id;

            $insertcritrechosql = "insert into criancatrecho (id_trecho,id_crianca,cpf_condutor,placa_veiculo,periodo_conducao,id_contrato) values (".$id_trecho.",".$id_crianca.",'".$cpf_condutor."','".$placa_veiculo."','".$periodo."',null)";

            $insertcritrechoresult = $conexao->query($insertcritrechosql);
          }

          if ($insertresult && $insertcritrechoresult){
            $retorno = [
              'success' => true,
              'mensagem' => "Transporte cadastrado com sucesso!"
            ];
          }else{
            $retorno = [
              'success' => false,
              'mensagem' => "Erro ao cadastrar o Transporte!"
            ];
          }
        }

    }
    if ($acao =="SALVARUPDATE"){
          
          $updatesql = "update trecho set tipo = '".$tipo."', cep_origem = '".$cep_origem."', logradouro_origem = '".$logradouro_origem."', numero_origem = '".$numero_origem."', bairro_origem = '".$bairro_origem."', complemento_origem = '".$complemento_origem."', cidade_origem = '".$cidade_origem."', estado_origem = '".$estado_origem."', cep_destino = '".$cep_destino."', logradouro_destino = '".$logradouro_destino."', numero_destino = '".$numero_destino."', bairro_destino = '".$bairro_destino."', complemento_destino = '".$complemento_destino."', cidade_destino = '".$cidade_destino."', estado_destino = '".$estado_destino."' where id=".$id_trecho;

          $updatecritrechosql = "update criancatrecho set cpf_condutor = '".$cpf_condutor."', placa_veiculo = '".$placa_veiculo."', periodo_conducao = '".$periodo."' where id_trecho = ".$id_trecho." and id_crianca = ".$id_crianca;

          $updateresult = $conexao->query($updatesql);
          $updatecritrechoresult = $conexao->query($updatecritrechosql);

          if ($updateresult && $updatecritrechoresult){
            $retorno = [
              'success' => true,
              'mensagem' => "Transporte atualizado com sucesso!"
            ];
          }else{
            $retorno = [
              'success' => false,
              'mensagem' => "Erro ao atualizar o Transporte!"
            ];
          }
        } 

    if ($acao == "SALVARDELETE"){
      $select = "select c.id from contrato c inner join criancatrecho ct on ct.id_contrato = c.id and ct.id_trecho = ".$id_trecho." and ct.id_crianca = ".$id_crianca." where c.deletado = 'N'";
      $selectresult = $conexao->query($select);

      if ($selectresult->num_rows == 0) {      
          
        $deletesql = "update criancatrecho set deletado = 'S' where id_trecho = ".$id_trecho." and id_crianca = ".$id_crianca;
        $deletesql2 = "update trecho set deletado = 'S' where id = ".$id_trecho;

        $deleteresult = $conexao->query($deletesql);
        $deleteresult2 = $conexao->query($deletesql2);
        
        if ($deleteresult and $deleteresult2){
            $retorno = [
              'success' => true,
              'mensagem' => "Transporte deletado com sucesso!"
            ];
        }else{
           $retorno = [
              'success' => false,
              'mensagem' => "Erro ao deletar o Transporte!"
            ];
        }
      } else {
        $retorno = [
            'success' => false,
            'mensagem' => "Erro ao deletar o Transporte! Transporte já associado a um contrato."
        ];
      }
    }

  echo json_encode($retorno);

} ?>
