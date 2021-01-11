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
		/* Ajout d'une balise */	
	if(!empty($_POST['idA'])){
		$reponse=$bdd->prepare($req21);
		$reponse->execute(array('id'=>$_POST['idA'],'pays'=>$_POST['paysA'],'ville'=>$_POST['villeA'], 'localisation'=>$_POST['localisationA'],'coordonnees'=>$_POST['coordonneesA']));

		$reponse=$bdd->prepare($req26);
		$reponse->execute(array('id'=>$_POST['idA']));
		
	}
	header('Location: ../index.php');
?>


	
