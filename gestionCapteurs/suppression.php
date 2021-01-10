<?php include("../listeRequete.php"); ?>
<?php
	try{
	    // On se connecte a postgres
		$bdd = new PDO("pgsql:host=localhost;port=5432;dbname=pfe;user=root;password=glopglop");
  	}
	catch(Exception $e){
	    // En cas d'erreur, on affiche un message et on arrête tout
                die('Erreur : '.$e->getMessage()); 
	} 
	$reponseS=$bdd->prepare($req22);
	$reponseS->execute(array('id'=>$_GET['id']));
	header('Location: ../index.php');
?>	

