
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
	elseif($decoded==4){
		$inondee="OUI";
		$niveau=10;
	}
	elseif($decoded==10){
		$inondee="OUI";
		$niveau=15;
	}
	elseif($decoded==40){
		$inondee="OUI";
		$niveau=20;
	}
	elseif($decoded==0){
		$inondee="NON";
		$niveau=0;
	}
	else
	{
		$inondee="NON";
		$niveau=0;
	}


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

	//On verifie si la balise est deja enregistre
	$requete=$bdd->prepare('SELECT enable FROM balises WHERE id=:id');
	$requete->execute(array('id'=>$id));
	$requete=$requete->fetch();
	if (empty($requete)){
		$requete=$bdd->prepare('INSERT INTO unregistered_sensor VALUES (:id)';
		$requete->execute(array('in'=>$id));
	}
	else if($requete['enable']==true){
	
	//des qu'une donnee ajoute on met a jour la table balises
	$requete=$bdd->prepare('UPDATE balises 
		       		SET inondee=:in, niveau=:niv  
		       		WHERE id=:id');
	$requete->execute(array('in'=>$inondee, 'niv'=>$niveau, 'id'=>$id));
	

	//on veirfie si la balise es active avant de stocker en base
	$ajrd=date("Y-m-d h:i:s A");
		$requete=$bdd->prepare('INSERT INTO historique_balise
					VALUES (DEFAULT,:id,:d,:niv,:in)');
	$requete->execute(array('id'=>$id,'d'=>$ajrd, 'niv'=>$niveau, 'in'=>$inondee));
	
	}
}
?>


		






         
