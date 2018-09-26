<?php
include './inc/conexao.php';
session_start();
	if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
		unset($_SESSION['usuario']);
		unset($_SESSION['senha']);
		unset($_SESSION['id']);
		header("Location: login.php");
	}
session_destroy();
?>