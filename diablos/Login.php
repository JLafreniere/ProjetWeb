<?php
require_once ("Connexion/Connect.php");
require_once ("Connexion/Connexion.php");
require_once ("Connexion/ExecRequete.php");
require_once ("functionPHP.php");

		
		?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
	<head>
	
<meta http-equiv="content-type" content="text/html; charset=utf8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script src="functions.js"></script>
		 <link rel="stylesheet" type="text/css" href="css/style.css" />
		 <link rel="stylesheet" type="text/css" href="mastersheet.css">
		<title>Connexion</title>
		
	</head>

	<body>
	<div class="wrapper">
<div class="content">

<?php
require_once('nav-bar.php');
?>
		
		<div>
		
			<div class="row">
<div  class="col-sm-2"></div>
<div style="background-color:white;margin-right:auto;margin-left:auto;padding-bottom:30px;border-radius:10px;opacity:0.95;padding-top:30px;height:275px!important" class="col-sm-8">
				<form class="form-horizontal" id="af-form" method="post" style="margin-left:auto;margin-right:auto;" action="Login.php">
				<fieldset>
					<div class="form-group">
					<label for="input-noEmp" class="col-md-4 control-label">Nom d'utilisateur</label>
						<div class="col-md-5">
							<input type="text" name="txtNomUtilisateur" id="input-nomUser" class="form-control input-md"  maxlength="20" style="width:250px" required>
						</div>
					</div>
					<div class="form-group">
					<label for="input-pwd" class="col-md-4 control-label">Mot de passe</label>
						<div class="col-md-5">
							<input type="password" name="txtPwd" id="input-pwd" class="form-control input-md" style="width:250px" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" for="CONNECT"></label>
						<div class="col-md-4">
							<button type="submit" name="CONNECT" class="btn btn-primary" style="margin-left:65px">Se connecter</button>
						</div>
					</div>
					</fieldset>
				</form>
		</div>
		</div>
<div class="col-sm-2"></div>
</div>
</div>

</div>
<?php
			if(isset($_POST['CONNECT']))
			{
				connectMembre($_POST['txtNomUtilisateur'], $_POST['txtPwd']);
				
			}
		?>	
<div class="footer"> 
<?php
require_once("footer.php");
?>
  
</div>
</div>
</div>
	
	</body>
</html>