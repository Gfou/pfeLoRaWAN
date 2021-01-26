<form method="post" action="rechercheHistorique.php" style="position:relative; left: 15px;">
  <div class="row">
    <div class="col">
	<select class="browser-default custom-select" name="id" id="id">
		 <option disabled selected>Search by ID</option>
		 <?php
		 $reponse=$bdd->query($req23);
		 while($donnees=$reponse->fetch()){?>
		 <option value="<?php echo $donnees['id'];?>"><?php echo $donnees['id'];?></option>
		 <?php } ?>
       	</select>
    </div>
    <div class="col">
	<select class="browser-default custom-select" name="localisation" id="localisation">
		 <option disabled selected>Search by location</option>
		 <?php
		  $reponse=$bdd->query($req24);
		  while($donnees=$reponse->fetch()){?>
		  <option value="<?php echo $donnees['localisation'];?>"><?php echo $donnees['localisation'];?></option>
          	  <?php } $reponse->closeCursor(); ?>
       	</select>
    </div>
    <label for="plageDebut" style="position:relative; top: 7px; left: 10px" >De :</label>
    <div class="col">
      <input type="date" class="form-control"  placeholder="De" name="plageDebut" id="plageDebut">
    </div>
    <label for="plageFin" style="position:relative; top: 7px; left: 10px">à :</label>
    <div class="col">
       <input type="date" class="form-control" placeholder="a" name="plageFin" id="plageFin">
    </div>
    <div class="col">
    <button type="submit" class="btn btn-primary">Confirm</button>
    </div>
  </div>
</form>
