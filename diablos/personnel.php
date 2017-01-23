<?php
 
?>
<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf8" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script src="functions.js"></script>
<link rel="stylesheet" type="text/css" href="mastersheet.css">
<script type="text/javascript" src="Includes/moment.js"></script>
<meta http-equiv="pragma" content="no-cache" />
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
  <li><a href="personnel.php">Personnel</a></li>
</ol>
<div class="row">
  <div class="col-sm-12">
	<form class="form-horizontal" id="addEvent" method="POST">
		<fieldset>
			<?php
				if(isset($_GET['ref']))
				{
					echo '<legend>Modification d\'un membre du personnel</legend>';
					$mod = true;
					$ID  = $_GET['ref'];
				}
				else
				{
					echo '<legend>Ajout d\'un membre du personnel</legend>';
					$mod = false;
					$ID  = null;
				}
			?>
			<button type="submit" id="btnSavePersonnel" name="btnSavePersonnel" class="btn btn-default btn-sm" style="float:right;margin-right:10px;">
    <span class="glyphicon glyphicon-floppy-disk" ></span> Enregistrer
</button>
<button type="submit" class="btn btn-default btn-sm" id="btnSupprimerPersonnel" name="btnSupprimerPersonnel" style="float:right;margin-right:10px;"; onclick="return confirm('Voulez-vous vraiment supprimer ce membre du personnel?')" <?php if(isset($_GET['ref'])){ echo "enabled"; }else{ echo "disabled"; } ?>>
    <span class="glyphicon glyphicon-remove"></span> Supprimer
</button>
<button type="button" class="btn btn-default btn-sm"  style="float:right; margin-right:10px" id="btnAnnulerPersonnel" name="btnAnnulerPersonnel" onclick="window.location.replace('gestionPersonnel.php');">
    Annuler
