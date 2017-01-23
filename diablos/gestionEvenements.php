<?php
 
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<html>

<head>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<meta http-equiv="content-type" content="text/html; charset=utf8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="stylesheet" type="text/css" href="mastersheet.css">
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
  <li><a href="gestionEvenements.php">Gestion des évènements</a></li>
</ol>

<legend>Liste des évènements</legend>
<div class="container" id="evenement">
<div class="row">
 <div class="col-sm-12 col-md-12 col-lg-12">
<?php if (isset($_SESSION['nomUtilisateur'])){echo '<a class="btn btn-default btn-sm" style="float:right" role="button" id="btnAjouterEvent" href="evenement.php"><span class="glyphicon glyphicon-plus-sign"></span> Ajouter</a>';}?>
   <div id="sectionFiltre">
	<label class="" for="filtre">Filtre:</label>
	<input type="text" class="form-control" placeholder="Mot clé"  id="filtre" name="filtre">
		  <span class="glyphicon glyphicon-filter" style="float:right;" data-toggle="modal" data-target="#modalFiltre"></span>
		  </div> 
		  <div>
<span class="glyphicon pdf" style="float:right;" data-toggle="modal" data-target="#modalPDF"> <img src="Images/iconePDF.png"></span>

</div>

<?php 
getEvenements();
if (isset($_SESSION['modifEvent']) && $_SESSION['modifEvent'] == 1){
			echo '<script>toastr["success"]("Les modifications ont été apportées.", "Succès!");</script>';
			$_SESSION['modifEvent'] = "";
			}
			if (isset($_SESSION['ajoutEvent']) && $_SESSION['ajoutEvent'] == 1){
			echo '<script>toastr["success"]("L\'évènement a été ajouté!", "Succès!");</script>';
			$_SESSION['ajoutEvent'] = "";
			}
            if (isset($_SESSION['supprimerEvent']) && $_SESSION['supprimerEvent'] == 1){
			    echo '<script>toastr["success"]("L\'évènement a été supprimé!", "Succès!");</script>';
                $_SESSION['supprimerEvent'] = "";
			}
?>
<?php
if (isset($_SESSION['nomUtilisateur']))
echo '<script>afficherEngrenage("#tableEvenement",true);</script>';
else
echo '<script>afficherEngrenage("#tableEvenement",false);</script>';
?>
</div>
</div>
</div>
<br>
<!-- Modal options PDF-->
<div id="modalPDF" class="modal fade" role="dialog">
<div class="modal-dialog">
<!-- Modal contenu-->
<div class="modal-content" id="mdl-PDF">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Paramètres</h4>
</div>

  <div class="modal-body">

  <form method="POST" action="evenementPDF.php"><i><h6>Les paramètres sont facultatifs.</h6></i>
  
  <script>
  
  </script>
    <div class="form-group">
      <label class="col-md-4 control-label" for="dateDebutPDF">Date de début</label>
      <div class="col-md-5">
        <input id="dateDebutPDF" name="dateDebutPDF" type="Date" class="form-control input-md" style='width:150px' onchange="dateMax()">
        </div>
        </div>
        <div class="form-group">
        <label class="col-md-4 control-label" for="dateFinPDF">Date de fin</label>
         <div class="col-md-5">
        <input id="dateFinPDF" name="dateFinPDF" type="Date" class="form-control input-md" style='width:150px' onchange="dateMax();">
      </div>
      </div>
	  <div class="form-group">
  <label class="col-md-4 control-label" for="sport">Sport</label>
  <div class="col-md-5" style="display:inline-block;">
    <select name="sport" id="sport" class="form-control input-md" style='width:150px'>
	<option>-Sport-</option>
			<?php
				getSport(-1);				
			?>
	</select>
  </div>
</div>
    </div>


  <div class="modal-footer">
  <div id="btnOptionPDF">
  <input type="submit" value="Télécharger" class="btn btn-default">
  </form>
    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
    </div>

  </div>
</div>
</div>
</div>

