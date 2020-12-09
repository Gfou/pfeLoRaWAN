<?php

$req1IdLocNoDate='SELECT h.ID, h.id_balise, h.Date, b.Pays, b.Ville, b.Localisation, h.Niveau, h.Inondee 
                  FROM balises b,historique_balise h 
                  WHERE id_balise = :id AND b.ID = h.id_balise AND Localisation = :localisation';

$req2IdNoLocNoDate='SELECT h.id, h.id_balise, h.date, b.pays, b.ville, b.localisation, h.niveau, h.inondee
                    FROM historique_balise h, balises b
                    WHERE id_balise = :id AND b.id = h.id_balise';

$req3NoIdLocNoDate='SELECT h.ID, h.id_balise, h.Date, b.Pays, b.Ville, b.Localisation, h.Niveau, h.Inondee
                    FROM historique_balise h, balises b
                    WHERE Localisation = :localisation AND b.ID = h.id_balise';

$req4IdLocDate='SELECT h.ID, h.id_balise, h.Date, b.Pays, b.Ville, b.Localisation, h.Niveau, h.Inondee
                FROM historique_balise h, balises b 
                WHERE Localisation = :localisation AND id_balise = :id AND b.ID = h.id_balise AND date_part(\'day\',h.Date)>= :jourDebut 
		AND date_part(\'day\',h.Date)<= :jourFin  AND date_part(\'month\',h.Date)>= :moisDebut AND date_part(\'month\',h.Date) <= :moisFin 
		AND date_part(\'year\',h.Date)>= :anneeDebut AND date_part(\'year\',h.Date) <= :anneeFin';

$req5IdNoLocDate='SELECT h.ID, h.id_balise, h.Date, b.Pays, b.Ville, b.Localisation, h.Niveau, h.Inondee 
                  FROM historique_balise h, balises b
                  WHERE id_balise = :id AND b.ID = h.id_balise AND date_part(\'day\',h.Date)>= :jourDebut AND date_part(\'day\',h.Date)<= :jourFin  
		  AND date_part(\'month\',h.Date)>= :moisDebut AND date_part(\'month\',h.Date) <= :moisFin AND date_part(\'year\',h.Date)>= :anneeDebut 
		  AND date_part(\'year\',h.Date) <= :anneeFin';

$req6NodIdLocDate='SELECT h.ID, h.id_balise, h.Date, b.Pays, b.Ville, b.Localisation, h.Niveau, h.Inondee
                   FROM historique_balise h, balises b
                   WHERE Localisation = :localisation AND b.ID = h.id_balise AND date_part(\'day\',h.Date)>= :jourDebut AND date_part(\'day\',h.Date)<= :jourFin  
		   AND date_part(\'month\',h.Date)>= :moisDebut AND date_part(\'month\',h.Date) <= :moisFin AND date_part(\'year\',h.Date)>= :anneeDebut 
		   AND date_part(\'year\',h.Date) <= :anneeFin';

$req7IdLocDateDebut='SELECT h.ID, h.id_balise, h.Date, b.Pays, b.Ville, b.Localisation, h.Niveau, h.Inondee
                     FROM historique_balise h, balises b 
                     WHERE Localisation = :localisation AND b.ID = h.id_balise AND id_balise = :id AND date_part(\'day\',h.Date)>= :jourDebut 
		     AND date_part(\'month\',h.Date)>= :moisDebut AND date_part(\'year\',h.Date)>= :anneeDebut';

$req8IdNoLocDateDebut='SELECT h.ID, h.id_balise, h.Date, b.Pays, b.Ville, b.Localisation, h.Niveau, h.Inondee 
                       FROM historique_balise h, balises b 
                       WHERE h.id_balise = :id AND b.ID = h.id_balise AND date_part(\'day\',h.date)>=:jourDebut AND date_part(\'month\',h.date)>= :moisDebut 
		       AND date_part(\'year\',h.date)>= :anneeDebut';

$req9NoIdLocDateDebut='SELECT h.ID, h.id_balise, h.Date, b.Pays, b.Ville, b.Localisation, h.Niveau, h.Inondee 
                       FROM historique_balise h, balises b
                       WHERE Localisation = :localisation AND b.ID = h.id_balise AND date_part(\'day\',h.Date)>= :jourDebut 
		       AND date_part(\'month\',h.Date)>= :moisDebut AND date_part(\'year\',h.Date)>= :anneeDebut';

$req10IdLocDateFin='SELECT h.ID, h.id_balise, h.Date, b.Pays, b.Ville, b.Localisation, h.Niveau, h.Inondee 
                    FROM historique_balise h, balises b 
                    WHERE Localisation = :localisation AND b.ID = h.id_balise AND id_balise = :id AND date_part(\'day\',h.Date)<= :jourFin  
		    AND date_part(\'month\',h.Date) <= :moisFin  AND date_part(\'year\',h.Date) <= :anneeFin';

$req11IdNoLocDateFin='SELECT h.ID, h.id_balise, h.Date, b.Pays, b.Ville, b.Localisation, h.Niveau, h.Inondee 
                      FROM historique_balise h, balises b 
                      WHERE id_balise = :id AND b.ID = h.id_balise AND date_part(\'day\',h.Date)<= :jourFin AND date_part(\'month\',h.Date) <= :moisFin  
		      AND date_part(\'year\',h.Date) <= :anneeFin';

$req12noIdLocDateFin='SELECT h.ID, h.id_balise, h.Date, b.Pays, b.Ville, b.Localisation, h.Niveau, h.Inondee 
                      FROM historique_balise h, balises b 
                      WHERE Localisation = :localisation AND b.ID = h.id_balise AND date_part(\'day\',h.Date)<= :jourFin  
		      AND date_part(\'month\',h.Date) <= :moisFin  AND date_part(\'year\',h.Date) <= :anneeFin';

?>
