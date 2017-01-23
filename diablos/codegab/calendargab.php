<?php
    /*
    Auteur: 		Gabriel Dubé
    Description:	Aperçu calendrier web
    */
    require_once ("Connexion/Connect.php");
    require_once ("Connexion/Connexion.php");
    require_once ("Connexion/ExecRequete.php");
    require_once ("functionPHP.php");
     
    ?>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment-with-locales.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="Includes/toastr.min.js"></script>
        <script src="functions.js"></script>
        <script src="calendargab.js"></script>
        <meta charset="UTF8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="mastersheet.css">
        <link rel="stylesheet" type="text/css" href="calendargab.css">
        <link rel="stylesheet" type="text/css" href="nav-bar.css">
        <link rel="stylesheet" type="text/css" href="Includes/toastr.css">
        <link rel="stylesheet" type="text/css" href="footer.css">
		<script>
  
        $(document).ready(function() { 
		activeSwitchGestion("calendar-preview");
        
        });
    </script>
		
    </head>
    <body>
        <?php
            require_once('nav-bar_inner.php');
          
        ?>
        <div style="border: dashed 1px #000; width: 850px; margin: 0 auto;">
        <!-- CALENDAR BEGIN -->
        <div id="calendar">
          <div class="pull-left">
              <div id="head" style="display: inline-block;">
                  <div id="head-left" class="pull-left">
                      ACTIVITÉS
                  </div>
                  <div id="head-right" class="pull-right">
                      <span id="navleft">&#x25c0;</span>
                      <span id="current_month"></span>
                      <span id="navright">&#x25b6;</span>
                  </div>
              </div>
              <div>
                  <table id="calendrier_table"  >
                    <tbody id="calendrier_contenu">
                    </tbody>
                  </table>
              </div>
             
          </div>
          <div id="scroll_bar" class="pull-right">
              <span id="move_up"><span>&#x25b2;</span></span>
              <span id="move_down"><span>	&#x25bc;</span></span>
          </div>
          <div id="more_info" class="pull-right">
              <div id="more_info_inner">
                  <div>
                  </div>
              </div>
          </div>
          
        </div>
        <!-- CALENDAR END -->
        
        </div>
        <div class="footer"> 
            <?php
                require_once("footer_inner.php");
                ?>
        </div>
    </body>
</html>