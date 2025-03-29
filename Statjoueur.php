<! affichage du tableau donnant le nombre de parties gagantes par joueur >
<! avec classement par ordre décroissant >
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
$rqSql = "SELECT j.nom_joueur, COUNT(*) AS nb_gagnants
FROM joueur j
JOIN ordre_score o ON j.id_joueur = o.id_joueur
JOIN (
    SELECT id_partie, MAX(score) AS max_score
    FROM ordre_score
    GROUP BY id_partie
) AS max_scores ON o.id_partie = max_scores.id_partie AND o.score = max_scores.max_score
GROUP BY j.nom_joueur
ORDER BY nb_gagnants DESC;
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






