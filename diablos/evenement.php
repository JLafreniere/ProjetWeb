﻿<?php
require_once("Connexion/Connect.php");
require_once("Connexion/Connexion.php");
require_once("Connexion/ExecRequete.php");
require_once("functionPHP.php");
session_start();
if(isset($_GET['ref']))
{
	$ID  = $_GET['ref'];
}
?>
<html>

<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment-with-locales.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2-rc.1/js/select2.min.js"></script>
  <script type="text/javascript" src="Includes/bootstrap-datetimepicker.js"></script>
  <script src="Includes/toastr.min.js"></script>
  <script src="functions.js"></script>
  <meta charset="UTF_8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link type="text/css" rel="stylesheet" href="Includes/bootstrap-datetimepicker.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2-rc.1/css/select2.min.css"/>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="Includes/toastr.css">
  <link rel="stylesheet" type="text/css" href="mastersheet.css">
  <link rel="stylesheet" type="text/css" href="nav-bar.css">
  <link rel="stylesheet" type="text/css" href="footer.css">

</head>


<body>
<div class="wrapper">
<div class="content">
<?php 
require_once('nav-bar_inner.php');
?>

<ol class="breadcrumb">
  <li><a href="index.php">Accueil</a></li>
  <li><a href="gestionEvenements.php">Gestion des évènements</a></li>
  <li><a href="evenement.php">Évènements</a></li>
</ol>

<div class="row">
  <div class="col-sm-12">
 <form class="form-horizontal" id="addEvent" method="POST"  style="margin-bottom:60px">
<fieldset>
<button type="submit" class="btn btn-default btn-sm" id="btnSaveEvent" name="btnSaveEvent" style="float:right;margin-right:10px">
    <span class="glyphicon glyphicon-floppy-disk"></span> Enregistrer
</button>
<?php
	if (isset($_SESSION['estAdmin']) && $_SESSION['estAdmin'] == 1){ echo '
	<button type="submit" class="btn btn-default btn-sm"  style="float:right; margin-right:10px" id="btnSupprimerEvent" name="btnSupprimerEvent" onclick="return confirm(\'Voulez-vous vraiment supprimer cet événement?\')" '; if(isset($_GET['ref'])){ echo "enabled"; }else{ echo "disabled"; } echo'>
		Supprimer
	</button>';
	}
?>
<button type="button" class="btn btn-default btn-sm"  style="float:right; margin-right:10px" id="btnAnnulerEvent" name="btnAnnulerEvent" onclick="window.location.replace('gestionEvenements.php');">
    Annuler
</button>
<?php
$_SESSION['modifevenement']='modif';
if(isset($_GET['ref']))
{
	echo '<legend>Modification d\'un évènement</legend>';
	$mod = true;
	$ID  = $_GET['ref'];
}
else
{
	echo '<legend>Ajout d\'un évenement</legend>';
	$mod = false;
	$ID  = null;
}
?>

<input type="hidden" name="mod" value="<?php echo $mod ?>" >
<input type="hidden" name="ID" id="id" value="<?php echo $ID ?>" >
<a href="" class="af-link" onclick="
$('#infoGenerales').toggle(500);

$('#infoTransport,#Responsable,#infoSejour,#infoLieu').hide(500);
$('#infGen').toggleClass('glyphicon-chevron-up glyphicon-chevron-down');

$('#infTrans, #infResponsable, #infSejour, #infLieu').removeClass('glyphicon-chevron-up');
$('#infTrans, #infResponsable, #infSejour, #infLieu').addClass('glyphicon-chevron-down');

