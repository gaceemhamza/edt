<?php
// demarrage de la session et recupération de l'utilisateur connecté
if(session_status()==PHP_SESSION_NONE){
    session_start();

    }
if(empty($_SESSION['id'])){
    header('Location:../index.php');
}
?>
