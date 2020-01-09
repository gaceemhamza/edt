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

if(isset($_POST['add_aff'])) {

    $user_id           = $_POST['utilisateur'];
    $code_diplome      = $_POST['diplome'];
    $test=0;
    $sql = 'select * from gerer';
    $result = $bdd->query($sql);
    while($row = $result->fetch()) {
        $id_user=$row['identifiant_user'];
        $code_dip=$row['code_diplome'];
        if($code_dip==$code_diplome && $user_id==$id_user ){
            echo "<script> alert(\"Cet utilisateur est déja affecté à un diplôme\") </script>";
            $test=1;
        }
    }

    if($test==0){
        $sql = 'INSERT INTO gerer (identifiant_user, code_diplome) VALUES(:user_id, :code_diplome)';
        $prep = $bdd->prepare($sql);
        $result=$prep->execute(array(
            'user_id' =>$user_id,
            'code_diplome' =>$code_diplome
        ));
        header('Location:profil.php?page=view_utilisateurs');

    }


}
?>
<div class="contenu">
<div class="row">

    <div class="col-md-6 offset-md-3">
    <h3>Assigner un utilisateur à une diplôme</h3>

     <form action="" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="utilisateur">Utilisateur</label>
            <select name="utilisateur" id="utilisateur" class="form-control">
               <option selected>Choisir un utilisateur</option>
                <?php
                    $sql = "SELECT * FROM utilisateur ORDER BY nom_user ASC";
                    $result = $bdd->query($sql);
                    while($row = $result->fetch()) {
                        $utilisateur_id = $row['identifiant_user'];
                        $nom= $row['nom_user'];
                        $prenom= $row['prenom_user'];
                        $utilisateur=$nom." ".$prenom;
                        echo "<option value='$utilisateur_id'>{$utilisateur}</option>";
                    }
               ?>
            </select>
        </div>

        <div class="form-group">
            <label for="diplome">Diplôme</label>
            <select name="diplome" id="diplome" class="form-control">
               <option selected>Choisir un diplome</option>
                <?php
                    $sql = 'SELECT * FROM diplome ORDER BY libelle_diplome ASC';
                    $result = $bdd->query($sql);
                    while($row = $result->fetch()) {
                        $code_diplome       = $row['code_diplome'];
                        $libelle_diplome    = $row['libelle_diplome'];
                        echo "<option value='$code_diplome'>{$libelle_diplome }</option>";
                    }

               ?>
            </select>
        </div>

      <div class="form-group">
          <input class="btn btn-primary" type="submit" name="add_aff" value="Assigner">
      </div>


</form>
</div>
</div>
</div>
<script>

    $("#groupe").hide();

    $(function () {
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
