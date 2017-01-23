<?php
require_once ("Connexion/Connect.php");
require_once ("Connexion/Connexion.php");
require_once ("Connexion/ExecRequete.php");
require_once ("functionPHP.php");
?>
<html>

<head>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<meta charset="UTF_8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script src="functions.js"></script>
<link rel="stylesheet" type="text/css" href="mastersheet.css">
<link rel="stylesheet" type="text/css" href="footer.css">
<meta http-equiv="pragma" content="no-cache" />
<script>
//Sélectionne le bon onglet et le bon élément dans le dropdown
//Gabriel Richer
  $(document).ready(function() { 
		activeSwitchGestion("utilisateur");
     });
	 
	 </script>
</head>


<body>
<?php require_once('nav-bar.php'); ?>
<div class="wrapper">

<div class="content">
<?php 
echo '<ol class="breadcrumb">
  <li><a href="index.php">Accueil</a></li>
  <li><a href="gestionUtilisateur.php">Gestion des utilisateurs</a></li>
   <li><a href="modifierUtilisateur.php">Utilisateur</a></li>
</ol>';




if (isset($_SESSION['nomClique'])){
$row = getMembre($_SESSION['nomClique']);
echo '
<legend>Modification d\'un utilisateur</legend>
<div class="container">
<form method="POST">
<fieldset>
<div class="row">
<div class="col-sm-12">
<button type="button" class="btn btn-default btn-sm" id="btnEnregistrerMembre" name="btnEnregistrerMembre">
    <span class="glyphicon glyphicon-floppy-disk"></span> Enregistrer
</button>
<button type="button" class="btn btn-default btn-sm" id="btnSupprimerMembre" name="btnSupprimerMembre" ;>
    <span class="glyphicon glyphicon-remove"></span> Supprimer
</button>
<button type="button" class="btn btn-default btn-sm" id="btnAnnuler" onclick="window.location.replace(\'gestionUtilisateur.php\')";>
     Annuler
</button><br><br>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="nomUtilisateur">Nom d\'utilisateur</label>  
  <div class="col-md-5">
  <input pattern="[a-zA-Z0-9]{2, 30}" id="nomUtilisateur" name="nomUtilisateur" value='.$row["nomUtilisateur"].' type="text" placeholder="Entrez le nom d\'utilisateur" class="form-control" readonly required="">
    
  </div>
</div>





<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="statut">Statut</label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="statut">
      <input type="checkbox" name="statut" id="actif" '; if($row['estActif'] == 1){echo ' checked="true">';} else echo '>';
	  echo '
      Actif
    </label>
	<label class="checkbox-inline" for="admin">
      <input type="checkbox" name="admin" id="admin"'; if($row['estAdmin'] == 1){echo ' checked="true">';} else echo '>';
	  echo '
      Administrateur
    </label>
  </div>
</div>

<!-- Password input-->
<div class="form-group">
  
  <div class="col-md-5">
    <!-- Trigger the modal with a button -->
	<a id="lienPW"  data-toggle="modal" data-target="#secModifier">Modifier le mot de passe</a>
    
  </div>
</div>


</fieldset>
</form>

</div>
</div>
</div>
<br>

<div id="messageArea"></div>';

echo ' <input id="id" name="id" type="hidden" value="'.$row['id'].'">';
// $_SESSION['id'] = $row['id'];

}


?>

<!-- Modal -->
<div id="secModifier" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modification du mot de passe</h4>
      </div>
      <div class="modal-body">
        
		<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="motPasse">Mot de passe</label>
  <div class="col-md-5">
    <input id="motPasse" name="motPasse" pattern=".{6,30}" title="Mot de passe entre 6 et 30 caractères." type="password" placeholder="Entrez un mot de passe" class="form-control input-md" required="required">
   
  </div>
</div>
<!--
<div class="form-group">
  <label class="col-md-4 control-label" for="motPasseConfirmation">Confirmation</label>
  <div class="col-md-5">
    <input id="motPasseConfirmation" name="motPasseConfirmation" type="password" placeholder="Confirmez le mot de passe" class="form-control input-md" required="">
   
  </div>
</div> -->
		
		<br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
		 <button type="button" class="btn btn-default" data-dismiss="modal" id="btnEnregistrerMDP" >Enregistrer</button>
      </div>
    </div>

  </div>
</div>

 <?php
// if (isset($_POST['btnEnregistrerMembre'])){

// if (isset($_POST['statut'])) {$statut = 1;} 
// else $statut = 0;
// if (isset($_POST['admin'])){$admin = 1;} 
// else $admin = 0;

// updateMembre($row['id'],$_POST['nomUtilisateur'],$statut,$admin);
// $row = getMembre($_SESSION['nomClique']);

// }


// ?>


<script>
$(document).ready(function(){
	//Modifier mot de passe
	$('#btnEnregistrerMDP').on('click', function(e){ 
	if (document.getElementById('motPasse').value == ""){
	alert("Vous devez entrer un mot de passe");
	}else {
	$.ajax({
	
	type: 'POST',
    url: 'functionPHP.php',
    data: {motPasseUpdate: document.getElementById('motPasse').value, userID:document.getElementById('id').value},
	 success: function (msg) {
   toastr["success"]("Le mot de passe a été changé.", "Succès!");
    },
    error: function (err){
      ajouterMessage('messageArea','danger','La modification du mot de passe a échouée.');
    }

	
       });
	   }
    });

	//Supprimer
	$('#btnSupprimerMembre').on('click', function(e){

	$.ajax({
	
	type: 'POST',
    url: 'functionPHP.php',
    data: {userID:document.getElementById('id').value,btnSupprimerMembre:'btnSupprimerMembre', supprimer:"supprimer"},
	 success: function (msg) {
      window.location.replace('gestionUtilisateur.php');
    },
    error: function (err){
      // alert('Erreur');
    }

	
       
    });

});

	//Enregistrer utilisateur
	$('#btnEnregistrerMembre').on('click', function(e){ $.ajax({
	async: false,
	type: 'POST',
    url: 'functionPHP.php',
    data: { userID:document.getElementById('id').value, nomUtilisateur:document.getElementById('nomUtilisateur').value, estActif: + document.getElementById('actif').checked,estAdmin: + document.getElementById('admin').checked, updateMembre:'updateMembre'},

	 success: function (msg) {
      window.location.replace('gestionUtilisateur.php');
    },
    error: function (err){
      ajouterMessage('messageArea','danger','Les modifications ont échouées.');
    
    }

	
       });
	   
    });


});


</script>
</div>
<div style="bottom:initial" class="footer">
<?php
require_once ("footer_inner.php");
?>
</div>
</div>
</body>


<!--verifierValeur(document.getElementById('motPasse').value,document.getElementById('motPasseConfirmation').value) -->

</html>