<form method="post" action="rechercheHistorique.php" style="position:relative; left: 15px;">
  <div class="row">
    <div class="col">
      <input type="text" class="form-control" placeholder="Id balise" name="id">
    </div>
    <div class="col">
      <input type="text" class="form-control" placeholder="Localisation" name="localisation">
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
    <button type="submit" class="btn btn-primary">Valider la recherche</button>
    </div>
  </div>
</form>