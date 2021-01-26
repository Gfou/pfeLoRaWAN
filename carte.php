<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
	<script src="https://maps.google.com/maps/api/js?key=AIzaSyCDONsgNQkHD0VrPlwRc3FqGjkVnr_TzO0&libraries=visualization" type="text/javascript"></script>
	<script async type="text/javascript">
			// On initialise la latitude et la longitude de Paris (centre de la carte)
			var lat = 50.630409;
			var lon = 3.059348;
			var map = null;
			<?php
			    try{
	    		    // On se connecte a postgres
				$bdd = new PDO("pgsql:host=localhost;port=5432;dbname=pfe;user=root;password=glopglop");
    			    }			
    			    catch(Exception $e){
	    		// En cas d'erreur, on affiche un message et on arrête tout
        		    	die('Erreur : '.$e->getMessage());
			    }
			$reponse=$bdd->query('SELECT COUNT(*) FROM balises');
  			$nbMarqueur=$reponse->fetch();
			?>
			var nbMarqueur=<?php echo $nbMarqueur['count'];?>;
			var locations = new Array(nbMarqueur);
			var coordonnees, coord1, coord2;
			var heatMapData = new Array(nbMarqueur);
			<?php
			$reponse=$bdd->query('SELECT localisation, coordonnees, niveau FROM balises');
			?>
			var infos =JSON.parse('<?php echo json_encode($reponse->fetchAll(), true); ?>');
			console.log(nbMarqueur);
			for(var i=0; i<nbMarqueur; i++){
				locations[i]=new Array(4);
				locations[i][0]=infos[i]['localisation'];
				coordonnees=infos[i]['coordonnees'];
				var pos=coordonnees.indexOf(",");
				coord1=coordonnees.slice(0,pos-1);
				coord2=coordonnees.slice(pos+1);
				locations[i][1]=coord1;
				locations[i][2]=coord2,
				locations[i][3]=i;
				heatMapData[i]={location: new google.maps.LatLng(coord1, coord2), weight: infos[i]['niveau']};
			}
			
			
			//var locations = [
      			//	['Bondi Beach', -33.890542, 151.274856, 4],
      			//	['Coogee Beach', -33.923036, 151.259052, 5],
      			//	['Cronulla Beach', -34.028249, 151.157507, 3],
      			//	['Manly Beach', -33.80010128657071, 151.28747820854187, 2],
      			//	['Maroubra Beach', -33.950198, 151.259302, 1]
			//];
			// Fonction d'initialisation de la carte
			function initMap() {
				// Créer l'objet "map" et l'insèrer dans l'élément HTML qui a l'ID "map"
				map = new google.maps.Map(document.getElementById("map"), {
					// Nous plaçons le centre de la carte avec les coordonnées ci-dessus
					center: new google.maps.LatLng(lat, lon), 
					// Nous définissons le zoom par défaut
					zoom: 11, 
					// Nous définissons le type de carte (ici carte routière)
					mapTypeId: google.maps.MapTypeId.ROADMAP, 
					// Nous activons les options de contrôle de la carte (plan, satellite...)
					mapTypeControl: true,
					// Nous désactivons la roulette de souris
					scrollwheel: true, 
					mapTypeControlOptions: {
						// Cette option sert à définir comment les options se placent
						style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR 
					},
					// Activation des options de navigation dans la carte (zoom...)
					navigationControl: true, 
					navigationControlOptions: {
						// Comment ces options doivent-elles s'afficher
						style: google.maps.NavigationControlStyle.ZOOM_PAN 
					}
				});
				var infowindow = new google.maps.InfoWindow();
				var marker, i;

    				/*for (i = 0; i < locations.length; i++) {
      					marker = new google.maps.Marker({
        				position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        				map: map
					});
					google.maps.event.addListener(marker, 'click', (function(marker, i) {
        					return function() {
          						infowindow.setContent(locations[i][0]);
          						infowindow.open(map, marker);
        					}
      					})(marker, i));
				}*/
				var heatmap = new google.maps.visualization.HeatmapLayer({
					data: heatMapData, radius: 0.005, dissipating:false
				});
				heatmap.setMap(map);			
			}
			window.onload = function(){
				// Fonction d'initialisation qui s'exécute lorsque le DOM est chargé
				initMap(); 
			};
		</script>
		<style type="text/css">
			#map{ /* la carte DOIT avoir une hauteur sinon elle n'apparaît pas */
				height:800px;
			}
		</style>
		<title>Carte</title>
	</head>
	<body style="background-color:#E2EEFF;">
	<?php include("navBar.php"); ?>
		<div id="map">
			<!-- Ici s'affichera la carte -->
		</div>
	</body>
</html>

