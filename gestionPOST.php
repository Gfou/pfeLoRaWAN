
<?php
header("content-type: application/json");
$json = file_get_contents("php://input");
$obj = json_decode($json);
$decoded = base64_decode(json_encode($obj->data));

$fp = @fopen("toto.txt","a");
fwrite($fp,$decoded);
fwrite($fp,"\r\n");
//fclose($fp);


//Ici on recupere le payload et on le decompose en id, niveau, inondee (format tram id:niveau1:niveau2:niveau3)
$id;
$niveau;
$inondee;
$result;

$regex="#^([0-9]+):([0-1]{1}):([0-1]{1}):([0-1]{1})$#";
if(preg_match($regex,$decoded,$result)){
	$id=$result[1];
	if($result[2]==1){
		$inondee="OUI";
		$niveau=10;
		if($result[3]==1 && $result[4]==0)
			$niveau=20;
		elseif($result[3]==1 && $result[4]==1)
			$niveau=30;
		else{ 
			$inondee="NON";
			$niveau=0;
		}
			
	}
}
//echo $inondee;
//fwrite($fp,$inondee);
//fwrite($fp,$inondee . " niveau: " . $niveau . "\r\n");
fclose($fp);
	
	
try{
	//On se connecte a  postgres
	$bdd = new PDO("pgsql:host=localhost;port=5432;dbname=pfe;user=root;password=glopglop");
}
catch(Exception $e){
     // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
}

$request=$bdd->prepare('UPDATE balises 
	       		SET inondee=:in, niveau=:niv  
	       		WHERE id=:id');
$request->execute(array('in' => $inondee, 'niv' => $niveau, 'id' => $id));
?>


		






         
