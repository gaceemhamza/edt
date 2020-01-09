<?php
    include("connexion_bdd.php");
    include("functions.php");
    include('verify_session.php');
    include('head.php');
    include('menu.php');

if(isset($_POST['add_ue'])) {
        $code_ue          = $_POST['code_ue'];
        $libelle_ue       = $_POST['lib_ue'];

    if($_SESSION['profil']==1){
        $code_diplome     = $_POST['diplome'];

    }else if($_SESSION['profil']==2){
        $code_diplome     = $_SESSION['code_diplome'];
    }


    $sql = 'SELECT * FROM ue where code_ue=:code_ue';
    $result = $bdd->prepare($sql);
    $result->execute(array('code_ue' =>$code_ue));
    $count = $result->rowCount();
    if($count > 0){
         echo ('<script>alert(\'Ce code est déjà utilisé\')</script>');
    }
    else{

        $sql = 'INSERT INTO ue (code_ue, libelle_ue, code_diplome) ';

        $sql.= 'VALUES(:code_ue, :libelle_ue, :code_dip)';

        $prep = $bdd->prepare($sql);

        $result=$prep->execute(array(
            'code_ue' =>$code_ue,
            'libelle_ue' =>$libelle_ue,
            'code_dip' =>$code_diplome
        ));
        header('Location: index.php?page=view_ue');
    }
}
?>

<div class="contenu">
    <div class="row">
    <div class="col-md-5 offset-md-3">
    <h3>Ajouter une UE</h3>

     <form action="" method="post" enctype="multipart/form-data">

      <div class="form-group">
            <label for="code">Code UE</label>
            <input type="text" class="form-control" name="code_ue" required>
      </div>
      <div class="form-group">
            <label for="libelle">Libelle UE</label>
            <input type="text" class="form-control" name="lib_ue" required>
      </div>
      <div class="form-group" id="IdNiv">
            <label for="niveau">Niveau</label>
            <select name="niveau" id="niveau" class="form-control" required>
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
            <label for="niveau">Diplome</label>
            <select name="diplome" id="diplome" class="form-control">

          </select>
      </div>
      <div class="form-group">
          <input class="btn btn-primary" type="submit" name="add_ue" value="Envoyer">
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

</script>
<?php include('footer.php');?>
