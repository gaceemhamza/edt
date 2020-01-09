<?php
include("connexion_bdd.php");
include("functions.php");
include('head.php');
include('menu.php');

if(isset($_GET['id_diplome'])) {

    $code_diplome=$_GET['id_diplome'];

    $sql = 'SELECT * FROM diplome where code_diplome=:code_diplome';
    $result = $bdd->prepare($sql);
    $result->execute(array('code_diplome' =>$code_diplome));
    while($row = $result->fetch()) {
        $code_diplome       = $row['code_diplome'];
        $niveau             = $row['niveau'];
        $libelle_diplome    = $row['libelle_diplome'];
        $annee_debut        = $row['annee_debut'];
        $annee_fin          = $row['annee_fin'];
    }
}


if(isset($_POST['edit_dip'])) {

    $code_diplome_edit  = $_POST['code_diplome'];
    $niveau	            = $_POST['niveau'];
    $libelle_diplome    = $_POST['libelle_diplome'];
    $annee_debut        = $_POST['anneeD'];
    $annee_fin          = $_POST['anneeF'];

    $sql = 'SELECT * FROM diplome where code_diplome= :code_diplome';
    $result = $bdd->prepare($sql);
    $result->execute(array('code_diplome' =>$code_diplome_edit));
    $count = $result->rowCount();
    if($count > 0 && $code_diplome_edit!=$code_diplome){
         echo 'Ce code est déjà utilisé';
    }
    else{

        $sql = 'UPDATE diplome SET code_diplome=:code_diplome_edit, niveau=:niveau, libelle_diplome=:libelle_diplome, annee_debut=:annee_debut, annee_fin=:annee_fin where code_diplome =:code_diplome';

        $prep = $bdd->prepare($sql);

        $result=$prep->execute(array(
            'code_diplome_edit' =>$code_diplome_edit,
            'niveau' =>$niveau,
            'libelle_diplome' =>$libelle_diplome,
            'annee_debut' =>$annee_debut,
            'annee_fin' =>$annee_fin,
            'code_diplome'=>$code_diplome
        ));
        header('Location:profil.php?page=view_diplome');
    }
}
?>
<div class="contenu" >
    <div class="row">

    <div class="col-md-5 offset-md-3">
    <h3>Modifier un Diplome</h3>

     <form action="" method="post" enctype="multipart/form-data">

      <div class="form-group">
            <label for="code_diplome">code de diplome</label>
            <input type="text" class="form-control" name="code_diplome" value="<?php echo $code_diplome ?>">
      </div>
      <div class="form-group">
            <label for="niveau">Niveau</label>
            <select name="niveau" id="niveau" class="form-control">
                <option selected value="<?php echo $niveau ?>"><?php echo $niveau ?></option>
                <option value="L1">L1</option>
                <option value="L2">L2</option>
                <option value="L3">L3</option>
                <option value="M1">M1</option>
                <option value="M2">M2</option>
            </select>
        </div>
      <div class="form-group">
            <label for="libelle_diplome">libelle de diplome</label>
            <input type="text" class="form-control" name="libelle_diplome" value="<?php echo $libelle_diplome ?>">
      </div>
      <div class="form-group">
            <label for="anneeD">Année de début</label>
            <select name="anneeD" id="anneeD" class="form-control">


            </select>
      </div>
      <div class="form-group">
            <label for="anneeF">Année de fin</label>
            <input type="text" id="anneeF" class="form-control" name="anneeF" value="<?php echo $annee_fin ?>">

      </div>
      <div class="form-group">
          <input class="btn btn-primary" type="submit" name="edit_dip" value="Modifier">
      </div>


</form>
</div>
</div>
</div>
<script>

    var year = 2019;
    var end = 2050;
    var options = "<option selected>"+ <?php echo $annee_debut ?> +"</option>";
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
<?php include('footer.php'); ?>
