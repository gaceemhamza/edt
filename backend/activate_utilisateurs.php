<?php

//connexion à la base de données
include("connexion_bdd.php");

//Activation et désactivation d'utilisateur

if (isset($_GET['id_user']) && $_GET['etat']==1){
    //Pour desactiver un utilisateur
    $desactivate = $bdd -> query('UPDATE  utilisateur SET etat=0 WHERE identifiant_user='.$_GET['id_user'].'') or die(print_r($bdd->errorInfo()));

}
else if(isset($_GET['id_user']) && $_GET['etat']==0){

    $activate = $bdd -> query('UPDATE  utilisateur SET etat=1 WHERE identifiant_user='.$_GET['id_user'].'') or die(print_r($bdd->errorInfo()));
}
//header('Location: index.php?page=view_utilisateurs.php');
header('Location:profil.php?page=view_utilisateurs'); 
?>