return false;" style="padding-left:20%">Informations générales <span id="infGen" class="glyphicon glyphicon-chevron-up" ></span></a>
<hr style="border-width: 1px;border-style: inset;">
<div class="form-group" id="infoGenerales">
<div class="form-group">
  <label class="col-md-4 control-label" for="sports">Sport</label>
  <div class="col-md-5" style="display:inline-block;">
    <select name="sport" id="sports" class="form-control input-md" style='width:150px' required <?php if(isset($_GET['ref']))
			{
				echo "disabled";
			} ?>>
	<option value=-5>-Sport-</option>
			<?php
			if(isset($_GET['ref']))
			{
				getSport(getEvenement($_GET['ref'])["idSport"]);
			}
			else
			{
				getSport(0);
				
			}
									
			?>
	</select>
	<?php
			if(isset($_GET['ref']))
			{
				echo '<input name="sport_id_save" type="hidden" value="'.getEvenement($_GET['ref'])["idSport"].'"/>';
			}
		
									
			?>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="equipeLocale">Équipe Locale</label>
  <div class="col-md-5">
  <input id="equipeLocale" name="equipeLocale" type="text" placeholder="Équipe locale" class="form-control input-md" style='width:250px' maxlength="75" list="listeEquipes" <?php if(isset($_GET['ref'])){echo 'value="'.getEvenement($_GET['ref'])["equipeReceveur"].'"';} ?>  autocomplete="off">
  <datalist id="listeEquipes">
  <?php
  if(isset($_GET['ref']))
  {
	  getEquipes(getEvenement($_GET['ref'])["idSport"]);
  }
  else
  {
	 getEquipes(0); 
  }
  ?>
  </datalist>
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="equipeVisiteur">Équipe Visiteur</label>
  <div class="col-md-5">
  <input id="equipeVisiteur" name="equipeVisiteur" type="text" placeholder="Équipe visiteur" class="form-control input-md" style='width:250px' maxlength="75" list="listeEquipes" <?php if(isset($_GET['ref'])){echo 'value="'.getEvenement($_GET['ref'])["equipeVisiteur"].'"';} ?>  autocomplete="off">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="typeEvent">Type</label>
  <div class="col-md-5">
    <input id="typeEvent" name="typeEvent" type="text" placeholder="Type d'évenement" class="form-control input-md" style='width:250px' maxlength="80" <?php if(isset($_GET['ref'])){echo 'value="'.getEvenement($_GET['ref'])["type"].'"';} ?>>
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="dateEvent">Date *</label>
  <div class=' col-md-5 input-group date' id='datetimepicker1' style="width: 255px;">
		  <input id="dateEvent" name="dateEvent"
			   type="text"
				 placeholder="Date d'évenement" class="form-control input-md" 
				 style='width:200px; margin-left:15px;' 
				 <?php if(isset($_GET['ref'])){echo 'value="'.getEvenement($_GET['ref'])["date"].'"';} ?>
				  required="">
			<span class="input-group-addon" style="top:10px">
					<span class="glyphicon glyphicon-calendar"></span>
			</span>
	</div>   
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="heureEvent">Heure</label>
  <div class="col-md-5">
    <input id="heureEvent" name="heureEvent" type="time" placeholder="Heure d'évenement"  class="form-control input-md"  style='width:100px' <?php if(isset($_GET['ref'])){echo 'value="'.getEvenement($_GET['ref'])["heure"].'"';} ?>>
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="status">Statut de l'évenement</label>
  <div class="col-md-5">
	<select name="status" id="status" class="form-control input-md" style='width:150px'>
			<option value="0" <?php if(isset($_GET['ref'])){if(getEvenement($_GET['ref'])["status"]=='0'){echo 'selected';}} ?> >Créé</option>
			<option value="1" <?php if(isset($_GET['ref'])){if(getEvenement($_GET['ref'])["status"]=='1'){echo 'selected';}} ?> >Approuvé</option>
			<option value="2" <?php if(isset($_GET['ref'])){if(getEvenement($_GET['ref'])["status"]=='2'){echo 'selected';}} ?> >À confirmer</option>
			<option value="3" <?php if(isset($_GET['ref'])){if(getEvenement($_GET['ref'])["status"]=='3'){echo 'selected';}} ?> >Annulé</option>
	</select>
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="description">Description</label>
  <div class="col-md-5">
    <textarea id="description" name="description" rows="5" cols="50" form="addEvent" placeholder="Description" class="form-control input-md" style="resize:none"  maxlength="255" ><?php if(isset($_GET['ref'])){echo getEvenement($_GET['ref'])["description"];} ?></textarea>
  </div>
</div>
<hr>
</div>

<a href="" class="af-link" style="padding-left:20%" onclick="
$('#infoLieu').toggle(500);

$('#infoTransport,#Responsable,#infoSejour,#infoGenerales').hide(500);
$('#infLieu').toggleClass('glyphicon-chevron-up glyphicon-chevron-down');

