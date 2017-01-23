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
  <li><a href="gestionUtilisateur.php">Gestion des rôles</a></li>
</ol>

<legend>Liste des rôles</legend>
<div class="container">
<div class="row">
<div class="col-sm-12">
<?php if (isset($_SESSION['estAdmin']) && $_SESSION['estAdmin'] == 1){echo '<a class="btn btn-default btn-sm" role="button" id="btnAjouterRole" href="role.php"><span class="glyphicon glyphicon-plus-sign"></span> Ajouter</a>';}?>
      <div id="sectionFiltre">
	<label class="" for="filtre">Filtre:</label>
	<input type="text" class="form-control" placeholder="Mot clé"  id="filtre" name="filtre" autofocus>
		  
		  </div>

<?php 
getRolesTableau();
if (isset($_SESSION['modifRole']) && $_SESSION['modifRole'] == 1){
			echo '<script>toastr["success"]("Les modifications ont été apportées.", "Succès!");</script>';
			$_SESSION['modifRole'] = "";
			}
if ($_SESSION['supprimerRole'] == 1 && isset($_SESSION['supprimerRole'])){
echo '<script>toastr["success"]("Le rôle a été supprimé!", "Succès!");</script>';
$_SESSION['supprimerRole'] = "";
}
if ($_SESSION['succesRole'] == 1 && isset($_SESSION['succesRole'])){
echo '<script>toastr["success"]("Le rôle a été ajouté!", "Succès!");</script>';
$_SESSION['succesRole'] = "";
}


?>

</div>
</div>
</div>
<br>
<div id="messageArea"></div>';
<form action="modifierUtilisateur.php">
<input type="hidden" name="nomUtilisateur"  value="" id="hidden" />
</form>
<?php
if (isset($_SESSION['nomUtilisateur']))
echo '<script>afficherEngrenage("#tableRoles",true);</script>';
else
echo '<script>afficherEngrenage("#tableRoles",false);</script>';
?>

<script>
$(document).ready(function(){


	$('.table-hover tbody tr').on('click', function(e){window.location.href = "role.php?ref=" + $(this).find("td:first").text();
	});
    activeSwitch("role");

$('#tbl-roles').pageMe({pagerSelector:'#pagerRole',showPrevNext:true,hidePageNumbers:false,perPage:35});
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
    var jo = $("#tableRoles").find("tr").not(':first');
    var pager = $("#pagerRole");
    pager.hide();

    if (this.value == "") {
        pager.empty();
        jo.show();
        $('#tbl-roles').pageMe({pagerSelector:'#pagerRole',showPrevNext:true,hidePageNumbers:false,perPage:35});
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