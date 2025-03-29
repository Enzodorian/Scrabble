<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title> score joueur en cours</title>
    <link rel="stylesheet" href="styles.css"> 
    
  </head>
  <body>
     <?php
	require('header.php');
	require('Resultat.php');
	require('joueurencours.php');
	// Affichage de l'image du joueur
    	if ($photo) {
        	// Encode les données binaires de l'image en base64
       	 	$photoBase64 = base64_encode($photo);
        
        	// Affiche l'image en utilisant la syntaxe base64 dans un tag <img>
        	
		echo "<img src='data:image/jpeg;base64,$photoBase64' style='width: 300px; display: block; margin-left: auto; margin-right: auto;'>";


   		 } else {
       		 echo "<p style='text-align: center;'>Aucune image disponible pour ce joueur.</p>";
    		}
    
	
	?>
	
	<form action="" method="post">
  		<label>Ajouter au Score  : <input type="number" name="score_ajout" value="" autofocus/></label>
  		
	</form>
	
      	<?php
   	 	// Vérification si le formulaire a été soumis
    		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        		if (!empty($_POST['score_ajout'])) {
            			$score_nouveau = $_POST['score_ajout']+$score;
           		 	
				$rqSql = "UPDATE ordre_score SET score = '$score_nouveau', encours=False WHERE id_partie = '$partie' and num_ordre='$ordre'";
				$result = mysqli_query($connexion, $rqSql )
				or die( "Execution requete impossible.");
				echo "<br><br>";
            			$ordre<$nbjoueurs ? $ordre=$ordre+1 :$ordre=1;
				$rqSql = "UPDATE ordre_score SET  encours=True WHERE id_partie = '$partie' and num_ordre='$ordre'";
				$result = mysqli_query($connexion, $rqSql )
				or die( "Execution requete impossible.");
				//echo "<a href='score.php?partie=" . $partie . "&joueur=" . $joueur . "&ordre=" . $ordre. "'>Joueur suivant</a>";
				// appel page suivantee via JavaScript après soumission
    				echo "<script>
       		     		window.location.href = 'score.php?partie=" . $partie . "&joueur=" . $joueur . "&ordre=" . $ordre. "'; 
    				</script>";
				
        		}
    		}
		echo"<br>";
		$ordre>1 ? $ordre=$ordre-1 :$ordre=$nbjoueurs;
		echo "<h1 style='text-align: center;'><a href='FinPartie.php?partie=" . $partie . "&joueur=" . $joueur . "&ordre=" . $ordre. "'>Fin de Partie</a></h1>";    	
	?>
	
            
  </body>
</html>