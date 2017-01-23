<?php
 
require_once ("Connexion/Connect.php");
require_once ("Connexion/Connexion.php");
require_once ("Connexion/ExecRequete.php");
require_once ("functionPHP.php");
error_reporting(0);
?>
<html>

<head>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<meta charset="UTF_8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script src="functions.js"></script>
<link rel="stylesheet" type="text/css" href="mastersheet.css">
</head>


<body>
<div class="wrapper">

<div class="content">
<?php 
require_once('nav-bar.php');
?>

<ol class="breadcrumb">
  <li><a href="index.php">Accueil</a></li>
  <li><a href="gestionUtilisateur.php">Gestion des utilisateurs</a></li>
</ol>

<legend>Liste des utilisateurs</legend>
<div class="container">
<div class="row">
<div class="col-sm-12">
<?php if (isset($_SESSION['estAdmin']) && $_SESSION['estAdmin'] == 1){echo '<a class="btn btn-default btn-sm" role="button" id="btnAjouterMembre" href="inscription.php"><span class="glyphicon glyphicon-plus-sign"></span> Ajouter</a>';}?>
      <div id="sectionFiltre">
	<label class="" for="filtre">Filtre:</label>
	<input type="text" class="form-control" placeholder="Mot clé"  id="filtre" name="filtre" autofocus>
		  
		  </div>

<?php 
getMembres();
if (isset($_SESSION['succesModification']) && strlen($_SESSION['succesModification']) > 0 ){
			echo '<script>toastr["success"](\''.$_SESSION['succesModification'].'\');</script>';
			$_SESSION['succesModification'] = "";
}
if ($_SESSION['supprimerMembre'] == "supprimer" && isset($_SESSION['supprimerMembre'])){
    echo '<script>toastr["success"]("Le membre a été supprimé!", "Succès!");</script>';
    $_SESSION['supprimerMembre'] = "";
}
if ($_SESSION['inscrire'] == "inscrire" && isset($_SESSION['inscrire'])){
    echo '<script>toastr["success"]("Le membre a été ajouté!", "Succès!");</script>';
    $_SESSION['inscrire'] = "";
}
if (isset($_SESSION['dernierAdmin']) && $_SESSION['dernierAdmin'] == 1){
    echo '<script>toastr["error"]("Impossible de retirer le dernier administrateur.", "Erreur!");</script>';
    $_SESSION['dernierAdmin'] = "";
}

?>
<?php
if (isset($_SESSION['nomUtilisateur']))
echo '<script>afficherEngrenage("#tableUtilisateurs",true);</script>';
else
echo '<script>afficherEngrenage("#tableUtilisateurs",false);</script>';
?>
</div>
</div>
</div>
<br>
<div id="messageArea"></div>';
<form action="modifierUtilisateur.php">
<input type="hidden" name="nomUtilisateur"  value="" id="hidden" />
</form>



<script>
$(document).ready(function(){
activeSwitchGestion("utilisateur");
    // $(".table-hover tbody tr").click(function(){
	  
	
	$('.table-hover tbody tr').on('click', function(e){
	// if (document.getElementById('securite').value == "1"){
	$.ajax({
	// var id = $(this).find("td:first").text();
	// var hidden = document.getElementById('hidden');
	// hidden.value = id;
	
	type: 'POST',
    url: 'sessionSetter.php',
    data: {sendCellValue: $(this).find("td:first").text()},
	 success: function (msg) {
     
	  window.location.href = 'modifierUtilisateur.php';
    },
    error: function (err){
      alert('Erreur');
    }

	
       
    });//}
});
$('#tbl-Utilisateurs').pageMe({pagerSelector:'#pagerUtilisateur',showPrevNext:true,hidePageNumbers:false,perPage:35});
});

$('#filtre').keypress(function(e){
    var txt = String.fromCharCode(e.which);
    if(!txt.match(/[a-zA-Z0-9À-ÿ\x08]/))
    {
        return false;
    }
});


$("#filtre").keyup(function () {
    var data = this.value.toUpperCase().split(" ");
    var jo = $("#tableUtilisateurs").find("tr").not(':first');
    var pager = $("#pagerUtilisateur");
    pager.hide();

    if (this.value == "") {
        pager.empty();
        jo.show();
        $('#tbl-Utilisateurs').pageMe({pagerSelector:'#pagerUtilisateur',showPrevNext:true,hidePageNumbers:false,perPage:35});
        pager.show();
        return;
    }
  
    jo.hide();

    jo.filter(function (i, v) {
        var $t = $(this);
        for (var d = 0; d < data.length; ++d) {
            if ($t.text().toUpperCase().indexOf(data[d]) > -1) {
                return true;
            }
        }
        return false;
    })
    
    .show();
}).focus(function () {
    this.value = "";
   
    $(this).unbind('focus');
});


</script>



</div>
<div class="footer">
<?php
require_once ("footer.php");
?>
</div>
</div>

</body>





</html>