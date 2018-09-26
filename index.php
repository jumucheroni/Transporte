<?php 
session_start();
if (isset($_SESSION['usuario']) && isset($_SESSION['senha']) && isset($_SESSION['id'])) {
	include './inc/header.php'; 

	include './inc/footer.php';
}
?>