<?php 
 ini_set('error_reporting',0);
	ini_set('display_error',0);
	session_start();
function nav_inner($path){
 echo $path;
}
?>

<nav class="navbar navbar-default" >
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php nav_inner("index.php") ?>"><img src="<?php nav_inner("logoDiabloDebout.png") ?>" class="navbar-logo"></a>
    </div>
    <input type="hidden" id="securite" value =<?php if (isset($_SESSION['nomUtilisateur'])) {echo '1';} else echo '2'; ?> />
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav" id="navbar">
        <li class="active" id="accueil"><a href="<?php nav_inner("index.php") ?>">Accueil <span class="sr-only">(current)</span></a></li>
		<li id="planification"><a href="<?php nav_inner("gestionEvenements.php") ?>">Planification</a></li>
        <li class="dropdown" id="gestion">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gestion <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li id="entraineur"><a href="<?php nav_inner("gestionEntraineur.php") ?>">Entraîneurs</a></li>
            <li id="equipe"><a href="<?php nav_inner("gestionEquipes.php") ?>">Équipes</a></li>
            <li id="calendar-preview"><a href="calendargab.php">Aperçu calendrier</a></li>
			      <li id="staff"><a href="<?php nav_inner("gestionPersonnel.php") ?>">Personnel responsable</a></li>
				  <li id="role"><a href="<?php nav_inner("gestionRole.php") ?>">Rôles</a></li>
				  <li id="sport"><a href="<?php nav_inner("gestionSport.php") ?>">Sports</a></li>
			   	  <?php if(isset($_SESSION['estAdmin']) && $_SESSION['estAdmin'] == 1){ ?>
              <li role="separator" class="divider"></li>
              <li id="utilisateur"><a href="<?php nav_inner("gestionUtilisateur.php") ?>">Utilisateurs</a></li>
            <?php } ?>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        
        <li class="dropdown">
          <?php estConnecte(); ?>

          <!--
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Mon compte <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="" id="btnConnexion" onclick="connexionSwitch();return false;">Connexion</a></li>
            </ul>
          -->
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
