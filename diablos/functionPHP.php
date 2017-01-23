<?php
$_SESSION['modifevenement']="";
 // error_reporting(0);
//  
 ini_set('error_reporting',0);
	ini_set('display_error',0);
	session_start();
require_once ("Connexion/Connect.php");
require_once ("Connexion/Connexion.php");
require_once ("Connexion/ExecRequete.php");
mb_internal_encoding('UTF-8');

//mysqli_report(MYSQLI_REPORT_ALL);
 //Jérémie
 function connectMembre($user, $pass){
	 $connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
		$trouv = false;
		$requete = "SELECT * from utilisateurs_gestion where nomUtilisateur = '".$user."' and estActif = 1";
		mysqli_set_charset($connexion,'UTF8');
		$resultat = ExecRequete($requete, $connexion);
		$resultat->data_seek(0);
		$row = $resultat->fetch_assoc();	

			if( password_verify($pass, $row['motPasse']))
				{
					$trouv =true;
					$type = $row['estAdmin'];
					$_SESSION['conn_re'] = 'conn';

				}
				else
				{
					echo '<script>toastr.error("Votre nom d\'utilisateur ou votre mot de passe est incorrect");</script>';
					 $trouv = false;
				}					
		if($trouv)
		{		
			$_SESSION['nomUtilisateur']=$user;	
			$_SESSION['estAdmin']= $type;
			echo '<script>window.location.replace("index.php");</script>'	;
		}
	
}
//Jérémie
if(isset($_GET['DECONNECT']))
{
//if(session_status() != PHP_SESSION_NONE)
//{
	 
	session_unset();
//}
		$_SESSION['deconn_re']='deconn';
		echo '<script>window.location.replace("index.php");</script>'	;	
	
}

 //mysqli_report(MYSQLI_REPORT_ALL);
//Détermine si l'utilisateur est administrateur via son ID
//Anthony
function getAdminStatus($userID){
$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$requete = "SELECT estAdmin FROM utilisateur where id = '".$userID."';";
	mysqli_set_charset($connexion,'UTF8');
	$resultat = ExecRequete($requete, $connexion);
	$resultat->data_seek(0);
	$row = $resultat->fetch_assoc();
	$_SESSION['estAdmin'] = $row['estAdmin'];
	return $row['estAdmin'];

}

//Détermine si l'utilsateur est actif via son ID
//Anthony
function getActiveStatus($userID){

$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$requete = "SELECT estActif FROM utilisateur where id = '".$userID."';";
	mysqli_set_charset($connexion,'UTF8');
	$resultat = ExecRequete($requete, $connexion);
	$resultat->data_seek(0);
	$row = $resultat->fetch_assoc();
	$_SESSION['estAdmin'] = $row['estActif'];
	return $row['estActif'];

}

/// Gabriel Dubé
function usernameExists($username) {
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$requete = "SELECT COUNT(id) FROM utilisateurs_gestion WHERE nomUtilisateur = ?;";
	$stmt = $connexion->prepare($requete);
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$stmt->bind_result($count);
	while ($stmt->fetch()) {
		if ($count > 0){
			return true;
		} else {
			return false;
		}
	}
	
	return false;
}

//Inscrit un membre
//Gabriel Dubé
function inscrireMembre($username, $password, $status){
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	mysqli_set_charset($connexion,'UTF8');
	
	// Check username
	$username_check = preg_replace('/[^a-zA-Z0-9_]/', '', $username);
	if ( strlen($username_check) < 2 || strlen($username_check) > 29 ){
		$_SESSION['inscrireError'] = "Le nom d\\'utilisateur ne peut pas contenir de caractères spéciaux ni d\\'espaces. Il doit avoir entre 2 et 30 caractères.";
		return;
	}
	
	if (usernameExists($username)) {
		$_SESSION['inscrireError'] = "Le nom d\\'utilisateur existe déjà.";
		return;
	}
	
	// Check password
	$pswd_check = preg_replace('/[^a-zA-Z0-9_]/', '', $password);
	if ( strlen($pswd_check) < 2 || strlen($pswd_check) > 30 ){
		$_SESSION['inscrireError'] = "Le mot de passe ne peut pas contenir de caractères spéciaux ni d\\'espaces. Il doit avoir entre 2 et 30 caractères.";
		return;
	}

	$username = addslashes($username);
	$password = addslashes(password_hash($_POST['motPasse'], PASSWORD_DEFAULT));


	$requete = "INSERT INTO utilisateurs_gestion values (null, ?, ?, 0, ?);";
	
	$stmt = $connexion->prepare($requete);
	$stmt->bind_param("ssi", $username, $password, $status);
	$stmt->execute();
	
	$_SESSION['succesModification'] =  "L\\'utilisateur a été créé avec succès.";
}


//Détermine si l'utilisateur est connecté
//Maxime && Anthony
function estConnecte(){
	if (isset($_SESSION['nomUtilisateur']))
	{
		echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Mon compte <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="" id="btnConnexion" onclick="connexionSwitch();return false;">Déconnexion</a></li>
	          </ul>';
	}
	else {
		echo '          <a href="#" class="dropdown-toggle" id="btnConnexion" role="button" onclick="connexionSwitch();return false;">Connexion</a>';
	}
}


//Affiche la liste des membres
function getMembres(){
$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
$requete = "select * from utilisateurs_gestion;";
mysqli_set_charset($connexion,'UTF8');
$resultat = ExecRequete($requete, $connexion);
$resultat->data_seek(0);
$row = $resultat->fetch_assoc();
echo '<div class="table-responsive">
<table class="table table-striped table-hover" id="tableUtilisateurs">
    <thead>
      <tr>
        <th>Nom utilisateur</th>
        <th>Actif</th>
        <th>Administrateur</th>
      </tr>
    </thead>
	<tbody id="tbl-Utilisateurs">';
foreach($resultat as $row){
if ($row['estActif'] == 1){
	if ($row['estAdmin'] == 1){
		echo '<tr><td>'.$row["nomUtilisateur"].'</td><td><span class="glyphicon glyphicon-ok"></span></td><td><span class="glyphicon glyphicon-ok"></td><td><span class="glyphicon glyphicon-cog"></span></td></tr>';

	}else
		echo '<tr><td>'.$row["nomUtilisateur"].'</td><td><span class="glyphicon glyphicon-ok"></span></td><td></td><td><span class="glyphicon glyphicon-cog"></span></td></tr>';
}else
if ($row['estAdmin'] == 1){
echo '<tr><td>'.$row["nomUtilisateur"].'</td><td></td><td><span class="glyphicon glyphicon-ok"></span></td><td><span class="glyphicon glyphicon-cog"></span></td></tr>';
}else
echo '<tr><td>'.$row["nomUtilisateur"].'</td><td></td><td></td><td><span class="glyphicon glyphicon-cog"></span></td></tr>';
}
echo '</tbody></table></div>
<div class="col-md-12 text-center">
      <ul class="pagination pagination-lg pager" id="pagerUtilisateur"></ul>
      </div>';


}

//Affiche un membre selon son nom d'utilisateur
//Anthony
function getMembre($nomUtilisateur){
$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$requete = "SELECT * FROM utilisateurs_gestion where nomUtilisateur = '".$nomUtilisateur."';";
	mysqli_set_charset($connexion,'UTF8');
	$resultat = ExecRequete($requete, $connexion);
	$resultat->data_seek(0);
	$row = $resultat->fetch_assoc();
	return $row;
}

//Enregistre les modifications approtées à un membre
//Anthony
function updateMembre($id,$nomUtilisateur,$status,$admin){
$caught = false;
$err = false;
$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);

$req = "select estAdmin from utilisateur where id ='".$id."' ;";
$resultat0 = ExecRequete($req, $connexion);
	$resultat0->data_seek(0);
	$row0 = $resultat0->fetch_assoc();
	
$requete = "update utilisateurs_gestion set nomUtilisateur = '".addslashes($nomUtilisateur)."', estActif = '".$status."',estAdmin = '".$admin."' where id ='".$id."' ;";


mysqli_set_charset($connexion,'UTF8');

try{

if ($admin == 0 && $row0['estAdmin'] == 1){
if (getAdminCount() > 1){
ExecRequete($requete, $connexion);} else { $_SESSION['dernierAdmin'] = 1;$err = true;} } else ExecRequete($requete, $connexion);}

catch (Exception $e){
$caught = true;
echo '<div class="alert alert-danger">
  <strong>Erreur!</strong> Le nom d\'utilisateur existe déjà.
</div>';
}
finally{
if (!$caught && !$err){
	$_SESSION['succesModification'] = 'succes';
	}
}
return getMembre($id);
}

function updatePassword($userID,$motPasse){
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	mysqli_set_charset($connexion,'UTF8');
	$requete = "update utilisateurs_gestion set motPasse = '".password_hash($motPasse,PASSWORD_DEFAULT)."' where id =".$userID.";";
	ExecRequete($requete, $connexion);
}

function deleteMembre($userID){
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	mysqli_set_charset($connexion,'UTF8');
	$requete = "delete from utilisateurs_gestion where id = ".$userID.";";
	$req = "select estAdmin from utilisateurs_gestion where id ='".$userID."' ;";

	$resultat0 = ExecRequete($req, $connexion);
	$resultat0->data_seek(0);
	$row0 = $resultat0->fetch_assoc();


	if (getAdminCount() > 1 || $row0['estAdmin'] == 0){
		$_SESSION['supprimerMembre'] = 'supprimer';
		ExecRequete($requete, $connexion);} else {
			$_SESSION['dernierAdmin'] = 1;
			echo"<script>window.location.replace('gestionUtilisateur.php');</script>";
		}
	}
