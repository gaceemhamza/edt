<?php
include("connexion_bdd.php");
include("functions.php");
include('verify_session.php');
include('head.php');
include('menu.php');

if(isset($_GET['id_ens'])) {

   $id_ens=$_GET['id_ens'];

    $sql = 'select * from enseignant where num_enseignant= :id_ens';

    $result = $bdd->prepare($sql);

    $result->execute(array('id_ens' =>$id_ens));

    while($row = $result->fetch()) {
            $ens_id            = $row['num_enseignant'];
            $ens_name          = $row['nom_enseignant'];
            $ens_firstname     = $row['prenom_enseignant'];
            $ens_mail          = $row['mail_enseignant'];
            $ens_tel           = $row['tel_enseignant'];
    }
}

if(isset($_POST['edit_ens'])){

    $nom        = $_POST['nom'];
    $prenom     = $_POST['prenom'];
    $email      = $_POST['email'];
    $tel        = $_POST['tel'];

        $sql = 'UPDATE enseignant SET nom_enseignant=:nom, prenom_enseignant=:prenom, mail_enseignant=:email, tel_enseignant=:tel where num_enseignant=:id_ens';

        $result = $bdd->prepare($sql);

        $result->execute(array(
            'nom' =>$nom,
            'prenom' =>$prenom,
            'email' =>$email,
            'tel' =>$tel,
            'id_ens'=>$id_ens
        ));
        header('Location:profil.php?page=view_enseignants');

}
?>
<div class="contenu" >
    <h3>Modifier un enseignant</h3>

     <form action="" method="post" enctype="multipart/form-data">

      <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" class="form-control" name="nom" value="<?php echo $ens_name ?>">

            <label for="nom">Prenom</label>
            <input type="text" class="form-control" name="prenom" value="<?php echo $ens_firstname  ?>" >

            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" value="<?php echo $ens_mail  ?>">

            <label for="tel">Téléphone</label>
            <input type="tel" class="form-control" name="tel" value="<?php echo $ens_tel ?>" pattern="[0-9]{10}" title="10 chiffres" >

          <input class="btn btn-primary" type="submit" name="edit_ens" value="Modifier">
      </div>

    </form>
    </div>
<?php include('footer.php'); ?>
