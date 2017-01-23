<?php

 // Fonction Connexion: connexion à MySQL

 function Connexion ($pNom, $pMotPasse, $pBase, $pServeur)
 {
  // Connexion au serveur 
  $connexion = new mysqli($pServeur, $pNom, $pMotPasse,$pBase);

  if (!$connexion) {
    echo "Désolé, connexion au serveur $pServeur impossible\n";
	
    exit;
  }


  // // Connexion à la base
  // if (!mysql_select_db ($pBase, $connexion)) {
    // echo "Désolé, accès à la base $pBase impossible\n";
    // echo "<b>Message de MySQL :</b> " . mysql_error($connexion);
    // exit;
  // }

  // // On renvoie la variable de connexion
  return $connexion;
 } // Fin de la fonction
?>