$('#infTrans, #infResponsable, #infSejour, #infGen').removeClass('glyphicon-chevron-up');
$('#infTrans, #infResponsable, #infSejour, #infGen').addClass('glyphicon-chevron-down');

return false;">
Informations Lieu <span id="infLieu" class="glyphicon glyphicon-chevron-down" ></span></a>
<hr>
<div class="form-group" id="infoLieu" hidden>
	<div class="form-group">
		<label class="col-md-4 control-label" for="endroitEvent">Endroit</label>  
		<div class="col-md-5">
			<input id="endroitEvent" name="endroitEvent" type="text" placeholder="Endroit de l'évenement"
					class="form-control input-md" 
					<?php if(isset($_GET['ref'])){echo 'value="'.getEvenement($_GET['ref'])["endroit"].'"';} ?>
					style='width:300px' maxlength="125" list="listeEndroits" autocomplete="off"/>
			<datalist id="listeEndroits">
				<?php getEndroitEvent();?>
			</datalist>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label" for="rueEvent">Rue</label>
		<div class="col-md-5">
			<input id="rueEvent" name="rueEvent" type="text" placeholder="Rue" class="form-control input-md" style='width:300px' maxlength="125" <?php if(isset($_GET['ref'])){echo 'value="'.getEvenement($_GET['ref'])["rue"].'"';} ?>>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label" for="villeEvent">Ville</label>
		<div class="col-md-5">
			<input id="villeEvent" name="villeEvent" type="text" placeholder="Ville" class="form-control input-md" style='width:250px' maxlength="125" list="listeVilles" <?php if(isset($_GET['ref'])){echo 'value="'.getEvenement($_GET['ref'])["ville"].'"';} ?> autocomplete="off">
			<datalist id="listeVilles">
				<?php getVilles(); ?>
			</datalist>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label" for="codePostal">Code postal</label>
		<div class="col-md-5">
			<input id="codePostal" name="codePostal" type="text" pattern="[ABCEGHJKLMNPRSTVXY]{1}\d{1}[A-Z]{1} \d{1}[A-Z]{1}\d{1}" title="Entrez un code postal valide ex: X9X 9X9" placeholder="Code postal" class="form-control input-md" style='width:110px' maxlength="7" <?php if(isset($_GET['ref'])){echo 'value="'.getEvenement($_GET['ref'])["codePostal"].'"';} ?> >
		</div>
	</div>
	<hr>
</div>

<a href="" class="af-link" style="padding-left:20%" onclick="
$('#infoTransport').toggle(500);

$('#infoLieu,#Responsable,#infoSejour,#infoGenerales').hide(500);
$('#infTrans').toggleClass('glyphicon-chevron-up glyphicon-chevron-down');

$('#infLieu, #infResponsable, #infSejour, #infGen').removeClass('glyphicon-chevron-up');
$('#infLieu, #infResponsable, #infSejour, #infGen').addClass('glyphicon-chevron-down');

