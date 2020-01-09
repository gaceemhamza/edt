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

if(isset($_GET['id_ue'])) {

    //global $code_ue;
        $code_ue=$_GET['id_ue'];

    if($_SESSION['profil']==1){
        $sql = 'select * from ue where code_ue=:code_ue';
        $result = $bdd->prepare($sql);
        $result->execute(array('code_ue' =>$code_ue));

        while($row = $result->fetch()) {
                $code_ue            = $row['code_ue'];
                $libelle_ue         = $row['libelle_ue'];
        }


    } elseif($_SESSION['profil']==2){

        $codeD = $_SESSION['code_diplome'];
        $sql = 'select * from ue where code_ue=:code_ue AND code_diplome=:code_diplome';
        $result = $bdd->prepare($sql);
        $result->execute(array('code_ue' =>$code_ue, 'code_diplome'=>$codeD));

        while($row = $result->fetch()) {
                $code_ue            = $row['code_ue'];
                $libelle_ue         = $row['libelle_ue'];
                $code_diplome       = $row['code_diplome'];
        }
    }

    $sql = 'SELECT * FROM diplome where code_diplome=:code_diplome';
    $result = $bdd->prepare($sql);
    $result->execute(array('code_diplome' =>$code_diplome));
    while($row = $result->fetch()) {
        $code_diplome   = $row['code_diplome'];
        $niveau         = $row['niveau'];
         $lib_diplome    = $row['libelle_diplome'];
    }
}

if(isset($_POST['edit_ue'])) {

    $code_ue_edit     = $_POST['code_ue'];
    $libelle_ue       = $_POST['lib_ue'];

    $code_diplome = $_POST['diplome'];
    $sql = 'SELECT * FROM ue where code_ue=:code_ue';
    $result = $bdd->prepare($sql);
    $result->execute(array('code_ue' =>$code_ue_edit));


    $count = $result->rowCount();
    if($count > 0 && $code_ue_edit!=$code_ue){
         echo ('<script>alert(\'Ce code est déjà utilisé\')</script>');
    }
    else{

        $sql = 'UPDATE ue SET code_ue=:code_ue_edit, libelle_ue=:libelle_ue, code_diplome=:code_diplome where code_ue =:code_ue';

     //   $result = $bdd->prepare($sql);

        $prep = $bdd->prepare($sql);
        $result=$prep->execute(array(
            'code_ue_edit' =>$code_ue_edit,
            'libelle_ue' =>$libelle_ue,
            'code_diplome' =>$code_diplome,
            'code_ue' =>$code_ue
        ));

        header('Location:profil.php?page=view_ue');
    }
}
?>
<div class="contenu">
    <div class="row">
    <div class="col-md-5 offset-md-3">
    <h3>Modifier une UE</h3>

     <form action="" method="post" enctype="multipart/form-data">

      <div class="form-group">
            <label for="code">Code UE</label>
            <input type="text" class="form-control" name="code_ue" value="<?php echo $code_ue ?>">
      </div>
      <div class="form-group">
            <label for="libelle">Libelle UE</label>
            <input type="text" class="form-control" name="lib_ue" value="<?php echo $libelle_ue ?>">
      </div>
       <div class="form-group" id="IdNiv">
            <label for="niveau">Niveau</label>
            <select name="niveau" id="niveau" class="form-control">
               <?php echo "<option value='$niveau'>{$niveau}</option>";?>
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
            <label for="diplome">Diplome</label>
            <select name="diplome" id="diplome" class="form-control">
                <?php echo "<option value='$code_diplome'>{$lib_diplome}</option>";?>
          </select>
      </div>
      <div class="form-group">
          <input class="btn btn-primary" type="submit" name="edit_ue" value="Modifier">
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

        //On recupère la variable de session
    var profil = <?php echo json_encode($_SESSION['profil']); ?> ;
        if(profil==2){ //editeur chargé d'un diplome
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
