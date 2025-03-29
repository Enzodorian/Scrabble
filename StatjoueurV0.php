<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Stat joueur </title>
<link rel="stylesheet" href="styles.css"> 

</head>
<body>
<table>
    <thead>
        <tr>
            <th>Nom    </th>
            <th>Nb Parties gagnantes     </th>
            
           
        </tr>
    </thead>
<tbody>
<?php
echo "<br>";
$rqSql = "SELECT j.nom_joueur,count(*) as nb_gagnants
 FROM joueur j 
JOIN ordre_score o ON j.id_joueur=o.id_joueur
WHERE (o.id_joueur, o.id_partie, o.score) IN ( 
	SELECT o2.id_joueur, o2.id_partie, o2.score
	FROM ordre_score o2
	WHERE (o2.id_partie, o2.score) IN (
    		SELECT id_partie, MAX(score)
    		FROM ordre_score
    	GROUP BY id_partie
	
)
 ) 
GROUP BY j.nom_joueur
ORDER  BY nb_gagnants DESC
";

// ExÃƒÂ©cution de la requÃƒÂªte 1

$result1 = mysqli_query($connexion, $rqSql )
or die( "Execution requete impossible.");
// afficher les rÃƒÂ©sultats 

$numero=0;
while ($row = mysqli_fetch_assoc($result1)) {
   
    echo "<tr>";	
    echo "<td>" .  $row['nom_joueur'] . "</td><td>" . $row['nb_gagnants'] . "</td>";
    echo "</tr>";
    }

?>
<br><br><br><br><br>
 </tbody>
</table>
</body>
</html>






