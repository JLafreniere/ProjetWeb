<?php
 
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<html>

<head>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<meta http-equiv="content-type" content="text/html; charset=utf8" />
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
  <li><a href="gestionEquipes.php">Gestion des équipes</a></li>
</ol>

<legend>Liste des équipes</legend>
<div class="container">
<div class="row">
<div class="col-sm-12">
<?php if (isset($_SESSION['nomUtilisateur'])){echo '<a class="btn btn-default btn-sm" style="float:right" role="button" id="btnAjouterEquipe" href="equipe.php"><span class="glyphicon glyphicon-plus-sign"></span> Ajouter</a>';}?>
<span class="glyphicon pdf" style="float:right;" onclick="location.href= 'equipePDF.php'"> <img src="Images/iconePDF.png"></span>
<?php 
getListeEquipes();
if (isset($_SESSION['modifEquipe']) && $_SESSION['modifEquipe'] == 1){
			echo '<script>toastr["success"]("Les modifications ont été apportées.", "Succès!");</script>';
			$_SESSION['modifEquipe'] = "";
			}
			if (isset($_SESSION['ajoutEquipe']) && $_SESSION['ajoutEquipe'] == 1){
			echo '<script>toastr["success"]("L\'équipe a été ajouté!", "Succès!");</script>';
			$_SESSION['ajoutEquipe'] = "";
			} else if (isset($_SESSION['ajoutEquipe']) && $_SESSION['ajoutEquipe'] == 'error'){
				echo '<script>toastr["error"]("L\'équipe n\'a été ajouté, les doublons ne sont pas acceptés.", "Erreur!!");</script>';
				$_SESSION['ajoutEquipe'] = "";
			}
			if (isset($_SESSION['suppEquipe']) && $_SESSION['suppEquipe'] == 1){
			echo '<script>toastr["success"]("L\'équipe a été supprimé!", "Succès!");</script>';
			$_SESSION['suppEquipe'] = "";
			}
?>

<?php
if (isset($_SESSION['nomUtilisateur']))
echo '<script>afficherEngrenage("#tableEquipe",true);</script>';
else
echo '<script>afficherEngrenage("#tableEquipe",false);</script>';
?>

<script>
activeSwitchGestion("equipe");
$(document).ready(function(){
	$('#tbl-equipes').pageMe({pagerSelector:'#myPager',showPrevNext:true,hidePageNumbers:false,perPage:35});
	$('.table-hover tbody tr').on('click', function(e){ if (document.getElementById('securite').value == "1"){window.location.href = "equipe.php?ref=" + $(this).find("td:first").text();
	}});
});
</script>
</div>
</div>
</div>
</div>
<div class="footer" style="position: absolute;">
<?php
require_once ("footer.php");
?>
</div>
</div>
</body>
</html>