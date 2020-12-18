
<?php
if($_GET['event']=="up"){
	header("content-type: application/json");
	$json = file_get_contents("php://input");
	$obj = json_decode($json);
	$id = bin2hex(base64_decode(json_encode($obj->devEUI)));
	$decoded = bin2hex(base64_decode(json_encode($obj->data)));


	$fp = fopen("toto.txt","a");
	//var_dump($obj);
	//$tototo=ob_get_clean();
	fprintf($fp,"%d ---\n",$decoded);
	//fclose($fp);


	//Ici on recupere le payload et on le decompose en id, niveau, inondee (format tram id:niveau1:niveau2:niveau3)
	//$id;
	$niveau;
	$inondee;
	$result;
	$decoded;

	
	if($decoded==1){
		$inondee="OUI";
		$niveau=5;
	}
	if($decoded==4){
		$inondee="OUI";
		$niveau=10;
	}
	if($decoded==10){
		$inondee="OUI";
		$niveau=15;
	}
	if($decoded==40){
		$inondee="OUI";
		$niveau=20;
	}
	if($decoded==0b00000000){
		$inondee="NON";
		$niveau=0;
	}
	else
	{
		$inondee="NON";
		$niveau=0;
	}


	/*$regex="#^([0-9]+):([0-1]{1}):([0-1]{1}):([0-1]{1})$#";
	if(preg_match($regex,$decoded,$result)){
		$id=$result[1];
		if($result[2]==1){
			$inondee="OUI";
			$niveau=10;
			if($result[3]==1 && $result[4]==0)
				$niveau=20;
			elseif($result[3]==1 && $result[4]==1)
				$niveau=30;
		}
		else{ 
			$inondee="NON";
			$niveau=0;
		}		
	}*/
	
	try{
		//On se connecte a  postgres
		$bdd = new PDO("pgsql:host=localhost;port=5432;dbname=pfe;user=root;password=glopglop");
	}
	catch(Exception $e){
	     // En cas d'erreur, on affiche un message et on arrête tout
	        die('Erreur : '.$e->getMessage());
	}
	
	//fwrite($fp,$id." ".$niveau." ".$inondee."\r\n");
	fclose($fp);
	//des qu'une donnee ajoute on met a jour la table balises
	$requete=$bdd->prepare('UPDATE balises 
		       		SET inondee=:in, niveau=:niv  
		       		WHERE id=:id');
	$requete->execute(array('in'=>$inondee, 'niv'=>$niveau, 'id'=>$id));
	

	//on regarde si la dernière entre en base a plus de 24h, si oui on enregistre
	$ajrd=date("Y-m-d");
	$requete=$bdd->prepare('SELECT MAX(date) AS max_date
				FROM historique_balise
				WHERE id_balise=:id');
	$requete->execute(array('id' => $id));
	$resultat=$requete->fetch();
	if($ajrd>$resultat['max_date']  || $resultat==FALSE){
		$requete=$bdd->prepare('INSERT INTO historique_balise
					VALUES (DEFAULT,:id,:d,:niv,:in)');
		$requete->execute(array('id'=>$id,'d'=>$ajrd, 'niv'=>$niveau, 'in'=>$inondee));
	}
}
?>


		






         
