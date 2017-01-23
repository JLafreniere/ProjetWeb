<?php
/*
Auteur:			Gabriel Richer
Description:	Page où les informations des différents sports sont affichés dans un tableau récapitulatif.
				Pont d'accès vers la visualisation complète, l'ajout, modification et suppression de ces derniers.
*/
require_once ("Connexion/Connect.php");
require_once ("Connexion/Connexion.php");
require_once ("Connexion/ExecRequete.php");
require_once ("functionPHP.php");
 
?>
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
  <li><a href="gestionSport.php">Gestion des sports</a></li>
</ol>

<legend>Liste des sports</legend>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<?php if (isset($_SESSION['nomUtilisateur'])){echo '<a class="btn btn-default btn-sm" role="button" id="btnAjouterSport" href="modifierSport.php" onclick='.$_SESSION['mode']="AJOUT".'><span class="glyphicon glyphicon-plus-sign"></span> Ajouter</a>';}?>
			<div id="sectionFiltre">
				<label class="" for="filtre">Filtre:</label>
				<input type="text" class="form-control" placeholder="Mot clé"  id="filtre" name="filtre">
			</div>

			<?php 
			getSports();
			
			if (isset($_SESSION['succesModification']) && $_SESSION['succesModification'] == "succes"){
				echo '<script>toastr["success"]("Les modifications ont été apportées.", "Succès!");</script>';
				$_SESSION['succesModification'] = "";
			}
			
			if (isset($_SESSION['ajoutSport']) && $_SESSION['ajoutSport'] == 'ajout'){
				echo '<script>toastr["success"]("Le sport a été ajouté!", "Succès!");</script>';
				$_SESSION['ajoutSport'] = "";
			} else if  (isset($_SESSION['ajoutSport']) && $_SESSION['ajoutSport'] == 'error'){
				echo '<script>toastr["error"]("Le sport n\a pas été ajouté, les doublons ne sont pas autorisés!", "Erreur!");</script>';
				$_SESSION['ajoutSport'] = "";
			}

			if (isset($_SESSION['supprimerSport']) && $_SESSION['supprimerSport'] == 'supprimer'){
				echo '<script>toastr["success"]("Le sport a été supprimé!", "Succès!");</script>';
				$_SESSION['supprimerSport'] = "";
			}
			
			?>
		</div>
	</div>

<br>


<form action="modifierUtilisateur.php">
	<input type="hidden" name="nomUtilisateur"  value="" id="hidden">
</form>

<script>
activeSwitchGestion("sport");

$(document).ready(function(){

	$('#tbl-sports').pageMe({pagerSelector:'#myPager',showPrevNext:true,hidePageNumbers:false,perPage:35});

	$('.table-hover tbody tr').on('click', function(e){ if (document.getElementById('securite').value == "1"){$.ajax({
		type: 'POST',
		url: 'sessionSetter.php',
		data: {sendCellValue: $(this).find("td:first").text(), mode:'MODIFICATION', idEntraineur:$(this).find("td:nth-child(2)").text()},
		success: function (msg) {
			window.location.href = 'modifierSport.php';
		},
		error: function (err){
			alert('Erreur');
		}

	});}
	});
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
	var jo = $("#tableSports").find("tr").not(':first');
	var pager = $("#myPager");
    pager.hide();

	if (this.value == "") {
		pager.empty();
		jo.show();
		$('#tbl-sports').pageMe({pagerSelector:'#myPager',showPrevNext:true,hidePageNumbers:false,perPage:35});
		pager.show();
		return;
	}

	jo.hide();

	jo.filter(function (i, v) {
		var $t = $(this).find(':nth-child(2)'); //2: nom, 3:téléphone, 4:courriel
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
</div>
<div class="footer"> 
	<?php
	require_once ("footer.php");
	?>
</div>
</div>

</body>
</html>