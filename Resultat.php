<! Affichage du résultat actualisé avec classement provisoire>

<table>
    <thead>
        <tr>
            <th>rang    </th>
            <th>Nom     </th>
            <th>Score</th>
           
        </tr>
    </thead>
<tbody>
<?php
echo "<br>";
$rqSql = "SELECT j.nom_joueur,o.id_partie,o.score FROM ordre_score o JOIN joueur j ON o.id_joueur=j.id_joueur WHERE o.id_partie = '$partie'
ORDER BY o.score DESC";
// ExÃƒÂ©cution de la requÃƒÂªte 1

$result1 = mysqli_query($connexion, $rqSql )
or die( "Execution requete impossible.");
// afficher les rÃƒÂ©sultats 

$numero=0;
while ($row = mysqli_fetch_assoc($result1)) {
    $numero=$numero+1;
    echo "<tr>";	
   
    echo "<td>" . $numero . "</td><td>" . $row['nom_joueur'] . "</td><td><strong style='font-size: 20px;'>" . $row['score'] . "</strong></td>";
    echo "</tr>";
    }

?>
<br>
 </tbody>
</table>



