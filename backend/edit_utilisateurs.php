<?php
include("connexion_bdd.php");
include("functions.php");
include('verify_session.php');
include('head.php');
include('menu.php');

if(isset($_GET['user_id'])) {

   $id_user=$_GET['user_id'];

    $sql = 'select * from utilisateur where identifiant_user= :id_user';

    $result = $bdd->prepare($sql);

    $result->execute(array('id_user' =>$id_user));

    while($row = $result->fetch()) {
            $user_id            = $row['identifiant_user'];
            $user_login         = $row['login_user'];
            $user_password      = $row['mdp_user'];
            $user_name          = $row['nom_user'];
            $user_firstname     = $row['prenom_user'];
            $user_mail          = $row['mail_user'];
            $user_id_profil     = $row['num_profil'];
    }
    $sql = 'SELECT * FROM profil where num_profil=:id_profil';
    $result = $bdd->prepare($sql);
    $result->execute(array('id_profil' =>$user_id_profil));
    while($row = $result->fetch()) {
        $profil_id = $row['num_profil'];
        $profil = $row['libelle_profil'];
    }
}

if(isset($_POST['edit_user'])){


    $login      = $_POST['login'];
    $password   = $_POST['mdp'];
    $nom        = $_POST['nom'];
    $prenom     = $_POST['prenom'];
    $email      = $_POST['email'];
    $profil_id  = $_POST['profil'];

    if(!empty($password)){

        $password   = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

        $sql = 'UPDATE utilisateur SET login_user=:login, mdp_user=:password, nom_user=:nom, prenom_user=:prenom, mail_user=:email, num_profil=:profil_id where identifiant_user=:user_id';

        $result = $bdd->prepare($sql);

        $result->execute(array(
            'login' =>$login,
            'password' =>$password,
            'nom' =>$nom,
            'prenom' =>$prenom,
            'email' =>$email,
            'profil_id' =>$profil_id,
            'user_id'=>$user_id
        ));
        header('Location:profil.php?page=view_utilisateurs');
    }else{
        $sql = 'UPDATE utilisateur SET login_user=:login, nom_user=:nom, prenom_user=:prenom, mail_user=:email, num_profil=:profil_id where identifiant_user=:user_id';

        $result = $bdd->prepare($sql);

        $result->execute(array(
            'login' =>$login,
            'nom' =>$nom,
            'prenom' =>$prenom,
            'email' =>$email,
            'profil_id' =>$profil_id,
            'user_id'=>$user_id
        ));
        header('Location:profil.php?page=view_utilisateurs');
    }

}
?>
    <div class="contenu" >
    <h3>Modifier un utilisateur</h3>

     <form action="" method="post" enctype="multipart/form-data">

      <div class="form-group">
         <label for="login" >Login</label>
          <input type="text" class="form-control" name="login" value="<?php echo $user_login ?>">

             <label for="mdp">Mot de passe</label>
            <input type="password" class="form-control" name="mdp"value="<?php //echo $user_password ?>" >

            <label for="nom">Nom</label>
            <input type="text" class="form-control" name="nom" value="<?php echo $user_name ?>">

            <label for="nom">Prenom</label>
            <input type="text" class="form-control" name="prenom" value="<?php echo $user_firstname ?>">

            <label for="email">Email</label>
            <input type="text" class="form-control" name="email" value="<?php echo $user_mail ?>">

       <label for="profil">profil</label>
       <select name="profil" id="" class="form-control">
          <?php echo "<option value='$profil_id'>{$profil}</option>";?>
            <?php select_profils(); ?>
      </select>

          <input class="btn btn-primary" type="submit" name="edit_user" value="Modifier">
      </div>
    </div>


</form>
<?php include('footer.php'); ?>