return false;">
Informations Transport <span id="infTrans" class="glyphicon glyphicon-chevron-down" ></span></a>
<hr>
<input type="hidden" name="IDTransport" <?php if(isset($_GET['ref'])){echo 'value="'.getEvenement($_GET['ref'])["idTransport"].'"';}else{echo 'value=""';} ?> >
<div class="form-group" id="infoTransport" hidden>
	<div class="form-group">
		<label class="col-md-4 control-label" for="transporteur">Transporteur</label>
		<div class="col-md-5">
			<select name="transporteur" id="transporteur" class="form-control input-md" style='width:250px'>
				<option value=null>-Transporteur-</option>
				<?php
					if(isset($_GET['ref']))
					{
						getTransporteur(getInfoTransport(getEvenement($_GET['ref'])["idTransport"])["idTransporteur"]);
					}
					else
					{
						getTransporteur(0);
					}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label" for="heureDepart">Heure départ</label>
		<div class="col-md-5">
			<input id="heureDepart" name="heureDepart" type="time" class="form-control input-md"  style='width:100px' <?php if(isset($_GET['ref'])){echo 'value="'.getInfoTransport(getEvenement($_GET['ref'])["idTransport"])["heureDepart"].'"';} ?>>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label" for="heureRetour">Heure retour</label>
		<div class="col-md-5">
			<input id="heureRetour" name="heureRetour" type="time" class="form-control input-md"  style='width:100px' <?php if(isset($_GET['ref'])){echo 'value="'.getInfoTransport(getEvenement($_GET['ref'])["idTransport"])["heureRetour"].'"';} ?>>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label" for="dateTransport">Date départ</label>
		<div class="col-md-5 input-group date" id='datetimepicker2' style="width: 255px;">
			<input id="dateTransport" 
						name="dateTransport" 
						type="text" 	
						placeholder="Date départ" 
						class="form-control input-md" 
						style='width:200px; margin-left:15px;' 
						<?php if(isset($_GET['ref'])){echo 'value="'.getInfoTransport(getEvenement($_GET['ref'])["idTransport"])["date"].'"';} ?>
			 />
			<span class="input-group-addon" style="top:10px">
				<span class="glyphicon glyphicon-calendar"></span>
			</span>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label" for="dateTransportR">Date retour</label>
		<div class="col-md-5 input-group date" id='datetimepicker3' style="width: 255px;">
			<input id="dateTransportR" 
						 name="dateTransportR" 
						 type="text" 
						 placeholder="Date retour" 
						 class="form-control input-md" 
						 style='width:200px; margin-left:15px;' 
						 <?php if(isset($_GET['ref'])){echo 'value="'.getInfoTransport(getEvenement($_GET['ref'])["idTransport"])["dateRetour"].'"';} ?>
			/>
			<span class="input-group-addon" style="top:10px">
				<span class="glyphicon glyphicon-calendar"></span>
			</span>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label" for="demandeAchat">Demande d'achat</label>
		<div class="col-md-5 ">
			<input id="demandeAchat" name="demandeAchat" type="text" placeholder="Demande d'achat" class="form-control input-md" style='width:150px' maxlength="10" <?php if(isset($_GET['ref'])){echo 'value="'.getInfoTransport(getEvenement($_GET['ref'])["idTransport"])["demandeAchat"].'"';} ?>>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label" for="typeTransport">Type de transport</label>
		<div class="col-md-5">
			<input id="typeTransport" name="typeTransport" type="text" class="form-control input-md" <?php if(isset($_GET['ref'])){echo 'value="'.getInfoTransport(getEvenement($_GET['ref'])["idTransport"])["typeTransport"].'"';} ?> style='width:200px' maxlength="30" list="listeTypeTransport" autocomplete="off">
			<datalist id="listeTypeTransport">
				<?php
					getTypeTransport();
				?>
			</datalist>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label" for="statusTransport">Statut du transport</label>
		<div class="col-md-5">
		<select name="statusTransport" id="statusTransport" class="form-control input-md" style='width:150px'>
				<option value="0" <?php if(isset($_GET['ref'])){if(getEvenement($_GET['ref'])["status"]=='0'){echo 'selected';}} ?> >Créé</option>
				<option value="1" <?php if(isset($_GET['ref'])){if(getEvenement($_GET['ref'])["statusTransport"]=='1'){echo 'selected';}} ?> >Approuvé</option>
				<option value="2" <?php if(isset($_GET['ref'])){if(getEvenement($_GET['ref'])["statusTransport"]=='2'){echo 'selected';}} ?> >À confirmer</option>
				<option value="3" <?php if(isset($_GET['ref'])){if(getEvenement($_GET['ref'])["statusTransport"]=='3'){echo 'selected';}} ?> >Annulé</option>
		</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label" for="note">Note</label>
		<div class="col-md-5">
			<textarea id="note" name="note" rows="5" cols="50" form="addEvent" placeholder="Note" class="form-control input-md" style="resize:none"  maxlength="255"><?php if(isset($_GET['ref'])){echo getInfoTransport(getEvenement($_GET['ref'])["idTransport"])["note"];} ?></textarea>
		</div>
	</div>
<hr>
</div>


<a href="" class="af-link" style="padding-left:20%" onclick="

$('#infoSejour').toggle(500);

$('#infoLieu,#Responsable,#infoTransport,#infoGenerales').hide(500);
$('#infSejour').toggleClass('glyphicon-chevron-up glyphicon-chevron-down');

$('#infLieu, #infResponsable, #infTrans, #infGen').removeClass('glyphicon-chevron-up');
$('#infLieu, #infResponsable, #infTrans, #infGen').addClass('glyphicon-chevron-down');

return false;">
Informations séjour <span id="infSejour" class="glyphicon glyphicon-chevron-down" ></span></a>
<hr>

