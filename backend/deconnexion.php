<?php
// demarrage de la session et recupération de l'utilisateur connecté
if(session_status()==PHP_SESSION_NONE){
    session_start();
    }
if(isset($_POST['deconnect'])){
    session_destroy();
    header('Location: ../index.php');
}

?>

<!-- <!DOCTYPE html>
<html>
<head>
    <title>DECONNEXION</title>
    <meta charset="utf-8">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body> -->
    <!-- Pour le bouton deconnexion-->
    <!-- <form method="post" action="<?php // $_SERVER['PHP_SELF']?>">
             <input class="btn btn-danger btn-sm" type="submit" name="deconnect" value="Deconnexion">
    </form>
</body>
</html> -->
