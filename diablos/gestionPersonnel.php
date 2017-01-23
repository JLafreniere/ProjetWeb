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
  <li><a href="gestionPersonnel.php">Gestion du personnel</a></li>
</ol>
<legend>Liste du personnel</legend>
<div class="container">
<div class="row">
<div class="col-sm-12">
<?php if (isset($_SESSION['nomUtilisateur'])){echo '<a class="btn btn-default btn-sm" style="float:right" role="button" id="btnAjouterEquipe" href="personnel.php"><span class="glyphicon glyphicon-plus-sign"></span> Ajouter</a>';}?>
<div id="sectionFiltre">
				<label class="" for="filtre">Filtre:</label>
				<input type="text" class="form-control" placeholder="Mot clé"  id="filtre" name="filtre">
			</div>
<div class="checkbox">
  <label><input type="checkbox" value="" name="AnneeCourante" id="anneeCourante" checked>Année courante seulement</label>
</div>
<span class="glyphicon pdf" style="float:right;" onclick="location.href= 'personnelPDF.php'"> <img src="Images/iconePDF.png"></span>
<?php 
getListePersonnel();
if (isset($_SESSION['modifPersonnel']) && $_SESSION['modifPersonnel'] == 1){
			echo '<script>toastr["success"]("Les modifications ont été apportées.", "Succès!");</script>';
			$_SESSION['modifPersonnel'] = "";
			}
			if (isset($_SESSION['ajoutPersonnel']) && $_SESSION['ajoutPersonnel'] == 1){
			echo '<script>toastr["success"]("Le membre du personnel a été ajouté!", "Succès!");</script>';
			$_SESSION['ajoutPersonnel'] = "";
			}
			if (isset($_SESSION['suppPersonnel']) && $_SESSION['suppPersonnel'] == 1){
			echo '<script>toastr["success"]("Le membre du personnel a été supprimé!", "Succès!");</script>';
			$_SESSION['suppPersonnel'] = "";
			}
?>

<?php
if (isset($_SESSION['nomUtilisateur']))
echo '<script>afficherEngrenage("#tbl-personnel",true);</script>';
else
echo '<script>afficherEngrenage("#tbl-personnel",false);</script>';
?>

<script>
activeSwitch("staff");
$(document).ready(function(){
	$('#tbl-personnel').pageMe({pagerSelector:'#myPager',showPrevNext:true,hidePageNumbers:false,perPage:35});

	$(document).on('click','.table-hover tbody tr', function(e){ 
		if (document.getElementById('securite').value == "1"){
			window.location.href = "personnel.php?ref=" + $(this).find("td:first").text();
		}
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
	var jo = $("#tablePersonnel").find("tr").not(':first');
	var pager = $("#myPager");
    pager.hide();

	if (this.value == "") {
		pager.empty();
		jo.show();
		$('#tbl-personnel').pageMe({pagerSelector:'#myPager',showPrevNext:true,hidePageNumbers:false,perPage:35});
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
	
	$('#anneeCourante').on('click',function(e){
		$("#tbl-personnel").empty();
		$.ajax({
		type: 'POST',
		url: 'functionPHP.php',
		data: {anneeCourantePersonnel: $('#anneeCourante').prop('checked') ? 1 : 0},
		success: function (response) {
			document.getElementById("tbl-personnel").innerHTML=response;
		},
		error: function (err){
			alert('Erreur');
		}

	});
	});
	
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