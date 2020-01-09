<?php include ("../backend/connexion_bdd.php");?>
<?php include ("verify_session.php"); ?>
<?php
$sql = "SELECT * FROM seance ";
$req = $bdd->prepare($sql);
$req->execute();
$events = $req->fetchAll();
?>
<?php
$code_diplome=$_SESSION['code_diplome'];
?>
<!DOCTYPE html>
<html>
 <head>
 <meta charset="UTF-8">
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
   /* customButtons: {
        trash: {
            text: 'Supprimer Séance'
            }
    },*/

    editable:true,
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
    scrollTime: '08:00:00',
    slotLabelFormat: 'H:mm',
    businessHours: {
      dow: [ 1, 2, 3, 4, 5 ],
      start: '8:00',
      end: '19:00',
    },
    //height: 550,
    contentHeight:"auto",
    //defaultDate: new Date(),
    events: 'load.php',
    allDaySlot: false,
    nowIndicator: true,

    selectable:true,
    selectHelper:true,
    select: function(start, end, allDay)
    {
        $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm'));
		$('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm'));
		$('#ModalAdd').modal('show');
    },
    editable:true,

    eventResize:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm");
     //var title = event.title;
     var id = event.id;
     $.ajax({
      url:"update_drop.php",
      type:"POST",
      data:{start:start, end:end, id:id},
      success:function()
      {
       calendar.fullCalendar('refetchEvents');
       alert("Séance Modifié");
      }
     });
    },

    eventRender: function(event, element) {
                 //element.children().last().append(event.groupe);

        element.find(".fc-title").css("font-weight", "bold");
        element.find('.fc-content').append(event.nature+"<br/>"+ event.enseignant+"<br/>"+ event.groupe+"<br/>"+ event.salle);
         element.bind('click', function() {
            var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm");
            var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm");
            $('#ModalEdit #id').val(event.id);
            $('#ModalEdit #title').val(event.title);
            $('#ModalEdit #start').val(start);
            $('#ModalEdit #end').val(end);
            $('#ModalEdit #salle').val(event.salle);
            $('#ModalEdit #color').val(event.color);
            $('#ModalEdit #commentaire').val(event.commentaire);
            $('#ModalEdit #nature').val(event.nature);
            $('#ModalEdit').modal('show');
        });

                },
    eventDragStop: function(event,jsEvent) {

        var trashEl = jQuery('#calendarTrash');
        var ofs = trashEl.offset();

        var x1 = ofs.left;
        var x2 = ofs.left + trashEl.outerWidth(true);
        var y1 = ofs.top;
        var y2 = ofs.top + trashEl.outerHeight(true);

        if (jsEvent.pageX >= x1 && jsEvent.pageX<= x2 &&
            jsEvent.pageY >= y1 && jsEvent.pageY <= y2) {
                if (confirm("Etes-vous sur de vouloir supprimer " + event.title +" ?")) {
                    //pour annuler les informations
                    $('#calendar').fullCalendar('removeEvents', event._id);
                    var id = event.id;
                      $.ajax({
                       url:"delete.php",
                       type:"POST",
                       data:{id:id},
                       success:function()
                       {
                        calendar.fullCalendar('refetchEvents');
                        alert("Séance supprimé");
                       }
                      })

                }

        }
    },

    eventDrop:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm");
     //var title = event.title;
     var id = event.id;
     $.ajax({
      url:"update_drop.php",
      type:"POST",
      data:{start:start, end:end, id:id},
      success:function()
      {
       calendar.fullCalendar('refetchEvents');
       alert("Seance Modifier");
      }
     });
    },



   /* eventClick:function(event)
    {
     if(confirm("Are you sure you want to remove it?"))
     {
      var id = event.id;
      $.ajax({
       url:"delete.php",
       type:"POST",
       data:{id:id},
       success:function()
       {
        calendar.fullCalendar('refetchEvents');
        alert("Event Removed");
       }
      })
     }
    },*/


   });

       var currentDate='<?php echo end($events)["start_seance"]; ?>';
        $('#calendar').fullCalendar('gotoDate', currentDate);

  });

