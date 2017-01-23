<?php
    /*
    Auteur Original: Anthony Duhaime (fichier original "functions.php")
    Auteur: Gabriel Dubé
    Modifications apportées: 
      Remplacement du code php par du javascript. 
      Réduction du couplage (ie: il n'y a plus de php dans du javascript inline).
      Utilisation de JQUERY.
      Nom de fichier significatif
      Support de recherches dynamiques
    Raison: L'ancien calendrier était statique et ne supportait pas la recherche dynamique.
    Description: Calendrier avec fonctions avancées
    */
?>

<!-- CALENDAR FILTER START 
      Auteur: 		Gabriel Dubé
      Description:	Filtre sur le calendrier
-->
<div class="row" id="search_btn_row">
    <div class="col-sm-3 col-xs-1"></div>
    <div class="col-sm-6 col-xs-10"><button class="btn btn-info search-btn expand"><i class="fa fa-search caret-dropup"></i>&nbsp;Filtrer <span class="glyphicon glyphicon-triangle-bottom"></button></div>
    <div class="col-sm-3 col-xs-1"></div>
</div>

<div class="row">
<div class="col-xs-12">
    <div id="search" class="search-box container-fluid" hidden>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="background-color: transparent; padding: 10px;">
                <label>Endroit</label>
                <input type="text" name="visiteur" class="form-control data-endroit">
            </div>
        </div>

        
        <div class="row">      
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <label>Receveur</label>
                <input type="text" name="receveur" class="form-control data-receveur">
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <label>Visiteur</label>
                <input type="text" name="visiteur" class="form-control data-visiteur">
            </div>
        </div>
        
        <div class="row">      
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <label>Date inférieure</label>
                <div class='input-group date' id='datetimepicker1' style="width: 240px;">
                <input type="text" name="minDate" class="form-control data-minDate" data-mask="0000-00-00" placeholder="0000-00-00" style="width:200px;">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>   
            </div>


            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <label>Date supérieure</label>
                <div class='input-group date' id='datetimepicker2' style="width: 240px;">
                <input type="text" name="maxDate" class="form-control data-maxDate" data-mask="0000-00-00" placeholder="0000-00-00" style="width:200px;">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        
        <div class="row" id="search_btn_submit_row">
            
            <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2"><button type="button" class="btn btn-default search-btn-submit expand"><span class="glyphicon glyphicon-check"></span> Appliquer le filtre</button></div>
        </div>
    
    </div>
</div>
</div>

<!-- CALENDAR FILTER END -->

<div id="calender_section">
    <h2>
        <a id="prev_month" href="javascript:;"><span class="glyphicon glyphicon-arrow-left"></span></a>
        <select id="month_dropdown" class="month_dropdown dropdown"></select>
        <select id="year_dropdown" class="year_dropdown dropdown"></select>
        <a id="next_month" href="javascript:;"><span class="glyphicon glyphicon-arrow-right"></span></a>
    </h2>
    
    <div id="calender_section_top">
        <ul>
            <li>Dim</li>
            <li>Lun</li>
            <li>Mar</li>
            <li>Mer</li>
            <li>Jeu</li>
            <li>Ven</li>
            <li>Sam</li>
        </ul>
    </div>
    <div id="calendar_popup" hidden>
        <div id="calendar_popup_inner">
            <div class="pull-right">
                <span class="pop-exit glyphicon glyphicon-remove-sign"></span>
            </div>
        </div>
    </div>
    <div id="calender_section_bot">
        <!-- Voir maincalendar.js -->
    </div>
    <div id="event_list" class="none"></div>
</div>