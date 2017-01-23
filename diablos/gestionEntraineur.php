<?php
/*
Auteur:			Anthony Duhaime
Description:	Page où les informations des différents entraîneurs sont affichés dans un tableau récapitulatif.
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
  <li><a href="gestionEntraineur.php">Gestion des entraîneurs</a></li>
</ol>

<legend>Liste des entraîneurs</legend>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<?php if (isset($_SESSION['nomUtilisateur'])){echo '<a class="btn btn-default btn-sm" role="button" id="btnAjouterMembre" href="modifierEntraineur.php" onclick='.$_SESSION['mode']="AJOUT".'><span class="glyphicon glyphicon-plus-sign"></span> Ajouter</a>';}?>
			<div id="sectionFiltre">
				<label class="" for="filtre">Filtre:</label>
				<input type="text" class="form-control" placeholder="Mot clé"  id="filtre" name="filtre">
			</div>
			<span class="glyphicon pdf" style="float:right;" onclick="location.href= 'entraineurPDF.php'"> <img src="Images/iconePDF.png"></span>
			<?php 
			getEntraineurs();
			if (isset($_SESSION['succesModification']) && $_SESSION['succesModification'] == "succes"){
			echo '<script>toastr.success("Les modifications ont été apportées.", "Succès!");</script>';
			$_SESSION['succesModification'] = "";
			}
			if (isset($_SESSION['ajoutEntraineur']) && $_SESSION['ajoutEntraineur'] == 'ajout'){
			echo '<script>toastr.success("L\'entraineur a été ajouté!", "Succès!");</script>';
			$_SESSION['ajoutEntraineur'] = "";
			}
			if (isset($_SESSION['supprimerMembre']) && $_SESSION['supprimerMembre'] == 'supprimer'){
			echo '<script>toastr.success("L\'entraineur a été supprimé!", "Succès!");</script>';
			$_SESSION['supprimerMembre'] = "";
			}
			
			?>
		</div>
	</div>

<br>


<form action="modifierUtilisateur.php">
	<input type="hidden" name="nomUtilisateur"  value="" id="hidden">
</form>

<script>
activeSwitchGestion("entraineur");
$(document).ready(function(){

	$('#tbl-entraineur').pageMe({pagerSelector:'#myPager',showPrevNext:true,hidePageNumbers:false,perPage:35});

	$('.table-hover tbody tr').on('click', function(e){ if (document.getElementById('securite').value == "1"){
		
		$.ajax({
		type: 'POST',
		url: 'sessionSetter.php',
		data: {sendCellValue: $(this).find("td:first").text(), mode:'MODIFICATION', idEntraineur:$(this).find("td:nth-child(2)").text()},
		success: function (msg) {
			window.location.href = 'modifierEntraineur.php';
			
		},
		error: function (err){
			alert('Erreur');
		}

	});}
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
	var jo = $("#tableEntraineurs").find("tr").not(':first');
	var pager = $("#myPager");
    pager.hide();

	if (this.value == "") {
		pager.empty();
		jo.show();
		$('#tbl-entraineur').pageMe({pagerSelector:'#myPager',showPrevNext:true,hidePageNumbers:false,perPage:35});
		pager.show();
		return;
	}

	jo.hide();

	jo.filter(function (i, v) {
		var $t = $(this).find(':nth-child(3)'); //2: nom, 3:téléphone, 4:courriel
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