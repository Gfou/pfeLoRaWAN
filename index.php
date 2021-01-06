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
    <table class="table" style="position:relative; top: 15px;">
        <thead class="thead-dark">
            <tr>
             <th scope="col">#</th>
             <th scope="col">ID balise</th>
             <th scope="col">Pays</th>
             <th scope="col">Ville</th>
             <th scope="col">Localisation</th>
             <th scope="col">Coordonnées</th>
             <th scope="col">Niveau (cm)</th>
             <th scope="col">Innondée</th>
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
             <th scope="row"><?php echo $indice ?></th>
                <td><?php echo $donnees['id']?></td>
                <td><?php echo $donnees['pays']?></td>
                <td><?php echo $donnees['ville']?></td>
                <td><?php echo $donnees['localisation']?></td>
                <td><?php echo $donnees['coordonnees']?></td>
                <td><?php echo $donnees['niveau']?></td>
                <td><?php echo $donnees['inondee']?></td>
            </tr>

        <?php   
        $indice++;
        }
        $reponse->closeCursor();
    ?>
	</table>  
    </body> 
</html>
         
