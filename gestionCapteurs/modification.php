<?php
	session_start();
	if(!empty($_SESSION['login'])){
		include("../listeRequete.php");
		try{
	    // On se connecte a postgres
			$bdd = new PDO("pgsql:host=localhost;port=5432;dbname=pfe;user=root;password=glopglop");
  		  }
  	         catch(Exception $e){
	    // En cas d'erreur, on affiche un message et on arrête tout
                	die('Erreur : '.$e->getMessage()); 
		 }
		 
		 if(!empty($_POST['coordonneesM'])){
			$reponseM=$bdd->prepare($req17);
			$reponseM->execute(array('coordonnees'=>$_POST['coordonneesM'],'id'=>$_GET['id']));
		 }
		 if(!empty($_POST['paysM'])){
		 	$reponseM=$bdd->prepare($req18);
		 	$reponseM->execute(array('pays'=>$_POST['paysM'],'id'=>$_GET['id']));
		 }
  		 if(!empty($_POST['villeM'])){
			$reponseM=$bdd->prepare($req19);
			$reponseM->execute(array('ville'=>$_POST['villeM'],'id'=>$_GET['id']));
		 }
		 if(!empty($_POST['localisationM'])){
			$reponseM=$bdd->prepare($req20);
			$reponseM->execute(array('localisation'=>$_POST['localisationM'],'id'=>$_GET['id']));
		 }
		 header('Location: ../index.php');
	  }

	else{
		$_SESSION['page']='gestionCapteurs/modification.php';
		header('Location: ../login.php');
	}
?>
