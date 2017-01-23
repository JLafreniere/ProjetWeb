<?php
 // Exécution d'une requête avec MySQL

 function ExecRequete ($requete, $connexion)
 {
  $resultat =  $connexion->query($requete);

  if ($resultat)
   return $resultat;
  else {  
     echo "<b>Erreur dans l'exécution de la requête '$requete'.</b><br/>";
     echo "<b>Message de MySQL :</b> " .  mysqli_error($connexion);
    exit;
  }  
 } // Fin de la fonction ExecRequete

 // Recherche de l'objet suivant
 function ObjetSuivant ($resultat)
 {
   return  mysqli_fetch_object ($resultat);
 } 

 // Recherche de la ligne suivante (retourne un tableau)
 function LigneSuivante ($resultat)
 {
   return  mysqli_fetch_assoc ($resultat);
 }
?>