//fonction pour ue et matiere
$(function () {
        $("#ue").change(function (event) {
            var ue = $('#ue').val();
            var dataString = 'ue=' + ue;
            $.ajax({
                type: 'post',
                url: 'get_matiere.php',
                dataType: "html", // le fichier php fait un echo de code HTML
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                data: dataString,
                success : function(code_html, statut){
                    $("#matiere").html("<option value=''>Choisir une matière</option>" + code_html);
                }
            });
        });
    });
/*$(function () {
        $("#matiere").change(function (event) {
        var matiere= $("#matiere").val();
        $("#title").val(matiere);
        });
});*/
$(function () {
   $('.fc-left').append('<div id="calendarTrash" class="calendar-trash"><img src="img/trash.png" title=" Glisser la séance vers la corbeille pour la supprimer"></img></div>');
    $('.fc-right').append('<div id="ical" class="ical"><a href="ical.php"><img src="img/ical.png" style="max-width: 100px; height: 35px;" title="Exporter vers google agenda"></img><a></div>');
    $('.fc-right').append('<div id="apple" ><a class="ical" href="ical.php"><img src="img/apple.png" style="max-width: 40px; height: 35px;" title="Exporter vers apple agenda"></img><a></div>');
    $('.fc-right').append('<div id="csvl" class="csv"><a href="to_csv.php"><img src="img/csv.png" style="max-width: 40px; height: 35px;" title="Exporter vers fichier CSV"></img><a></div>');
});
//cacher popup
$(function () {
    $('#ModalAdd').on('hidden.bs.modal', function () {
        $(this).find("input,textarea,select").val('').end();
    });
});



  </script>
 </head>
<body>
    <br/>
    <h2 align="center">Gestion de l'emploi du temps du <?php echo $code_diplome?></h2>
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
    <div id="calendar"></div>

<!--form ajout seance-->

