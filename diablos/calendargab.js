 /*
    Auteur: 		Gabriel Dubé
    Description:	Aperçu calendrier web
*/

$( document ).ready(function() {
  mois = ["JANVIER", "FÉVRIER", "MARS", "AVRIL", "MAI", "JUIN", "JUILLET", "AOÛT", "SEPTEMBRE", "OCTOBRE", "NOVEMBRE", "DÉCEMBRE"];
  mois_abrev = ["JANV.", "FEV.", "MARS", "AVRIL", "MAI", "JUIN", "JUILL.", "AOÛT", "SEPT.", "OCT.", "NOV.", "DEC."];

  activites = []

  colcount = 7;
  rowcount = 5;
  offset_details_activites = 0;
  max_offset_details_activites = 0;

  date = moment();

  function goto_activite() {
    if( $(this).data("index") == -1) {return; } 
    var act = activites[$(this).data("index")];  
    window.location.href = "evenement.php?ref="+act["id"];
  }

  function translate_activite(delta) {
      var offset = offset_details_activites;
      var new_offset = offset + delta;
      offset_details_activites = new_offset;
    
      var translate =  "translate(0px,"+new_offset+"px)";     
      $("#more_info_inner>*").css({"transform":translate});
  }

  function calendar_days(){
    var days = [];
    var xday = date.startOf('month').startOf('day');
    
    xday.subtract(xday.day(), 'day');

    while(days.length < 6*7){
      days.push(moment(xday));
      xday.add(1, 'day');
    }
    
    date.subtract(1, "month");
    
    return days;
  }

  function date_in_activites(date){
    var indexes = [];
    
    for (var i = 0; i < activites.length; i++) {
      var xdate = activites[i]["date"];
      if(date.date() == xdate.date() &&
        date.month() == xdate.month() &&
        date.year() == xdate.year()){
        indexes.push(i);
      }
    }
    
    return indexes;
  }

  function make_activite(activite, index){
    var container = $(document.createElement('div'));
    var text = $(document.createElement('div'));
    var date = $(document.createElement('div'));
    var date_num = $(document.createElement('div'));
    var date_month = $(document.createElement('div'));
    var title = $(document.createElement('h4'));
    var descr = $(document.createElement('span'));
    
    container.toggleClass("activite");
    text.toggleClass("activite-text pull-right");
    date.toggleClass("activite-date");
    date_num.toggleClass("date-num");
    date_month.toggleClass("date-month");
    
    date_num.html(activite["date"].date());
    date_month.html(mois_abrev[activite["date"].month()]);
    title.html(activite["nom"]);
    descr.html(activite["des"]);
    
    text.append(title)
    text.append(descr)
    date.append(date_num);
    date.append(date_month);
    container.append(text);
    container.append(date);
    container.append($(document.createElement('hr')));
    container.data("index", index);
    container.on("click", goto_activite);
    $("#more_info_inner").append(container);
  }
  
  function display_activite() {
    console.log($("#more_info_inner"));
    $("#more_info_inner").html("");
    offset_details_activites = 0;
    
    var count = 0;
    var indexes = $(this).data("indexes");
    for(var i=0; i < indexes.length; i++){
      var activite = activites[indexes[i]];
      make_activite(activite, indexes[i]);
      count += 1;
    }
    
    max_offset_details_activites = (count-1)*100;
 }

  function load_calendar() {
    $("#current_month").html(mois[date.month()] + " " + date.year())
    $("#calendrier_contenu").html("");
    var xday = date.startOf('month');
    var yday = date.endOf('month');
    
    var days_of_week = 'D_L_M_M_J_V_S'.split('_');
    var tr = $(document.createElement('tr'));
    for (var i=0; i < colcount; ++i) {
      var c = $(document.createElement('th'));
      c.html(days_of_week[i]);
      tr.append(c);
    }
    $("#calendrier_contenu").append(tr);
    
    days = calendar_days()
    for (var i=0; i < rowcount; ++i) {
      var tr = $(document.createElement('tr'));
      for (var j=0; j < colcount; ++j){
        var c = $(document.createElement('td'));
        var cc = $(document.createElement('div'));
        var cdate = days.shift();
        if (cdate.month() == date.month()){
          cc.html(cdate.date());
          if ( (indexes = date_in_activites(cdate)).length != 0){
            cc.toggleClass("highlight-activite");
            cc.data("indexes", indexes);
            cc.on("click", display_activite );
          } else {
            cc.toggleClass("nohighlight-activite");
          }
        } else {
          cc.html("&nbsp;");
        }
        c.append(cc)
        tr.append(c);
      }
      $("#calendrier_contenu").append(tr);
    } 
    
  }

  function load_activites() {
    $.get( "requests/calendargab_listactivite.php", function( data ) {
      var data_raw = JSON.parse(data);
      activites = [];
      max_offset_details_activites = 0;
      for (var i = 0; i < data_raw.length; i++) {
        if(data_raw[i]){
          var act = JSON.parse(data_raw[i]);
          act["date"] = moment(act["date"], "YYYY-M-DD");
          activites.push(act);
        } else {
          console.log("failed to load an activity!");
        }
      }
      
      var count = 0;
      var in_3_month = moment().add(3, "month");
      $.each(activites, function(index, value) {
        if(value["date"] > moment() && value["date"] < in_3_month) {
          make_activite(value, index);
          count += 1;
        }
      });
      
      max_offset_details_activites = (count-1)*100;
      
      if(count == 0){
        var activite = {"date": moment(), "nom": "Aucune activités", "des": "Il n'y a aucune activité de prévue dans les 3 prochains mois."};
        make_activite(activite, -1);
      }
      
      load_calendar();
    });
    
  }

  $("#navleft").on('click', function(){
    date.subtract(1, 'month');
    load_calendar();
  });

  $("#navright").on('click', function(){
    date.add(1, 'month');
    load_calendar();
  });

  $("#move_up").on('click', function(){
      var offset = offset_details_activites;
      if(offset+40 <= 0)
        translate_activite(40);
  });

  $("#move_down").on('click', function(){
    var offset = offset_details_activites;
    if(offset-40 >= -max_offset_details_activites)
      translate_activite(-40);
  });

  $("#more_info").data("offset", 0);
  load_activites();
});

function connexionSwitch(){
  var btnConn = document.getElementById('btnConnexion');

  if (btnConn.innerHTML == "Connexion"){
    window.location.replace("Login.php");
    }
    else{
      window.location.replace("functionPHP.php?DECONNECT=true");
    }
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