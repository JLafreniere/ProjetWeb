<?php
/*
Auteur:			Gabriel Richer
Description:	Page où l'utilisateur peut ajouter/modifier/supprimer un sport.
*/
require_once ("Connexion/Connect.php");
require_once ("Connexion/Connexion.php");
require_once ("Connexion/ExecRequete.php");
require_once ("functionPHP.php");
 
?>
<html>


<head>
<meta http-equiv="content-type" content="text/html; charset=utf8" />
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment-with-locales.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

  <script type="text/javascript" src="Includes/bootstrap-datetimepicker.js"></script>
  <script src="Includes/toastr.min.js"></script>
  <script src="functions.js"></script>
  <script src="select2.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link type="text/css" rel="stylesheet" href="Includes/bootstrap-datetimepicker.min.css">

  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="Includes/toastr.css">
  <link rel="stylesheet" type="text/css" href="mastersheet.css">
  <link rel="stylesheet" type="text/css" href="nav-bar.css">
  <link rel="stylesheet" type="text/css" href="footer.css">
  <link rel="stylesheet" type="text/css" href="select2.css">

  <script>
  
       var ctr=0;
 var ctr2=0;
 var ctr3=0;
 var lastvalue="";

     $(document).ready(function() { 

		activeSwitchGestion("sport");
      $('#e1').select2(); 
	  
$("#e1 option:selected").each(function()
{
   ctr=ctr+1;
});
 var $select2 = $("#e1");
 
 $("#e1").select2({
tags: true
});

$("select").on("select2:select", function (evt) {
var element = evt.params.data.element;
var $element = $(element);

$element.detach();
$(this).append($element);
$(this).trigger("change");

});

		
$("select").on("select2:select", function (evt) {
	
$("#e1 option:selected").each(function()
{
   ctr2=ctr2+1;
   
   
});

if (ctr<ctr2){
var option = document.createElement("option");
var x = document.getElementById("e1");
option.text="";
option.value="";
option.text=$("option:selected:last",this).text();
option.value=$("option:selected:last",this).text();
lastvalue=$("option:selected:last",this).text();;
var element = evt.params.data.element;
var $element = $(element);
$("#e1 option:selected:last").remove();
$element.detach();
$(this).append($element);



x.add(option);


ctr=ctr2;
ctr2=0;
ctr3=0;
}


});

$("#e1").change(function() {
	
$("#e1 option:selected").each(function()
{
   ctr3=ctr3+1;
 
});

if (ctr>ctr3){
	/*
	var map = {};
	var ctr5=0;
  $("#e1").on('click',"select2-selection__choice__remove",function (evt) {
      alert('gg');

        var $remove = $(this);
        var $selection = $remove.parent();

        var data = $selection.data('data');

        self.trigger('unselect', {
          originalEvent: evt,
          data: data
        });
      }
    );
*/

ctr=ctr3;


}  
ctr3=0;
ctr5=0;
}); 
});
    </script>
</head>

<body style="background-image:none !important">
<div class="wrapper">
<div class="content">
<?php 
require_once('nav-bar_inner.php');
?>

<ol class="breadcrumb">
  <li><a href="index.php">Accueil</a></li>
  <li><a href="gestionSport.php">Gestion des sports</a></li>
  <li><a href="modifierSport.php">Sports</a></li>
</ol>

<?php 
echo '<form class="form-horizontal" method="POST">
<fieldset>

<!-- Form Name -->
<legend>Sports</legend>';

if( !isset($_SESSION['mode']) ) {
    $_SESSION['mode'] = 'Chat';
}

if ( $_SESSION['mode'] == 'MODIFICATION'){
echo '
<div class="row">
  <div class="col-sm-12">
<button type="submit" class="btn btn-default btn-sm btn-gestion" id="btnEnregistrerSport" name="btnEnregistrerSport">
    <span class="glyphicon glyphicon-floppy-disk"></span> Enregistrer
</button>
<button type="submit" class="btn btn-default btn-sm btn-gestion" id="btnSupprimerSport" name="btnSupprimerSport" ;>
     <span class="glyphicon glyphicon-remove"></span> Supprimer
</button>
<button type="button" class="btn btn-default btn-sm btn-gestion" id="btnAnnuler" onclick="window.location.replace(\'gestionSport.php\')";>
     Annuler
</button><br><br>';
}
if ($_SESSION['mode'] != 'MODIFICATION'){
echo '<div class="row">
  <div class="col-sm-12"><button type="submit" id="inscrire" name="btnInscrireSport" style="float:right;margin-right:10px;" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-floppy-disk" ></span> Enregistrer</button><br><br>';
 $_SESSION['nomClique'] = null;
} 
if (isset($_SESSION['nomClique'])){
// echo '<div class=row>';
getSport2($_SESSION['nomClique']);
// echo '</div>';
}
else getSport2(null);


?></div></div></div></div>


<?php


$string="";
 if (isset($_POST['btnInscrireSport'])){
	
if (isset($_POST['e1'])){
foreach ($_POST['e1'] as $select)
{
	$string=$string."".$select.';';


}
	 }

    inscrireSport('null',$_POST['nom'],$string);

	$_SESSION['nomClique'] = null;
	// $_SESSION['ajoutSport'] = 'ajout';
	 echo "<script>location.replace('gestionSport.php');</script>";	

 }
 
 if (isset($_POST['btnEnregistrerSport'])){
	$string="";
	if (isset($_POST['e1'])){
	foreach ($_POST['e1'] as $select)
{
	$string=$string."".$select.';';

	

}
	}
	
    updateSport($_SESSION['nomClique'],$_POST['nom'],$string);
	
  
 }

 if (isset($_POST['btnSupprimerSport'])){
 supprimerSport($_SESSION['nomClique']);
 
 }

?>

<div class="footer">
<?php
require_once ("footer_inner.php");
?>
</div>
</div>


</body>



</html>