<?php
	session_start();
	if(!empty($_SESSION['login'])){
	$tutu=$_GET['id'];
	echo $tutu;
	}

	else{
		$_SESSION['page']='gestionCapteurs/modification.php';
		header('Location: ../login.php');
	}
?>
