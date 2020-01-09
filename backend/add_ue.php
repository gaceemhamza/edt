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
?>

<div class="contenu">
    <div class="row">
    <div class="col-md-5 offset-md-3">
    <h3>Ajouter une UE</h3>

     <!--<form action="" method="post" enctype="multipart/form-data">-->

       <div class="form-group" id="IdNiv">
            <label for="niveau">Niveau</label>
            <select name="niveau" id="niveau" class="form-control">
           <option selected>Choisir un Niveau</option>
            <?php
                $sql = "SELECT distinct niveau FROM diplome";
                $result = $bdd->query($sql);
                while($row = $result->fetch()) {
                    $niveau = $row['niveau'];
                    echo "<option value='$niveau'>{$niveau}</option>";
                }
            ?>
          </select>
      </div>
      <div class="form-group" id="IdDip">
            <label for="niveau">Diplôme</label>
            <select name="diplome" id="diplome" class="form-control">

          </select>
      </div>

      <div class="form-group">
            <label for="code">Code UE</label>
            <input type="text" class="form-control" id="code_ue" name="code_ue">
      </div>
      <div class="form-group">
            <label for="libelle">Libelle UE</label>
            <input type="text" class="form-control" id="lib_ue" name="lib_ue">
      </div>

      <div class="form-group">
          <input id="btn" class="btn btn-primary" type="submit" name="add_ue" value="Envoyer">
      </div>


<!--</form>-->
</div>
</div>

<script>

    $(function () {

        $("#niveau").change(function (event) {
            remplirDiplome();
        });

    //On recupère la variable de session et on cache les champs qu'on recupere directement
    var profil = <?php echo json_encode($_SESSION['profil']); ?> ;
        if(profil==2){
            $("#IdNiv").hide();
            $("#IdDip").hide();
        }

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
    $("#btn").click(function (event) {
        var profil = <?php echo json_encode($_SESSION['profil']); ?> ;
        if(profil==2){
            var code_diplome = <?php echo json_encode($_SESSION['code_diplome']); ?> ;
        }else if(profil==1){
            var code_diplome = $('#diplome').val();
        }

        var code_ue = $('#code_ue').val();
        var lib_ue = $('#lib_ue').val();
        $.ajax({
            type: 'post',
            url: 'add_ue_ajax.php',
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            data:{code_ue:code_ue, lib_ue:lib_ue, code_diplome:code_diplome},
            success : function(){
                alert("UE ajouté");
                $('#code_ue').val('');
                $('#lib_ue').val('');

            },
            error: function () {
                alert("Ce code est déjà utilisé");
            }
        });
    });
});

</script>
</body>


</html>
