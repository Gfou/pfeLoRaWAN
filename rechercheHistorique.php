<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Titre</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
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
    <?php include("barreRechercheHistorique.php"); ?>
    <table class="table table-striped table-dark" style="position:relative; top: 15px;">
        <thead>
            <tr>
            <th scope="col">#</th>
             <th scope="col">ID</th>
             <th scope="col">sensor's id</th>
             <th scope="col">Date</th>
             <th scope="col">Country</th>
             <th scope="col">City</th>
             <th scope="col">Location</th>
             <th scope="col">Level (cm)</th>
             <th scope="col">Flooded</th>
            </tr>
        </thead>

    

    <?php
    
    if(!empty($_POST['id']) OR !empty($_POST['localisation'])){
        //cas où il y a une ID et une Localisation
        if(!empty($_POST['id']) AND !empty($_POST['localisation']) AND empty($_POST['plageDebut']) AND empty($_POST['plageFin'])){  
            $reponse=$bdd->prepare($req1IdLocNoDate);
            $reponse->execute(array('id'=>$_POST['id'], 'localisation'=>$_POST['localisation']));
        }

        //cas où il y a seulement une ID
        elseif(!empty($_POST['id']) AND empty($_POST['localisation']) AND empty($_POST['plageDebut']) AND empty($_POST['plageFin'])){
            $reponse=$bdd->prepare($req2IdNoLocNoDate);
            $reponse->execute(array('id' => $_POST['id']));
        }

        //cas ou il y a seulement une Localisation
        elseif(empty($_POST['id']) AND !empty($_POST['localisation']) AND empty($_POST['plageDebut']) AND empty($_POST['plageFin'])){
            $reponse=$bdd->prepare($req3NoIdLocNoDate);
            $reponse->execute(array('localisation' => $_POST['localisation']));
        }

        //cas où il y a une plage de date
        elseif(!empty($_POST['plageDebut']) AND !empty($_POST['plageFin'])){
            $regex= "#([0-9]{4})-([0-9]{2})-([0-9]{2})#";
            if(preg_match($regex,$_POST['plageDebut'],$resultat)){
                $anneeDebut=$resultat[1];
                $moisDebut=$resultat[2];
                $jourDebut=$resultat[3];
            
            }
            if(preg_match($regex,$_POST['plageFin'],$resultat)){
                $anneeFin=$resultat[1];
                $moisFin=$resultat[2];
                $jourFin=$resultat[3];
            
            }

            //cas où il y a une plage de date, une id et une localisation
            if(!empty($_POST['id']) AND !empty($_POST['localisation'])){
                $reponse=$bdd->prepare($req4IdLocDate);
                $reponse->execute(array('localisation' => $_POST['localisation'], 'id'=> $_POST['id'], 'jourDebut'=>$jourDebut, 'jourFin'=>$jourFin, 'moisDebut'=>$moisDebut, 'moisFin'=>$moisFin, 'anneeDebut'=>$anneeDebut, 'anneeFin'=>$anneeFin));
            }

            //cas où il y a une plage de date et une id
            elseif(!empty($_POST['id']) AND empty($_POST['localisation'])){
                $reponse=$bdd->prepare($req5IdNoLocDate); 
                $reponse->execute(array('id'=> $_POST['id'], 'jourDebut'=>$jourDebut, 'jourFin'=>$jourFin, 'moisDebut'=>$moisDebut, 'moisFin'=>$moisFin, 'anneeDebut'=>$anneeDebut, 'anneeFin'=>$anneeFin));
            }

            //cas où il y a une plage de date et une localisation
            elseif(empty($_POST['id']) AND !empty($_POST['localisation'])){
                $reponse=$bdd->prepare($req6NodIdLocDate);
                $reponse->execute(array('localisation' => $_POST['localisation'], 'jourDebut'=>$jourDebut, 'jourFin'=>$jourFin, 'moisDebut'=>$moisDebut, 'moisFin'=>$moisFin, 'anneeDebut'=>$anneeDebut, 'anneeFin'=>$anneeFin));
            }
            
            
        }

        //cas où il y a une Date de debut
        elseif(!empty($_POST['plageDebut']) AND empty($_POST['plageFin'])){
            $regex= "#([0-9]{4})-([0-9]{2})-([0-9]{2})#";
            if(preg_match($regex,$_POST['plageDebut'],$resultat)){
                $anneeDebut=$resultat[1];
                $moisDebut=$resultat[2];
		$jourDebut=$resultat[3];
            }
            
            //cas où il y a une date de debut, une id et une localisation
            if(!empty($_POST['id']) AND !empty($_POST['localisation'])){
                $reponse=$bdd->prepare($req7IdLocDateDebut);
                $reponse->execute(array('localisation' => $_POST['localisation'], 'id'=> $_POST['id'], 'jourDebut'=>$jourDebut, 'moisDebut'=>$moisDebut, 'anneeDebut'=>$anneeDebut));
            }

            //cas où il y a une date de debut et une id
            elseif(!empty($_POST['id']) AND empty($_POST['localisation'])){
                $reponse=$bdd->prepare($req8IdNoLocDateDebut); 
                $reponse->execute(array('id'=> $_POST['id'], 'jourDebut'=>$jourDebut, 'moisDebut'=>$moisDebut, 'anneeDebut'=>$anneeDebut));
            }

            //cas où il y a une date de debut et une localisation
            elseif(empty($_POST['id']) AND !empty($_POST['localisation'])){
                $reponse=$bdd->prepare($req9NoIdLocDateDebut); 
                $reponse->execute(array('localisation' => $_POST['localisation'], 'jourDebut'=>$jourDebut, 'moisDebut'=>$moisDebut, 'anneeDebut'=>$anneeDebut));
            } 
        }

         //cas où il y a une date de fin
         elseif(empty($_POST['plageDebut']) AND !empty($_POST['plageFin'])){
            $regex= "#([0-9]{4})-([0-9]{2})-([0-9]{2})#";
            if(preg_match($regex,$_POST['plageFin'],$resultat)){
                $anneeFin=$resultat[1];
                $moisFin=$resultat[2];
                $jourFin=$resultat[3];
            
            }

            //cas où il y a une date de fin, une id et une localisation
            if(!empty($_POST['id']) AND !empty($_POST['localisation'])){
                $reponse=$bdd->prepare($req10IdLocDateFin);
                $reponse->execute(array('localisation' => $_POST['localisation'], 'id'=> $_POST['id'], 'jourFin'=>$jourFin,  'moisFin'=>$moisFin,  'anneeFin'=>$anneeFin));
            }

            //cas où il y a une date de fin et une id
            elseif(!empty($_POST['id']) AND empty($_POST['localisation'])){
                $reponse=$bdd->prepare($req11IdNoLocDateFin); 
                $reponse->execute(array('id'=> $_POST['id'], 'jourFin'=>$jourFin,  'moisFin'=>$moisFin, 'anneeFin'=>$anneeFin));
            }

            //cas où il y a une date de fin et une localisation
            elseif(empty($_POST['id']) AND !empty($_POST['localisation'])){
                $reponse=$bdd->prepare($req12noIdLocDateFin); 
                $reponse->execute(array('localisation' => $_POST['localisation'], 'jourFin'=>$jourFin, 'moisFin'=>$moisFin, 'anneeFin'=>$anneeFin));
            }
            
            
        }



        $indice=0;
        while($donnees=$reponse->fetch()){?>
            <tr>
             <th scope="row"><?php echo $indice ?></th>
                <td><?php echo $donnees['id']?></td>
                <td><?php echo $donnees['id_balise']?></td>
                <td><?php echo $donnees['date']?></td>
                <td><?php echo $donnees['pays']?></td>
                <td><?php echo $donnees['ville']?></td>
                <td><?php echo $donnees['localisation']?></td>
                <td><?php echo $donnees['niveau']?></td>
                <td><?php echo $donnees['inondee']?></td>
            </tr>

        <?php   
        $indice++;
        }
        $reponse->closeCursor();
    ?>
	</table>
        
    <?php
    }
    else{?>
        <p style="position:relative; top:15px; font-weight:bold" ><img src="attention.png" alt="attention"/>Please fill in at least one id and/or location</p>
    <?php
    }
    ?>
    </body>