<div class="form-group" id="infoSejour" hidden>
	<div class="form-group">
		<label class="col-md-4 control-label" for="lieuSejour">Lieu de séjour</label>
		<div class="col-md-5" style="display:inline-block;" id="infoSejourChild">
				<?php
					if(isset($_GET['ref']))
					{
						getSejour(getEvenement($_GET['ref'])["idSejour"], true);
					}
					else
					{
						getSejour(0, true);
					}?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label" for="statusSejour">Statut du séjour</label>
		<div class="col-md-5">
			<select name="statusSejour" id="statusSejour" class="form-control input-md" style='width:150px'>
					<option value="0" <?php if(isset($_GET['ref'])){if(getEvenement($_GET['ref'])["status"]=='0'){echo 'selected';}} ?> >Créé</option>
					<option value="1" style='background-image:url(..\images\green_light.ico) no-repeat left center;' <?php if(isset($_GET['ref'])){if(getEvenement($_GET['ref'])["statusSejour"]=='1'){echo 'selected';}} ?> >Approuvé </option>
					<option value="2" <?php if(isset($_GET['ref'])){if(getEvenement($_GET['ref'])["statusSejour"]=='2'){echo 'selected';}} ?> >À confirmer</option>
					<option value="3" <?php if(isset($_GET['ref'])){if(getEvenement($_GET['ref'])["statusSejour"]=='3'){echo 'selected';}} ?> >Annulé</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label" for="noteS">Note</label>
		<div class="col-md-5">
			<textarea id="noteS" name="noteS" rows="5" cols="50" form="addEvent" placeholder="Note" class="form-control input-md" style="resize:none"  maxlength="255"><?php if(isset($_GET['ref'])){echo getEvenement($_GET['ref'])["noteSejour"];} ?></textarea>
		</div>
	</div>
	<hr>
</div>

<a href="" class="af-link" style="padding-left:20%" onclick="
$('#Responsable').toggle(500);

$('#infoLieu,#infoSejour,#infoTransport,#infoGenerales').hide(500);
$('#infResponsable').toggleClass('glyphicon-chevron-up glyphicon-chevron-down');

$('#infLieu, #infSejour, #infTrans, #infGen').removeClass('glyphicon-chevron-up');
$('#infLieu, #infSejour, #infTrans, #infGen').addClass('glyphicon-chevron-down');

return false;">Personnel responsable  <span id="infResponsable" class="glyphicon glyphicon-chevron-down" ></span></a>

<hr style="border-width: 1px;border-style: inset;">
<div class="form-group" id="Responsable" hidden>	

<div class="form-group">
				<label class="col-md-4 control-label" for="roleResponsable">Rôle</label>  
				<div class="col-md-4">
					<select name="roleResponsable" id="roleResponsable" class="form-control input-md" style='width:250px'>
					
						<?php
							getRoles2(0);		
						?>
					</select>
				</div>
			</div>
			<div class="form-group">
  <label class="col-md-4 control-label" for="personnelResponsable">Personnel responsable</label>
  <div class="col-md-5">
    <select name="personnelResponsable" id="personnelResponsable" class="form-control input-md" style='width:250px'>
			<option value="0" selected>- Membre du personnel -</option>
			<?php
				getListeResponsable();		
			?>
	</select>
  </div>
</div>	
			<div class="form-group">
				<label class="col-md-4 control-label" for=""></label>  
				<div class="col-md-4">
					<button type="button" id="btnAjoutResp" name="btnAjoutResp" class="btn btn-default btn-sm">
						<span class="glyphicon glyphicon-plus-sign" ></span> Ajouter
					</button>
				</div>
			</div>
			
			<div class="table-responsive">
			<table class="table table-striped" name="tableResp" id="tableResp" style="width: 50%;margin: 0 auto;">
			<thead>
			<tr>
				<th style="display:none;"></th>
				<th style="display:none;" </th>
				<th style="display:none;"></th>
				<th>Rôle</th>
				<th>Personne</th>
				<th style="display:none;" ></th>
			</tr>
			</thead>
			<tbody id="resps" name="resps">
				<?php
					if(isset($_GET['ref']))
					{
						getListRespEvent($ID);
					}
				?>
			</tbody>
			</table>
			</div></br>


