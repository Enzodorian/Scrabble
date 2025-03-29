<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
    <meta charset="UTF-8">
    <title>joueur de la partie en cours</title>
   	<link rel="stylesheet" href="styles.css"> 

   	<script>
	    function updateCombo(combo1, combo2, combo3,combo4) {
            let selectedValue1 = combo1.value;
            let selectedValue2 = combo2.value;
            let selectedValue3 = combo3.value;
	    let selectedValue4 = combo4.value;

            // Réactiver toutes les options dans chaque combo
            resetCombo(combo1);
            resetCombo(combo2);
            resetCombo(combo3);
	    resetCombo(combo4);

            // Désactiver l'option sélectionnée dans les autres combos
            if (selectedValue1) {
                disableOption(combo2, selectedValue1);
                disableOption(combo3, selectedValue1);
		disableOption(combo4, selectedValue1);
            }
            if (selectedValue2) {
                disableOption(combo1, selectedValue2);
                disableOption(combo3, selectedValue2);
		disableOption(combo4, selectedValue2);
            }
            if (selectedValue3) {
                disableOption(combo1, selectedValue3);
                disableOption(combo2, selectedValue3);
		disableOption(combo4, selectedValue3);
            }
	    if (selectedValue4) {
                disableOption(combo1, selectedValue4);
                disableOption(combo2, selectedValue4);
		disableOption(combo3, selectedValue4);
            }
        }
   	// Fonction pour réactiver toutes les options d'un combo
        function resetCombo(combo) {
            for (let option of combo.options) {
                option.disabled = false;
            }
        }

        // Fonction pour désactiver une option spécifique
        function disableOption(combo, value) {
            for (let option of combo.options) {
                if (option.value == value) {
                    option.disabled = true;
                }
            }
        }
    </script>
</head>
     
 	


<body>
	<?php
	require('header.php');
	$datetime = date('Y-m-d H:i:s');
	echo " Date : $datetime";
	echo "<br>";
	echo "<br>";
	// Requête 1  SQL : liste des joueurs
	$rqSql1 = "SELECT NOM_JOUEUR, ID_JOUEUR FROM JOUEUR ";
	// Exécution de la requête 1
	$result1 = mysqli_query($connexion, $rqSql1 )
	or die( "Execution requete impossible.");
	// Conserver les résultats 
	$joueurs = [];
	while ($row = mysqli_fetch_assoc($result1)) {
    	$joueurs[] = [ 'nom' => $row['NOM_JOUEUR'], 'id' => $row['ID_JOUEUR'] ];}
	?>
	<p> <br><br> Choisir les joueurs de la partie <br><br></p> 
	<form method="POST" >
        <label for="joueur1">Premier joueur          :</label>
        <select name="joueur1" id="joueur1" onchange="updateCombo(joueur1, joueur2,joueur3,joueur4)">>
            
            // Affichage dynamique des options de la combobox
		<option value="" selected disabled>-- Choisir un joueur --</option>
		<?php
			foreach ($joueurs as $joueur) {
    		    	echo "<option value='" . $joueur['id'] . "'>" . $joueur['nom'] . "</option>"; }
        	?>
        </select>
        <br><br>
	<label for="joueur2">Deuxième joueur    :</label>
        <select name="joueur2" id="joueur2" onchange="updateCombo(joueur1, joueur2,joueur3,joueur4)">
            
            // Affichage dynamique des options de la combobox
		<option value="" selected disabled>-- Choisir un joueur --</option>
		<?php
			foreach ($joueurs as $joueur) {
    		    echo "<option value='" . $joueur['id'] . "'>" . $joueur['nom'] . "</option>"; }
        	?>
        </select>
        <br><br>
	<label for="joueur3">Troisième joueur  :</label>
        <select name="joueur3" id="joueur3" onchange="updateCombo(joueur1, joueur2,joueur3,joueur4)">
             // Affichage dynamique des options de la combobox
		<option value="" selected disabled>-- Choisir un joueur --</option>
		<?php
			foreach ($joueurs as $joueur) {
    		    echo "<option value='" . $joueur['id'] . "'>" . $joueur['nom'] . "</option>";}
        	?>
        </select>
        <br><br>
	  	<label for="joueur4">Quatrième joueur :</label>
        	<select name="joueur4" id="joueur4" onchange="updateCombo(joueur1, joueur2,joueur3,joueur4)">
            // Affichage dynamique des options de la combobox
		<option value="" selected disabled>-- Choisir un joueur --</option>
		<?php
			foreach ($joueurs as $joueur) {
    		    echo "<option value='" . $joueur['id'] . "'>" . $joueur['nom'] . "</option>"; }
            	?>
        </select>
        <br><br><br>
        <input type="submit" value="valider et commencer la partie">
   </form>
  

<?php
    // Vérification si le formulaire a été soumis
    	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	  // Créer un enregistement dasn table PARTIES
		$numero=0;
		$encours=True;
		$ligne = "INSERT INTO PARTIES VALUES ($partie, '$datetime')";
		mysqli_query($connexion, $ligne )
		or die( "Execution requete impossible."); 
          // Récupérer l'id du joueur sélectionné
		if (!empty($_POST['joueur1'])) {
			$joueur1 = $_POST['joueur1'];
			$numero=$numero+1;
			// requete 4-1 : initialiser le score pour joueur1 qui sera le joueur actif
			$ligne = "INSERT INTO ordre_score VALUES ($partie, $joueur1,True,$numero,0)";
			mysqli_query($connexion, $ligne )
			or die( "Execution requete impossible.");
			$encours=False;} 
			
		if (!empty($_POST['joueur2'])){
	 		$joueur2 = $_POST['joueur2'];
			$numero=$numero+1;
			// requete 4-2 : initialiser le score pour joueur2 non actif
			$ligne = "INSERT INTO ORDRE_SCORE VALUES ($partie, $joueur2,False,$numero,0)";
			mysqli_query($connexion, $ligne )
			or die( "Execution requete impossible.");
			$encours=False;}      
	 		
		if (!empty($_POST['joueur3'])){
			$joueur3 = $_POST['joueur3'];
			$numero=$numero+1;
			// requete 4-3 : initialiser le score pour joueur3 non actif
			$ligne = "INSERT INTO ORDRE_SCORE VALUES ($partie, $joueur3,False,$numero,0)";
			mysqli_query($connexion, $ligne )
			or die( "Execution requete impossible.");
			$encours=False;}      	
			
		if (!empty($_POST['joueur4'])){
			$joueur4 = $_POST['joueur4'];
			$numero=$numero+1;
			// requete 4-4 : initialiser le score pour joueur4 non actif
			$ligne = "INSERT INTO ORDRE_SCORE VALUES ($partie, $joueur4,False,$numero,0)";
			mysqli_query($connexion, $ligne )
			or die( "Execution requete impossible.");
			$encours=False;}      
			
		echo "<br><br>";
		
		
		// appel page suivantee via JavaScript après soumission
    		echo "<script>
       		     window.location.href = 'score.php?partie=" . $partie . "&joueur=" . $joueur1 . "&ordre=1'; // Redirection après soumission
    		</script>";

    		}

    ?>
</body>
</html>
