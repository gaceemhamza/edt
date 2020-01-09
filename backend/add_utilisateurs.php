<?php
include("connexion_bdd.php");
include("functions.php");
include('verify_session.php');
include('head.php');
include('menu.php');
?>
<div class="contenu">
    <h3 class="h3">Ajouter un utilisateur</h3>

     <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">

      <div class="form-group">
         <label for="login" >Login</label>
          <input type="text" class="form-control"  name="login" required>

             <label for="mdp">Mot de passe</label>
            <input type="password" class="form-control"  name="mdp" required>

            <label for="nom">Nom</label>
            <input type="text" class="form-control" name="nom" required>

            <label for="prenom">Prénom</label>
            <input type="text" class="form-control" name="prenom" required>

            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" required>

       <label for="profil">Profil</label>
       <select name="profil" id="" class="form-control">
           <option selected>Choisir un profil</option>
            <?php select_profils(); ?>
      </select><br>
          <input class="btn btn-primary" type="submit" name="add_user" value="Enregistrer">
      </div>

</form>

<?php
if(isset($_POST['add_user'])){

    //add_users();
    $login      = $_POST['login'];
    $password   = $_POST['mdp'];
    $nom        = $_POST['nom'];
    $prenom     = $_POST['prenom'];
    $email      = $_POST['email'];
    $profil_id  = $_POST['profil'];
    // $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));

    $sql = 'SELECT * FROM utilisateur where login_user= :login';
    $result = $bdd->prepare($sql);
    $result->execute(array('login' =>$login));
    $count = $result->fetchColumn();
    if($count > 0){
         echo 'Ce login est déjà utilisé';
    }
    else{

    $sql = "INSERT INTO utilisateur (login_user, mdp_user, mail_user, nom_user, prenom_user, num_profil, etat)
            VALUES ('$login','$password','$email','$nom','$prenom','$profil_id',0)";
    $insertion=$bdd->query($sql); }
    header('Location:profil.php?page=view_utilisateurs');
}

?>
</div>
<?php include('footer.php');?>