//Jérémie
function getEvenements(){
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$requete = "SELECT `evenement`.`id` as `id`, `evenement`.`idSport` as `idSport`, `transporteur`.`nom` as `transporteur`, `evenement`.`statusTransport` as `statusTransport`, `evenement`.`endroit` as `endroit`, `endroit_sejour`.`nom` as `lieuSejour`, `evenement`.`idSejour` as `idSejour`, `evenement`.`statusSejour`, `evenement`.`equipeVisiteur` as `equipeVisiteur`, `evenement`.`equipeReceveur` as `equipeReceveur`,`evenement`.`type` as `type`, DATE_FORMAT(`evenement`.`heure`, '%H:%i') as `heure`, `evenement`.`date` as `date`, `evenement`.`rue` as `rue`, `evenement`.`ville` as `ville`, `evenement`.`codePostal` as `codePostal`, `evenement`.`status` as `status` FROM `evenement` left join `endroit_sejour` on `evenement`.`idSejour` = `endroit_sejour`.`id` left join `transport` on `evenement`.`idTransport` = `transport`.`id` left join `transporteur` on `transport`.`idTransporteur` = `transporteur`.`id` order by `evenement`.`date` desc";
	mysqli_set_charset($connexion,'UTF8');
	$resultat = ExecRequete($requete, $connexion);
	$resultat->data_seek(0);
	$row = $resultat->fetch_assoc();
	echo '<div class="table-responsive" style="width: 100%;">
	<table class="table table-striped table-hover" id="tableEvenement">
		<thead>
			<tr>
				<th class="hidden"></th>
				<th class="hidden"></th>
				<th>Date</th>
				<th>Heure</th>
				<th>Équipe Locale</th>
				<th>Équipe Visiteur</th>
				<th>Endroit</th>
				<th>Transporteur</th>
				<th>Lieu Séjour</th>
				<th hidden>Type</th>
			</tr>
		</thead>
		<tbody id="tblEvenement">';
	foreach($resultat as $row){
		echo '<tr class="visible">
		<td  class="hidden">'.$row["id"].'</td>
		<td  class="hidden">'.$row["idSport"].'</td>
		<td style="text-align:center; width:98px">'.$row["date"];

		if($row['status']==1)
		{
			/*echo '<br><img class="EvenementStatut" style="width:15px;height:15px;text-align:center" src="images\green_light.ico"/>';*/
			echo '<br><span style="color:#00cc00; font-size:1.5em" title="Confirmé">&#10004;</span>';
		}
		else if($row['status']==2)
		{	
			/*echo '<br><img class="EvenementStatut" style="width:15px;height:15px;text-align:center" src="images\yellow_light.ico"/>';*/
			echo '<br><span style="color:#ffcc00; font-size:1.5em" title="À confirmer">&#10067;</span>';
		}
		else if($row['status']==3)
		{
			/*echo '<br><img class="EvenementStatut" style="width:15px;height:15px;text-align:center" src="images\red_light.ico"/>';*/
			echo '<br><span style="color:#ff0000; font-size:1.5em" title="Annulé">&#10006;</span>';
		}

		echo '</td>
		<td>'.$row["heure"].'</td>
		<td>'.$row["equipeReceveur"].'</td>
		<td>'.$row["equipeVisiteur"].'</td>
		<td>'.$row["endroit"].'</td>
		<td style="text-align:center">'.$row["transporteur"];
		if($row['statusTransport']==1)
		{
			/*echo '<br><img class="EvenementStatut" style="width:15px;height:15px;text-align:center" src="images\green_light.ico"/>';*/
			echo '<br><span style="color:#00cc00; font-size:1.5em" title="Confirmé">&#10004;</span>';
		}
		else if($row['statusTransport']==2)
		{
			/*echo '<br><img class="EvenementStatut" style="width:15px;height:15px;text-align:center" src="images\yellow_light.ico"/>';*/
			echo '<br><span style="color:#ffcc00; font-size:1.5em" title="À confirmer">&#10067;</span>';
		}
		else if($row['statusTransport']==3)
		{
			/*echo '<br><img class="EvenementStatut" style="width:15px;height:15px;text-align:center" src="images\red_light.ico"/>';*/
			echo '<br><span style="color:#ff0000; font-size:1.5em" title="Annulé">&#10006;</span>';
		}
		echo '</td>
		<td style="text-align:center">'.$row["lieuSejour"];
		if($row['idSejour'] != NULL)
		{
			if($row['statusSejour']==1)
			{
				/*echo '<br><img class="EvenementStatut" style="width:15px;height:15px;text-align:center" src="images\green_light.ico"/>';*/
				echo '<br><span class="icon" style="color:#00cc00; font-size:1.5em" title="Confirmé">&#10004;</span>';	
			}
			else if($row['statusSejour']==2)
			{
				/*echo '<br><img class="EvenementStatut" style="width:15px;height:15px;text-align:center" src="images\yellow_light.ico"/>';*/
				echo '<br><span style="color:#ffcc00; font-size:1.5em" title="À confirmer">&#10067;</span>';
			}
			else if($row['statusSejour']==3)
			{
				/*echo '<br><img class="EvenementStatut" style="width:15px;height:15px;text-align:center" src="images\red_light.ico"/>';*/
				echo '<br><span style="color:#ff0000; font-size:1.5em" title="Annulé">&#10006;</span>';
			}
		}
		echo'</td>
		<td hidden>'.$row["type"].'</td>
		<td onClick="if (document.getElementById(\'securite\').value == \'1\'){window.location.href=\'evenement.php?ref=',$row["id"],'\'}" ><span class="glyphicon glyphicon-cog"></span></td>
		</tr>';
	}
	echo '</tbody></table></div><div id="infoEventDetail" class="modal fade" role="dialog"></div><div class="col-md-12 text-center">
	<ul class="pagination pagination-lg pager" id="pagerEvent"></ul>
	</div>';
}

//Jérémie
function getEvenement($idEvenement){
$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$requete = "SELECT * FROM evenement where id = '".$idEvenement."';";
	mysqli_set_charset($connexion,'UTF8');
	$resultat = ExecRequete($requete, $connexion);
	$resultat->data_seek(0);
	$row = $resultat->fetch_assoc();
	return $row;
}
//Jérémie
function getSejour($id, $editfix = false){
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$requete = "SELECT * from endroit_sejour order by nom;";
	$exist = false;
	mysqli_set_charset($connexion,'UTF8');
	$resultat = ExecRequete($requete, $connexion);
	$resultat->data_seek(0);
	$row = $resultat->fetch_assoc();
	echo '<div><select name="lieuSejour" id="lieuSejour" class="form-control input-md" style="width:200px; display:inline-block;"><option value="NULL" selected>-Lieu de séjour-</option>';
	foreach($resultat as $row){
		if($id == $row["id"])
		{
			echo '<option value="'.$row["id"].'" selected>'.$row["nom"].'</option>';
			$exist = true;
		}
		else
		{
			echo '<option value="'.$row["id"].'">'.$row["nom"].'</option>';
		}
	}

	echo '</select>
		<a class="btn btn-default btn-sm" data-toggle="modal" data-target="#secModifier" id="btnAjouterSejour"  style="display:inline-block;margin-left: 15px; width:100px;">
			<span class="glyphicon glyphicon-plus-sign"></span> Ajouter
		</a>
		<a class="col-md-4 btn btn-default btn-sm"  style="float:None; width:100px;" id="idBtnSupprimerSejour" font-weight: bold; border:1px solid black;">
			<span class="glyphicon glyphicon-remove"></span> Supprimer 
		</a>
		</div><br><div id="detailSejour">';
	
	if($exist)
	{
		getDetailSejour($id);
	}
	else
	{
		getDetailSejour(0);
	}
	
	if(!$editfix)
		echo '</div>';
}

//Jeremie
function getDetailSejour($idSejour)
{
	if($idSejour!=0)
	{
		$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
		$requete = "SELECT * from endroit_sejour where id=".$idSejour.";";
		mysqli_set_charset($connexion,'UTF8');
		$resultat = ExecRequete($requete, $connexion);
		$resultat->data_seek(0);
		$row = $resultat->fetch_assoc();
		echo '<div class="form-group">
				<label class="col-md-5 control-label" for="nomSejour" style="text-align:left;padding-top:0px;">Nom</label>
				<div class="col-md-4" style="padding-bottom:20px">
				<input type="text" name="" style=" border: 0;"  maxlength="125" readonly value="'.$row["nom"].'"/>
				</div>
				<label class="col-md-5 control-label" for="rueSejour" style="text-align:left;padding-top:0px;">Rue</label>
				<div class="col-md-4" style="padding-bottom:20px">
				<input type="text" name="" style=" border: 0;" maxlength="125" readonly value="'.$row["rue"].'"/>
				</div>
				<label class="col-md-5 control-label" for="villeSejour" style="text-align:left;padding-top:0px;">Ville</label>
				<div class="col-md-4" style="padding-bottom:20px">
				<input type="text" name="" style=" border: 0;" maxlength="125" readonly value="'.$row["ville"].'"/>
				</div>
				<label class="col-md-5 control-label" for="codePostal" style="text-align:left;padding-top:0px;">Code Postal</label>
				<div class="col-md-4" style="padding-bottom:20px">
				<input type="text" name="" style=" border: 0;" maxlength="7" readonly value="'.$row["codePostal"].'"/>
				</div>

				<label class="col-md-5 control-label" for="Telephone" style="text-align:left;padding-top:0px;">Téléphone(s)</label> 
				<div class="col-md-6" id="tel_container">';
				///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				//////////À FINIR!!!!!!!!!!!!!!!/////////////////////////////////////À FINIR!!!!!!!!!!!!!!!/////////////////////////////////////À FINIR!!!!!!!!!!!!!!!/
				// for (i=0;maximum=explode('_',$row['no_tel'].lenght);i++)
				// {
					// ('.substr($row['no_tel'],0,3).') '.substr($row['no_tel'],3,3).'-'.substr($row['no_tel'],6).';
				// }
				///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				$readonlyTest = "";
				$readonlyNom = "";
				if (isset($_SESSION['modifevenement']) && $_SESSION['modifevenement'] == "modif"){
					echo '<input type="text" name="testTelSejour" id="testTelSejour" maxlength="14" pattern="\(\d{3}\) \d{3}-\d{4}" style="height: 29px; border: '.$readonlyTest.';"  '.$readonlyNom.' value="('.substr($row['no_tel'],0,3).') '.substr($row['no_tel'],3,3).'-'.substr($row['no_tel'],6).'"/>';
					if ($readonlyNom=="") 
					{
						echo '<a class="btn btn-default btn-sm"  id="idAjouterTelSejour" style= "position: relative;  top:5px; width: 75px; float: right;"><span class="glyphicon glyphicon-plus-sign"></span> Ajouter</a>';
								
					}
					echo'</div>
						<div id="divTelSejour">	
						</div>';

				} else {
					$array2 = $pieces = explode("_", $row['no_tel']);
					
					foreach ($array2 as $v) {
						echo '<input type="text" name="" style=" border: 0;" readonly value="('.substr($v,0,3).') '.substr($v,3,3).'-'.substr($v,6).'"/>';
					}
				}
				echo'
						</div>
				<div id="divTelSejour">	
				</div>';
		}
echo '
</div>
</div>
<div>';
	}

if(isset($_POST['detailSejourUpdate']))
{
	getDetailSejour($_POST['detailSejourUpdate']);
}

if(isset($_POST['updateSejour']))
{
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	// echo "alert('test');";
	list($idSejour, $nom, $rue, $ville, $codePostal, $tel) = explode(';', $_POST['updateSejour']);
	$requete = "update endroit_sejour set `nom`='".$nom."', `rue`='".$rue."', `ville`='".$ville."', `codePostal`='".$codePostal."', `no_tel`='".$tel."' WHERE id=".$idSejour;
	mysqli_set_charset($connexion,'UTF8');
	ExecRequete($requete, $connexion);	
	//modif option text current
	
}

if(isset($_POST['deleteSejour']))
{
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	mysqli_set_charset($connexion,'UTF8');
	$requete = "update evenement set idSejour=null WHERE idSejour=".$_POST['deleteSejour'];
	ExecRequete($requete, $connexion);	
	$requete = "delete from endroit_sejour WHERE id=".$_POST['deleteSejour'];
	ExecRequete($requete, $connexion);
/////////////////////////////////////////////////////////////////////
//À RÉPARER//////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////	
	//remove current option selected
	getSejour($_POST['deleteSejour']);
	
}

//Jérémie
function getVilles(){
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$requete = "SELECT * from villes;";
	mysqli_set_charset($connexion,'UTF8');
	$resultat = ExecRequete($requete, $connexion);
$resultat->data_seek(0);
$row = $resultat->fetch_assoc();
foreach($resultat as $row){
	echo '<option value="'.$row["municipalite"].'">';
}
}

//Jérémie
function getEquipes($sport){
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	if($sport!=0)
	{
		$requete = "SELECT * from equipes where id_sport=".$sport." order by nom;";
	}
	else
	{
		$requete = "SELECT * from equipes order by nom;";
	}
	mysqli_set_charset($connexion,'UTF8');
	$resultat = ExecRequete($requete, $connexion);
$resultat->data_seek(0);
$row = $resultat->fetch_assoc();
foreach($resultat as $row){
	echo '<option value="'.$row["nom"].'">';
}
}

//Anthony
//Affiche les équipes d'un entraineur
function getEquipesEntraineur($id){
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$requete = "select nom, sexe, saison from equipes e, entraineur_equipe ee where e.id_equipe = ee.id_equipe and ee.id_entraineur =".$id.";" ;
	mysqli_set_charset($connexion,'UTF8');
	$resultat = ExecRequete($requete, $connexion);
$resultat->data_seek(0);
$row = $resultat->fetch_assoc();
echo '<div class="table-responsive">
<table class="table table-striped table-hover table-responsive" id="tableEquipeEntraineur">
    <thead>
      <tr>
        <th>Nom</th>
        <th>Sexe</th>
		<th>Saison</th>
      </tr>
    </thead>
	<tbody>';
foreach($resultat as $row){
	echo "<tr><td>".$row['nom']."</td><td>".$row['sexe']."</td><td>".$row['saison']."</td></tr>";
}
echo "</tbody></table></div>";
}

