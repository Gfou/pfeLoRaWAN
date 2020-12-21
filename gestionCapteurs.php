<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Accueil</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    </head>

    <body>
    <?php include("navBar.php"); ?>
    <?php include("listeRequete.php"); ?>
    <h1 style="margin-top:30px; margin-left:15px; width:fit-content; font-family:Georgia,serif; border:3px black solid; box-shadow:6px 10px 8px black;background-color:#303030; color:white">Ajout d'une nouvelle balise</h1>
    	<form method="post" action="gestionCapteurs.php" style="position:relative; left: 25px; top:15px">
  		<div class="row">
  		  <div class="col">
  		    <input type="text" required class="form-control" placeholder="Id balise" name="idA">
  		  </div>
  		  <div class="col">
  		    <input type="text" required class="form-control" placeholder="Coordonnees" name="coordonneesA">
		  </div>
		  <div class="col">
		    <input type="text" class="form-control" placeholder="invisible" name="invisible" style="visibility: hidden">
		 </div>
		</div>
	        <div class="row">
  		  <div class="col">
  		    <input type="text" required class="form-control" placeholder="Pays" name="paysA">
  		  </div>
  		  <div class="col">
  		    <input type="text" required class="form-control" placeholder="Ville" name="villeA">
		  </div>
		  <div class="col">
		    <input type="text" required class="form-control" placeholder="Localisation" name="localisationA">
		  </div>
  		  <div class="col">
  		  <button type="submit" class="btn btn-primary">Valider l'ajout</button>
  		  </div>
		</div>
	</form>

     <h1 style="width:fit-content; margin-left:15px; margin-top:50px; font-family:Georgia,serif; border:3px black solid; box-shadow:6px 10px 8px black; background-color:#303030; color:white">Modification d'une balise</h1>
    	<form method="post" action="gestionCapteurs.php" style="position:relative; left: 25px; top:15px">
  		<div class="row">
  		  <div class="col">
  		    <input type="text" required class="form-control" placeholder="Id balise" name="idM">
  		  </div>
  		  <div class="col">
  		    <input type="text"  class="form-control" placeholder="Coordonnees" name="coordonneesM">
		  </div>
		  <div class="col">
		    <input type="text"  class="form-control" placeholder="invisible" name="invisible" style="visibility: hidden">
		 </div>
		</div>
		<div class="row">
  		  <div class="col">
  		    <input type="text"  class="form-control" placeholder="Pays" name="paysM">
  		  </div>
  		  <div class="col">
  		    <input type="text"  class="form-control" placeholder="Ville" name="villeM">
		  </div>
		  <div class="col">
		    <input type="text"  class="form-control" placeholder="Localisation" name="localisationM">
		  </div>
  		  <div class="col">
  		  <button type="submit" class="btn btn-primary">Valider la modification</button>
  		  </div>
  		</div>
	</form>
	 <h1 style="width:fit-content; margin-left:15px; margin-top:50px; font-family:Georgia,serif; border:3px black solid; box-shadow:6px 10px 8px black; background-color:#303030; color:white">Suppression d'une balise</h1>
    	<form method="post" action="gestionCapteurs.php" style="position:relative; left: 25px; top:15px">
  		<div class="row">
  		  <div class="col">
  		    <input type="text" required class="form-control" placeholder="Id balise" name="idS" style="width:48.5%">
		  </div>
		 <div class="col">
		  <button type="submit" class="btn btn-primary" style="position:relative; right:52%">Valider la suppression</button>
		 </div>
		</div>
	</form>


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
			 $reponse=$bdd->prepare('INSERT INTO balises
			 		  VALUES(:id,:pays,:ville,:localisation,:coordonnees,0,\'NON\')');
			 $reponse->execute(array('id'=>$_POST['idA'],'pays'=>$_POST['paysA'],'ville'=>$_POST['villeA'], 'localisation'=>$_POST['localisationA'],'coordonnees'=>$_POST['coordonneesA']));
		 }
		/* suppression d'une balise */
		 elseif(!empty($_POST['idS'])){
			 $reponse=$bdd->prepare('DELETE FROM balises WHERE id=:id');
			 $reponse->execute(array('id'=>$_POST['idS']));
		 }
		 elseif(!empty($_POST['idM'])){
			 if(!empty($_POST['coordonneesM'])){
				 $reponse=$bdd->prepare('UPDATE balises SET coordonnees=:coordonnees WHERE id=:id');
				 $reponse->execute(array('coordonnees'=>$_POST['coordonneesM'],'id'=>$_POST['idM']));
			 }
			 if(!empty($_POST['paysM'])){
				 $reponse=$bdd->prepare('UPDATE balises SET pays=:pays WHERE id=:id');
				 $reponse->execute(array('pays'=>$_POST['paysM'],'id'=>$_POST['idM']));
			 }
  			 if(!empty($_POST['villeM'])){
				 $reponse=$bdd->prepare('UPDATE balises SET ville=:ville WHERE id=:id');
				 $reponse->execute(array('ville'=>$_POST['villeM'],'id'=>$_POST['idM']));
			 }
			 if(!empty($_POST['localisationM'])){
				 $reponse=$bdd->prepare('UPDATE balises SET localisation=:localisation WHERE id=:id');
				 $reponse->execute(array('localisation'=>$_POST['localisationM'],'id'=>$_POST['idM']));
			 }

		 }
	?>

    </body>