</fieldset>
</form>

  </div>

	</hr>

</div>

<div id="secModifier" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
	  
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="color:black;">Ajouter un lieu de séjour</h4>
      </div>
      <div class="modal-body2" style="
    height: 220px;">
<div class="form-group">
  <label class="col-md-4 control-label" for="nomSejour">Nom</label>
  <div class="col-md-5" style="padding-bottom:20px">
    <input id="nomSejour" name="nomSejour" type="text" placeholder="Endroit séjour" class="form-control input-md" required="" maxlength="125">
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="rueSejour" style="">Rue</label>
  <div class="col-md-5" style="padding-bottom:20px">
    <input id="rueSejour" name="rueSejour" type="text" placeholder="Rue" class="form-control input-md" required="" maxlength="125">
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="villeSejour">Ville</label>
  <div class="col-md-5" style="padding-bottom:20px">
    <input id="villeSejour" name="villeSejour" type="text" placeholder="Ville" class="form-control input-md" required="" maxlength="125"> 
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="codePostalSejour">Code Postal</label>
  <div class="col-md-5" style="padding-bottom:20px">
    <input id="codePostalSejour" name="codePostalSejour" type="text" pattern="[ABCEGHJKLMNPRSTVXY]{1}\d{1}[A-Z]{1} \d{1}[A-Z]{1}\d{1}" title="Entrez un code postal valide ex: X9X 9X9" placeholder="Code Postal" class="form-control input-md" required="" maxlength="7">
  </div>
</div>
<div class="form-group">
				<label class="col-md-4 control-label" for="telephoneS">Téléphone(s)</label>  
				<div class="col-md-4">
					<input id="telephoneS" name="telephoneS" pattern="/\(\d{3}\) \d{3}-\d{4}/" title="(111) 222-3333" type="text" maxlength="14" placeholder="(111) 222-3333" class="form-control input-md" style='width:250px'>  
				</div>
			</div>
      </div>
      <div class="modal-footer" style="display:inline-block;">
        <button type="button" class="btn btn-default" id="btnFermerSejour" data-dismiss="modal">Fermer</button>
		 <button type="button" class="btn btn-default" id="btnEnregistrerSejour" ><span class="glyphicon glyphicon-floppy-disk"></span> Enregistrer</button>
      </div>
    </div>
  </div>
</div>
<script>
<?php
	if (isset($_POST['btnSupprimerEvent'])){
		$_SESSION['supprimerEvent'] = 1;
	}
?>
activeSwitch("planification");