//Jérémie
function getInfoTransport($id){
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$requete = "SELECT * from transport where id = ".$id.";";
	mysqli_set_charset($connexion,'UTF8');
	$resultat = ExecRequete($requete, $connexion);
$resultat->data_seek(0);
$row = $resultat->fetch_assoc();
return $row;
}
//Jérémie
function getTransporteur($id){
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$requete = "SELECT * from transporteur;";
	mysqli_set_charset($connexion,'UTF8');
	$resultat = ExecRequete($requete, $connexion);
$resultat->data_seek(0);
$row = $resultat->fetch_assoc();
foreach($resultat as $row){
	if($id == $row["id"])
	{
		echo '<option value="'.$row["id"].'" selected>'.$row["nom"].'</option>';
	}
	else
	{
		echo '<option value="'.$row["id"].'">'.$row["nom"].'</option>';
	}
	
}
}

//Jérémie
function getEndroitEvent(){
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$requete = "SELECT distinct endroit from evenement;";
	mysqli_set_charset($connexion,'UTF8');
	$resultat = ExecRequete($requete, $connexion);
	$resultat->data_seek(0);
	$row = $resultat->fetch_assoc();
	foreach($resultat as $row){
		echo '<option value="'.$row["endroit"].'">';
	}
}
//Jérémie
function getSport($id){
		$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
		$requete = "SELECT * from sports order by sport;";
		mysqli_set_charset($connexion,'UTF8');
		$resultat = ExecRequete($requete, $connexion);
		$resultat->data_seek(0);
		$row = $resultat->fetch_assoc();
foreach($resultat as $row){
	if($id == $row["id_sport"])
	{
		echo '<option value="'.$row["id_sport"].'" selected>'.$row["sport"].'</option>';
	}
	else
	{
		echo '<option value="'.$row["id_sport"].'">'.$row["sport"].'</option>';
	}
}
}
//Jérémie
if(isset($_POST['sportChange']))
{
	$sp = $_POST['sportChange'];
	getEquipes($sp);
}

//Retourne la liste des sports
//Gabriel Richer
function getSports(){
$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
$requete = "select * from sports;";
mysqli_set_charset($connexion,'UTF8');
$resultat = ExecRequete($requete, $connexion);
$resultat->data_seek(0);
$row = $resultat->fetch_assoc();
echo '<div class="table-responsive">
<table class="table table-striped table-hover" id="tableSports">
    <thead>
      <tr>
		<th class="hidden">IdSport</td>
		 <th>Nom</th>
		
      </tr>
    </thead>
	<tbody id="tbl-sports">';
foreach($resultat as $row){
echo '<tr> <td class="hidden">'.$row['id_sport'].'</td><td id="idSport">'.$row['sport'].'</td> </tr>';
}
echo '</tbody></table></div>
<div class="col-md-12 text-center">
      <ul class="pagination pagination-lg pager" id="myPager"></ul>
      </div>';

}
//Inscrit un sport
//Gabriel Richer

function inscrireSport($id, $nom,$roles){
$caught = false;
$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
mysqli_set_charset($connexion,'UTF8');
$requeteValidation = "select * from sports where sport = '".$nom."';";
$resultat = ExecRequete($requeteValidation, $connexion);
$count = mysqli_num_rows($resultat);
// $rowCount=$count->fetch_assoc();
if ($count > 0 ){
	$_SESSION['ajoutSport'] = "error";
}
else
{
	$_SESSION['ajoutSport'] = 'ajout';
	$requete = "insert into sports values(null,'".($nom)."','".$roles."');";
	try{
ExecRequete($requete, $connexion);}
catch (Exception $e){
$caught = true;
echo '<div class="alert alert-danger">
  <strong>Erreur!</strong> Erreur lors de l\'ajout d\'un sport.
</div>';
}
finally{
	
if (!$caught){

	echo '<div class="alert alert-success">
  <strong>Succèss!</strong> Le sport a été ajouté!</strong>
</div>';
$last_id = mysqli_insert_id($connexion);
	}
}
}



}
//Retourne les informations d'un sport
//Gabriel Richer
function getSport2($id){
$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
mysqli_set_charset($connexion,'UTF8');
	$requete = "SELECT * FROM sports where id_sport = '".$id."';";
	$requete2= "SELECT * FROM role; ";
	$resultat = ExecRequete($requete, $connexion);
	$resultat->data_seek(0);
	$row = $resultat->fetch_assoc();
	$resultat2 = ExecRequete($requete2, $connexion);
	$resultat2->data_seek(0);
	$row2 = $resultat2->fetch_assoc();
	
if ($id===null){
	
	echo '
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="nom">Nom *</label>  
  <div class="col-md-4">
  <input id="nom" name="nom" pattern="[a-zA-Z\è\é\ë\ç\ê\-\ ]{1,50}" title="1-30 lettres" type="text" placeholder="Nom" class="form-control input-md" required="">
    
  </div>
</div>

<div class="form-group">
<label class="col-md-4 control-label" for="nom">Rôles(s)</label>  
 <div class="col-md-4">
<select name="e1[]" id="e1" multiple=multiple class="col-md-12" >';

foreach($resultat2 as $row2)
{
	
	 echo'
	  <option value="'.$row2["nom"].'">'.$row2["nom"].'</option>';
	
	
}
		
		
    

echo '  
    </select>
	
	
</div>
</div>


</fieldset>
</form>';
	
	
	}	


else{

/*	
	$str =$row["roles"];
    $arr=explode(";",$str);
	

echo '
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="nom">Nom *</label>  
  <div class="col-md-4">
  <input id="nom" name="nom" pattern="[a-zA-Z\è\é\ë\ç\ê\-\ ]{1,50}" title="1-30 lettres" type="text" placeholder="Nom" class="form-control input-md" required="" value="'.$row["sport"].'">
    
  </div>
</div>
<div class="form-group">
<label class="col-md-4 control-label" for="nom">Rôle(s) *</label>
 <div class="col-md-4">
<select name="e1[]" id="e1" multiple=multiple class="col-md-12" >';

foreach($resultat2 as $row2)
{
	$bool=false;
	foreach ($arr as &$value) {
   if ($value==$row2["nom"]){
	   $bool=true;
   }
}
	if ($bool==true){
  echo'
        <option value="'.$row2['nom'].'" selected>'.$row2["nom"].'</option>';
	}

else{
	 echo'
	  <option value="'.$row2['nom'].'">'.$row2["nom"].'</option>';
	
	
}
		
		
    
}
echo '  
    </select>
	
	</div>
	
</div>



</fieldset>
</form>';

}*/
$str =$row["roles"];
    $arr=explode(";",$str);
	

echo '
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="nom">Nom *</label>  
  <div class="col-md-4">
  <input id="nom" name="nom" pattern="[a-zA-Z\è\é\ë\ç\ê\-\ ]{1,50}" title="1-30 lettres" type="text" placeholder="Nom" class="form-control input-md" required="" value="'.$row["sport"].'">
    
  </div>
</div>
<div class="form-group">
<label class="col-md-4 control-label" for="nom">Rôle(s) *</label>
 <div class="col-md-4">
<select name="e1[]" id="e1" multiple=multiple class="col-md-12" >';

foreach($resultat2 as $row2)
{
	$bool=false;
	foreach ($arr as &$value) {
   if ($value==$row2["nom"]){
	  echo'
        <span><option value="'.$row2['nom'].'" selected>'.$row2["nom"].'</option>
		';
   }
}
	
  
	


	 echo'
	  <option value="'.$row2['nom'].'">'.$row2["nom"].'</option>';
	
	

		
		
    
}
echo '  
    </select>
	
	</div>
	
</div>



</fieldset>
</form>';

}
}

//Enregistre les informations d'un sport
//Gabriel Richer
function updateSport($id, $nom,$roles){
$caught = false;
$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
mysqli_set_charset($connexion,'UTF8');
$requete = "update sports set sport = '".addslashes($nom)."', roles = '".$roles."' where id_sport ='".$id."' ;";
$caught=false;


if (trim($nom,' ')==''){
	
	$caught=true;
	echo '<div class="alert alert-danger">
  <strong>Erreur!</strong> Le champ nom est vide.
</div>';
}

if (!$caught){
ExecRequete($requete, $connexion);
$_SESSION['succesModification'] = 'succes';
echo '<script>window.location.replace("gestionSport.php");</script>'	;
	
}

}
//Supprime un sport
//Gabriel Richer
function supprimerSport($id){
$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);

$requete = "delete from sports where id_sport = ".$id;

mysqli_set_charset($connexion,'UTF8');
ExecRequete($requete, $connexion);
$caught = false;


if (!$caught){
	echo '<div class="alert alert-success">
  <strong>Succès!</strong> Le sport a été supprimer.
 </div>';
$_SESSION['supprimerSport'] = "supprimer";
 echo "<script>location.replace('gestionSport.php');</script>";

}
}


