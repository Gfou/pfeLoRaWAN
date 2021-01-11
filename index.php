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
    <div id="add"></div>
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
	     <th scope="col">Enable</th>
	     <th scope="col">Options</th>
	   </tr>
	</thead>
<!--     </table>  -->
    
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
<!--	<table class="table">   -->
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
<!--	</table>  -->
	    <div id=<?php echo $donnees['id']."D";?>></div>

        <?php   
        $indice++;
        }
        $reponse->closeCursor();
    ?>
	</table> 
	<script> 

		var listForm=[];
		var indiceOpen=0;

		function newLine(id){
			var ID=id+'C';
			var DIV=id+'D';
			if (!listForm.includes(id)){

				var line=document.getElementById(ID);
				var div=document.getElementById(DIV);

				listForm.forEach((form) => {	
					console.log(form);
					var remove=document.getElementById(form+'F');
					var removeDiv=document.getElementById(form+'D');
					const index = listForm.indexOf(form);
					listForm.splice(index,1);
					removeDiv.removeChild(remove);
				})

				var f = document.createElement("FORM");
				f.setAttribute('id',id+'F');
				f.setAttribute('method',"post");
				f.setAttribute('action',"gestionCapteurs/modification.php?id="+id);
				f.setAttribute('style',"position:relative; margin-left:15px; margin-top:1%;");

				var drow = document.createElement("div");
				drow.setAttribute('class',"row");
	
				var dcol1 = document.createElement("div");
				dcol1.setAttribute('class',"col");
	
				var dcol2 = document.createElement("div");
				dcol2.setAttribute('class',"col");

				var dcol3 = document.createElement("div");
				dcol3.setAttribute('class',"col");
			
				var dcol4 = document.createElement("div");
				dcol4.setAttribute('class',"col");
			
				var dcol5 = document.createElement("div");
				dcol5.setAttribute('class',"col");
	
				var c = document.createElement("input");
				c.setAttribute('type',"text");
				c.setAttribute('name',"coordonneesM");	
				c.setAttribute('placeholder',"Coordonnees");
				c.setAttribute('class',"form-control");
			
				var p = document.createElement("input");
				p.setAttribute('type',"text");
				p.setAttribute('name',"paysM");	
				p.setAttribute('placeholder',"Pays");
				p.setAttribute('class',"form-control");
			
				var v = document.createElement("input");
				v.setAttribute('type',"text");
				v.setAttribute('name',"villeM");	
				v.setAttribute('placeholder',"Ville");
				v.setAttribute('class',"form-control");
			
				var l = document.createElement("input");
				l.setAttribute('type',"text");
				l.setAttribute('name',"localisationM");	
				l.setAttribute('placeholder',"Localisation");
				l.setAttribute('class',"form-control");
			
				var b = document.createElement("button");
				b.setAttribute('type',"submit");
				b.setAttribute('class',"btn btn-primary");

				var s = document.createElement("span");
				s.setAttribute('style',"font-size:10px");

				var t = document.createTextNode("Valider modifications pour "+id);
	
				s.appendChild(t);
				b.appendChild(s);
				dcol1.appendChild(c);
				dcol2.appendChild(p);
				dcol3.appendChild(v);
				dcol4.appendChild(l);
				dcol5.appendChild(b);
				drow.append(dcol1, dcol2, dcol3, dcol4, dcol5);
				f.appendChild(drow);
				div.appendChild(f);

				listForm.push(id);
			}
			else{
				
				var div=document.getElementById(DIV);
				var form=document.getElementById(id+'F');
				const index = listForm.indexOf(id);
				listForm.splice(index,1);
				div.removeChild(form);
				
			}
		}


		function deleteBalise(id){
			if(confirm("Delete balise with ID "+id+" ?")){
				console.log("toto");
				document.location.href='gestionCapteurs/suppression.php?id='+id;
			}
			else{}
		}


		function disable(id){
			document.location.href='gestionCapteurs/desactivation.php?id='+id;
		}


		function del(){
				
			var div=document.getElementById('add');
			if (indiceOpen==0){	
				var f = document.createElement("FORM");
				f.setAttribute('id',"addForm");
				f.setAttribute('method',"post");
				f.setAttribute('action',"gestionCapteurs/ajout.php");
				f.setAttribute('style',"position:relative; margin-left:15px; margin-top:1%;");

				var drow = document.createElement("div");
				drow.setAttribute('class',"row");
	
				var dcol1 = document.createElement("div");
				dcol1.setAttribute('class',"col");
	
				var dcol2 = document.createElement("div");
				dcol2.setAttribute('class',"col");

				var dcol3 = document.createElement("div");
				dcol3.setAttribute('class',"col");
			
				var dcol4 = document.createElement("div");
				dcol4.setAttribute('class',"col");
			
				var dcol5 = document.createElement("div");
				dcol5.setAttribute('class',"col");

				var dcol6 = document.createElement("div");
				dcol6.setAttribute('class',"col");

				var i = document.createElement("select");
				<?php $reponse=$bdd->query('SELECT id FROM unregistred_sensor');?>
				var infos =JSON.parse('<?php echo json_encode($reponse->fetchAll(), true); ?>');
				if (infos.length>0){
					i.setAttribute('class',"brower-default custom-select");
					i.setAttribute('name',"idA");
					i.setAttribute('id',"idA");
					var opt = document.createElement("option");
					opt.setAttribute('disabled',"disabled");
					opt.setAttribute('selected',"selected");
					var tex = document.createTextNode("Select id");
					opt.appendChild(tex);
					i.appendChild(opt);
					for(var j=0; j<infos.length; j++){
						var o = document.createElement("option");
						o.setAttribute('value',infos[j]['id']);
						var t = document.createTextNode(infos[j]['id']);
						o.appendChild(t);
						i.appendChild(o);
					}

				}
				else{
					var opt = document.createElement("option");
					opt.setAttribute('disabled',"disabled");
					var tex = document.createTextNode("Select id");
					opt.appendChild(tex);
					i.appendChild(opt);
				}

				console.log(infos);
				i.setAttribute('type',"text");
				i.setAttribute('name',"idA");	
				i.setAttribute('placeholder',"Id Balise");
				i.setAttribute('class',"form-control");
				i.setAttribute('required',"required");
	
				var c = document.createElement("input");
				c.setAttribute('type',"text");
				c.setAttribute('name',"coordonneesA");	
				c.setAttribute('placeholder',"Coordonnees");
				c.setAttribute('class',"form-control");	
				c.setAttribute('required',"required");
			
				var p = document.createElement("input");
				p.setAttribute('type',"text");
				p.setAttribute('name',"paysA");	
				p.setAttribute('placeholder',"Pays");
				p.setAttribute('class',"form-control");
				p.setAttribute('required',"required");

				var v = document.createElement("input");
				v.setAttribute('type',"text");
				v.setAttribute('name',"villeA");	
				v.setAttribute('placeholder',"Ville");
				v.setAttribute('class',"form-control");
				v.setAttribute('required',"required");
				
				var l = document.createElement("input");
				l.setAttribute('type',"text");
				l.setAttribute('name',"localisationA");	
				l.setAttribute('placeholder',"Localisation");
				l.setAttribute('class',"form-control");
				l.setAttribute('required',"required");

				var b = document.createElement("button");
				b.setAttribute('type',"submit");
				b.setAttribute('class',"btn btn-primary");

				var s = document.createElement("span");
				s.setAttribute('style',"font-size:15px");

				var t = document.createTextNode("Confirm ?");
	
				s.appendChild(t);
				b.appendChild(s);
				dcol1.appendChild(i);
				dcol2.appendChild(p);
				dcol3.appendChild(v);
				dcol4.appendChild(l);
				dcol5.appendChild(c);
				dcol6.appendChild(b);
				drow.append(dcol1, dcol2, dcol3, dcol4, dcol5, dcol6);
				f.appendChild(drow);
				div.appendChild(f);
				indiceOpen=1;
			}
			else{
				var form=document.getElementById('addForm');
				div.removeChild(form);
				indiceOpen=0;
			}

		}

    	</script>	
    </body> 
</html>
         
