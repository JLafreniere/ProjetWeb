<?php
 
?>
<html>

<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<meta http-equiv="content-type" content="text/html; charset=utf8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script src="functions.js"></script>
<link rel="stylesheet" type="text/css" href="mastersheet.css">

<meta http-equiv="pragma" content="no-cache" />

<script>
//Sélectionne le bon onglet et le bon élément dans le dropdown
//Gabriel Richer
   $(document).ready(function() { 
		activeSwitchGestion("equipe");
     
        });
</script>
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
  <li><a href="equipe.php">Équipe</a></li>
</ol>

<div class="row">
  <div class="col-sm-12">
	<form class="form-horizontal" id="addEvent" method="POST">
		<fieldset>
			<?php
				if(isset($_GET['ref']))
				{
					echo '<legend>Modification d\'une équipe</legend>';
					$mod = true;
					$ID  = $_GET['ref'];
				}
				else
				{
					echo '<legend>Ajout d\'une équipe</legend>';
					$mod = false;
					$ID  = null;
				}
			?>
			<button type="submit" id="btnSaveEquipe" name="btnSaveEquipe" class="btn btn-default btn-sm" style="float:right;margin-right:10px;" onclick="return verifierForm();">
    <span class="glyphicon glyphicon-floppy-disk" ></span> Enregistrer
</button>
<button type="submit" class="btn btn-default btn-sm" id="btnSupprimerEquipe" name="btnSupprimerEquipe" style="float:right;margin-right:10px;" onclick="return confirm('Voulez-vous vraiment supprimer cette équipe?')" <?php if(isset($_GET['ref'])){ echo "enabled"; }else{ echo "disabled"; } ?>>
    <span class="glyphicon glyphicon-remove"></span> Supprimer
</button>
<button type="button" class="btn btn-default btn-sm"  style="float:right; margin-right:10px" id="btnAnnulerEquipe" name="btnAnnulerEquipe" onclick="window.location.replace('gestionEquipes.php');">
    Annuler
</button><br><br>
			<input type="hidden" name="mod" value="<?php echo $mod ?>" >
			<input type="hidden" name="ID" value="<?php echo $ID ?>" >
			<div class="form-group">
				<label class="col-md-4 control-label" for="sport">Sport</label>
				<div class="col-md-5" style="display:inline-block;">
					<select name="sport" id="sport" class="form-control input-md" style='width:150px' required>
						<option value="">-Sport-</option>
						<?php
							if(isset($_GET['ref']))
							{
								getSport(getInfoEquipe($_GET['ref'])["id_sport"]);
							}
							else
							{
								getSport(0);
							}		
						?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label" for="niveauEquipe">Nom *</label>
				<div class="col-md-5">
					<input id="nomEquipe" name="nomEquipe" type="text" placeholder="Nom" class="form-control input-md" style='width:250px' maxlength="50" <?php if(isset($_GET['ref'])){echo 'value="'.getInfoEquipe($_GET['ref'])["nom"].'"';} ?> required="">
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label" for="sexeEquipe">Sexe</label>
				<div class="col-md-5">
					<input type="radio" name="sexeEquipe" id="sexeEquipeM" value="M" <?php if(isset($_GET['ref'])){ if(getInfoEquipe($_GET['ref'])["sexe"] == 'M'){echo 'checked="true"';}} ?>> <label for="sexeEquipeM">Masculin</label><br>
					<input type="radio" name="sexeEquipe" id="sexeEquipeF" value="F" <?php if(isset($_GET['ref'])){ if(getInfoEquipe($_GET['ref'])["sexe"] == 'F'){echo 'checked="true"';}} ?>> <label for="sexeEquipeF">Féminin</label><br>
					<input type="radio" name="sexeEquipe" id="sexeEquipeX" value="X" <?php if(isset($_GET['ref'])){ if(getInfoEquipe($_GET['ref'])["sexe"] == 'X'){echo 'checked="true"';}}else{echo 'checked="true"';} ?>> <label for="sexeEquipeX">Mixte</label><br>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label" for="saisonEquipe">Saison *</label>
				<div class="col-md-5">
					<input id="saisonEquipe" name="saisonEquipe" type="text" pattern="\d{4}-\d{4}" placeholder="Ex: 2015-2016" class="form-control input-md" style='width:125px' maxlength="20" <?php if(isset($_GET['ref'])){echo 'value="'.getInfoEquipe($_GET['ref'])["saison"].'"';} ?> required="">
				</div>
			</div>
		</fieldset>
	</form>
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