<?php
//demarrer la session
if(session_status()==PHP_SESSION_NONE){
    session_start();
    }
include("connexion_bdd.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>CONNEXION</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script>
        $(function(){$('#Erreur').hide();})
</script>
</head>
<body>
<?php
//recuperation des données du formulaire
if(isset($_POST['login']) && isset($_POST['psw']))
{
    $identifiant=$_POST['login'];
    $password=$_POST['psw'];


//traitement attendu
$req="SELECT utilisateur.identifiant_user,nom_user, prenom_user, num_profil, diplome.code_diplome, niveau, libelle_diplome FROM utilisateur
join gerer on utilisateur.identifiant_user = gerer.identifiant_user
join diplome on gerer.code_diplome = diplome.code_diplome
WHERE etat=1 AND login_user regexp '$identifiant' AND mdp_user regexp '$password'";

$utilisateur=$bdd->query($req) or die(print_r($bdd->errorInfo()));

$detail = $utilisateur->fetch();

if($detail){

          $_SESSION['id']=$detail['identifiant_user'];
          $_SESSION['nom']=$detail['nom_user'];
          $_SESSION['prenom']=$detail['prenom_user'];
          $_SESSION['profil']=$detail['num_profil'];
          $_SESSION['code_diplome']=$detail['code_diplome'];
          $_SESSION['niveau']=$detail['niveau'];
          $_SESSION['libelle_diplome']=$detail['libelle_diplome'];
          $_SESSION['date'] = date("d-m-Y");

          header('Location: profil.php');

          //echo "BIENVENUE ". $_SESSION['nom']." ".$_SESSION['prenom'];
}
else{

     echo "<script>
     $(document).ready(function(){
     $ ('#Erreur').text(\"Login ou mot de passe incorrect ou Aucune liaison avec un diplôme\");
     $ ('#Erreur').show();
     });
     </script>";
}
}
//on recupère le diplome gérer par l'utilisateur


?>

<div class="container_login">
<div id="Erreur" class="alert alert-danger" style="display:hidden;"></div>
<a href="https://www.univ-tlse2.fr/" target="_blank"><img id="logo_JJ"src="imgs/logo_JJ.png" alt="Université Jean Jaurès" height="40px" width="167.33px"></a><br><br>
<img id="logo_EDT" src="imgs/logo_EDT.png" alt="DDAME-EDT" height="120px" width="127px"></a>
  <h2 class="h2_login" >Connexion à EDT-DDAME</h2>
  <!-- Trigger the modal with a button -->
  <button type="button" class="login" id="myBtn">&nbsp;Login</button>
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:35px 50px;">
          <h4><span class="glyphicon glyphicon-lock"></span> &nbsp;Connectez-vous</h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
          <form role="form" method="POST" action="<?php $_SERVER['PHP_SELF']?>">
            <div class="form-group">
              <label for="login"><span class="glyphicon glyphicon-user"></span>&nbsp;Login</label>
              <input type="text" class="form-control" name="login" id="login" placeholder="votre identifiant" required>
            </div>
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Password</label>
              <input type="password" class="form-control" name="psw" id="psw" placeholder="Votre mot de passe" required>
            </div>

              <button type="submit" name="connexion" class="btn btn-success btn-block"><span class="glyphicon glyphicon-off"></span>&nbsp;Connexion</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>&nbsp;Retour</button>
        </div>
      </div>

    </div>
  </div>
</div>
<footer>&#169; DDAME - 2019</footer>
<script>
$(document).ready(function(){
  $("#myBtn").click(function(){
    $("#myModal").modal();

  });
});
</script>

</body>
</html>
