<?php
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'http://172.26.189.22:8080/api/internal/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "{  \n   \"email\": \"admin\",  \n   \"password\": \"admin\"  \n }");

$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = 'Accept: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);
$result=json_decode($result,true);
echo $result['jwt'];

$ch = curl_init();

$requete="{  \n   \"device\": {  \n     \"applicationID\": \"9\",  \n     \"description\": \"sensor\",  \n     \"devEUI\": \"".$_POST['idA']."\",  \n     \"deviceProfileID\": \"61f0844c-4ffa-4979-9ebf-3531a348baa3\",  \n     \"isDisabled\": true,  \n     \"name\": \"".$_POST['localisationA']."\",  \n     \"referenceAltitude\": 0,  \n     \"skipFCntCheck\": true,  \n     \"tags\": {},  \n     \"variables\": {}  \n   }  \n }";
curl_setopt($ch, CURLOPT_URL, 'http://172.26.189.22:8080/api/devices');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $requete);

$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = 'Accept: application/json';
$headers[] = 'Grpc-Metadata-Authorization: Bearer '.$result['jwt'];
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

echo $result;
$result=json_decode($result,true);
echo " fock ";
echo $result['code'];
if($result==null){
	include("../listeRequete.php"); 
 	try{
    		// On se connecte a postgres
		$bdd = new PDO("pgsql:host=localhost;port=5432;dbname=pfe;user=root;password=glopglop");
	}
	catch(Exception $e){
		// En cas d'erreur, on affiche un message et on arrête tout
        	die('Erreur : '.$e->getMessage());
	}
	$reponse=$bdd->prepare($req21);
	$reponse->execute(array('id'=>$_POST['idA'],'pays'=>$_POST['paysA'],'ville'=>$_POST['villeA'], 'localisation'=>$_POST['localisationA'],'coordonnees'=>$_POST['coordonneesA']));
	
	header('Location: ../index.php?code=1');
}
//wrong devEUI
elseif($result['code']==3){
	header('Location: ../index.php?code=3');
}

//an object is already created
else if($result['code']==6){
	header('Location: ../index.php?code=6');
}
else{
	header('Location: ../index.php.code=0');
}

?>
