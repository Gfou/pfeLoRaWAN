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

	<?php include("navBar.php");?>	
	<?php
	if(!empty($_POST['login']) AND !empty($_POST['mdp'])){
	 	try{
	 	       // On se connecte à postgres
	 	       $bdd = new PDO("pgsql:host=localhost;port=5432;dbname=pfe;user=root;password=glopglop");
        	}
        	catch(Exception $e){
		        // En cas d'erreur, on affiche un message et on arrête tout
        	    die('Erreur : '.$e->getMessage());
		}
		$mdp=hash('ripemd128',$_POST['mdp']);
		$requete=$bdd->prepare('SELECT id FROM utilisateurs WHERE id=:id AND mdp=:mdp');
		$requete->execute(array('id'=>$_POST['login'], 'mdp'=>$mdp));
		$requete=$requete->fetch();
		if(!empty($requete)){
			$_SESSION['login']=1;
			header('Location: index.php');
		}
		else{
			$erreur=1;
		}
	}
	?>
	<div style="position:absolute; top:180px; left:44%">
		<p><img src="login.png" alt="logo"/></p>
	</div>
	<form method="post" action="login.php" style="position:absolute; left:42.5%; top:350px"> 
		<div class="row">
		<input type="text" class="form-control" name="login" <?php if(empty($erreur)){?> placeholder="Login"<?php }else{?>placeholder="Connection error" style="border:solid red 1px;"<?php } ?>/>
		</div>
		<div class="row" style="position:relative; top:10px">
		<input type="password" class="form-control" name="mdp" <?php if(empty($erreur)){?>placeholder="Password"<?php }else{?>placeholder="Try again" style="border:solid red 1px;"<?php } ?></>
		</div>
		<div class="row" style="position:relative; top:20px; left:50px">
			<button type="submit" class="btn btn-primary">Connection</button>
		</div>
	</form>
    </body>
</html>

