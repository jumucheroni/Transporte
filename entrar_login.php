<?php
include './inc/conexao.php';
session_start();
	if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {

		$retorno = [
			'success' => false,
			'url' => 'index.php',
			'erro' => 1
		];
		echo json_encode($retorno);
		return;
	} 

	$usuario = @$_POST['usuario'];
	$senha = @$_POST['senha'];

	if ($usuario && $senha) {
		$sql = "select * from usuario where usuario='".$usuario."' and senha='".$senha."'";
    	$result = $conexao->query($sql);
    	$row = @mysqli_fetch_array($result);
    	if ($row['id']) {
    		$_SESSION["usuario"] = $row["usuario"];
    		$_SESSION["senha"] = $row["senha"];
    		$_SESSION["id"] = $row["id"];

    		$hoje = new DateTime();
    		$hoje = $hoje->format('Y-m-d');

    		$update = "update pagamentos set status ='A' where status ='N' and deletado='N' and data_prevista_pgto < '".$hoje."'";
    		$updateresult = $conexao->query($update);

    		$retorno = [
				'success' => true,
				'url' => 'index.php',
				'erro' => 0
			];
			echo json_encode($retorno);
			return;
    	} else {
    		$retorno = [
				'success' => false,
				'url' => 'login.php',
				'erro' => 2
			];
			echo json_encode($retorno);
			return;
    	}
    } else {
    	$retorno = [
			'success' => false,
			'url' => 'login.php',
			'erro' => 3
		];
		echo json_encode($retorno);
		return;
    } 
?>