</button><br><br>
			<input type="hidden" name="mod" id="mod" value="<?php echo $mod ?>" >
			<input type="hidden" name="ID" id="ID" value="<?php echo $ID ?>" >
			<div class="form-group">
				<label class="col-md-4 control-label" for="nom">Nom *</label>
				<div class="col-md-5" style="display:inline-block;">
					<input id="nom" name="nom" type="text" pattern="[a-zA-Z\è\é\ë\ç\ê\-\ ]{1,50}" title="1-30 lettres" placeholder="Nom" class="form-control input-md" style='width:250px'  maxlength="50" <?php if(isset($_GET['ref'])){echo 'value="'.getInfoPersonnel2($ID)['nom'].'"';} ?> required="">
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label" for="prenom">Prénom *</label>
				<div class="col-md-5" style="display:inline-block;">
					<input id="prenom" name="prenom" type="text" pattern="[a-zA-Z\è\é\ë\ç\ê\-\ ]{1,50}" title="1-30 lettres" placeholder="Prénom" class="form-control input-md" style='width:250px' maxlength="50" <?php if(isset($_GET['ref'])){echo 'value="'.getInfoPersonnel2($ID)["prenom"].'"';} ?> required="">
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label" for="sexe">Sexe</label>
				<div class="col-md-5">
					<input type="radio" name="sexe" id="sexeM" value="M" <?php if(isset($_GET['ref'])){ if(getInfoPersonnel2($ID)["sexe"] == 'M'){echo 'checked="true"';}}else{ echo 'checked="true"';} ?>> <label for="sexeEquipeM">Homme</label>
					<input type="radio" name="sexe" id="sexeF" value="F" <?php if(isset($_GET['ref'])){ if(getInfoPersonnel2($ID)["sexe"] == 'F'){echo 'checked="true"';}} ?>> <label for="sexeEquipeF">Femme</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label" for="telephone">Téléphone</label>  
				<div class="col-md-4">
					<input id="telephone" name="telephone" pattern="\d{10}" title="Dix chiffres sans caractères spéciaux" type="text" placeholder="#Téléphone    Ex. 8193761721" class="form-control input-md" maxlength="10" style='width:250px' <?php if(isset($_GET['ref'])){echo 'value="'.getInfoPersonnel2($ID)["no_tel"].'"';} ?>>  
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label" for="poste">Extension</label>  
				<div class="col-md-4">
					<input id="poste" name="poste" pattern="\d{0,6}" title="6 chiffres sans caractères spéciaux" type="text" placeholder="#ext." class="form-control input-md" maxlength="6" style='width:75px' <?php if(isset($_GET['ref'])){echo 'value="'.getInfoPersonnel2($ID)["posteTelephonique"].'"';} ?>>  
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-4 control-label" for="courriel">Courriel</label>  
				<div class="col-md-4">
					<input id="courriel" name="courriel" pattern=".+@.+[.].+" title="Adresse de messagerie valide ex.: ex@example.com" type="text" placeholder="Adresse de messagerie" class="form-control input-md" style='width:250px' <?php if(isset($_GET['ref'])){echo 'value="'.getInfoPersonnel2($ID)["courriel"].'"';} ?>>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label" for="courriel">Date d'embauche *</label>  
				<div class="col-md-4">
					<input id="dateEmbauche" name="dateEmbauche"  title="Date d'embauche de l'employé"
					 type="date" required class="form-control input-md" style='width:250px' value="<?php 
					   if (isset($_GET['ref'])) {
						   echo getInfoPersonnel2($ID)["dateEmbauche"];
					   } else {
						   echo date("Y-m-j");
					   } ?>"
					>
					</div>
			</div>
			<script>dateMaximum('dateEmbauche');</script>

			<hr>
		
			<div class="form-group">
				<label class="col-md-4 control-label" for="noEmb">No. Embauche</label>  
				<div class="col-md-4">

					<input id="noEmb" name="noEmb" type="text" placeholder="#" class="form-control input-md" style='width:75px;' maxlength="10">
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label" for=""></label>  
				<div class="col-md-4">
					<button type="button" id="btnAjoutRole" name="btnAjoutRole" class="btn btn-default btn-sm">
						<span class="glyphicon glyphicon-plus-sign" ></span> Ajouter
					</button>
				</div>
			</div>
			
			<div class="table-responsive">
			<table class="table table-striped" name="tableRoles" id="tableRoles" style="width: 50%;margin: 0 auto;">
			<thead>
			<tr>
				<th class="hidden"></th>
				<th class="hidden"></th>
				<th>No. Embauche</th>
				<th></th>
			</tr>
			</thead>
			<tbody id="roles" name="roles">
				<?php
					if(isset($_GET['ref']))
					{
						getRolesPersonne($ID);
					}
				?>
			</tbody>
			</table>
			</div>
		</fieldset>
	</form>
  </div>
</div>
</div>
<div class="footer" style="position: absolute;">
<?php
 require_once ("footer.php");
?>
</div>
</div>
<script>
$(document).ready(function(){
	$(document).on('click', '#tableRoles tbody tr button', function(e){
			var r = confirm("Voulez-vous vraiment supprimer le numéro d'embauche?");
			if (r == true)
			{
				/*$("#roles").empty();*/
				$.ajax({
				type: 'POST',
				url: 'functionPHP.php',
				data: {suppRole: $(this).closest("tr").find("td:nth-child(2)").text(), idPers: document.getElementById("ID").value, data: $(this).closest("tr").find("td:nth-child(3) input").val()},
				success: 
				function (response) {
					document.getElementById("roles").innerHTML=response;
			},
			error: function (err){
			ajouterMessage('messageArea','danger','L\'ajout du lieu de séjour a échouée.');
	  
			}
			});
		}
    });
	$('#btnAjoutRole').on('click', function(e){
			if (document.getElementById('noEmb').value != "")
			{
				var table = document.getElementById("roles");
				var ligne = table.insertRow(0);
				var mod = ligne.insertCell(0);
				var idRole = ligne.insertCell(1);
				var noEmb = ligne.insertCell(2);
				var no = document.getElementById("noEmb").value;
				mod.innerHTML = '<input type="hidden" name="modif[]" value="0"/>';
				idRole.innerHTML = '0';
				idRole.className='hidden';
				mod.className='hidden';
				noEmb.innerHTML = '<input type="text" name="tabNoEmb[]" readonly value="'+ document.getElementById('noEmb').value + '" style=" border: 0;"/>';
				
				document.getElementById('noEmb').value = "";
			}
    });
});
</script>
</body>
<footer>

</footer>
</html>