<?php

//connexion à la base de données
include("connexion_bdd.php");

// Suppression d'utilisateur selectionné
if (isset($_GET['id_user'])){
    $id=$_GET['id_user'];

    //Pour supprimer un utilisateur
   $delete = $bdd -> query('DELETE  FROM utilisateur WHERE identifiant_user='.$id.'') or die(print_r($bdd->errorInfo()));

}
header('Location:profil.php?page=view_utilisateurs');
?>
