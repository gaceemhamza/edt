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

if(isset($_POST['add_groupe'])) {

  if($_POST['nature']=='groupe principal'){

      $nature            = $_POST['nature'];
      $libelle_groupe    = $_POST['libelle_groupe'];
      $code_diplome      = $_SESSION['code_diplome'];
      $sql = "INSERT INTO groupe (libelle_groupe, nature_groupe, code_diplome) VALUES('$libelle_groupe', '$nature', '$code_diplome')";
      $insertion=$bdd->query($sql);
      // $sql.= 'VALUES(:libelle_groupe, :nature_groupe, :code_diplome)';
      // $prep = $bdd->prepare($sql);
      // $result=$prep->execute(array(
      //     'libelle_groupe' =>$libelle_groupe,
      //     'nature_groupe' =>$nature,
      //     'code_diplome' =>$code_diplome
      //));
  header('Location:profil.php?page=view_groupe');
    // echo "<script>alert('$libelle_groupe')</script>";  //
  }
    if($_POST['nature']=='sous-groupe'){

        $nature            = $_POST['nature'];
        $num_group         = $_POST['groupe'];
        $libelle_groupe    = $_POST['libelle_groupe'];
        $code_diplome      = $_SESSION['code_diplome'];
        $sql = 'INSERT INTO groupe (libelle_groupe, nature_groupe, code_diplome, num_groupe_compose) ';
        $sql.= 'VALUES(:libelle_groupe, :nature_groupe, :code_diplome, :num_groupe_compose)';
        $prep = $bdd->prepare($sql);
        $result=$prep->execute(array(
            'libelle_groupe' =>$libelle_groupe,
            'nature_groupe' =>$nature,
            'num_groupe_compose' =>$num_group,
            'code_diplome' =>$code_diplome
        ));
    } // header('Location:index.php?page=view_groupe');
}
?>
<div class="contenu">
    <div class="row">

    <div class="col-md-5 offset-md-3">
    <h3>Ajouter un groupe ou sous-groupe</h3>

     <form action="" method="post" enctype="multipart/form-data">


      <div class="form-group">
            <label for="nature">Nature de groupe</label>
            <select name="nature" id="nature" class="form-control">
                <option selected>Choisir la nature du groupe</option>
                <option value="groupe principal">Groupe principal</option>
                <option value="sous-groupe">Sous-groupe</option>
            </select>
        </div>

        <div class="form-group" id="groupe">
         <label for="profil">Groupe</label>
       <select name="groupe"  class="form-control">
           <option selected>Choisir un groupe</option>
            <?php
                if($_SESSION['profil']==1){//administrateur
                    $sql = "SELECT * FROM groupe";

                }else if($_SESSION['profil']==2){//editeur
                    $sql = "SELECT num_groupe, libelle_groupe FROM groupe where code_diplome='{$code_diplome}'";
                }
                $result = $bdd->query($sql);
                while($row = $result->fetch()) {
                    $groupe_id = $row['num_groupe'];
                    $groupe = $row['libelle_groupe'];
                    echo "<option value='$groupe_id'>{$groupe}</option>";
                }

            ?>
      </select>
      </div>

      <div class="form-group">
            <label for="libelle_groupe">Libelle</label>
            <input type="text" class="form-control" name="libelle_groupe">
      </div>


      <div class="form-group">
          <input class="btn btn-primary" type="submit" name="add_groupe" value="Envoyer">
      </div>


</form>
</div>
</div>
</div>
<script>


    $(function() {
        $("#groupe").hide();
        var natGp;
        $("#nature").change(function (event) {
            natGp= $("#nature").val();
            if(natGp=="groupe principal"){
                $("#groupe").hide();
            }else{
                $("#groupe").show();
            }
        });
    });

</script>
<?php include('footer.php');?>
