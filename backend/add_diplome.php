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

if(isset($_POST['add_dip'])) {

    $code_diplome       = $_POST['code_diplome'];
    $niveau	            = $_POST['niveau'];
    $libelle_diplome    = $_POST['libelle_diplome'];
    $annee_debut        = $_POST['anneeD'];
    $annee_fin          = $_POST['anneeF'];

    $sql = 'SELECT * FROM diplome where code_diplome= :code_diplome';
    $result = $bdd->prepare($sql);
    $result->execute(array('code_diplome' =>$code_diplome));
    $count = $result->rowCount();
    if($count > 0){
         echo 'Ce code est déjà utilisé';
    }
    else{

        $sql = 'INSERT INTO diplome (code_diplome, niveau, libelle_diplome, annee_debut, annee_fin ) ';

        $sql.= 'VALUES(:code_diplome, :niveau, :libelle_diplome, :annee_debut, :annee_fin)';

        $prep = $bdd->prepare($sql);

        $result=$prep->execute(array(
            'code_diplome' =>$code_diplome,
            'niveau' =>$niveau,
            'libelle_diplome' =>$libelle_diplome,
            'annee_debut' =>$annee_debut,
            'annee_fin' =>$annee_fin
        ));
        header('Location:profil.php?page=view_diplome');
    }
}
?>
<div class="contenu">
    <div class="row">
    <div class="col-md-5 offset-md-3">
    <h3>Ajouter un diplôme</h3>

     <form action="" method="post" enctype="multipart/form-data">

      <div class="form-group">
            <label for="code_diplome">Code du diplôme</label>
            <input type="text" class="form-control" name="code_diplome">
      </div>
      <div class="form-group">
            <label for="niveau">Niveau</label>
            <select name="niveau" id="niveau" class="form-control">
                <option selected>Choisir un niveau</option>
                <option value="L1">L1</option>
                <option value="L2">L2</option>
                <option value="L3">L3</option>
                <option value="M1">M1</option>
                <option value="M2">M2</option>
            </select>
        </div>
      <div class="form-group">
            <label for="libelle_diplome">Nom</label>
            <input type="text" class="form-control" name="libelle_diplome">
      </div>
      <div class="form-group">
            <label for="anneeD">Année de début</label>
            <select name="anneeD" id="anneeD" class="form-control">

            </select>
      </div>
      <div class="form-group">
            <label for="anneeF">Année de fin</label>
            <input type="text" id="anneeF" class="form-control" name="anneeF" value="Choisir une année">
            <!--<select name="anneeF" id="anneeF" class="form-control">
                <option selected>Année de fin</option>
            </select>-->
      </div>
      <div class="form-group">
          <input class="btn btn-primary" type="submit" name="add_dip" value="Envoyer">
      </div>


</form>
</div>
</div>
</div>
<script>

    var year = 2019;
    var end = 2050;
    var options = "<option selected>Choisir une année</option>";
    for(var y=year; y<=end; y++){
      options += "<option>"+ y +"</option>";
    }
    document.getElementById("anneeD").innerHTML = options;

    $(function () {
        var anneeF;
        var anneeD
        $("#anneeD").change(function (event) {
            anneeD= $("#anneeD").val();
            anneeF=parseInt(anneeD)+1;

            $("#anneeF").val(anneeF);
        });
    });

    </script>
<?php include('footer.php');?>
