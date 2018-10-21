<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
    include './inc/conexao.php';

      $acao = @$_POST["acao"];

      $id                         = @$_POST["id"];
      $id_crianca                 = @$_POST["id_crianca"];
      $data_inicio_contrato       = DtToDb(@$_POST["data_inicio_contrato"]);
      $data_fim_contrato          = DtToDb(@$_POST["data_fim_contrato"]);
      $dia_vencimento_mensalidade = @$_POST["dia_vencimento_mensalidade"];
      $mensalidade                = str_replace(",",".",@$_POST["mensalidade"]);
      $id_trecho                  = @$_POST['trecho'];

    if ($acao=="SALVARCADASTRO"){

        $dtfim = new DateTime($data_fim_contrato);
        $dtini = new DateTime($data_inicio_contrato);

        $intervalo = $dtfim->diff($dtini);
        $meses =  $intervalo->m + ($intervalo->y * 12);

        $insertsql = "insert into contrato (id_crianca,data_inicio_contrato,data_fim_contrato,dia_vencimento_mensalidade, mensalidade) values (".$id_crianca.",'".$data_inicio_contrato."','".$data_fim_contrato."',".$dia_vencimento_mensalidade.",".$mensalidade.")";

        $insertresult = $conexao->query($insertsql); 

        $id_contrato = $conexao->insert_id;
        $data = $dtini;
        for ($i = 1 ; $i <= $meses; $i++) {
          $insertpagamentosql = "insert into pagamentos (data_prevista_pgto,status,id_contrato) values ('".$data_inicio_contrato."','N',".$id_contrato.")";
          $insertpagamentosresult = $conexao->query($insertpagamentosql);
          $data = date('Y-m-d', strtotime("+1 month", strtotime($data_inicio_contrato)));
          $data_inicio_contrato = $data;
        }

        foreach ($id_trecho as $value) {
          $trecho = explode("-", $value);
          $updatetrechosql = "update criancatrecho set id_contrato = ".$id_contrato." where id_crianca = ".$id_crianca." and id_trecho = ".$trecho[0];
          $updatetrechoresult = $conexao->query($updatetrechosql);
        }

        if ($insertresult){
              $retorno = [
                  'success' => true,
                  'mensagem' => "Contrato cadastrado com sucesso!"
              ];
        }else{
            $retorno = [
                  'success' => false,
                  'mensagem' => "Erro ao cadastrar o Contrato!"
            ];
        }

    }
    if ($acao =="SALVARUPDATE"){

          $updatesql = "update contrato set dia_vencimento_mensalidade = ".$dia_vencimento_mensalidade." where id = ".$id;
          $updateresult = $conexao->query($updatesql);

          if ($updateresult){
              $retorno = [
                  'success' => true,
                  'mensagem' => "Contrato atualizado com sucesso!"
              ];
          }else{
              $retorno = [
                  'success' => false,
                  'mensagem' => "Erro ao atualizar o Contrato!"
              ];
          }
        } 
    if ($acao == "SALVARDELETE"){ 
      $hoje = date('Y-m-d');
      $deletesql = "update contrato set data_fim_contrato = '".$hoje."', deletado = 'S' where id = ".$id;
      $deleteresult = $conexao->query($deletesql);
      if ($deleteresult){
          $retorno = [
              'success' => true,
              'mensagem' => "Contrato deletado com sucesso!"
          ];
      }else{
          $retorno = [
              'success' => false,
              'mensagem' => "Erro ao deletar o Contrato!"
          ];
      }
    }

    echo json_encode($retorno);

 } ?>