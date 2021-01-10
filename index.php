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
             <th scope="col">Inondée</th>
	     <th scope="col">Options</th>
	   </tr>
	</thead>
     </table>
    
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
	<table class="table">
            <tr>
	     <th scope="row" id="<?php echo $donnees['id']."C";?>"><?php echo $indice ?></th>
                <td><?php echo $donnees['id']?></td>
                <td><?php echo $donnees['pays']?></td>
                <td><?php echo $donnees['ville']?></td>
                <td><?php echo $donnees['localisation']?></td>
                <td><?php echo $donnees['coordonnees']?></td>
                <td><?php echo $donnees['niveau']?></td>
		<td><?php echo $donnees['inondee']?></td>
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
					<button id="<?php echo $donnees['id']; ?>" type="image" style="border:none; background-color:white;"><img src="eye2.png" alt="enable/disable"/></button>
				</div>
				<div class="col">
					<button id="<?php echo $donnees['id']; ?>" type="image" style="border:none; background-color:white;"><img src="remove2.png" alt="delete"/></button>
			
				</div>
			</div>
		</td>
	    </tr>
	</table>
	    <div id=<?php echo $donnees['id']."D";?>></div>

        <?php   
        $indice++;
        }
        $reponse->closeCursor();
    ?>
	</table> 
	<script> 

		function newLine(id){
			ID=id+'C';
			DIV=id+'D';
			var line=document.getElementById(ID);
			var div=document.getElementById(DIV);
		/*	var htmlContent='<form method="post" action="gestionCapteurs/modification.php">'+
						'<div class="row">\'+
  		  					'<div class="col">'+
  		  						  '<input type="text" required class="form-control" placeholder="Id balise" name="idM">'+
  		  					'</div>'+
  		  					'<div class="col">'+
  		  						  '<input type="text"  class="form-control" placeholder="Coordonnees" name="coordonneesM">'+
		  					'</div>'+
		  					'<div class="col">'+
		  						  '<input type="text"  class="form-control" placeholder="invisible" name="invisible" style="visibility: hidden">'+
		 					'</div>'+
						'</div>'+
						'<div class="row">'+
  		  					'<div class="col">'+
  		  					 	 '<input type="text"  class="form-control" placeholder="Pays" name="paysM">'+
  		  					'</div>'+
  		  					'<div class="col">'+
  		  						  '<input type="text"  class="form-control" placeholder="Ville" name="villeM">'+
		  					'</div>'+
		  					'<div class="col">'+
		  						  '<input type="text"  class="form-control" placeholder="Localisation" name="localisationM">'+
		  					'</div>'+
  		  					'<div class="col">'+
  		  						'<button type="submit" class="btn btn-primary">Valider la modification</button>'+
  		  					'</div>'+
						'</div>'+
						'</form>';*/

			var f = document.createElement("FORM");
			f.setAttribute('method',"post");
			f.setAttribute('action',"gestionCapteurs/modification.php");

			var i = document.createElement("input");
			i.setAttribute('type',"text");
			i.setAttribute('name',"idM");	

			f.appendChild(i);

			div.appendChild(f);
			//line.parentNode.insertBefore(f,line.nextSibling);
			//par.insertBefore(f,line);
			//line.insertAdjacentElement('afterend',htmlContent);
			//console.log(line);
			//console.log(form);
		}
    	</script>
    </body> 
</html>
         
