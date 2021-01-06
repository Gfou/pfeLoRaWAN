<?php
	try{
    		// On se connecte a postgres
		$bdd = new PDO("pgsql:host=localhost;port=5432;dbname=pfe;user=root;password=glopglop");
	}
		 catch(Exception $e){
		 // En cas d'erreur, on affiche un message et on arrête tout
		 die('Erreur : '.$e->getMessage()); 
    	}
?>


<form method="post" action="index.php" style="position:relative; left: 15px;">
  	<div class="row">
    		<div class="col">
	   		<select class="browser-default custom-select" name="id" id="id">
		 		<option disabled selected>Recherche par balise</option>
		 		<?php
		  		$reponse=$bdd->query($req23);
		  		while($donnees=$reponse->fetch()){?>
				<option value="<?php echo $donnees['id'];?>"><?php echo $donnees['id'];?></option>
				
          	  		<?php } ?>
       	   		</select>
     <!-- <input type="text" class="form-control" placeholder="Id balise" name="id"> -->
    		</div>
		<div class="col">
			<select class="browser-default custom-select" name="localisation" id="localisation">
		 		<option disabled selected>Recherche par localisation</option>
		 		<?php
		  		$reponse=$bdd->query($req24);
		  		while($donnees=$reponse->fetch()){?>
				<option value="<?php echo $donnees['localisation'];?>"><?php echo $donnees['localisation'];?></option>
          	  		<?php } $reponse->closeCursor(); ?>
       	   		</select>
      	<!--		<input type="text" class="form-control" placeholder="Localisation" name="localisation"> -->
    		</div>
    		<div class="col">
    			<button type="submit" class="btn btn-primary">Valider la recherche</button>
    		</div>
  	</div>
</form>	
