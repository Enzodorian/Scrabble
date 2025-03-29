<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Application SCRABBLE </title>
<link rel="stylesheet" href="styles.css"> 
</head>

<body>
<?php
require('header.php');
// requete  : recherche partie en cours
$rqSql = "SELECT count(*) AS NB_ENCOURS FROM ordre_score WHERE encours =true";
// Exécution de la requête 
$result = mysqli_query($connexion, $rqSql )
or die( "Execution requete impossible.");
$ligne = $result->fetch_assoc(); // Récupère la ligne de résultats sous forme de tableau associatif
$nbencours = (int) $ligne['NB_ENCOURS']; 
if ($nbencours==0)  // pas de partie en cours
	{
	echo "<h1 style='text-align: center;'> <a href='joueur.php?partie=$partie'>Commencer une nouvelle partie</a><br><br>";
	echo "<a href='stats.php?partie=$partie'>Statistiques</a></h1>";
	}
else
	{
	// requete  : recherche joueur en cours
	$rqSql = "SELECT id_partie,id_joueur,num_ordre  FROM ordre_score WHERE encours =true";
	// Exécution de la requête 
	$result = mysqli_query($connexion, $rqSql )
	or die( "Execution requete impossible.");
	$ligne = $result->fetch_assoc(); // Récupère la ligne de résultats sous forme de tableau associatif
	$partie =  $ligne['id_partie']; 
	$joueur =  $ligne['id_joueur']; 
	$ordre =  $ligne['num_ordre']; 
	echo "<script>
        window.location.href = 'score.php?partie=" . $partie . "&joueur=" . $joueur . "&ordre=" . $ordre . "'; 
    	</script>";

	}
?>
</body>
</html>

