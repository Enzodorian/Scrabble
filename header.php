
<?php

echo "<h1>SCRABBLE</h1>"; 
echo "<br>";
echo "<br>";
// connexion Ã  la base
$serveurBD = "localhost";
$nomUtilisateur = "root";
$motDePasse = "";
$Database = "SCRABBLE";

$connexion = mysqli_connect($serveurBD, $nomUtilisateur,  $motDePasse, $Database);

// VÃ©rifier la connexion
if (!$connexion) { die('Connexion Echouee : ' . mysqli_connect_error());}

// DÃ©finir explicitement le jeu de caractÃ¨res en utf8
mysqli_set_charset($connexion, 'utf8mb4');

if (isset($_GET['joueur'])) { $joueur = $_GET['joueur'];} 
if (isset($_GET['ordre'])) { $ordre = $_GET['ordre'];} 
if (isset($_GET['partie'])) { $partie = $_GET['partie'];}
else
	{
	// requete  : nombre de parties pour trouver l'identifiant unique de la nouvelle partie
	$rqSql = "SELECT MAX(id_partie) AS NB_PARTIE FROM PARTIES ";
	// Exécution de la requête 
	$result = mysqli_query($connexion, $rqSql )
	or die( "Execution requete impossible.");
	$ligne = $result->fetch_assoc(); // Récupère la ligne de résultats sous forme de tableau associatif
	$partie = (int) $ligne['NB_PARTIE']+1; // Cela donne l'identifiant de la nouvelle partie
	
	}
if (isset($_GET['NB_JOUEURS'])) { $nbjoueurs = $_GET['NB_JOUEURS'];}
else
	{
	// requete  : nombre de joueur pour la partie en cours
	$rqSql = "SELECT COUNT(*) AS NB_JOUEURS FROM ordre_score WHERE id_partie='$partie'";
	// Exécution de la requête 
	$result = mysqli_query($connexion, $rqSql )
	or die( "Execution requete impossible.");
	$ligne = $result->fetch_assoc(); // Récupère la ligne de résultats sous forme de tableau associatif
	$nbjoueurs = (int) $ligne['NB_JOUEURS']; 
	}

?>
