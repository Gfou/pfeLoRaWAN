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
  	<script type="text/javascript" src="scriptIndex.js"></script>
    </head>

    <body style="background-color:#F1F4FF;">
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
    <?php include("listeRequete.php"); ?>
    <?php include("navBar.php"); ?>
    <?php include("barreRechercheBalise.php"); ?>
    
    <!-- On regarde si dans l'URL il n'y a pas un code de retour suite a un ajout de capteur -->
    <?php if(!empty($_GET['code'])){ ?>
    <div id="resultAdd"> <?php if(!empty($_GET['code'])){ ?><script>result(<?php echo $_GET['code']; ?>);</script><?php } ?></div>
    <?php } ?>

    <div id="add"></div>  <!-- balise div pour la barre d'ajout de capteur si l'utilisateur clique sur "Add a sensor" -->
    <table class="table" style="position:relative; top: 15px; background-color:white;">
        <thead class="thead-dark">
            <tr>
             <th scope="col">#</th>
             <th scope="col">ID</th>
             <th scope="col">Country</th>
             <th scope="col">City</th>
             <th scope="col">Location</th>
             <th scope="col">Coordinates</th>
             <th scope="col">Level (cm)</th>
	     <th scope="col">Flooded</th>
	     <th scope="col">Enable</th>
	     <th scope="col">Options</th>
	   </tr>
	</thead>
    
    <?php
        //cas où il y a une ID et une Localisation
        if(!empty($_POST['id']) AND !empty($_POST['localisation'])){  
            $reponse=$bdd->prepare($req13IdLoc);
            $reponse->execute(array('id' => $_POST['id'], 'localisation'=>$_POST['localisation']));
            
        }

        elseif(!empty($_POST['id']) AND empty($_POST['localisation'])){  
            $reponse=$bdd->prepare($req14IdNoLoc);
	    $reponse->execute(array('id' => $_POST['id']));
        }

        elseif(empty($_POST['id']) AND !empty($_POST['localisation'])){  
            $reponse=$bdd->prepare($req15NoIdLoc);
            $reponse->execute(array('localisation' => $_POST['localisation']));
            
        }

        else{
            $reponse=$bdd->query($req16NoIdNoLoc);
        }
	
    $indice=0;
    while($donnees=$reponse->fetch()){?>
            <tr>
	     <th scope="row" id="<?php echo $donnees['id']."C";?>"><?php echo $indice ?></th>
                <td><?php echo $donnees['id'];?></td>
                <td><?php echo $donnees['pays'];?></td>
                <td><?php echo $donnees['ville'];?></td>
                <td><?php echo $donnees['localisation'];?></td>
		<td><?php echo $donnees['coordonnees'];?></td>
                <td><?php if ($donnees['enable']==true){echo $donnees['niveau'];} else{echo "_";}?></td>
                <td><?php if ($donnees['enable']==true){echo $donnees['inondee'];} else{echo "_";}?></td>
		<td><?php if ($donnees['enable']==true){ ?><img src="img/check.png" alt="check"/><?php }else{ ?><img src="img/cancel.png" alt="cancel"/> <?php } ?></td>
		<td>
			<div class="row">
				<div class="col">
					<button id="<?php echo $donnees['id']; ?>" type="image" style="border:none; background-color:white;"
						<?php if(empty($_SESSION['login'])){ ?>
							onclick="document.location.href='login.php';"
						<?php }else{ ?>
							onclick="var id=this.getAttribute('id'); newLine(id);"
						<?php  }?>><img src="settings2.png" alt="settings"/></button>
				</div>
				<div class="col">
					<button id="<?php echo $donnees['id']; ?>" type="image" style="border:none; background-color:white;"
						<?php if(empty($_SESSION['login'])){ ?>
							onclick="document.location.href='login.php';"
						<?php }else{ ?>
							onClick="var id=this.getAttribute('id'); disable(id);"
						<?php  }?>><img src="eye2.png" alt="enable/disable"/></button>
				</div>
				<div class="col">
					<button id="<?php echo $donnees['id']; ?>" type="image" style="border:none; background-color:white;"
						<?php if(empty($_SESSION['login'])){ ?>
							onclick="document.location.href='login.php';"
						<?php }else{ ?>
							onClick="var id=this.getAttribute('id'); deleteBalise(id);"
						<?php  }?>><img src="remove2.png" alt="delete"/></button>
				</div>
			</div>
		</td>
	    </tr>
	    <div id=<?php echo $donnees['id']."D";?>></div>

        <?php   
        $indice++;
        }
        $reponse->closeCursor();
    ?>
	</table> 
    </body> 
</html>
