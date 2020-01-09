<?php
include ("../backend/connexion_bdd.php");
include ('verify_session.php');
?>
<?php

$code_diplome=$_SESSION['code_diplome'];
?>
<!DOCTYPE html>
<html>
 <head>
  <title>EDT</title>
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
    height: 590,
    businessHours: {
      dow: [ 1, 2, 3, 4, 5 ],
      start: '8:00',
      end: '19:00',
    },
    nowIndicator: true,
    scrollTime: '08:00:00',
    defaultDate: new Date(),
    eventRender: function(event, element) {
        element.find(".fc-title").css("font-weight", "bold");
        element.find('.fc-content').append(event.enseignant+"<br/>"+ event.groupe+"<br/>"+ event.salle);
         element.bind('click', function() {
            $('#ModalEdit #id').val(event.id);
            $('#ModalEdit #salle').val(event.salle);
             $('#ModalEdit #commentaire').val(event.commentaire);
            $('#ModalEdit').modal('show');
        });

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
    $("#btn").click(function (event) {
        var id = $('#ModalEdit #id').val();
        var salle = $('#ModalEdit #salle').val();
        var commentaire = $('#ModalEdit #commentaire').val();
        $.ajax({
            type: 'post',
            url: 'update_form.php',
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            data:{id:id, salle:salle, commentaire:commentaire},
            success : function(){
                $('#ModalEdit').modal('hide');
                $('#calendar').fullCalendar('refetchEvents');
            }
        });
    });
});

      $(function () {
            $('.fc-right').append('<div id="ical" class="ical"><a href=""><img src="img/ical.png" style="max-width: 100px; height: 35px;" title="Exporter vers google agenda"></img><a></div>');
           $('.fc-right').append('<div id="apple" ><a class="ical" href=""><img src="img/apple.png" style="max-width: 40px; height: 35px;" title="Exporter vers apple agenda"></img><a></div>');
            $('.fc-right').append('<div id="csv" class="csv"><a href=""><img src="img/csv.png" style="max-width: 40px; height: 35px;" title="Exporter vers fichier CSV"></img><a></div>');
      });

  </script>
 </head>
<body>
    <br/>
   <h2 align="center">Gestion d'emploi du temps du DDAME</h2>
    
    <div class="logout" id="logout">
     <form action="../backend/deconnexion.php" method="post" id="login">
     <button type="submit" value="Déconnexion"
     style="
       float: right;
       right: 85px;
       position: relative;
       top: -42px;
       font-family: 'Source Sans Pro', sans-serif;
       font-size: 0.9em;
       background:#B41933;
       color:#fff;
       border:none;
       padding:0 2em;
       cursor:pointer;
       transition:800ms ease all;
       outline:none;
       margin-left: 6px;
       text-transform: capitalize;
     "
      name="deconnect">Déconnexion</button>
     </form>
   </div>
    <br/>

    <div class="container">
    <!--<form action="load.php" method="POST">-->
        <div class="form-group  row justify-content-center">
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
            <div class="col-sm-3">
                <select name="diplome" id="diplome" class="form-control">

              </select>
            </div>

           <!-- <button id="btn" type="submit" class="btn btn-primary" formtarget="_blank">Afficher</button>-->
        </div>
        <!--</form>-->

    <div id="calendar"></div>


<!--form modification seance-->

<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <!-- <form class="form-horizontal" id="form">-->
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Modifier séance</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">



            <div class="form-group row">
                    <label for="salle" class="col-sm-3 control-label">Salle</label>
                    <div class="col-sm-9">
                        <input type="text" name="salle" class="form-control" id="salle">
                    </div>
            </div>
            <div class="form-group row">
                    <label for="commentaire" class="col-sm-3 control-label">Commentaire</label>
                    <div class="col-sm-9">
                        <textarea name="commentaire" class="form-control" rows="4" id="commentaire"></textarea>
                    </div>
                </div>
                <input type="hidden" name="id" class="form-control" id="id">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button id="btn" type="submit" class="btn btn-primary">Save</button>
          </div>
   <!-- </form>-->
</div>
</div>
</div>
</div>
</body>
</html>
