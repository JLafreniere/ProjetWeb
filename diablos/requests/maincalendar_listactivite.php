<?php
/*
Auteur: 		Gabriel Dubé
Description:	Liste les activité dans le calendrier
*/

require_once ("../Connexion/Connect.php");
require_once ("../Connexion/Connexion.php");
require_once ("../Connexion/ExecRequete.php");
 

$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
$data = [];

$skip_endroit = empty($_GET["endroit"]) || strlen(preg_replace('/\s+/', '', $_GET["endroit"])) == 0;
$skip_receveur = empty($_GET["receveur"]) || strlen(preg_replace('/\s+/', '', $_GET["receveur"])) == 0;
$skip_visiteur = empty($_GET["visiteur"]) || strlen(preg_replace('/\s+/', '', $_GET["visiteur"])) == 0;
$skip_mindate = empty($_GET["mind"]) || strlen(preg_replace('/\s+/', '', $_GET["mind"])) == 0;
$skip_maxdate = empty($_GET["maxd"]) || strlen(preg_replace('/\s+/', '', $_GET["maxd"])) == 0;

$endroit_val = $skip_endroit ? "" : '%' . $_GET["endroit"] . '%';
$receveur_val = $skip_receveur ? "" : '%' . $_GET["receveur"] . '%';
$visiteur_val = $skip_visiteur ? "" : '%' . $_GET["visiteur"] . '%';
$mindate_val = $skip_mindate ? "1900-01-01" :  $_GET["mind"];
$maxdate_val = $skip_maxdate ? "2101-01-01" : $_GET["maxd"];

$requete = "
SELECT 
  id, 
  DATE_FORMAT(date, '%Y-%c-%d') as date_,
  heure,
  endroit,
  rue,
  codePostal,
  equipeReceveur,
  equipeVisiteur
FROM 
  evenement
WHERE
  (TRUE = ? OR (CONCAT(endroit, ' ', rue) LIKE ? OR codePostal LIKE ? ) ) AND
  (TRUE = ? OR equipeReceveur LIKE ? ) AND
  (TRUE = ? OR equipeVisiteur LIKE ? ) AND
  (date BETWEEN CONCAT(?, ' ', '00:00:00') AND CONCAT(?, ' ', '23:59:59') )
ORDER BY 
  date;";

$stmt = $connexion->prepare($requete);
$stmt->bind_param("issisisss", 
  $skip_endroit, $endroit_val, $endroit_val,
  $skip_receveur, $receveur_val,
  $skip_visiteur, $visiteur_val,
  $mindate_val, $maxdate_val);
$stmt->execute();
$stmt->bind_result($id, $strdate, $heure, $endroit, $rue, $codep, $equipeR, $equipeV);

while ($stmt->fetch()) {
    $nom = utf8_encode("Match ".$equipeR." vs ".$equipeV);
    $des = utf8_encode($nom." à l'emplacement ".$endroit." . Heure du match: ".$heure.".");
    $location = utf8_encode($endroit . " ". $rue . " " . $codep );
    $entry = ["id"=>$id, "nom"=>$nom, "des"=>$des, "date"=>$strdate, "loc"=>$location];
    
    $t = json_encode($entry, JSON_FORCE_OBJECT);
    $data[] = $t; 
}

$stmt->close();

echo json_encode($data);