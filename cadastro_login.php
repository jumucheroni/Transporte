<?php
include './inc/conexao.php';
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
	$nome = @$_POST['nome'];
	$email = @$_POST['email'];

	if ($usuario && $senha && $nome && $email) {
		$insertsql = "insert into usuario (usuario,nome,senha,email) values ('".$usuario."','".$nome."','".$senha."','".$email."')";
    	$insertresult = $conexao->query($insertsql);
    	$id_usuario = $conexao->insert_id;
    	if ($insertresult){
    		session_start();
    		$_SESSION["usuario"] = $usuario;
    		$_SESSION["senha"] = $senha;
    		$_SESSION["id"] = $id_usuario;

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
			'erro' => 2
		];
		echo json_encode($retorno);
		return;
    } 
?>