//Connection d'un utilisateur
//Anthony
function connexionSwitch(){
var btnConn = document.getElementById('btnConnexion');

if (btnConn.innerHTML == "Connexion"){
	window.location.replace("Login.php");
	}
	else{
		window.location.replace("functionPHP.php?DECONNECT=true");
	}
}

//Modifie l'onglet possèdant la classe "active" selon l'id passé en paramètre
//Anthony +Gabriel Richer
function activeSwitch(onglet){
var ongletActif = document.getElementsByClassName('active');
var ongletSwitch = document.getElementById(onglet);

//Dsactivation
ongletActif[0].classList.remove("active");

//Switch
ongletSwitch.setAttribute("class","active");

//Gabriel Richer
$("#gestion").css({
  background: "-webkit-linear-gradient(top, #45484d 0%,#000000 100%)"}).css({
  background: "linear-gradient(top, #45484d 0%,#000000 100%)"})
  

 
};




//Sélectionne l'onglet Gestion et le bon élément du dropdown
//Gabriel Richer
function activeSwitchGestion(onglet){


//Desactivation
var ongletActif = document.getElementsByClassName('active');

if (($("#accueil").hasClass("active")) || ($("#planification").hasClass("active"))){
ongletActif[0].classList.remove("active");}

//Switch

$("#gestion ul li").each(function()
{
	
	
	if (this.id ==onglet){
	
    this.setAttribute("class","active");
	}
});

$("#gestion").toggleClass('gradient-blue');
 

  
  

 
 
 
};





//Ajoute un message d'erreur ou de confirmation à l'endroit choisi
//Anthony
function ajouterMessage(locationID, type, message){
var endroit = document.getElementById(locationID);

var element = document.createElement('div');
if (type == 'danger'){
element.className = 'alert alert-danger';
element.innerHTML = '<strong>Erreur!</strong>'+' '+ message;
} else {
element.className = 'alert alert-succes';
element.innerHTML = '<strong>Succès!</strong>'+' '+ message;}
endroit.appendChild(element);

}

//Live search de la barre de navigation
//Anthony
function showResult(str) {
	
  if (str.length==0) { 
    document.getElementById("livesearch").innerHTML="";
    document.getElementById("livesearch").style.border="0px";
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("livesearch").innerHTML=xmlhttp.responseText;
      document.getElementById("livesearch").style.border="1px solid #A5ACB2";
    }
  }
  xmlhttp.open("GET","livesearch.php?q="+str,true);
  xmlhttp.send();
}

//Fait la gestion du filtre de sport actif
//Anthony
function selectionFiltre(sport){
var sport= document.getElementById(sport);
var sportPrecedant = document.getElementsByClassName('filtreSelectionne')[0];

var pager = $('#pagerEvent');


if (sportPrecedant == sport){
    sport.removeAttribute('class');
    pager.show();
}
else if (sportPrecedant == null){
    pager.hide();
    if (sport.className == ""){
	   sport.setAttribute('class','filtreSelectionne');
	} else {
	   sport.removeAttribute('class');
	}
} else {
	sportPrecedant.removeAttribute('class');
	sport.setAttribute('class','filtreSelectionne');
}


}

//Modifie le css de la date du jour dans le calendrier
//Anthony
function jourMaintenant(){
var aujourdhui = new Date();
var dd = aujourdhui.getDate();
var mm = ("0" + (aujourdhui.getMonth() + 1)).slice(-2)

var yyyy = aujourdhui.getFullYear();
var jourCalendrier = document.getElementById('li-'+yyyy+'-'+'02'+'-'+dd);
jourCalendrier.style.color = "#E3373F";
}

//Pagination des tableaux
//Anthony
$.fn.pageMe = function(opts){
    var $this = this,
        defaults = {
            perPage: 10,
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

//Assure une cohérence entre une date de début et une date de fin
//Anthony
function dateMax(){
var dateMax = document.getElementById('dateFinPDF');
var dateDeb = document.getElementById('dateDebutPDF');

if (dateDeb.value > dateMax.value && dateDeb.value != "" && dateMax.value != ""){
	dateDeb.max = dateMax.value;
	dateDeb.value = dateMax.value;
	}
	
}



//Retourne la date du jour
//Anthony
function getCurrDate(){
	var today = new Date();
return today.toISOString().substring(0, 10);
}

//Set la valeur maximale d'une date à aujourd'hui
//Anthony
function dateMaximum($inputDate){
var input = document.getElementById($inputDate);

input.setAttribute('max',getCurrDate());
}

//Cache les statuts de la table d'évènements
//Anthony
function cacherStatut(){
var listeStatuts = document.getElementsByClassName('EvenementStatut');

for (i=0;i<listeStatuts.length;i++){
listeStatuts[i].setAttribute('hidden','hidden');
}
}

//Afficher ou cacher l'engrenage d'un tableau
//Anthony
function afficherEngrenage(idTableau,afficher){
	
	if (afficher){
		$(idTableau+':first tr').each(function() {
  var lasttd= $(this).find('td:last-child');
  lasttd.css('display','visible');
  
});
	}else
	{
		$(idTableau+':first tr').each(function() {
  var lasttd=  $(this).find('td:last-child')
  lasttd.css('display','none');

});
	}
	
}

//Maxime - exécute plusieurs vérification sur la forme d'équipe.
function verifierForm() {
    var saison = document.forms["addEvent"]["saisonEquipe"].value;
    if(!verifierSaison(saison)) {
        toastr.error('La saison doit avoir un équart d\'une année. Ex: 2015-2016');
        return false;
    }
    return true;
}

//Prends une saison en paramètre avec le format suivant : 2016-2017
//Vérifie si les 2 années ont un an d'équart.

//Maxime
function verifierSaison(saison) {
    var arrSaison = saison.split('-');
    if (parseInt(arrSaison[0]) + 1 == arrSaison[1]) {
        return true;
    }
    return false;
}

$( document ).ready(function() {
    if($('#datetimepicker1').datetimepicker !== undefined) {
            $('#datetimepicker1, #datetimepicker2, #datetimepicker3 ').datetimepicker({
            showClose: true,
            defaultDate: false,
            useCurrent: false,
            format: 'YYYY-MM-DD', 
            locale: 'fr',
        });
    }
    
});