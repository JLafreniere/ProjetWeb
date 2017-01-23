<?php
  /*
  Auteur: 		Anthony Duhaime
  Description:	Page d'accueil du site de gestion d'horaire des Diablos
  */
  require_once("Connexion/Connect.php");
  require_once("Connexion/Connexion.php");
  require_once("Connexion/ExecRequete.php");
  require_once("functionPHP.php");
  include_once('functions.php');
 ini_set('error_reporting',0);
	ini_set('display_error',0);
	session_start();
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
  <script src="maincalendar.js"></script>
  <script src="select2.js"></script>
  <meta charset="UTF_8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link type="text/css" rel="stylesheet" href="Includes/bootstrap-datetimepicker.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2-rc.1/css/select2.min.css"/>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="Includes/toastr.css">
  <link rel="stylesheet" type="text/css" href="mastersheet.css">
  <link rel="stylesheet" type="text/css" href="nav-bar.css">
  <link rel="stylesheet" type="text/css" href="footer.css">
   <link rel="stylesheet" type="text/css" href="select2.css">

 
</head>

<body>
<div class="wrapper">
<div class="content">

<?php
require_once('nav-bar_inner.php');
if (isset($_SESSION['conn_re'])){
	if ($_SESSION['conn_re'] == 'conn'){
		echo '<script>toastr.success("Connexion réussie !");</script>';
		$_SESSION['conn_re'] = '';
	}
	
}
if (isset($_SESSION['deconn_re'])){
if ($_SESSION['deconn_re'] == 'deconn'){
		echo '<script>toastr.success("Déconnexion réussie !");</script>';
		$_SESSION['deconn_re'] = '';
	}
}
?>

      <ol class="breadcrumb">
        <li><a href="index.php">Accueil</a></li>
      </ol>

      <div class="row">
        <div  class="col-sm-2"></div>
        <div id="calendar_div" style="background-color:white;margin-right:auto;margin-left:auto;padding-bottom:30px;border-radius:10px;opacity:0.95;display: table;" class="col-sm-8">
        <?php include("maincalendar.php") ?>
        <div  class="col-sm-2"></div>
      </div>
    </div>
  </div>

  <div class="footer"> 
    <?php require_once("footer_inner.php"); ?>
  </div>

</body>

</html>