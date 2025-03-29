<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <meta charset="UTF-8">
<title>Fin de partie SCRABBLE </title>
<link rel="stylesheet" href="styles.css"> 
</head>

<body >
	<?php
	require('header.php');
	require('Resultat.php');
	$FinPartie = true; // pour modifier affichage de joueur en cours
	if( $ordre!=0 ) {
	require('joueurencours.php');} // ordre = 0 si on revient sur fin de partie aorès aviur saisi les points restants
	//***********************
	// compter partie en cours
	// si > 1 on entre pour la première fois en fin de partie
	// permet de bloquer la sasie des scores et ne laisser que les résultats s'afficher
	//**********************
	$rqSql = "SELECT count(*) AS NBENCOURS FROM ordre_score WHERE encours = true AND id_partie = $partie";
	$result1 = mysqli_query($connexion, $rqSql )
	or die( "Execution requete impossible.");
	$row = mysqli_fetch_assoc($result1);
	$NBENCOURS = $row['NBENCOURS']; 
	

	// Requête 1  SQL : liste des joueurs qui gardent des lettres
	$rqSql1 = "SELECT j.nom_joueur, o.id_joueur,  o.score 
           FROM ordre_score o 
           JOIN joueur j ON o.id_joueur = j.id_joueur 
           WHERE o.id_partie = $partie AND o.num_ordre!=$ordre
           ORDER BY o.num_ordre";
	$result1 = mysqli_query($connexion, $rqSql1)
   	 or die("Exécution requête impossible.");
		
	// Conserver les résultats 
	$joueurs = [];
	while ($row = mysqli_fetch_assoc($result1)) {
    	$joueurs[] = [ 
        	'nom' => $row['nom_joueur'], 
        	'id' => $row['id_joueur'],
        	'score' => $row['score'],
        	];}
	?>
	<form action="" method="post">
		
		<?php
		if ($NBENCOURS > 0) { 
			$index = 0;  // Initialisation de l'index	
    			foreach ($joueurs as  $j) {
			$index++;  // Incrémente l'index à chaque itération
        		echo "<label>Points restants " . $j['nom'] . ": <input type='number' name='ajout_" . $index . "' value='' /></label>";
    			}

    			echo "<input type='submit' value='valider et finir la partie'>";
		} else {
        	        echo "<br><br>";
        		echo "<a href='Menu.php'><button type='button'>Accueil</button></a>"; // Utilisation d'un lien avec un bouton
    		}
		?>

	</form>
	
      	<?php
   	 	// Vérification si le formulaire a été soumis
    		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$index = 0;  // Initialisation de l'index
				$total_ajout=0;
				foreach ($joueurs as $j) {
					$index++;  // Incrémente l'index à chaque itération
					$nouveauscore = $j['score'] - (int)$_POST['ajout_' . $index];
    					$total_ajout=$total_ajout+(int)$_POST['ajout_' . $index];
					$rqSql = "UPDATE ordre_score SET score = $nouveauscore WHERE id_partie = '$partie' AND id_joueur = " . $j['id'];
					
					$result1 = mysqli_query($connexion, $rqSql )
					or die( "Execution requete impossible.");
					
				}
				// ajouter les points restants au dernier joueur
				$nouveauscore=$score+$total_ajout;
        			$rqSql = "UPDATE ordre_score SET score = $nouveauscore WHERE id_partie = '$partie' AND num_ordre = '$ordre'";							$result1 = mysqli_query($connexion, $rqSql )
				or die( "Execution requete impossible.");
				
				// effacer partie en cours
				$rqSql = "UPDATE ordre_score SET encours = False WHERE id_partie = '$partie'";
				$result1 = mysqli_query($connexion, $rqSql )
				or die( "Execution requete impossible.");
				
    				// appel page suivantee via JavaScript après soumission
    				echo "<script>
       		    		 window.location.href = 'FinPartie.php?partie=" . $partie . "&joueur=" . $joueur . "&ordre=0'; // Redirection après soumission
    				</script>";
    		}
		    	
	?>
	


</body>
</html>