<!-- Modal -->
<div id="modalFiltre" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" id="mdl-filtre">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Sélection du sport</h4>
      </div>
      <div class="modal-body">
	  <center>
        <ul class="filtreImgSport">
		<div>
			<li><img src="Images/football.bmp"		onclick="selectionFiltre('2')" id="2" alt="Football"></li>
			<li><img src="Images/basket.bmp" 		onclick="selectionFiltre('1')" id="1" alt="Basketball"></li>
			<li><img src="Images/natation.bmp" 		onclick="selectionFiltre('3')" id="3" alt="Natation"></li>
			</div><div>
			<li><img src="Images/soccer.bmp" 		onclick="selectionFiltre('4')" id="4" alt="Soccer"></li>
			<li><img src="Images/crosscountry.bmp"  onclick="selectionFiltre('5')" id="5" alt="Cross-country"></li>
			<li><img src="Images/cheerleading.bmp"  onclick="selectionFiltre('7')" id="7" alt="Cheerleading"></li>
			</div><div>
			<li><img src="Images/flagfootball.bmp"		onclick="selectionFiltre('8')" id="8" alt="Flag Football"></li>
			<li><img src="Images/golf.bmp" 			onclick="selectionFiltre('9')" id="9" alt="Golf"></li>
			<li><img src="Images/volleyball.bmp"	onclick="selectionFiltre('0')" id="0" alt="Volleyball"></li>
			</div><div id="dernierFiltre">
			<li><img src="Images/badminton.bmp"		onclick="selectionFiltre('6')" id="6" alt="Badminton"></li>
			</div>
		</ul>
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
      </div>
    </div>

  </div>
</div>
<script>
activeSwitch("planification");
var isFiltreImage = false;
var isFiltreTexte = false;
$(document).ready(function(){
//Pagination des tableaux
//Anthony
$.fn.pageMe = function(opts){
    var $this = this,
        defaults = {
            perPage: 35,
            showPrevNext: false,
            hidePageNumbers: false
        },
        settings = $.extend(defaults, opts);
    
    var listElement = $this;
    var perPage = settings.perPage; 
    var children = listElement.children();
    var pager = $('.pager');
    
    if (typeof settings.childSelector!="undefined") {
        children = listElement.find(settings.childSelector);
    }
    
    if (typeof settings.pagerSelector!="undefined") {
        pager = $(settings.pagerSelector);
    }
    
    var numItems = children.size();
    var numPages = Math.ceil(numItems/perPage);

    pager.data("curr",0);
    
    if (settings.showPrevNext){
        $('<li><a href="#" class="prev_link">«</a></li>').appendTo(pager);
    }
    
    var curr = 0;
    while(numPages > curr && (settings.hidePageNumbers==false)){
        $('<li><a href="#" class="page_link">'+(curr+1)+'</a></li>').appendTo(pager);
        curr++;
    }
    
    if (settings.showPrevNext){
        $('<li><a href="#" class="next_link">»</a></li>').appendTo(pager);
    }
    
    pager.find('.page_link:first').addClass('active');
    pager.find('.prev_link').hide();
    if (numPages<=1) {
        pager.find('.next_link').hide();
    }
  	pager.children().eq(1).addClass("active");
    
    children.hide();
    children.slice(0, perPage).show();
    
    pager.find('li .page_link').click(function(){
        var clickedPage = $(this).html().valueOf()-1;
        goTo(clickedPage,perPage);
        return false;
    });
    pager.find('li .prev_link').click(function(){
        previous();
        return false;
    });
    pager.find('li .next_link').click(function(){
        next();
        return false;
    });
    
    function previous(){
        var goToPage = parseInt(pager.data("curr")) - 1;
        goTo(goToPage);
    }
     
    function next(){
        goToPage = parseInt(pager.data("curr")) + 1;
        goTo(goToPage);
    }
    
    function goTo(page){
        var startAt = page * perPage,
            endOn = startAt + perPage;
        
        children.css('display','none').slice(startAt, endOn).show();
        
        if (page>=1) {
            pager.find('.prev_link').show();
        }
        else {
            pager.find('.prev_link').hide();
        }
        
        if (page<(numPages-1)) {
            pager.find('.next_link').show();
        }
        else {
            pager.find('.next_link').hide();
        }
        
        pager.data("curr",page);
      	pager.children().removeClass("active");
        pager.children().eq(page+1).addClass("active");
    
    }
};


$('#tblEvenement').pageMe({pagerSelector:'#pagerEvent',showPrevNext:true,hidePageNumbers:false,perPage:35});

$('.table-hover tbody td:not(:last-child)').on('click',function(e){$('#infoEventDetail').empty(); $.ajax({
	
	type: 'POST',
    url: 'functionPHP.php',
    data: {infoEventDetails: $(this).closest("tr").find("td:first").text()},
	 success: function (reponse) {
	  document.getElementById("infoEventDetail").innerHTML=reponse;
	  $('#infoEventDetail').modal('toggle');
    },
    error: function (err){
      alert('Erreur');
    }

	
       
    });
});
});
$('#filtre').keypress(function(e){
    var txt = String.fromCharCode(e.which);
    if(!txt.match(/[a-zA-Z0-9À-ÿ\x08]/))
    {
        return false;
    }
});

