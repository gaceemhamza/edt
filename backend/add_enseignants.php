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
<h3 class="h3">Ajouter un enseignant</h3>

<form action="<?php $_SERVER['PHP_SELF']?>" method="post"  enctype="multipart/form-data">
      <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" class="form-control" name="nom" required>

            <label for="prenom">Prénom</label>
            <input type="text" class="form-control" name="prenom" required>

            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" required>

            <label for="tel">Téléphone</label>
            <input type="tel" class="form-control" name="tel" pattern="[0-9]{10}" title="10 chiffres" required>

          <input class="btn btn-primary" type="submit" name="add_ens" value="Envoyer">
      </div>

</form>
</div>
<!-- Traitement des données du formulaire -->
<?php

if(isset($_POST['add_ens'])) {

    $nom        = $_POST['nom'];
    $prenom     = $_POST['prenom'];
    $email      = $_POST['email'];
    $tel        = $_POST['tel'];


    $sql = 'INSERT INTO enseignant(nom_enseignant, prenom_enseignant, mail_enseignant, tel_enseignant ) ';

    $sql.= 'VALUES(:nom, :prenom, :email, :tel)';

    $prep = $bdd->prepare($sql);

    $result=$prep->execute(array(
        'nom' =>$nom,
        'prenom' =>$prenom,
        'email' =>$email,
        'tel' =>$tel
    ));

    header('Location:profil.php?page=view_enseignants');
}
?>
</div>
<?php include('footer.php');?>
