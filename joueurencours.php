<! Afficher les infos du joueur en cors ou dernier à terminer la partie (indocateur $FinPartie)>
	<?php
	// Requête 1  SQL : lire données sur joueur en cours
	$rqSql = "SELECT j.nom_joueur, j.img_blob, o.score FROM ordre_score o JOIN joueur j ON o.id_joueur=j.id_joueur AND o.id_partie='$partie' AND o.num_ordre='$ordre'";
	// Exécution de la requête 1
	
	$result = mysqli_query($connexion, $rqSql )
	or die( "Execution requete impossible.");
	$ligne = $result->fetch_assoc(); // Récupère la ligne de résultats sous forme de tableau associatif
	$nom = $ligne['nom_joueur']; 
	$score = $ligne['score']; 
	$photo = $ligne['img_blob']; 
	// afficher lecteur en cours
	if (isset($FinPartie)) { 
    		echo "<h1 style='text-align: center;'>Dernier Joueur :   $nom </h1>";
	} else {
   		 echo "<h1 style='text-align: center;'>Joueur en cours :   $nom </h1>";
}

	?>