//Anthony
//Filtre sur équipe
$("#filtre").keyup(function () {
  
    var data = this.value.toUpperCase().split(" ");
    var jo = $("#tableEvenement").find("tr").not(':first'); //SOLUTION HASCLASS?
    var pager = $('#pagerEvent');
    pager.hide();

    if (this.value == "" && isFiltreImage == false) {
        isFiltreTexte = false;
        pager.empty();
        jo.show();
        $('#tblEvenement').pageMe({pagerSelector:'#pagerEvent',showPrevNext:true,hidePageNumbers:false,perPage:35});
	    pager.show();
        return;
    } else if (this.value == "" && isFiltreImage == true) {
        console.log('test');
        isFiltreTexte = false;
        jo.show();
        $('#tblEvenement > tr').not('.visibleImage').hide()
        return;
    } else {
        isFiltreTexte = true;
    }
	
    jo.hide();

    jo.filter(function (i, v) {
        var $t = $(this).find(':nth-child(5)');
		var $t2 = $(this).find(':nth-child(6)');
		var $l = $(this);
	
        for (var d = 0; d < data.length; ++d) {
            if (($t.text().toUpperCase().indexOf(data[d]) > -1 || $t2.text().toUpperCase().indexOf(data[d]) > -1 ) && $l.hasClass('visible')) {
                $(this).addClass('visibleTexte');
                return true;
            }
        }
        $(this).removeClass('visibleTexte');
        return false;
    })
    
    .show();
}).focus(function () {
    this.value = "";

    $(this).unbind('focus');
});



$(".filtreImgSport img").click(function () {
    var pager = $('#pagerEvent');
   
    if (isFiltreTexte && isFiltreImage && !this.className.indexOf("filtreSelectionne")) {
        console.log('eraseFiltreImage');
        //enlever le filtre image
        //filter('tbody tr', '');
        console.log($('.visibleImage'));
        $('tr').removeClass('visibleImage');
        $('.visibleTexte').show();
        isFiltreImage = false;
    }

    $('tbody tr').addClass('visible');
    if (isFiltreTexte && this.className.indexOf("filtreSelectionne")){
        console.log('-1');
        pager.hide();
        filter('tbody tr:visible', '');
        $('#tblEvenement > tr').not('.visibleImage').hide();
        $('#tblEvenement > tr.visibleTexte').show();
        $('.visibleImage').removeClass('visibleImage');
        isFiltreImage = false;
    } else if (isFiltreTexte){
        console.log('1');
        pager.hide();
        filter('tbody tr:visible', this.id);
        isFiltreImage = true;
    } else if (this.className.indexOf("filtreSelectionne")){
        console.log('2');
        filter('tbody tr', '');
        $('.visibleImage').removeClass('visibleImage');
        isFiltreImage = false;
    } else {
        console.log('3');
        pager.hide();
        filter('tbody tr', this.id);
        isFiltreImage = true;

    }
   

});

function filter(selector, query) {
    query =   $.trim(query); //trim white space
    query = query.replace(/ /gi, '|'); //add OR for regex query

    $(selector).find(':nth-child(2)').each(function() {
        ($(this).text().search(new RegExp(query, "i")) < 0) ? $(this).parent('tr',1).hide().removeClass('visible visibleImage') : $(this).parent('tr',1).show().addClass('visible visibleImage');
  });
}

</script>
</div>
<div class="footer" style="position: absolute;"> 
<?php
require_once("footer.php");
if (isset($_SESSION['nomUtilisateur']) && $_SESSION['nomUtilisateur'] == "") {
echo '<script>cacherStatut();</script>';
}
?>
  
</div>
</div>
</body>
</html>