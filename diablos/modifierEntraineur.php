<?php
require_once ("Connexion/Connect.php");
require_once ("Connexion/Connexion.php");
require_once ("Connexion/ExecRequete.php");
require_once ("functionPHP.php");
 
?>

<html>

<?php 
require_once('nav-bar.php');
?>

<head>

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script src="functions.js"></script>
<link rel="stylesheet" type="text/css" href="mastersheet.css">
<link rel="stylesheet" type="text/css" href="footer.css">
<script type="text/javascript" src="Includes/moment.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

<script>
//Sélectionne le bon onglet et le bon élément dans le dropdown
//Gabriel Richer
  $(document).ready(function() { 
		activeSwitchGestion("entraineur");
     });
	 
	 </script>

</head>

<body style="background-image:none !important">
<div class="wrapper">
<div class="content">

<ol class="breadcrumb">
  <li><a href="index.php">Accueil</a></li>
  <li><a href="gestionEntraineur.php">Gestion des entraineurs</a></li>
  <li><a href="modifierEntraineur.php">Entraineur</a></li>
</ol>

<?php 
echo '<form class="form-horizontal" method="POST">
<fieldset>

<!-- Form Name -->
<legend>Entraîneur</legend>';
if ($_SESSION['mode'] == 'MODIFICATION'){
echo '
<div class="row">
  <div class="col-sm-12">
<button type="submit" class="btn btn-default btn-sm btn-gestion" id="btnEnregistrerEntraineur" name="btnEnregistrerEntraineur">
    <span class="glyphicon glyphicon-floppy-disk"></span> Enregistrer
</button>
<button type="submit" class="btn btn-default btn-sm btn-gestion" id="btnSupprimerEntraineur" name="btnSupprimerEntraineur" ;>
     <span class="glyphicon glyphicon-remove"></span> Supprimer
</button>
<button type="button" class="btn btn-default btn-sm btn-gestion" id="btnAnnuler" onclick="window.location.replace(\'gestionEntraineur.php\')";>
     Annuler
</button><br><br>';
}
if ($_SESSION['mode'] != 'MODIFICATION'){
echo '<div class="row">
  <div class="col-sm-12"><button type="submit" id="inscrire" name="btnInscrire" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-floppy-disk" ></span> Enregistrer</button><br><br>';
 $_SESSION['nomClique'] = null;
} 
if (isset($_SESSION['nomClique'])){
// echo '<div class=row>';
getEntraineur($_SESSION['nomClique']);
// echo '</div>';
}
else getEntraineur(null);

if ($_SESSION['mode'] == 'MODIFICATION'){
echo "<legend style='color:black !important'>Équipes de l'entraîneur</legend><div class='row'>
  <div class='col-sm-12'>";

getEquipesEntraineur($_SESSION['idEntraineur']);

	}
?></div></div></div></div>


<?php
 if (isset($_POST['btnInscrire'])){
	 var_dump('ALLO');
 if (isset($_POST['radioSexe'])){

inscrireEntraineur($_POST['nom'],$_POST['prenom'],$_POST['radioSexe'],$_POST['telephone'],$_POST['courriel'],$_POST['note'],$_POST['poste'],$_POST['type'],$_POST['noEmbauche']);
	$_SESSION['nomClique'] = null;
	$_SESSION['ajoutEntraineur'] = 'ajout';
	 echo "<script>location.replace('gestionEntraineur.php');</script>";
	}

 }
 
 if (isset($_POST['btnEnregistrerEntraineur'])){
	
 updateEntraineur($_SESSION['nomClique'],$_POST['nom'],$_POST['prenom'],$_POST['radioSexe'],$_POST['telephone'],$_POST['courriel'],$_POST['note'],$_POST['type'],$_POST['poste'],$_POST['noEmbauche']);
 }

 if (isset($_POST['btnSupprimerEntraineur'])){
 supprimerEntraineur($_SESSION['nomClique']);
 $_SESSION['supprimerMembre'] = "supprimer";
 echo "<script>location.replace('gestionEntraineur.php');</script>";
 }

?>

<div style="bottom:initial" class="footer">
<?php
require_once ("footer_inner.php");
?>
</div>
</div>


</body>



</html>
