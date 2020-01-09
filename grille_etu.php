  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.css" />-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
  <link href='css/fullcalendar.min.css' rel='stylesheet' />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
 <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>-->
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>
  <script src='js/fullcalendar.min.js'></script>
  <script src='js/fr.js'></script>
  <script>


  $(document).ready(function() {
   var calendar = $('#calendar').fullCalendar({

    editable:false,
    header:{
     left:'prev,next today',
     center:'title',
     right:'agendaWeek,agendaDay,month'
    },
    defaultView:'agendaWeek',
    hiddenDays: [ 0 ],
    locale:'fr',
    minTime: "07:00:00",
    maxTime: "19:00:00",
    slotLabelFormat: 'H:mm',
    allDaySlot: false,
    //dayNamesShort: ['lun', 'mar', 'mer', 'jeu', 'ven', 'sam', 'Panier'],
    slotLabelInterval: '01:00',
    //slotDuration: '00:15',
    height: 450,
    //contentHeight:"auto",
    businessHours: {
      dow: [ 1, 2, 3, 4, 5 ],
      start: '8:00',
      end: '19:00',
    },
    nowIndicator: true,

    //now: '2019-01-11T11:15:00', //remove - only for demo
    scrollTime: '08:00:00',
    defaultDate: new Date(),


    eventRender: function(event, element) {

        element.find(".fc-title").css("font-weight", "bold");
        element.find('.fc-content').append(event.enseignant+"<br/>"+ event.groupe+"<br/>"+ event.salle);
         },


   });
  });

//si niveau change
$(function () {
        $("#niveau").change(function (event) {
            remplirDiplome();
        });
    });

    function remplirDiplome() {
        var niveau = $('#niveau').val();
        var dataString = 'niveau=' + niveau;
        $.ajax({
            type: 'post',
            url: 'get_diplome.php',
            dataType: "html", // le fichier php fait un echo de code HTML
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            data: dataString,
            success : function(code_html, statut){
                $("#diplome").html("<option value=''>Veuillez choisir un diplome</option>" + code_html);
            }
        });
    }

$(function () {
    $("#diplome").change(function (event) {
        $('#calendar').fullCalendar( 'removeEvents');
        var diplome = $('#diplome').val();
        var source='load.php?diplome='+diplome;
        $('#calendar').fullCalendar( 'addEventSource',source );

        $("#ical a").attr("href", "ical.php?diplome="+diplome);
        $("#apple a").attr("href", "ical.php?diplome="+diplome);
        $("#csv a").attr("href", "to_csv.php?diplome="+diplome);

    });
});

$(function () {
    $('.fc-right').append('<div id="ical" ><a class="ical" href=""><img src="img/ical.png" style="max-width: 100px; height: 35px;" title="Exporter vers google agenda"></img><a></div>');
    $('.fc-right').append('<div id="apple" ><a class="ical" href=""><img src="img/apple.png" style="max-width: 40px; height: 35px;" title="Exporter vers apple agenda"></img><a></div>');
    $('.fc-right').append('<div id="csv" ><a class="csv" href=""><img src="img/csv.png" style="max-width: 40px; height: 35px;" title="Exporter vers fichier CSV"></img><a></div>');
});


  </script>

    <div class="container">
        <div class="form-group row justify-content-center">
            <label for="niveau" class="control-label">Niveau</label>
            <div class="col-sm-3">
                <select name="niveau" id="niveau" class="form-control">
                   <option selected>Choisir un Niveau</option>
                    <?php
                        $sql = "SELECT distinct niveau FROM diplome order by niveau";
                        $result = $bdd->query($sql);
                        while($row = $result->fetch()) {
                            $niveau = $row['niveau'];
                            echo "<option value='$niveau'>{$niveau}</option>";
                        }
                    ?>
                  </select>
             </div>
            <label for="diplome" class="control-label">Diplome</label>
            <div class="col-sm-5">
                <select name="diplome" id="diplome" class="form-control">

                </select>

            </div>
        </div>

    <div id="calendar" style="width: 100%; display: inline-block;"></div>

</div>
 </body>
</html>
