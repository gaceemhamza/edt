<?php
include("connexion_bdd.php");
include("functions.php");
include('verify_session.php');
include('head.php');
if($_SESSION['profil']==1){
  include('menu.php');
} elseif ($_SESSION['profil']==2) {
  include('menu_editeur.php');
} elseif ($_SESSION['profil']==3) {
  header ('Location:../edt_ges/index.php');
}

if(isset($_POST['add_matiere'])) {

    $libelle_matiere  = $_POST['libelle_matiere'];
    $volume_horaire   = $_POST['volume_horaire'];
    $code_ue          = $_POST['ue'];

    $sql = 'INSERT INTO matiere (libelle_matiere, volume_horaire, code_ue) ';

    $sql.= 'VALUES(:libelle_matiere, :volume_horaire, :code_ue)';

    $prep = $bdd->prepare($sql);

    $result=$prep->execute(array(
        'libelle_matiere' =>$libelle_matiere,
        'volume_horaire' =>$volume_horaire,
        'code_ue' =>$code_ue
    ));

    header('Location:profil.php?page=view_matiere');
}
?>
<div class="contenu">
    <div class="row">
    <div class="col-md-5 offset-md-3">
    <h3>Ajouter une matière</h3>

     <form action="" method="post" enctype="multipart/form-data">

     <div class="form-group">
            <label for="niveau">Niveau</label>
            <select name="niveau" id="niveau" class="form-control">
           <option selected>Choisir un Niveau</option>
            <?php

                //lorsque l'administrateur se connecte
                if($_SESSION['profil']==1){
                    $sql = "SELECT distinct niveau FROM diplome";
            }else{ //lorsque un éditeur se connecte

                $sql = 'SELECT niveau FROM diplome Where code_diplome regexp "'.$_SESSION['code_diplome'].'"' ;

            }

                $result = $bdd->query($sql);
                while($row = $result->fetch()) {
                    $niveau = $row['niveau'];
                    echo "<option value='$niveau'>{$niveau}</option>";
                }
            ?>
          </select>
      </div>

      <div class="form-group">
            <label for="diplome">Choisir un Diplome</label>
            <select name="diplome" id="diplome" class="form-control">

          </select>
      </div>
      <div class="form-group">
            <label for="ue">UE</label>
            <select name="ue" id="ue" class="form-control">
                <option selected>Choisir une UE</option>

          </select>
      </div>


      <div class="form-group">
            <label for="libelle">libelle matiere</label>
            <input type="text" class="form-control" name="libelle_matiere">
      </div>
      <div class="form-group">
            <label for="volume">volume horaire</label>
            <input type="number" min="0" class="form-control" name="volume_horaire">
      </div>


      <div class="form-group">
          <input class="btn btn-primary" type="submit" name="add_matiere" value="Envoyer">
      </div>


</form>
</div>
</div>
</div>
<script>

    $(function () {

        $("#niveau").change(function (event) {

            remplirDiplome();

        });

    });

     $(function () {

        $("#diplome").change(function (event) {

            remplirUe();

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

    function remplirUe() {
        var diplome = $('#diplome').val();
        var dataString = 'diplome=' + diplome;
        $.ajax({
            type: 'post',
            url: 'get_ue.php',
            dataType: "html", // le fichier php fait un echo de code HTML
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            data: dataString,
            success : function(code_html, statut){
                $("#ue").html("<option value=''>Veuillez choisir une UE </option>" + code_html);
            }
        });
    }


</script>
<?php include('footer.php');?>