$(document).ready(function(){
//$('#statusSejour').select2();
$(document).on('change','#sports',function(){
	$("#resps").html("");
			$.ajax({
				type: 'POST',
				url: 'functionPHP.php',
				data: {ID: $('#sports option:selected').val(),sport_change:'Oui'},
				success: 
				function (response) {
					document.getElementById("resps").innerHTML=response;
			},
			error: function (err){
				ajouterMessage('messageArea','danger','L\'ajout du lieu de séjour a échouée.');
			}
			});
	
});
$('#personnelResponsable').on('change', function(e){
	$('#roleResponsable').empty(); 
	$.ajax({
	type: 'POST',
    url: 'functionPHP.php',
    data: {persRespEvent: $("#personnelResponsable option:selected").val()},
	 success: function (response) {
       document.getElementById("roleResponsable").innerHTML=response;
	 
    },
    error: function (err){
      ajouterMessage('messageArea','danger','');
	  
    }

	
       });
    });
	$('#btnAjoutResp').on('click', function(e){
			if ($("#personnelResponsable option:selected").html() != "- Membre du personnel -" && $("#roleResponsable option:selected").html() != "- Rôle -")
			{
				var table = document.getElementById("resps");
				var ligne = table.insertRow(0);
				var mod = ligne.insertCell(0);
				var idResp = ligne.insertCell(1);
				var idPersonne = ligne.insertCell(2);
				var role = ligne.insertCell(3);
				var nom = ligne.insertCell(4);
				
				var supp = ligne.insertCell(5);
				mod.innerHTML = '<input type="hidden" name="modif[]" value="0"/>';
				idResp.innerHTML = '0';
				idPersonne.innerHTML = '<input type="hidden" name="tabPers[]" readonly value="'+ $("#personnelResponsable option:selected").val() + '" style=" border: 0;"/>';
				idPersonne.className='hidden';
				mod.className='hidden';
				idResp.className='hidden';
				nom.innerHTML = '<input type="text" name="tabNoms[]" readonly value="'+ $("#personnelResponsable option:selected").html() + '" style=" border: 0;"/>';
				role.innerHTML = '<input type="text" name="tabRoles[]" readonly value="'+ $("#roleResponsable option:selected").html() + '" style=" border: 0;"/>';
				supp.innerHTML = '';
				
				document.getElementById('personnelResponsable').selectedIndex = 0;
				document.getElementById('roleResponsable').selectedIndex = 0;
			}
    });
	$(document).on('click', '#tableResp tbody tr button', function(e){
		    
			var r = confirm("Voulez-vous vraiment supprimer le responsable?");
			if (r == true)
			{
				$.ajax({
				type: 'POST',
				url: 'functionPHP.php',
				data: {suppResp: $(this).closest("tr").find("td:nth-child(2)").text(), idEvent: document.getElementById("id").value},
				success: 
				function (response) {
					document.getElementById("resps").innerHTML=response;
			},
			error: function (err){
				ajouterMessage('messageArea','danger','L\'ajout du lieu de séjour a échouée.');
			}
			});
		}
    });
	$('#btnEnregistrerSejour').on('click', function(e){
		
	    var nomSejour = document.getElementById('nomSejour').value;
			var rueSejour = document.getElementById('rueSejour').value;
			var villeSejour = document.getElementById('villeSejour').value;
			var codePostalSejour = document.getElementById('codePostalSejour').value;
			var telephoneS = document.getElementById('telephoneS').value;
			
			if (nomSejour.replace(' ','').length != 0 &&
			    villeSejour.replace(' ','').length != 0  &&
					rueSejour.replace(' ','').length != 0 &&
					codePostalSejour.match(/[ABCEGHJKLMNPRSTVXY]{1}\d{1}[A-Z]{1} \d{1}[A-Z]{1}\d{1}/) &&
					telephoneS.match(/\(\d{3}\) \d{3}-\d{4}/)){
					  	$('#infoSejourChild').empty(); 
				 			$.ajax({
								type: 'POST',
								url: 'functionPHP.php',
								data: {
									ajoutSejour: nomSejour, 
									rue: rueSejour, 
									ville: villeSejour, 
									codePostal: codePostalSejour, 
									noTel: telephoneS
								},
								success: function (response) {
									document.getElementById("infoSejourChild").innerHTML=response;
									$('#secModifier').modal('toggle');
								}
      			 });
				 		 
					}
					else{
						toastr.error('L\'ajout du lieu de séjour a échouée.');
					}
    });
	
	$('#sport').on('change', function(e){
	$('#listeEquipes').empty(); 
	$.ajax({
	type: 'POST',
    url: 'functionPHP.php',
    data: {sportChange: document.getElementById('sport').value},
	 success: function (response) {
       document.getElementById("listeEquipes").innerHTML=response;
	 
    },
    error: function (err){
      ajouterMessage('messageArea','danger','');
	  
    }

	
       });
    });
	
	//stéph
	$('#modifierSejour').on('click', function(e){
		$('#detailSejour').empty(); 
		$.ajax({
			type: 'POST',
			url: 'functionPHP.php',
			data: {detailSejourUpdate2: document.getElementById('lieuSejour').value},
			 success: function (response) {
			   document.getElementById("detailSejour").innerHTML=response;
			 
			},
			error: function (err){
			  ajouterMessage('messageArea','danger','');
			  
			}

	
       });
	});
	
	//steph
	
	$('body').on('click','#idBtnSauvegarderSejour', function()
	{   
		var datafunctiontest=document.getElementById('lieuSejour').options[document.getElementById('lieuSejour').selectedIndex].value+";"+document.getElementById('testNomSejour').value+";"+document.getElementById('testRueSejour').value 
				+";"+document.getElementById('testVilleSejour').value+";"+document.getElementById('testCodePostalSejour').value+";"
		for (var i=0, max=document.getElementsByName('testTelSejour').length; i < max; i++) {
			datafunctiontest=datafunctiontest+document.getElementsByName('testTelSejour')[i].value+"_";
		}
    
		$.ajax(
		{
			type: 'POST',
			url: 'functionPHP.php',
			data:{updateSejour:datafunctiontest},
			success: function (response) {
				document.getElementById("detailSejour").innerHTML=response;
				 
			},
			error: function (err){
			ajouterMessage('messageArea','danger','');}
		});
	 

		////reset
		$('#detailSejour').empty(); 
		$.ajax(
		{
			type: 'POST',
			url: 'functionPHP.php',
			data: {detailSejourUpdate: document.getElementById('lieuSejour').value},
			success: function (response) {
				document.getElementById("detailSejour").innerHTML=response;
				 
			},
			error: function (err){
			ajouterMessage('messageArea','danger','');
				  
			}

	
       });
	});
	
	
	//stéph  
	var testcounttel=1;
	$(document).on('click','#idAjouterTelSejour', function (){
		if($('.deleteTelSejour').length<3)
		{
			testcounttel++;
			$('#tel_container').append(
				"<input type='text' name='testTelSejour' id='testTelSejour' pattern='\(\d{3}\) \d{3}-\d{4}' maxlength='14' style='height: 29px; border: 1;' />"+
					"<span id='deleteTelSejour' class='deleteTelSejour glyphicon glyphicon-remove'></span>"
			)
		}	
});
	
	//stéph
	$('body').on('click','#idBtnSupprimerSejour', function (){
		
		$.ajax(
		{
			type: 'POST',
			url: 'functionPHP.php',
			data:{deleteSejour:document.getElementById('lieuSejour').value}
		});
		
		////reset
		$('#detailSejour').empty(); 
		$.ajax(
		{
			type: 'POST',
			url: 'functionPHP.php',
			data: {detailSejourUpdate: document.getElementById('lieuSejour').value},
			success: function (response) {
				document.getElementById("detailSejour").innerHTML=response;
				 
			},
			error: function (err){
			ajouterMessage('messageArea','danger','');
				  
			}

	
       });
	});
	
	//stéph
	$('body').on('click','.deleteTelSejour', function (){
		$(this).prev().remove();
		$(this).remove();
	});
	
	$(document).ready(function(){
		//Assure une cohérence entre une date de début et une date de fin de transport
		//Anthony
		function dateMaxEvenement($debut,$fin){
			var dateMax = document.getElementById($fin);
			var dateDeb = document.getElementById($debut);
			if (dateDeb.value > dateMax.value && dateDeb.value != "" && dateMax.value != ""){
				dateDeb.max = dateMax.value;
				dateDeb.value = dateMax.value;
				toastr["warning"]("La date de début doit être plus petite que celle de fin!", "Attention!")
			}
		}

		//Assure une cohérence entre date de transport et date évènements
		//Anthony
		function dateTransportEvenement($debut,$fin,$evenement){
			var dateMax = document.getElementById($fin);
			var dateDeb = document.getElementById($debut);
			var dateEvenement = document.getElementById($evenement);

			if (dateDeb.value > dateEvenement.value && dateDeb.value != "" && dateEvenement.value != ""){
				dateDeb.value = dateEvenement.value;
				toastr["warning"]("La date de départ doit être plus petite ou égale à celle de l'évènement!", "Attention!");
			}

			if (dateMax.value < dateEvenement.value && dateMax.value != "" && dateEvenement.value != ""){
				dateMax.value = dateEvenement.value;
				toastr["warning"]("La date de retour doit être plus petite ou égale à celle de l'évènement!", "Attention!");
			}

		}

		$('#dateTransport, #dateTransportR').on('change', function(){
			console.log("TEST");
			dateMaxEvenement('dateTransport','dateTransportR');
			dateTransportEvenement('dateTransport','dateTransportR','dateEvent');
		});		
	});


	$(document).on('change', '#lieuSejour', function(e){
		
		
		$('#detailSejour').empty(); 
		$.ajax({
			type: 'POST',
			url: 'functionPHP.php',
			data: {
				detailSejourUpdate: document.getElementById('lieuSejour').value
			},
			success: function (response) { document.getElementById("detailSejour").innerHTML=response; },
		});
  });
	$(document).on('change','#names',function(){
		 $(this).closest('tr').find('#tabPers').val($("#names option:selected").val());
		
	});
});
</script>
</div>
<div class="footer"> 
<?php
require_once("footer.php");
?>
</div>
</div>
</body>
</html>