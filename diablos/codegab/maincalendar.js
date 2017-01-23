/*
Auteur: Gabriel Dubé
Description: Calendrier avec fonctions avancées
*/


$( document ).ready(function() {
    
    activites = [];
    min_year = 2015;
    max_year = moment().year()+3;
    current_date = moment();
    colcount = 7;
    rowcount = 5;
    
    function display_activite(){
        var date = $(this).data("date");
        $.ajax({
            type:'POST',
            url:'functions.php',
            data:'func=getEvents&date='+date,
            success: function(html){
                $('#event_list').html(html);
                $('#event_list').slideDown('slow');
            }
        });
    }
    
    function calendar_days(){
        var days = [];
        var xday = current_date.startOf('month').startOf('day');
        
        xday.subtract(xday.day(), 'day');

        while(days.length < 6*7){
            days.push(moment(xday));
            xday.add(1, 'day');
        }
        
        current_date.subtract(1, "month");
        
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
    
    function filters_(){
        var endroit_ = $(".data-endroit").val();
        var visiteur_ = $(".data-receveur").val();
        var receveur_ = $(".data-visiteur").val();
        var mindate = $(".data-minDate").val();
        var maxdate = $(".data-maxDate").val();
        return {endroit:endroit_, visiteur:visiteur_,
                receveur:receveur_, mind:mindate, maxd: maxdate};
    }
    
    function load_calendar(){
        var days = calendar_days()
        var dates_holder = $(document.createElement('ul'));
        for (var i=0; i < rowcount; ++i) {
            for (var j=0; j < colcount; ++j){
                var c = $(document.createElement('li'));
                var num = $(document.createElement('span'));
                var cdate = days.shift();
                
                if (cdate.month() == current_date.month()){
                    num.html(cdate.date())
                    
                    if ( (indexes = date_in_activites(cdate)).length != 0){
                        var x = $("<div id=\"date_popup\" class=\"date_popup_wrap none\"></div>");
                        var y = $("<div class=\"date_window\"><a href=\"javascript:;\" onclick=\"getEvents(\''.$currentDate.'\')</div>");
                        var z = $("<div class=\"popup_event\"> évènement(s) ("+indexes.length+") <br> <a href='javascript:;'>Détails</a></div>");
                        y.append(z);
                        x.append(y);
                        
                        c.toggleClass("evenement");
                        c.data("indexes", indexes);
                        c.data("date", cdate.format("YYYY-MM-DD"));
                        c.on("click", display_activite);
                        c.mouseenter(function(){
                            $(".date_popup_wrap").fadeOut();
                            $(this).find("#date_popup").fadeIn();
                         })
                        c.append(x);    
                    } 
                }

                c.toggleClass("date_cell");
                c.append(num);
                dates_holder.append(c);
            }
        }
        
        $("#calender_section_bot").html("");
        $("#calender_section_bot").append(dates_holder);
        
        $('.date_cell').mouseleave(function(){
            $(".date_popup_wrap").fadeOut();		
        });
    }
    
    function load_activites(){
        $.get( "requests/maincalendar_listactivite.php", filters_())
         .done(
         function( data ) {
            var data_raw = JSON.parse(data);
            activites = [];
            for (var i = 0; i < data_raw.length; i++) {
                if(data_raw[i]){
                    var act = JSON.parse(data_raw[i]);
                    act["date"] = moment(act["date"], "YYYY-M-DD");
                    activites.push(act);
                } else {
                    console.log("failed to load an activity!");
                }
            }
            
            load_calendar();
       });
    }
     
    function select_months(){
        var mois = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
        var drop = $("#month_dropdown");
        for(var i=0; i < mois.length; i++){
            var op = $(document.createElement('option'));
            op.html(mois[i]);
            op.attr('value', i);
            if(i == current_date.month()){
                op.prop('selected', true);
            }
            drop.append(op);
        }
    }
    
    function select_years(){
        var drop = $("#year_dropdown");
        for(var year=min_year; year <= max_year; year++){
            var op = $(document.createElement('option'));
            op.html(year);
            op.attr('value', year);
            if(year == current_date.year()){
                op.prop('selected', true);
            }
            drop.append(op);
        }
    }
    
    function update_drop(){
        $("#year_dropdown>option").prop('selected', false);
        $("#month_dropdown>option").prop('selected', false);
        
        var year = current_date.year();
        if (year > max_year){
            max_year = year;
            var op = $(document.createElement('option'));
            op.html(year);
            op.attr('value', year);
            $("#year_dropdown").append(op);
        }
       
        $('#month_dropdown :nth-child('+(current_date.month()+1)+')').prop('selected', true);
        $('#year_dropdown :nth-child('+(current_date.year()-min_year+1)+')').prop('selected', true);
    }
    
    function update_month(){
        var year = $("#year_dropdown").val();
        var month = $("#month_dropdown").val();
        current_date.year(year);
        current_date.month(month);
        load_calendar();
    }
    
    function next_month(){
        current_date.add(1, "month");
        load_calendar();
        update_drop();
    }
    
    function previous_month(){
        current_date.subtract(1, "month");
        load_calendar();
        update_drop();
    }
    
    $('#datetimepicker1, #datetimepicker2').datetimepicker({
        showClose: true,
        defaultDate: false,
        useCurrent: false,
        format: 'YYYY-MM-DD', 
        locale: 'fr',
    });
   
    $(document).on("click",".search-btn", function(){
        $("#search").toggle(!$("#search").is(":visible"));
        $(".search-btn>span").toggleClass("glyphicon-triangle-bottom glyphicon-triangle-top ");
    });    
    
     $(".search-btn-submit").on("click", function(){ 
        load_activites(); 
        $("#search").toggle(!$("#search").is(":visible"));
        $(".search-btn>span").toggleClass("glyphicon-triangle-bottom glyphicon-triangle-top ");
    });
    
    $("#popup_bg").on('click', function(){ $("#popup_bg").hide() })

    $("#prev_month").on("click", function(){ previous_month(); });
    $("#next_month").on("click", function(){ next_month(); });
    $("#month_dropdown, #year_dropdown").on("change", function(){ update_month(); });
    select_months();
    select_years();
    load_activites();
});