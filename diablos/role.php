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
  <li><a href="gestionRole.php">Gestion des rôles</a></li>
  <li><a href="Role.php">Rôle</a></li>
</ol>
<div class="row">
  <div class="col-sm-12">
	<form class="form-horizontal" id="addEvent" method="POST">
		<fieldset>
			<?php
				if(isset($_GET['ref']))
				{
					echo '<legend>Modification d\'un rôle</legend>';
					$mod = true;
					$ID  = $_GET['ref'];
				}
				else
				{
					echo '<legend>Ajout d\'un rôle</legend>';
					$mod = false;
					$ID  = null;
				}
			?>
			<button type="submit" id="btnEnregistrerRole" name="btnEnregistrerRole" class="btn btn-default btn-sm" style="float:right;margin-right:10px;">
    <span class="glyphicon glyphicon-floppy-disk" ></span> Enregistrer
</button>
<button type="submit" class="btn btn-default btn-sm" id="btnSupprimerRole" name="btnSupprimerRole" style="float:right;margin-right:10px;"; onclick="return confirm('Voulez-vous vraiment supprimer ce rôle?')" >
    <span class="glyphicon glyphicon-remove"></span> Supprimer
</button>
<button type="button" class="btn btn-default btn-sm"  style="float:right; margin-right:10px" id="btnAnnulerRole" name="btnAnnulerRole" onclick="window.location.replace('gestionRole.php');">
    Annuler
</button><br><br>
			<input type="hidden" name="mod" id="mod" value="<?php echo $mod ?>" >
			<input type="hidden" name="ID" id="ID" value="<?php echo $ID ?>" >
			<div class="form-group">
				<label class="col-md-4 control-label" for="nom">Nom *</label>
				<div class="col-md-5" style="display:inline-block;">
					<input id="nom" name="nom" type="text" pattern="[a-zA-Z\è\é\ë\ç\ê\-\ ]{1,50}" title="1-30 lettres" placeholder="Nom" class="form-control input-md" style='width:250px'  maxlength="50" <?php if(isset($_GET['ref'])){echo 'value="'.getRoleForm($ID)['nom'].'"';} ?> required="">
				</div>
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
	
	
});
</script>
</body>
<footer>

</footer>
</html>