<div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
         <form class="form-horizontal" method="POST" action="insert.php">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Ajouter séance</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="ue" class="col-sm-3 control-label">UE</label>
                    <div class="col-sm-9">
                        <select name="ue" id="ue" class="form-control" required>
                            <option selected>Choisir une UE</option>
                            <?php
                                $sql = "SELECT distinct * FROM ue  where code_diplome= :code_diplome";
                                $result = $bdd->prepare($sql);
                                $result->execute(array('code_diplome' =>$code_diplome));
                                while($row = $result->fetch()) {
                                    $code_ue=$row['code_ue'];
                                    $ue = $row['libelle_ue'];
                                    echo "<option value='$code_ue'>{$ue}</option>";
                                }
                            ?>
                        </select>
                        </div>
                </div>
                <div class="form-group row">
                    <label for="matiere" class="col-sm-3 control-label">Matière</label>
                    <div class="col-sm-9">
                        <select name="matiere" id="matiere" class="form-control" required>

                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="groupe" class="col-sm-3 control-label">Groupe</label>
                    <div class="col-sm-9">
                        <select name="groupe" id="groupe" class="form-control" required>
                            <?php
                                $sql = "SELECT distinct libelle_groupe FROM groupe where code_diplome= :code_diplome";
                                $result = $bdd->prepare($sql);
                                $result->execute(array('code_diplome' =>$code_diplome));
                                while($row = $result->fetch()) {
                                    $num_groupe=$row['num_groupe'];
                                    $groupe = $row['libelle_groupe'];
                                    echo "<option value='$groupe'>{$groupe}</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="title" class="col-sm-3 control-label">Titre</label>
                    <div class="col-sm-9">
                        <input type="text" name="title" class="form-control" id="title" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="enseignant" class="col-sm-3 control-label">Enseignant</label>
                    <div class="col-sm-9">
                        <select name="enseignant" id="enseignant" class="form-control" required>
                           <option value="">Choisir un enseignant</option>
                            <?php
                                $sql = "SELECT * FROM enseignant join intervenir on enseignant.num_enseignant=intervenir.num_enseignant join diplome on intervenir.code_diplome= diplome.code_diplome where intervenir.code_diplome= :code_diplome order by nom_enseignant asc";
                                $result = $bdd->prepare($sql);
                                $result->execute(array('code_diplome' =>$code_diplome));
                                while($row = $result->fetch()) {
                                    $num_enseignant=$row['num_enseignant'];
                                    $nom_enseignant = $row['nom_enseignant'];
                                    $prenom_enseignant = $row['prenom_enseignant'];
                                    $enseignant=$nom_enseignant." ".$prenom_enseignant;
                                    echo "<option value='$num_enseignant'>{$enseignant}</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nature" class="col-sm-3 control-label">Nature</label>
                    <div class="col-sm-9">
                        <select name="nature" id="nature" class="form-control">
                            <option value="">Choisir la nature de la séance</option>
                            <option value="CM">CM</option>
                            <option value="TP">TD</option>
                            <option value="CM">TP</option>
                            <option value="Exposé">Exposé</option>
                            <option value="Séminaire">Séminaire</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="color" class="col-sm-3 control-label">Color</label>
                    <div class="col-sm-9">
                        <select name="color" class="form-control" id="color" required>
                            <option style="color:#0071c5;" value="#0071c5">&#9724; Bleu</option>
                            <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
                            <option style="color:#4ca85e;" value="#4ca85e">&#9724; vert</option>		
                            <option style="color:#FFD700;" value="#FFD700">&#9724; Jaune</option>
                            <option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
                            <option style="color:#ff3a3a;" value="#ff3a3a">&#9724; Rouge</option>
                            <option style="color:#cb73e0;" value="#cb73e0">&#9724; Violet</option>
                        </select>
                    </div>
                </div>
              <div class="form-group row">
                <label for="start" class="col-sm-2 control-label">Début Séance</label>
                <div class="col-sm-3">
                  <input type="text" name="start" class="form-control" id="start" readonly>
                </div>

                <label for="end" class="col-sm-2 control-label">Fin Séance</label>
                <div class="col-sm-3">
                  <input type="text" name="end" class="form-control" id="end" readonly>
                </div>
              </div>
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
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            <button id="btn" type="submit" class="btn btn-primary">Enregistrer</button>
          </div>
    </form>
</div>
</div>
</div>

<!--form modification seance-->

<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
         <form class="form-horizontal" method="POST" action="update_form.php">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Modifier séance</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">


                <div class="form-group row">
                    <label for="title" class="col-sm-3 control-label">Titre</label>
                    <div class="col-sm-9">
                        <input type="text" name="title" class="form-control" id="title" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nature" class="col-sm-3 control-label">Nature</label>
                    <div class="col-sm-9">
                        <select name="nature" id="nature" class="form-control">
                            <option value="CM">CM</option>
                            <option value="TD">TD</option>
                            <option value="TP">TP</option>
                            <option value="Exposé">Exposé</option>
                            <option value="Séminaire">Séminaire</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="color" class="col-sm-3 control-label">couleur</label>
                    <div class="col-sm-9">
                        <select name="color" class="form-control" id="color">
                            <option style="color:#0071c5;" value="#0071c5">&#9724; Bleu</option>
                            <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
                            <option style="color:#4ca85e;" value="#4ca85e">&#9724; vert</option>		
                            <option style="color:#FFD700;" value="#FFD700">&#9724; Jaune</option>
                            <option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
                            <option style="color:#ff3a3a;" value="#ff3a3a">&#9724; Rouge</option>
                            <option style="color:#cb73e0;" value="#cb73e0">&#9724; Violet</option>
                        </select>
                    </div>
                </div>
              <div class="form-group row">
                <label for="start" class="col-sm-2 control-label">Début Séance</label>
                <div class="col-sm-3">
                  <input type="text" name="start" class="form-control" id="start" readonly>
                </div>

                <label for="end" class="col-sm-2 control-label">Fin Séance</label>
                <div class="col-sm-3">
                  <input type="text" name="end" class="form-control" id="end" readonly>
                </div>
              </div>
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
            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            <button type="submit" class="btn btn-primary">Enregister</button>
          </div>
    </form>
</div>
</div>
</div>
</div>
 </body>
</html>