//Jérémie
if(isset($_POST['btnSaveEvent']))
{
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$mod      = $_POST['mod'];
	$ID        = $_POST['ID'];
	if (isset($_POST['sport'])){
		$sport     = $_POST['sport'];
	}
	else{
		$sport     = $_POST['sport_id_save'];
	}
	$equipeLocale = $_POST['equipeLocale'];
	$equipeVisiteur = $_POST['equipeVisiteur'];
	$typeEvent = $_POST['typeEvent'];
	$heureEvent = $_POST['heureEvent'];
	$dateEvent = $_POST['dateEvent'];
	$endroit = $_POST['endroitEvent'];
	$lieuSejour = $_POST['lieuSejour'];
	$villeEvent = $_POST['villeEvent'];
	$rueEvent = $_POST['rueEvent'];
	$codePostal = $_POST['codePostal'];
	$statusTransport = $_POST['statusTransport'];
	$statusSejour = $_POST['statusSejour'];
	$noteSejour = $_POST['noteS'];
	$status = $_POST['status'];
	$description = $_POST['description'];
	if (isset($_POST['resps'])){
		$resps = $_POST['resps'];
	}
	if (isset($_POST['resps'])){
		$resps = $_POST['resps'];
	}
	if (isset($_POST['modif'])){
		$modif = $_POST['modif'];
	}
	else{
		$modif = 1;
	}
	
	
	$skip_dateTransport = empty($_POST["dateTransport"]) || strlen(preg_replace('/\s+/', '', $_POST["dateTransport"])) == 0;
	$skip_TransportR = empty($_POST["dateTransportR"]) || strlen(preg_replace('/\s+/', '', $_POST["dateTransportR"])) == 0;

	
	$transporteur = $_POST['transporteur'];
	$heureDepart  = $_POST['heureDepart'];
	$heureRetour  = $_POST['heureRetour'];
	$dateTransport   = $skip_dateTransport ? "null" : "'".$_POST['dateTransport']."'" ;
	$dateTransportR = $skip_TransportR ?  "null" : "'".$_POST['dateTransportR']."'" ;
	$demandeAchat = $_POST['demandeAchat'];
	$typeTransport = $_POST['typeTransport'];
	$note = $_POST['note'];
	

	if($mod == false)
	{
		if (is_null($transporteur)){
			$requete = "
			insert into transport(
				`heureDepart`,
				`heureRetour`,
				`demandeAchat`,
				`date`,
				`dateRetour`,
				`note`,
				`typeTransport`)
			values(".
				$heureDepart."', '".
				$heureRetour."', '".
				addslashes($demandeAchat)."' , ".
				$dateTransport.", ".
				$dateTransportR.", '".
				addslashes($note)."', '".
				addslashes($typeTransport).
			"')";
		} else {

			$requete = "
			insert into transport(
				`idTransporteur`,
				`heureDepart`,
				`heureRetour`,
				`demandeAchat`,
				`date`,
				`dateRetour`,
				`note`,
				`typeTransport`)
			values(".
				$transporteur.",'".
				$heureDepart."', '".
				$heureRetour."', '".
				addslashes($demandeAchat)."' , ".
				$dateTransport.", ".
				$dateTransportR.", '".
				addslashes($note)."', '".
				addslashes($typeTransport).
			"')";
		}
		
		mysqli_set_charset($connexion,'UTF8');
		ExecRequete($requete, $connexion);	
		$IDTransport = $connexion->insert_id;
		
		$requete = "
		insert into evenement(
			`idTransport`,
			`statusTransport`, 
			`idSejour`, 
			`statusSejour`, 
			`noteSejour`, 
			`idSport`, 
			`equipeReceveur`, 
			`equipeVisiteur`, 
			`type`, 
			`heure`, 
			`date`, 
			`endroit`, 
			`ville`, 
			`rue`, 
			`codePostal`, 
			`status`, 
			`description`
		) values (".
		    $IDTransport.", ".
			$statusTransport.", ".
			$lieuSejour.", ".
			$statusSejour.", '".
			addslashes($noteSejour)."', ".
			$sport.", '".
			addslashes($equipeLocale)."', '".
			addslashes($equipeVisiteur)."', '".
			addslashes($typeEvent)."', '".
			$heureEvent."', '".
			$dateEvent."', '".
			addslashes($endroit)."', '".
			addslashes($villeEvent)."', '".
			addslashes($rueEvent)."', '".
			addslashes($codePostal)."', '".
			$status."', '".
			addslashes($description).
		"')";
		
		$_SESSION['ajoutEvent'] = 1;
		mysqli_set_charset($connexion,'UTF8');
		ExecRequete($requete, $connexion);	
		$IDEVENT = $connexion->insert_id;
		if(isset($resps)){
		foreach ( $resps as $index => $i )
		{
			if($modif[$index] == 0)
			{
				$requete = "INSERT INTO `responsable_plateau`(`id_personne`, `idEvenement`, `role`) VALUES (".$i.", '".$IDEVENT."','".$resps[$index]."')";
				
				mysqli_set_charset($connexion,'UTF8');
				ExecRequete($requete, $connexion);
			}
		}
		}
	}
	else
	{
		$IDTransport = $_POST['IDTransport'];
		$requete = "
		update transport 
		set `idTransporteur`=".$transporteur.", 
			`heureDepart`='".$heureDepart."',
			`heureRetour`='".$heureRetour."',
			`demandeAchat`='".addslashes($demandeAchat)."',
			`date`=".$dateTransport.", 
			`dateRetour`=".$dateTransportR.",
			`note`='".addslashes($note)."',
			`typeTransport`='".addslashes($typeTransport)."' 
		WHERE ID=".$IDTransport;
		mysqli_set_charset($connexion,'UTF8');
		ExecRequete($requete, $connexion);	
		
		$requete = "
		update evenement 
		set idTransport=".$IDTransport.", 
			`statusTransport`=".$statusTransport.", 
			idSejour=".$lieuSejour.", 
			`statusSejour`=".$statusSejour.", 
			`noteSejour`='".addslashes($noteSejour)."', 
			idSport=".$sport.", 
			equipeReceveur='".addslashes($equipeLocale)."', 
			equipeVisiteur='".addslashes($equipeVisiteur)."',  
			type='".addslashes($typeEvent)."', 
			heure='".$heureEvent."', 
			date='".$dateEvent."', 
			endroit='".addslashes($endroit)."', 
			ville='".addslashes($villeEvent)."',
			rue='".addslashes($rueEvent)."', 
			codePostal='".addslashes($codePostal)."', 
			status='".$status."', 
			description='".addslashes($description)."' 
		where id=".$ID;
		$_SESSION['modifEvent'] = 1;
		mysqli_set_charset($connexion,'UTF8');
		ExecRequete($requete, $connexion);	
		foreach ( $tabPers as $index => $i )
		{
			if($modif[$index] == 0)
			{
				$requete = "INSERT INTO `responsable_plateau`(`id_personne`, `idEvenement`, `role`) VALUES (".$i.", '".$ID."','".$tabRoles[$index]."')";
				
				mysqli_set_charset($connexion,'UTF8');
				ExecRequete($requete, $connexion);
			}
			if($modif[$index] == 2)
			{
				if ($i){
				$requete = "INSERT INTO `responsable_plateau`(`id_personne`, `idEvenement`, `role`) VALUES (".$i.", '".$ID."','".$tabRoles[$index]."')";
				mysqli_set_charset($connexion,'UTF8');
				ExecRequete($requete, $connexion);
			}
			}
		}
		
		
	}
	
	echo '<script>window.location.replace("gestionEvenements.php");</script>'	;
}

//Retourne la liste des entraineurs
//Anthony
function getEntraineurs(){
$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
$requete = "select * from personnes p, entraineurs e where e.id_personne = p.id_personne;";
mysqli_set_charset($connexion,'UTF8');
$resultat = ExecRequete($requete, $connexion);
$resultat->data_seek(0);
$row = $resultat->fetch_assoc();
echo '<div class="table-responsive">
<table class="table table-striped table-hover" id="tableEntraineurs">
    <thead>
      <tr>
		<th class="hidden">Id</td>
		<th class="hidden">idEntraineur</td>
        <th>Nom</th>
		<th>Type</th>
        <th>Téléphone</th>
		<th>Poste</th>
        <th>Courriel</th>
		<th>No. Embauche</th>
      </tr>
    </thead>
	<tbody id="tbl-entraineur">';
foreach($resultat as $row){
echo '<tr> <td class="hidden">'.$row['id_personne'].'</td><td class="hidden" id="idEntraineur">'.$row['id_entraineur'].'</td> <td>'.$row['nom'].', '.$row['prenom'].'</td> <td>'.$row['type'].'</td> <td>('.substr($row['no_tel'],0,3).') '.substr($row['no_tel'],3,3).'-'.substr($row['no_tel'],6).'</td> <td>'.$row['posteTelephonique'].'</td><td>'.$row['courriel'].'</td> <td>'.$row['no_embauche'].'</td></tr>';
}
echo '</tbody></table></div>
<div class="col-md-12 text-center">
      <ul class="pagination pagination-lg pager" id="myPager"></ul>
      </div>';

}

//Inscrit un entraineur
//Anthony
function inscrireEntraineur($nom, $prenom, $sexe, $tel, $courriel, $note, $poste, $type, $noEmbauche){
$caught = false;
$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
mysqli_set_charset($connexion,'UTF8');
$requete = "insert into personnes values(null,'".addslashes($nom)."','".addslashes($prenom)."','".$sexe."',null,'".addslashes($tel)."', '".addslashes($poste)."','".addslashes($courriel)."',null,null,null,null);";
try{
ExecRequete($requete, $connexion);}
catch (Exception $e){
$caught = true;
echo '<script>toastr.error(\"Erreur lors de l\'ajout d\'un entraineur\");</script>';
}
finally{
if (!$caught){
	echo '<script>toastr.error(\"Erreur lors de l\'ajout d\'un entraineur\");</script>';
$last_id = mysqli_insert_id($connexion);
$requeteb = "insert into entraineurs values(null,".$last_id.", '".addslashes($noEmbauche)."','".addslashes($note)."','".$type."',null);";

ExecRequete($requeteb, $connexion);}
	}
}

//Retourne les informations d'un entraineur
//Anthony
function getEntraineur($id){
$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
mysqli_set_charset($connexion,'UTF8');
	$requete = "SELECT * FROM personnes p, entraineurs e where p.id_personne = '".$id."' and p.id_personne=e.id_personne;";
	
	$resultat = ExecRequete($requete, $connexion);
	$resultat->data_seek(0);
	$row = $resultat->fetch_assoc();
	echo '

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="nom">Nom *</label>  
  <div class="col-md-4">
  <input id="nom" name="nom" pattern="[a-zA-Z\è\é\ë\ç\ê\-\ ]{1,50}" title="1-30 lettres" type="text" placeholder="Nom" class="form-control input-md" required="" value="'.$row["nom"].'">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="prenom">Prénom *</label>  
  <div class="col-md-4">
  <input id="prenom" name="prenom"  pattern="[a-zA-Z\è\é\ë\ç\ê\-\ ]{1,50}" title="1-30 lettres" type="text" placeholder="Prénom" class="form-control input-md" required="" value = "'.$row["prenom"].'">
    
  </div>
</div>

<!-- Select-->
<div class="form-group">
  <label class="col-md-4 control-label" for="type">Type</label>  
  <div class="col-md-4">
  <select id="type" name="type" class="form-control input-md" required="required">
  <option value="Entraîneur-chef" '; if ($row["type"] == "Entraîneur-chef") echo "selected=selected"; echo '>Entraîneur-chef</option>
  <option value="Assistant" '; if ($row["type"] == "Assistant") echo "selected=selected"; echo '>Assistant</option>
  <option value="Apprenti" '; if ($row["type"] == "Apprenti") echo "selected=selected"; echo '>Apprenti</option>
  <option value="Médical" '; if ($row["type"] == "Médical") echo "selected=selected"; echo ''; if ($row["type"] == "Apprenti") echo "selected=selected"; echo '>Médical</option>
  <option value="Soutien" '; if ($row["type"] == "Soutien") echo "selected=selected"; echo '>Soutien</option>
  </select>
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="radioSexe">Sexe *</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="radioSexe-0">
      <input type="radio" name="radioSexe" id="radioSexe-0" value="M" required="required"'; if ($row["sexe"] == "M"){echo'checked="checked"';} echo'>
      Homme
    </label> 
    <label class="radio-inline" for="radioSexe-1">
      <input type="radio" name="radioSexe" id="radioSexe-1" value="F" required="required"' ; if ($row["sexe"] == "F"){echo'checked="checked"';} echo'>
      Femme
    </label>
  </div>
</div>
  
  <!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="ville">Téléphone</label>  
  <div class="col-md-4">
  <input id="telephone" name="telephone" pattern="\d{10}" title="Neuf chiffres sans caractères spéciaux" type="text" placeholder="#Téléphone    Ex. 8193761721" class="form-control input-md" maxlength="10" value ="'.$row["no_tel"].'">
    
  </div>
</div>

  <!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="poste">Poste</label>  
  <div class="col-md-4">
  <input id="poste" name="poste" style="width:75px"  pattern="\d{0,6}" title="Six chiffres maximum" type="text" placeholder="#Poste" class="form-control input-md" maxlength="6" value ="'.$row["posteTelephonique"].'">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="courriel">Courriel</label>  
  <div class="col-md-4">
  <input id="courriel" name="courriel" pattern=".+@.+[.].+" title="Adresse de messagerie valide ex.: ex@example.com" type="text" placeholder="Adresse de messagerie" class="form-control input-md"  value = "'.$row["courriel"].'">
    
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="noEmbauche">No. embauche</label>  
  <div class="col-md-4">
  <input id="noEmbauche" name="noEmbauche"  type="text" placeholder="No. Embauche" class="form-control input-md" style="width:75px" value = "'.$row["no_embauche"].'" maxlength="10">
    
  </div>
</div>
<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="note">Note</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="note" name="note" maxlength="255">'.$row["note"].'</textarea>
  </div>
</div>

</fieldset>
</form>';
}

function updateEntraineur($id, $nom, $prenom, $sexe,  $tel, $courriel, $note, $type, $poste, $noEmbauche){
$caught = false;
$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
mysqli_set_charset($connexion,'UTF8');
$requete = "update personnes set nom = '".addslashes($nom)."', prenom = '".addslashes($prenom)."',sexe = '".$sexe."',no_tel = '".addslashes($tel)."',courriel='".addslashes($courriel)."', posteTelephonique = '".addslashes($poste)."' where id_personne ='".$id."' ;";
$requeteB = "update entraineurs set no_embauche='".addslashes($noEmbauche)."', note = '".addslashes($note)."', type = '".$type."' where id_personne = ".$id.";";

try{
ExecRequete($requete, $connexion);}
catch (Exception $e){
$caught = true;
echo '<div class="alert alert-danger">
  <strong>Erreur!</strong> Les modifications ont échouées.
</div>';
}
finally{
if (!$caught){
ExecRequete($requeteB, $connexion);
$_SESSION['succesModification'] = 'succes';
echo '<script>window.location.replace("gestionEntraineur.php");</script>'	;
	}
}

}

function supprimerEntraineur($id){
$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);

$requete = "delete from entraineurs where id_personne = ".$id;
$requeteB = "delete from personnes where id_personne = ".$id;
mysqli_set_charset($connexion,'UTF8');
ExecRequete($requete, $connexion);
ExecRequete($requeteB, $connexion);
}



if (isset($_POST['updateMembre'])){
updateMembre($_POST['userID'], $_POST['nomUtilisateur'], $_POST['estActif'], $_POST['estAdmin']);
}

 if (isset($_POST['motPasseUpdate'])){
updatePassword($_POST['userID'],$_POST['motPasseUpdate']);
 }
 
 if (isset($_POST['btnSupprimerMembre'])){
 deleteMembre($_POST['userID']);
 }
 
//Jérémie
if(isset($_POST['ajoutSejour'])){
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$nom = $_POST['ajoutSejour'];
	$rue = $_POST['rue'];
	$ville = $_POST['ville'];
	$codePostal = $_POST['codePostal'];
	$noTel = str_replace(array('(', ')', '-', ' '), '', $_POST['noTel']);
	
	$requete = "
	INSERT INTO `endroit_sejour`(
		`nom`, 
		`rue`, 
		`ville`, 
		`codePostal`, 
		`no_tel`) 
	VALUES (
		'".addslashes($nom)."','".
		addslashes($rue)."', '".
		addslashes($ville)."', '".
		addslashes($codePostal)."', '".
		addslashes($noTel).
	"')";
	mysqli_set_charset($connexion,'UTF8');
	ExecRequete($requete, $connexion);	
	$idSejour = $connexion->insert_id;
	getSejour($idSejour);
}

//Anthony
function evenementCalendrier($mois){
$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);

$requete = "select * from evenement where extract(month from date) = ".$mois.";";
mysqli_set_charset($connexion,'UTF8');
$resultat = ExecRequete($requete, $connexion);
$resultat->data_seek(0);
	return $resultat;
}

//Jérémie
function getListeEquipes()
{
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
$requete = "select equipes.id_equipe as id, equipes.nom as nom, equipes.sexe as sexe, equipes.saison as saison, sports.sport as sport from equipes, sports where equipes.id_sport = sports.id_sport order by equipes.nom;";
mysqli_set_charset($connexion,'UTF8');
$resultat = ExecRequete($requete, $connexion);
$resultat->data_seek(0);
$row = $resultat->fetch_assoc();
echo '<div class="table-responsive">
<table class="table table-striped table-hover" id="tableEquipe">
    <thead>
      <tr>
		<th class="hidden">Id</td>
		<th>Sport</th>
        <th>Nom</th>
        <th class="hidden">Sexe</th>
		<th>Saison</th>
      </tr>
    </thead>
	<tbody id="tbl-equipes">';
foreach($resultat as $row){
echo '<tr> 
		<td class="hidden">'.$row['id'].'</td> 
		<td>'.$row['sport'].'</td> 
		<td>'.$row['nom'].'</td>
		<td class="hidden">'.$row['sexe'].'</td> 
		<td>'.$row['saison'].'</td>
		<td><span class="glyphicon glyphicon-cog"></span></td>
	</tr>';
}
echo '</tbody></table></div><div class="col-md-12 text-center">
      <ul class="pagination pagination-lg pager" id="myPager"></ul>
      </div>';
}
//Jérémie
function getInfoEquipe($idEquipe)
{
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$requete = "SELECT * FROM equipes where id_equipe = '".$idEquipe."';";
	mysqli_set_charset($connexion,'UTF8');
	$resultat = ExecRequete($requete, $connexion);
	$resultat->data_seek(0);
	$row = $resultat->fetch_assoc();
	return $row;
}
//Jérémie
if(isset($_POST['btnSaveEquipe']))
{
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$mod      = $_POST['mod'];
	$ID        = $_POST['ID'];
	$sport     = $_POST['sport'];
	$nom = $_POST['nomEquipe'];
	$sexe = $_POST['sexeEquipe'];
	$saison = $_POST['saisonEquipe'];
	
	if($mod == false)
	{
		$requeteValidation = "select * from equipes where nom = '".addslashes($nom). "' and sexe = '".addslashes($sexe)."' and saison = '".addslashes($saison)."'";
		$resultat = ExecRequete($requeteValidation, $connexion);
		$count = mysqli_num_rows($resultat);
		if ($count > 0){
			$_SESSION['ajoutEquipe']= 'error';
		} else {
			$_SESSION['ajoutEquipe'] = 1;
			$requete = "insert into equipes(`nom`, `sexe`, `saison`, `id_sport`) values('".addslashes($nom)."', '".addslashes($sexe)."', '".addslashes($saison)."', ".$sport.")";
			ExecRequete($requete, $connexion);
		}
	}
	else
	{
		$requete = "update equipes set nom='".addslashes($nom)."', sexe='".addslashes($sexe)."', saison='".addslashes($saison)."', id_sport=".$sport." where id_equipe=".$ID;
		$_SESSION['modifEquipe'] = 1;
		ExecRequete($requete, $connexion);
	}
	mysqli_set_charset($connexion,'UTF8');
		
	echo '<script>window.location.replace("gestionEquipes.php");</script>'	;
}
if(isset($_POST['btnSupprimerEquipe']))
{
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$ID        = $_POST['ID'];
	
	$requete = "delete from equipes where id_equipe = ".$ID;
	ExecRequete($requete, $connexion);	
	$_SESSION['suppEquipe'] = 1;
	echo '<script>window.location.replace("gestionEquipes.php");</script>'	;
}
//Jérémie
function afficherInfoEvenement($ID){
echo'<div class="modal-dialog" style="height: auto;">
    <div class="modal-content"  >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="color:black;">Détail de l\'évenement</h4>
      </div>
      <div class="modal-body2" style="
    padding-top: 20px">
	<div>';
	if (getEvenement($ID)["status"] == 1)
	{echo '
<a href="" class="af-link" onclick="$(\'#infoGenerales\').toggle(500);$(\'#infGen\').toggleClass(\'glyphicon glyphicon-chevron-down\').toggleClass(\'glyphicon glyphicon-chevron-up\');return false;" style="padding-left:20%">Informations générales <span style="color:#00cc00; font-size:1.5em" title="Confirmé">&#10004;</span><span id="infGen" class="glyphicon glyphicon-chevron-up" ></span></a>
	';}
	elseif (getEvenement($ID)["status"] == 2)
	{echo '
<a href="" class="af-link" onclick="$(\'#infoGenerales\').toggle(500);$(\'#infGen\').toggleClass(\'glyphicon glyphicon-chevron-down\').toggleClass(\'glyphicon glyphicon-chevron-up\');return false;" style="padding-left:20%">Informations générales <span style="color:#ffcc00; font-size:1.5em" title="À confirmer">&#10067;</span><span id="infGen" class="glyphicon glyphicon-chevron-up" ></span></a>
	';}
	elseif (getEvenement($ID)["status"] == 3)
	{echo '
<a href="" class="af-link" onclick="$(\'#infoGenerales\').toggle(500);$(\'#infGen\').toggleClass(\'glyphicon glyphicon-chevron-down\').toggleClass(\'glyphicon glyphicon-chevron-up\');return false;" style="padding-left:20%">Informations générales <span style="color:#ff0000; font-size:1.5em" title="Annulé">&#10006;</span><span id="infGen" class="glyphicon glyphicon-chevron-up" ></span></a>
	';}
	else
		{echo '
<a href="" class="af-link" onclick="$(\'#infoGenerales\').toggle(500);$(\'#infGen\').toggleClass(\'glyphicon glyphicon-chevron-down\').toggleClass(\'glyphicon glyphicon-chevron-up\');return false;" style="padding-left:20%">Informations générales <span id="infGen" class="glyphicon glyphicon-chevron-up" ></span></a>
	';}
echo '
<hr>
<div id="infoGenerales">
<div class="form-group">
  <label class="col-md-5 control-label" for="equipeLocale">Équipe receveur</label>
  <div class="col-md-4" style="padding-bottom:20px">
  <input type="text" name="" style=" border: 0;" readonly value="'.getEvenement($ID)["equipeReceveur"].'"/>
  </div>
  <label class="col-md-5 control-label" for="equipeVisiteur">Équipe visiteur</label>
  <div class="col-md-4" style="padding-bottom:20px">
  <input type="text" name="" style=" border: 0;" readonly value="'.getEvenement($ID)["equipeVisiteur"].'"/>
  </div>
  <label class="col-md-5 control-label" for="typeEvent">Type</label>
  <div class="col-md-4" style="padding-bottom:20px">
  <input type="text" name="" style=" border: 0;" readonly value="'.getEvenement($ID)["type"].'"/>
  </div>
  <label class="col-md-5 control-label" for="dateEvent">Date</label>
  <div class="col-md-4" style="padding-bottom:20px">
  <input type="text" name="" style=" border: 0;" readonly value="'.getEvenement($ID)["date"].'"/>
  </div>
  <label class="col-md-5 control-label" for="heureEvent">Heure</label>
  <div class="col-md-4" style="padding-bottom:20px">
  <input type="text" name="" style=" border: 0;" readonly value="'.substr (getEvenement($ID)["heure"], 0, 5).'"/>
  </div>
</div>
</div>
</div>
<div>
<a href="" class="af-link" style="padding-left:20%" onclick="$(\'#infoLieu\').toggle(500);$(\'#infoTransport\').hide(500);$(\'#infoSejour\').hide(500);$(\'#infLieu\').toggleClass(\'glyphicon glyphicon-chevron-down\').toggleClass(\'glyphicon glyphicon-chevron-up\');$(\'#infSejour\').removeClass(\'glyphicon glyphicon-chevron-up\');$(\'#infSejour\').addClass(\'glyphicon glyphicon-chevron-down\');$(\'#infTrans\').removeClass(\'glyphicon glyphicon-chevron-up\');$(\'#infTrans\').addClass(\'glyphicon glyphicon-chevron-down\');return false;">Informations Lieu <span id="infLieu" class="glyphicon glyphicon-chevron-down" ></span></a>
<hr>
<div class="form-group" id="infoLieu" hidden>
<div class="form-group">
  <label class="col-md-5 control-label" for="endroit">Endroit</label>
  <div class="col-md-4" style="padding-bottom:20px">
  <input type="text" name="" style=" border: 0;" readonly value="'.getEvenement($ID)["endroit"].'"/>
  </div>
  <label class="col-md-5 control-label" for="rue">Rue</label>
  <div class="col-md-4" style="padding-bottom:20px">
  <input type="text" name="" style=" border: 0;" readonly value="'.getEvenement($ID)["rue"].'"/>
  </div>
  <label class="col-md-5 control-label" for="ville">Ville</label>
  <div class="col-md-4" style="padding-bottom:20px">
  <input type="text" name="" style=" border: 0;" readonly value="'.getEvenement($ID)["ville"].'"/>
  </div>
  <label class="col-md-5 control-label" for="codePostal">Code Postal</label>
  <div class="col-md-4" style="padding-bottom:20px">
  <input type="text" name="" style=" border: 0;" readonly value="'.getEvenement($ID)["codePostal"].'"/>
  </div>
</div>
</div>
</div>';
echo '<div>';
if (getEvenement($ID)["statusTransport"] == 1)
{
echo '
<a href="" class="af-link" style="padding-left:20%" onclick="$(\'#infoTransport\').toggle(500);$(\'#infoLieu\').hide(500);$(\'#infoSejour\').hide(500);$(\'#infTrans\').toggleClass(\'glyphicon glyphicon-chevron-down\').toggleClass(\'glyphicon glyphicon-chevron-up\');$(\'#infLieu\').removeClass(\'glyphicon glyphicon-chevron-up\');$(\'#infLieu\').addClass(\'glyphicon glyphicon-chevron-down\');$(\'#infSejour\').removeClass(\'glyphicon glyphicon-chevron-up\');$(\'#infSejour\').addClass(\'glyphicon glyphicon-chevron-down\');return false;">Informations Transport <span style="color:#00cc00; font-size:1.5em" title="Confirmé">&#10004;</span><span id="infTrans" class="glyphicon glyphicon-chevron-down" ></span></a>
';}
else if (getEvenement($ID)["statusTransport"] == 2)
{
echo '
<a href="" class="af-link" style="padding-left:20%" onclick="$(\'#infoTransport\').toggle(500);$(\'#infoLieu\').hide(500);$(\'#infoSejour\').hide(500);$(\'#infTrans\').toggleClass(\'glyphicon glyphicon-chevron-down\').toggleClass(\'glyphicon glyphicon-chevron-up\');$(\'#infLieu\').removeClass(\'glyphicon glyphicon-chevron-up\');$(\'#infLieu\').addClass(\'glyphicon glyphicon-chevron-down\');$(\'#infSejour\').removeClass(\'glyphicon glyphicon-chevron-up\');$(\'#infSejour\').addClass(\'glyphicon glyphicon-chevron-down\');return false;">Informations Transport <span style="color:#ffcc00; font-size:1.5em" title="À confirmer">&#10067;</span><span id="infTrans" class="glyphicon glyphicon-chevron-down" ></span></a>
';}
else if (getEvenement($ID)["statusTransport"] == 3)
{
echo '
<a href="" class="af-link" style="padding-left:20%" onclick="$(\'#infoTransport\').toggle(500);$(\'#infoLieu\').hide(500);$(\'#infoSejour\').hide(500);$(\'#infTrans\').toggleClass(\'glyphicon glyphicon-chevron-down\').toggleClass(\'glyphicon glyphicon-chevron-up\');$(\'#infLieu\').removeClass(\'glyphicon glyphicon-chevron-up\');$(\'#infLieu\').addClass(\'glyphicon glyphicon-chevron-down\');$(\'#infSejour\').removeClass(\'glyphicon glyphicon-chevron-up\');$(\'#infSejour\').addClass(\'glyphicon glyphicon-chevron-down\');return false;">Informations Transport <span style="color:#ff0000; font-size:1.5em" title="Annulé">&#10006;</span><span id="infTrans" class="glyphicon glyphicon-chevron-down" ></span></a>
';}
else 
{
echo '
<a href="" class="af-link" style="padding-left:20%" onclick="$(\'#infoTransport\').toggle(500);$(\'#infoLieu\').hide(500);$(\'#infoSejour\').hide(500);$(\'#infTrans\').toggleClass(\'glyphicon glyphicon-chevron-down\').toggleClass(\'glyphicon glyphicon-chevron-up\');$(\'#infLieu\').removeClass(\'glyphicon glyphicon-chevron-up\');$(\'#infLieu\').addClass(\'glyphicon glyphicon-chevron-down\');$(\'#infSejour\').removeClass(\'glyphicon glyphicon-chevron-up\');$(\'#infSejour\').addClass(\'glyphicon glyphicon-chevron-down\');return false;">Informations Transport <span id="infTrans" class="glyphicon glyphicon-chevron-down" ></span></a>
';}
echo ' 
<hr>
<div class="form-group" id="infoTransport" hidden>
	<div class="form-group">
		<label class="col-md-5 control-label" for="transporteur">Transporteur</label>
		<div class="col-md-4" style="padding-bottom:20px">
			<input type="text" name="" style=" border: 0;" readonly value="'.getInfoTransport(getEvenement($ID)["idTransport"])["nom"].'"/>
		</div>
		
		<label class="col-md-5 control-label" for="heureDepart">Heure départ</label>
		<div class="col-md-4" style="padding-bottom:20px">
			<input type="text" name="" style=" border: 0;" readonly value="'.substr (getInfoTransport(getEvenement($ID)["idTransport"])["heureDepart"],0,5).'"/>
		</div>
		
		<label class="col-md-5 control-label" for="heureRetour">Heure retour</label>
		<div class="col-md-4" style="padding-bottom:20px">
			<input type="text" name="" style=" border: 0;" readonly value="'.substr (getInfoTransport(getEvenement($ID)["idTransport"])["heureRetour"],0,5).'"/>
		</div>
		
		<label class="col-md-5 control-label" for="dateDepart">Date départ</label>
		<div class="col-md-4" style="padding-bottom:20px">
			<input type="text" name="" style=" border: 0;" readonly value="'.getInfoTransport(getEvenement($ID)["idTransport"])["date"].'"/>
		</div>
		
		<label class="col-md-5 control-label" for="dateDepart">Date retour</label>
		<div class="col-md-4" style="padding-bottom:20px">
			<input type="text" name="" style=" border: 0;" readonly value="'.getInfoTransport(getEvenement($ID)["idTransport"])["dateRetour"].'"/>
		</div>
		
		<label class="col-md-5 control-label" for="demandeAchat">Demande d\'achat</label>
		<div class="col-md-4" style="padding-bottom:20px">
			<input type="text" name="" style=" border: 0;" readonly value="'.getInfoTransport(getEvenement($ID)["idTransport"])["demandeAchat"].'"/>
		</div>
		
		<label class="col-md-5 control-label" for="nbTransport">Type de transport</label>
		<div class="col-md-4" style="padding-bottom:20px">
			<input type="text" name="" style=" border: 0;" readonly value="'.getInfoTransport(getEvenement($ID)["idTransport"])["typeTransport"].'"/>
		</div>
		
		<label class="col-md-5 control-label" for="note">note</label>
		<div class="col-md-4" style="padding-bottom:20px">
			<input type="text" name="" style=" border: 0;" readonly value="'.getInfoTransport(getEvenement($ID)["idTransport"])["note"].'"/>
		</div>
	</div>
</div>
</div>';
echo'<div>';
if (getEvenement($ID)["statusSejour"] == 1){
echo '
<a href="" class="af-link" style="padding-left:20%" onclick="$(\'#infoSejour\').toggle(500);$(\'#infoLieu\').hide(500);$(\'#infoTransport\').hide(500);$(\'#infSejour\').toggleClass(\'glyphicon glyphicon-chevron-down\').toggleClass(\'glyphicon glyphicon-chevron-up\');$(\'#infLieu\').removeClass(\'glyphicon glyphicon-chevron-up\');$(\'#infLieu\').addClass(\'glyphicon glyphicon-chevron-down\');$(\'#infTrans\').removeClass(\'glyphicon glyphicon-chevron-up\');$(\'#infTrans\').addClass(\'glyphicon glyphicon-chevron-down\');return false;">Informations séjour <span style="color:#00cc00; font-size:1.5em" title="Confirmé">&#10004;</span><span id="infSejour" class="glyphicon glyphicon-chevron-down" ></span></a>
';}
else if (getEvenement($ID)["statusSejour"] == 2){
echo '
<a href="" class="af-link" style="padding-left:20%" onclick="$(\'#infoSejour\').toggle(500);$(\'#infoLieu\').hide(500);$(\'#infoTransport\').hide(500);$(\'#infSejour\').toggleClass(\'glyphicon glyphicon-chevron-down\').toggleClass(\'glyphicon glyphicon-chevron-up\');$(\'#infLieu\').removeClass(\'glyphicon glyphicon-chevron-up\');$(\'#infLieu\').addClass(\'glyphicon glyphicon-chevron-down\');$(\'#infTrans\').removeClass(\'glyphicon glyphicon-chevron-up\');$(\'#infTrans\').addClass(\'glyphicon glyphicon-chevron-down\');return false;">Informations séjour <span style="color:#ffcc00; font-size:1.5em" title="À confirmer">&#10067;</span><span id="infSejour" class="glyphicon glyphicon-chevron-down" ></span></a>
';}
else if (getEvenement($ID)["statusSejour"] == 3){
echo '
<a href="" class="af-link" style="padding-left:20%" onclick="$(\'#infoSejour\').toggle(500);$(\'#infoLieu\').hide(500);$(\'#infoTransport\').hide(500);$(\'#infSejour\').toggleClass(\'glyphicon glyphicon-chevron-down\').toggleClass(\'glyphicon glyphicon-chevron-up\');$(\'#infLieu\').removeClass(\'glyphicon glyphicon-chevron-up\');$(\'#infLieu\').addClass(\'glyphicon glyphicon-chevron-down\');$(\'#infTrans\').removeClass(\'glyphicon glyphicon-chevron-up\');$(\'#infTrans\').addClass(\'glyphicon glyphicon-chevron-down\');return false;">Informations séjour <span style="color:#ff0000; font-size:1.5em" title="Annulé">&#10006;</span><span id="infSejour" class="glyphicon glyphicon-chevron-down" ></span></a>
';}
else{
echo '
<a href="" class="af-link" style="padding-left:20%" onclick="$(\'#infoSejour\').toggle(500);$(\'#infoLieu\').hide(500);$(\'#infoTransport\').hide(500);$(\'#infSejour\').toggleClass(\'glyphicon glyphicon-chevron-down\').toggleClass(\'glyphicon glyphicon-chevron-up\');$(\'#infLieu\').removeClass(\'glyphicon glyphicon-chevron-up\');$(\'#infLieu\').addClass(\'glyphicon glyphicon-chevron-down\');$(\'#infTrans\').removeClass(\'glyphicon glyphicon-chevron-up\');$(\'#infTrans\').addClass(\'glyphicon glyphicon-chevron-down\');return false;">Informations séjour <span id="infSejour" class="glyphicon glyphicon-chevron-down" ></span></a>
';}
echo '
<hr>
<div class="form-group" id="infoSejour" hidden>';
if(getEvenement($ID)["idSejour"]!=NULL)
{
	getDetailSejour(getEvenement($ID)["idSejour"]);
}
else
{
	echo '
	 <div>
<label class="col-md-9 control-label" for="" style="padding-bottom:15px">Aucun lieu de séjour</label>  ';
 echo'</div>';
}
echo '
</div>
<div>';

echo '

	<a href="" class="af-link" style="padding-left:20%" 
		onclick="
			$(\'#Responsable\').toggle(500);
			$(\'#infoLieu\').hide(500);
			$(\'#infoSejour\').hide(500);
			$(\'#infResponsable\').toggleClass(\'glyphicon glyphicon-chevron-down\').toggleClass(\'glyphicon glyphicon-chevron-up\');
			$(\'#infLieu\').removeClass(\'glyphicon glyphicon-chevron-up\');
			$(\'#infLieu\').addClass(\'glyphicon glyphicon-chevron-down\');
			$(\'#infSejour\').removeClass(\'glyphicon glyphicon-chevron-up\');
			$(\'#infSejour\').addClass(\'glyphicon glyphicon-chevron-down\');
			return false;"> 
			Personnes responsables <span id="infResponsable" class="glyphicon glyphicon-chevron-down" ></span>
	</a>
	<hr>
	<div class="form-group" id="Responsable" hidden>
		<div class="form-group">
			<table class="table table-striped" name="tableResp" id="tableResp" style="width: 50%;margin: 0 auto;">
				<thead>
				<tr>
					<th style="display:none;"></th>
					<th style="display:none;"></th>
					
					<th >Rôle</th>
					<th>Personne</th>
					<th style="display:none;"></th>
				</tr>
				</thead>
				<tbody id="resps" name="resps">';
					getListRespEvent3($ID);
					echo '</tbody>

			</table>
		</div>
	</div>
	
      
    </div>
	
  </div>
  <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove-circle"></span> Fermer</button>
      </div>
</div>';
}
//Jérémie
if(isset($_POST['infoEventDetails'])){
	afficherInfoEvenement($_POST['infoEventDetails']);
}
//Jérémie
function getTypeTransport()
{
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$requete = "SELECT distinct typeTransport from transport";
	mysqli_set_charset($connexion,'UTF8');
	$resultat = ExecRequete($requete, $connexion);
$resultat->data_seek(0);
$row = $resultat->fetch_assoc();
foreach($resultat as $row){
	echo '<option value="'.$row["typeTransport"].'">';
}
}
//Jérémie
function getListePersonnel()
{
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	mysqli_set_charset($connexion,'UTF8');
	
	$requete = "SELECT distinct p1.id_membre as id_personne, p1.nom as nom, p1.prenom as prenom, p1.no_tel as no_tel, p1.posteTelephonique as posteTelephonique, p1.courriel as courriel FROM membres_personnel p1 where extract(year from dateEmbauche) = extract(year from curdate()) or dateEmbauche is null order by p1.nom;";
	

	$resultat = ExecRequete($requete, $connexion);
	$resultat->data_seek(0);
$row = $resultat->fetch_assoc();
echo '<div class="table-responsive">
<table class="table table-striped table-hover" id="tablePersonnel">
    <thead>
      <tr>
		<th class="hidden">Id_personne</td>
		<th>Nom</th>
        <th>Téléphone</th>
		<th>Courriel</th>
      </tr>
    </thead>
	<tbody id="tbl-personnel">';
foreach($resultat as $row){
echo '<tr> 
		<td class="hidden">'.$row['id_personne'].'</td> 
		<td>'.$row['nom'].', '.$row['prenom'].'</td> ';
		if (is_null($row['no_tel']) or $row['no_tel'] == 0){
			echo '<td></td>';
		} else
			echo '<td>('.substr($row['no_tel'],0,3).') '.substr($row['no_tel'],3,3).'-'.substr($row['no_tel'],6).'</td>';
		echo '
		<td>'.$row['courriel'].'</td>
		<td><span class="glyphicon glyphicon-cog"></span></td>
	</tr>';
}
echo '</tbody></table></div><div class="col-md-12 text-center">
      <ul class="pagination pagination-lg pager" id="myPager"></ul>
      </div>';
}
//Jérémie
function getInfoPersonnel($ID)
{
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$requete = "SELECT * FROM responsable_plateau where id = '".$ID."';";
	mysqli_set_charset($connexion,'UTF8');
	$resultat = ExecRequete($requete, $connexion);
	$resultat->data_seek(0);
	$row = $resultat->fetch_assoc();
	return $row;
}
//Kevin
function getInfoPersonnel2($ID)
{
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$requete = "SELECT * FROM membres_personnel where id_membre = ".$ID.";";
	mysqli_set_charset($connexion,'UTF8');
	$resultat = ExecRequete($requete, $connexion);
	$resultat->data_seek(0);
	$row = $resultat->fetch_assoc();
	return $row;
}
//Jérémie
function getInfoPersonne($ID)
{
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$requete = "SELECT * FROM personnes where id_personne = '".$ID."';";
	mysqli_set_charset($connexion,'UTF8');
	$resultat = ExecRequete($requete, $connexion);
	$resultat->data_seek(0);
	$row = $resultat->fetch_assoc();
	return $row;
}
//Jérémie
function getRoles()
{
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$requete = "SELECT distinct role from role_responsable;";
	mysqli_set_charset($connexion,'UTF8');
	$resultat = ExecRequete($requete, $connexion);
	$resultat->data_seek(0);
	$row = $resultat->fetch_assoc();
	foreach($resultat as $row){
		echo '<option value="'.$row["role"].'">';
	}
}
//Jérémie
function getRoles2($ID)
{
	
	echo '<option value="" selected>- Rôle -</option>';
	
		$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
		$requete = "select nom from role;";
		mysqli_set_charset($connexion,'UTF8');
		$resultat = ExecRequete($requete, $connexion);
		$resultat->data_seek(0);
		$row = $resultat->fetch_assoc();

		foreach($resultat as $row){
			
			echo '<option value="'.$row['nom'].'">'.$row['nom'].'</option>';
			
		
	
}
}
//Jérémie
function getRolesPersonne($ID)
{
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$requete = "SELECT id_membre, no_embauches from membres_personnel where id_membre = ".$ID.";";
	mysqli_set_charset($connexion,'UTF8');
	$resultat = ExecRequete($requete, $connexion);
	$resultat->data_seek(0);
	$row = $resultat->fetch_assoc();
	$tags = explode(';',$row["no_embauches"]);
foreach($tags as $key) {
        if ($key != ''){    
		echo '<tr><td class="hidden"><input type="hidden" name="modif[]" value="1"/></td><td class="hidden">'.$row["id_membre"].'</td><td><input type="text" style=" border: 0;" name="tabNoEmb[]" readonly value="'.$key.'"/></td><td><button type="button" class="btn btn-default btn-sm" style="float:right;margin-right:10px;";>
    <span class="glyphicon glyphicon-trash"></span>
</button></td></tr>';
		}
	}
}
//Jérémie
if(isset($_POST['sport_change']))
{
	getListRespEvent2($_POST['ID']);
}
if(isset($_POST['btnSavePersonnel']))
{
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$mod      = isset($_POST['mod']) ? $_POST['mod'] : NULL;
	$ID        = isset($_POST['ID']) ? $_POST['ID'] : NULL;
	$nom     = isset($_POST['nom']) ? $_POST['nom'] : NULL;
	$prenom = isset($_POST['prenom']) ? $_POST['prenom'] : NULL;
	$noTel = isset($_POST['telephone']) ? $_POST['telephone'] : NULL;
	$poste  = isset($_POST['poste']) ? $_POST['poste'] : NULL;
	$sexe = isset($_POST['sexe']) ? $_POST['sexe'] : NULL;
	$courriel = isset($_POST['courriel']) ? $_POST['courriel'] : NULL;
	$tabNoEmb = isset($_POST['tabNoEmb']) ? $_POST['tabNoEmb'] : NULL;
	$modif    = isset($_POST['modif']) ? $_POST['modif'] : NULL;
	$noEmbs    = "";
	$dateEmbauche  = isset($_POST['dateEmbauche']) ? $_POST['dateEmbauche'] : NULL;

	if($mod == false)
	{
		foreach ( (array)$tabNoEmb as $index => $i )
		{
			if($modif[$index] == 0)
			{
				$noEmbs .= $i.";";
			}
		}


		$requete = "insert into membres_personnel(`nom`, `prenom`, `sexe`, `no_tel`, `posteTelephonique`, `courriel`, `no_embauches`,`dateEmbauche`) values('".addslashes($nom)."', '".addslashes($prenom)."', '".addslashes($sexe)."', '".addslashes($noTel)."', '".addslashes($poste)."', '".addslashes($courriel)."', '".addslashes($noEmbs)."',str_to_date('".addslashes($dateEmbauche)."','%Y-%m-%d'))";

		mysqli_set_charset($connexion,'UTF8');

		ExecRequete($requete, $connexion);	
		$id_personne = $ID;
		//$requete = "insert into responsable_plateau(`idEvenement`, `id_personne`, `role`) values(1, ".$id_personne.", '".addslashes($role)."')";
		
		
		$_SESSION['ajoutPersonnel'] = 1;
	}
	else
	{
		foreach ( (array)$tabNoEmb as $index => $i )
		{
			if($modif[$index] == 0)
			{
				$noEmbs .= $i.";";
				
			}
		}
		$requete1 = "SELECT no_embauches from membres_personnel where id_membre = ".$ID.";";
		mysqli_set_charset($connexion,'UTF8');
		$resultat1 = ExecRequete($requete1, $connexion);
		$resultat1->data_seek(0);
		$row1 = $resultat1->fetch_assoc();
		$noEmbs = $row1['no_embauches'].$noEmbs;


		$requete = "
		update membres_personnel set 
		  nom='".addslashes($nom)."',
		  prenom='".addslashes($prenom)."',
		  sexe='".addslashes($sexe)."',
		  no_tel='".addslashes($noTel)."',
		  courriel='".$courriel."',
		  posteTelephonique = '".addslashes($poste)."',
		  no_embauches = '".addslashes($noEmbs)."',
		  dateEmbauche = str_to_date('".addslashes($dateEmbauche)."','%Y-%m-%d')
		where id_membre=".$ID;
		mysqli_set_charset($connexion,'UTF8');

		ExecRequete($requete, $connexion);	
		//$requete = "update responsable_plateau set role='".addslashes($role)."' where id=".$ID;
		
		$_SESSION['modifPersonnel'] = 1;
	}
	
	
		echo '<script>window.location.replace("gestionPersonnel.php");</script>'	;
	
	
}
//Jérémie
if(isset($_POST['btnSupprimerPersonnel']))
{
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$ID        = $_POST['ID'];
	
	$requete = "delete from membres_personnel where id_membre = ".$ID;
	ExecRequete($requete, $connexion);	
	$_SESSION['suppPersonnel']=1;
	echo '<script>window.location.replace("gestionPersonnel.php");</script>'	;
}
//Jérémie
function getListeResponsable()
{
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
		$requete = "select distinct membres_personnel.id_membre, membres_personnel.prenom,membres_personnel.nom from membres_personnel left join responsable_plateau on membres_personnel.id_membre = responsable_plateau.id_personne";
		mysqli_set_charset($connexion,'UTF8');
		$resultat = ExecRequete($requete, $connexion);
		$resultat->data_seek(0);
		$row = $resultat->fetch_assoc();
foreach($resultat as $row){
		echo '<option value="'.$row["id_membre"].'">'.$row["nom"].', '.$row["prenom"].'</option>';
}
}
//Kevin
function getListeResponsable2($ID)
{
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
		$requete = "select distinct membres_personnel.id_membre as id, membres_personnel.prenom,membres_personnel.nom from membres_personnel left join responsable_plateau on membres_personnel.id_membre = responsable_plateau.id_personne";
		mysqli_set_charset($connexion,'UTF8');
		$resultat = ExecRequete($requete, $connexion);
		$resultat->data_seek(0);
		$row = $resultat->fetch_assoc();
foreach($resultat as $row){
	if ($row["id"] == $ID){
		echo '<option name = value="'.$row["id"].'" selected>'.$row["nom"].', '.$row["prenom"].'</option>';
	}
	else{
		echo '<option value="'.$row["id"].'">'.$row["nom"].', '.$row["prenom"].'</option>';
	}
}
}
//Jérémie
function getListRespEvent($ID)
{
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$requete1 = "select roles from sports where id_sport = (select idSport from evenement where id =".$ID.")";
	mysqli_set_charset($connexion,'UTF8');
	$resultat1 = ExecRequete($requete1, $connexion);
	$resultat1->data_seek(0);
	$row1 = $resultat1->fetch_assoc();
	
	$spo = explode(';',$row1["roles"]);
		foreach($spo as $s){
			if ($s != '' && $ID != ''){
				
			$requete2 = "select distinct m.id_membre as id,r.id as id_resp,m.nom as nom,m.prenom as prenom from membres_personnel m, responsable_plateau r where m.id_membre = r.id_personne and r.role ='".$s."' and r.idEvenement=".$ID.";";
			mysqli_set_charset($connexion,'UTF8');
			$resultat2 = ExecRequete($requete2, $connexion);
			$resultat2->data_seek(0);
			$row2 = $resultat2->fetch_assoc();
			
			if (!$row2["id"]) {
			echo '<tr><td class="hidden"><input type="hidden" name="modif[]" value="2"/></td><td class="hidden">'.$row2["id_resp"].'</td><td class="hidden"><input type="hidden" id ="tabPers" name="tabPers[]" value="'.$row2["id"].'"/></td><td><input type="text" style=" border: 0;" name="tabRoles[]" readonly value="'.$s.'"/></td><td><select name="names" id="names" class="form-control input-md" style="width:250px">
			<option value="0">- Membre du personnel -</option>';
				getListeResponsable2($row2["id"]);		
			echo '
	</select></td><td></td></tr>';
			}
			else{
				echo '<tr><td class="hidden"><input type="hidden" name="modif[]" value="1"/></td><td class="hidden">'.$row2["id_resp"].'</td><td class="hidden"><input type="hidden" name="tabPers[]" value="'.$row2["id"].'"/></td><td><input type="text" style=" border: 0;" name="tabRoles[]" readonly value="'.$s.'"/></td><td><input type="text" name="tabNoms[]" style=" border: 0;" readonly value="'.$row2["nom"].', '.$row2["prenom"].'"/></td><td><button type="button" class="btn btn-default btn-sm" style="float:right;margin-right:10px;";>
    <span class="glyphicon glyphicon-trash"></span>
</button></td></tr>';
			}
			
			}
		}
	$requete = "SELECT p2.id_personne as id, p2.id as id_resp, p1.nom as nom, p1.prenom as prenom, p2.role as role from responsable_plateau p2, personnes p1 where p2.id_personne = p1.id_personne and p2.idEvenement = ".$ID.";";
	mysqli_set_charset($connexion,'UTF8');
	$resultat = ExecRequete($requete, $connexion);
	$resultat->data_seek(0);
	$row = $resultat->fetch_assoc();
	foreach($resultat as $row){
		if (!in_array($row["role"], $spo)) {
			echo '<tr><td class="hidden"><input type="hidden" name="modif[]" value="1"/></td><td class="hidden">'.$row["id_resp"].'</td><td class="hidden"><input type="hidden" name="tabPers[]" value="'.$row["id"].'"/></td><td><input type="text" style=" border: 0;" name="tabRoles[]" readonly value="'.$row["role"].'"/></td><td><input type="text" name="tabNoms[]" style=" border: 0;" readonly value="'.$row["nom"].', '.$row["prenom"].'"/></td><td><button type="button" class="btn btn-default btn-sm" style="float:right;margin-right:10px;";>
    <span class="glyphicon glyphicon-trash"></span>
</button></td></tr>';
		}
		
	}
}
//Kevin
function getListRespEvent2($ID)
{
	

	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$requete1 = "select roles from sports where id_sport = ".$ID;
	
	mysqli_set_charset($connexion,'UTF8');
	$resultat1 = ExecRequete($requete1, $connexion);
	$resultat1->data_seek(0);
	$row1 = $resultat1->fetch_assoc();
	
	$spo = explode(';',$row1["roles"]);
		foreach($spo as $s){
			if ($s != ''){
			
			
			echo '<tr><td class="hidden"><input type="hidden" name="modif[]" value="2"/></td><td class="hidden"></td><td class="hidden"><input type="hidden" id ="tabPers" name="tabPers[]"/></td><td><input type="text" style=" border: 0;" name="tabRoles[]" readonly value="'.$s.'"/></td><td><select name="names" id="names" class="form-control input-md" style="width:250px">
			<option value="0">- Membre du personnel -</option>';
				getListeResponsable2('EE');		
			echo '
	</select></td><td></td></tr>';
			}
			
			}
		}
//Kevin
function getListRespEvent3($ID)
{
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$requete1 = "select roles from sports where id_sport = (select idSport from evenement where id =".$ID.")";
	
	mysqli_set_charset($connexion,'UTF8');
	$resultat1 = ExecRequete($requete1, $connexion);
	$resultat1->data_seek(0);
	$row1 = $resultat1->fetch_assoc();
	
	$spo = explode(';',$row1["roles"]);
		foreach($spo as $s){
			if ($s != '' && $ID != ''){
			$requete2 = "select distinct m.id_membre as id,r.id as id_resp,m.nom as nom,m.prenom as prenom from membres_personnel m, responsable_plateau r where m.id_membre = r.id_personne and r.role ='".$s."' and r.idEvenement=".$ID.";";
			mysqli_set_charset($connexion,'UTF8');
			$resultat2 = ExecRequete($requete2, $connexion);
			$resultat2->data_seek(0);
			$row2 = $resultat2->fetch_assoc();
			if (!$row2["id"]) {
			echo '<tr><td class="hidden"><input type="hidden" name="modif[]" value="2"/></td><td class="hidden">'.$row2["id_resp"].'</td><td class="hidden"><input type="hidden" id ="tabPers" name="tabPers[]" value="'.$row2["id"].'"/></td><td><input type="text" style=" border: 0;" name="tabRoles[]" readonly value="'.$s.'"/></td><td>
			</td><td></td></tr>';
			}
			else{
				echo '<tr><td class="hidden"><input type="hidden" name="modif[]" value="1"/></td><td class="hidden">'.$row2["id_resp"].'</td><td class="hidden"><input type="hidden" name="tabPers[]" value="'.$row2["id"].'"/></td><td><input type="text" style=" border: 0;" name="tabRoles[]" readonly value="'.$s.'"/></td><td><input type="text" name="tabNoms[]" style=" border: 0;" readonly value="'.$row2["nom"].', '.$row2["prenom"].'"/></td><td></td></tr>';
			}
			}
		}
	$requete = "SELECT p2.id_personne as id, p2.id as id_resp, p1.nom as nom, p1.prenom as prenom, p2.role as role from responsable_plateau p2, personnes p1 where p2.id_personne = p1.id_personne and p2.idEvenement = ".$ID.";";
	mysqli_set_charset($connexion,'UTF8');
	$resultat = ExecRequete($requete, $connexion);
	$resultat->data_seek(0);
	$row = $resultat->fetch_assoc();
	foreach($resultat as $row){
		if (!in_array($row["role"], $spo)) {
			echo '<tr><td class="hidden"><input type="hidden" name="modif[]" value="1"/></td><td class="hidden">'.$row["id_resp"].'</td><td class="hidden"><input type="hidden" name="tabPers[]" value="'.$row["id"].'"/></td><td><input type="text" style=" border: 0;" name="tabRoles[]" readonly value="'.$row["role"].'"/></td><td><input type="text" name="tabNoms[]" style=" border: 0;" readonly value="'.$row["nom"].', '.$row["prenom"].'"/></td><td></td></tr>';
		}
		
	}
}	
		
		
	

//Jérémie
function getAdminCount(){
$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
$requete = "select count(*) as nbr from utilisateurs_gestion where estAdmin = 1";
$resultat = ExecRequete($requete, $connexion);
$resultat->data_seek(0);
$row = $resultat->fetch_assoc();
return $row['nbr'];
}
//Jérémie
if(isset($_POST['persRespEvent']))
{
	getRoles2($_POST['persRespEvent']);
}
//Jérémie
if(isset($_POST['suppResp']))
{
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$ID        = $_POST['suppResp'];
	
	$requete = "delete from responsable_plateau where id = ".$ID;
	ExecRequete($requete, $connexion);	
	getListRespEvent($_POST['idEvent']);
}
//Jérémie
if(isset($_POST['suppRole']))
{
	
	$ID        = $_POST['suppRole'];
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$requete1 = "select no_embauches as no_embauches  from membres_personnel where id_membre = ".$ID.";";
	$resultat1 = ExecRequete($requete1, $connexion);
	$resultat1->data_seek(0);
	$row1 = $resultat1->fetch_assoc();
	$noEmb_to_delete = $_POST['data'];
	$noEmb_to_delete = $noEmb_to_delete.";";
	
	$newNoEmbs = str_replace($noEmb_to_delete,'',$row1['no_embauches']);
	
	if ($newNoEmbs != ''){
		$requete = "update membres_personnel set no_embauches = '".$newNoEmbs."' where id_membre = ".$ID;
	}
	else{
		$requete = "update membres_personnel set no_embauches = null where id_membre = ".$ID;
	}
	ExecRequete($requete, $connexion);	
	getRolesPersonne($_POST['idPers']);
}

//Anthony
//Affiche la liste des rôles
function getRolesTableau(){
$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
$requete = "select * from role;";
mysqli_set_charset($connexion,'UTF8');
$resultat = ExecRequete($requete, $connexion);
$resultat->data_seek(0);
$row = $resultat->fetch_assoc();
echo '<div class="table-responsive">
<table class="table table-striped table-hover" id="tableRoles">
    <thead>
      <tr>
        <th style="display:none">id</th>
        <th>Rôle</th>
		<th></th>
      </tr>
    </thead>
	<tbody id="tbl-roles">';
foreach($resultat as $row){
echo '<tr><td style="display:none">'.$row["id_role"].'</td><td>'.$row["nom"].'</td><td><span class="glyphicon glyphicon-cog"></span></td></tr>';
}
echo '</tbody></table></div>
<div class="col-md-12 text-center">
      <ul class="pagination pagination-lg pager" id="pagerRole"></ul>
      </div>';


}

//Anthony
//Update les informations d'un rôle
function updateRôle($id, $nom){
$caught = false;
$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
mysqli_set_charset($connexion,'UTF8');
$requete = "update role set nom = '".addslashes($nom)."' where id_role ='".$id."' ;";

try{
ExecRequete($requete, $connexion);}
catch (Exception $e){
$caught = true;
echo '<div class="alert alert-danger">
  <strong>Erreur!</strong> Les modifications ont échouées.
</div>';
}
finally{
if (!$caught){
$_SESSION['succesModification'] = 'succes';
echo '<script>window.location.replace("gestionRole.php");</script>'	;
	}
}

}

//Anthony
//Inscrit/Enregistre les modification d'un rôle
if(isset($_POST['btnEnregistrerRole']))
{
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$mod      = isset($_POST['mod']) ? $_POST['mod'] : NULL;
	$ID        = isset($_POST['ID']) ? $_POST['ID'] : NULL;
	$nom     = isset($_POST['nom']) ? $_POST['nom'] : NULL;
	
	if($mod == false)
	{
		
		$requete = "insert into role(nom) values('".addslashes($nom)."')";
		mysqli_set_charset($connexion,'UTF8');
		ExecRequete($requete, $connexion);	
		$id_personne = $ID;
		
		$_SESSION['succesRole'] = 1;
	}
	else
	{
		$requete = "update role set nom='".addslashes($nom)."' where id_role=".$ID;
		mysqli_set_charset($connexion,'UTF8');
		ExecRequete($requete, $connexion);	
		
		$_SESSION['modifRole'] = 1;
	}
	
	
		echo '<script>window.location.replace("gestionRole.php");</script>'	;
	
	
}

//Anthony
//Retourne les informations d'un rôle
function getRoleForm($id){
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$requete = "select * from role where id_role =".$id.";";
	mysqli_set_charset($connexion,'UTF8');
	$resultat = ExecRequete($requete, $connexion);
	$resultat->data_seek(0);
	$row = $resultat->fetch_assoc();
	return $row;
}

//Anthony
//Supprime un rôle
function supprimerRole($id){
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	mysqli_set_charset($connexion,'UTF8');
	$requete = "delete from role where id_role = ".$id.";";

		$resultat = ExecRequete($requete, $connexion);
		if ($resultat){
		$_SESSION['supprimerRole'] = 1;
			echo"<script>window.location.replace('gestionRole.php');</script>";
		}
	}

//Anthony
//Supprimer un rôle
if(isset($_POST['btnSupprimerRole']))
{
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	$ID        = $_POST['ID'];
	
	$requete = "delete from role where id_role = ".$ID;
	ExecRequete($requete, $connexion);	
	$_SESSION['supprimerRole']=1;
	echo '<script>window.location.replace("gestionRole.php");</script>'	;
}

//Anthony
//Détermine si un filtre pour l'année courante est demandé et l'active
if (isset($_POST['anneeCourantePersonnel'])){
	if ($_POST['anneeCourantePersonnel']){
	getListePersonnelFiltrer(true);
	}else getListePersonnelFiltrer(false);
}

//Anthony
//Permet d'obtenir la liste du personnel
function getListePersonnelFiltrer($filtrerAnneeCourante){
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	mysqli_set_charset($connexion,'UTF8');
	if ($filtrerAnneeCourante){
		$requete = "SELECT distinct p1.id_membre as id_personne, p1.nom as nom, p1.prenom as prenom, p1.no_tel as no_tel, p1.posteTelephonique as posteTelephonique, p1.courriel as courriel FROM membres_personnel p1 where extract(year from dateEmbauche) = extract(year from curdate()) or dateEmbauche is null order by p1.nom;";
	} else {
		$requete = "SELECT distinct p1.id_membre as id_personne, p1.nom as nom, p1.prenom as prenom, p1.no_tel as no_tel, p1.posteTelephonique as posteTelephonique, p1.courriel as courriel FROM membres_personnel p1 order by p1.nom;";
	}
	
	$resultat = ExecRequete($requete, $connexion);
	$resultat->data_seek(0);
	$row = $resultat->fetch_assoc();
	foreach($resultat as $row){
		echo '<tr>
		<td class="hidden">'.$row['id_personne'].'</td> 
		<td>'.$row['nom'].', '.$row['prenom'].'</td> 
		<td>('.substr($row['no_tel'],0,3).') '.substr($row['no_tel'],3,3).'-'.substr($row['no_tel'],6).'</td>
		<td>'.$row['posteTelephonique'].'</td>
		<td>'.$row['courriel'].'</td>
		<td><span class="glyphicon glyphicon-cog"></span></td>
		</tr>';
	}
}

if (isset($_POST['btnSupprimerEvent'])){
	supprimerEvenement($_POST['btnSupprimerEvent']);
}

//Anthony
//Permet de suppriemr un évènement
function supprimerEvenement($ID){
	$connexion = Connexion(NOM, PASSE, BASE, SERVEUR);
	mysqli_set_charset($connexion,'UTF8');
	$ID = $_POST['ID'];
	$requete = "delete from evenement WHERE id=".$ID;
	ExecRequete($requete, $connexion);	
	$_SESSION['supprimerEvent'] = 1;
	echo"<script>window.location.replace('gestionEvenements.php');</script>";
}
?>