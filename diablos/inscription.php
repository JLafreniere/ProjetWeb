<?php
require_once ("Connexion/Connect.php");
require_once ("Connexion/Connexion.php");
require_once ("Connexion/ExecRequete.php");
require_once ("functionPHP.php");
session_start();
?>
<html>

<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<meta charset="UTF_8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script src="functions.js"></script>
<link rel="stylesheet" type="text/css" href="mastersheet.css">
<script>
//Sélectionne le bon onglet et le bon élément dans le dropdown
//Gabriel Richer
  $(document).ready(function() { 
		activeSwitchGestion("utilisateur");
     });
	 
	 </script>
</head>


<body>
<div class="wrapper">
<div class="content">
<?php 
  require_once('nav-bar.php');
?>

<div class="row">
  <div class="col-sm-12">
 <form class="form-horizontal" method="POST" action="inscription.php">
<fieldset>

<!-- Form Name -->
<legend>Inscription d'un membre</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="nomUtilisateur">Nom d'utilisateur</label>  
  <div class="col-md-5">
  <input id="nomUtilisateur" name="nomUtilisateur" 
     type="text" placeholder="Entrez le nom d'utilisateur"
     class="form-control input-md" required=""
     value="<?php echo( isset($_POST['nomUtilisateur']) ? $_POST['nomUtilisateur'] : "" ) ?>">
  </div>
</div>

<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="motPasse">Mot de passe</label>
  <div class="col-md-5">
    <input id="motPasse" name="motPasse" type="password" placeholder="Entrez un mot de passe"
     class="form-control input-md" required=""
     value="<?php echo(isset($_POST['motPasse']) ? $_POST['motPasse'] : "" )?>">
    
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="statut">Statut</label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="statut">
      <input type="checkbox" name="statut" id="actif" value="estActif" checked="checked">
      Actif
    </label>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="inscrire"></label>
  <div class="col-md-4">
    <button type="submit" id="inscrire" name="btnInscrire" class="btn btn-primary">Inscrire</button>
  </div>
</div>

</fieldset>
</form>

  </div>
</div>

</div>
<div class="footer">
  <?php require_once ("footer.php");?>
</div>
</div>


<?php
$actif = isset($_POST['statut']);

if (isset($_POST['btnInscrire'])){
  inscrireMembre($_POST['nomUtilisateur'], $_POST['motPasse'], $actif);
}

if (isset($_SESSION['inscrireError']) && strlen($_SESSION['inscrireError']) > 0) {
  echo "<script>toastr.error('".$_SESSION['inscrireError']."')</script>";
  $_SESSION['inscrireError'] = "";
} else if (isset($_SESSION['succesModification']) && strlen($_SESSION['succesModification']) > 0) {
  echo "<script>location.replace(\"gestionUtilisateur.php\");</script>"; 
}

?>

</body>


</html>
