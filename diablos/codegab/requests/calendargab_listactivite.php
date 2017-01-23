<?php
/*
Auteur: 		Gabriel Dubé
Description:	Liste les activité dans le calendrier
*/

require_once (__DIR__ . "\/..\/..\/Connexion\/Connect.php");
require_once (__DIR__ . "\/..\/..\/Connexion\/Connexion.php");
require_once (__DIR__ . "\/..\/..\/Connexion\/ExecRequete.php");
 

$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
mysqli_set_charset($connexion,'UTF8');
$data = [];

$requete = "
    SELECT 
      id, 
      DATE_FORMAT(date, '%Y-%c-%d') as date,
      heure,
      endroit,
      equipeReceveur,
      equipeVisiteur,
      type,
      codePostal
    FROM
      evenement 
    ORDER BY date;";
    
$stmt = $connexion->prepare($requete);
$stmt->execute();
$stmt->bind_result($id,
    $strdate,
    $heure,
    $endroit,
    $equipeR,
    $equipeV,
    $type,
    $codep
);


while ($stmt->fetch()) {
    $nom = $type." ".$equipeR." vs ".$equipeV;
    $date = $strdate;
    $des = "Heure: ".( ($heure && $heure!="00:00:00") ? $heure : "Non défini") .
           "<br> Endroit: ".($endroit ? $endroit : "Non défini") . " " . ($codep ? $codep : ($endroit ? "Non défini" : ""));
    $entry = ["id"=>$id, "nom"=>$nom, "des"=>$des, "date"=>$date];
    
    $data[] = json_encode($entry, JSON_FORCE_OBJECT);
}

echo json_encode($data);