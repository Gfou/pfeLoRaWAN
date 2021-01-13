<form method="post" action="index.php" style="position:relative;left: 15px; background-color:#F1F4FF">
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
		<div class="col">
			<button type="button" class="btn btn-primary" style="position:relative; margin-left:50%;" 	
				<?php if(empty($_SESSION['login'])){ ?>
					onclick="document.location.href='login.php';"
				<?php }else{ ?>
					onclick="addSensor();"
				<?php  }?>><img src="img/sensor.png" alt="sensor"/> Add a sensor</button>
		</div>

  	</div>
</form>	
