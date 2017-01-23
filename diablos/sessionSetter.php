<?php
  ini_set('error_reporting',0);
	ini_set('display_error',0);
	session_start();
$_SESSION['nomClique'] = $_POST['sendCellValue'];
$_SESSION['mode'] = $_POST['mode'];
$_SESSION['idEntraineur'] = $_POST['idEntraineur'];
?>