<?php
session_start();
?>

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
	<div style="position:absolute; top:180px; left:810px">
		<p><img src="login.png" alt="logo"/></p>
	</div>
	<form method="post" action="login.php" style="position:absolute; left:800px; top:350px"> 
		<div class="row">
			<input type="text" class=form-control" id="Input" placeholder="Login"/>
		</div>
		<div class="row" style="position:relative; top:10px">
			<input type="text" class=form-control" id="Input2" placeholder="Mot de passe"/>
		</div>
		<div class="row" style="position:relative; top:20px; left:35px">
			<button type="submit" class="btn btn-primary">Connexion</button>
		</div>
	</form>
    </body>
</html>

