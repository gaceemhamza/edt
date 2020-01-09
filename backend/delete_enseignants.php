<?php

//connexion à la base de données
include("connexion_bdd.php");

// Suppression d'utilisateur selectionné
if (isset($_GET['id_ens'])){
    $id=$_GET['id_ens'];

    //Pour supprimer un utilisateur
   $delete = $bdd -> query('DELETE FROM enseignant  WHERE num_enseignant='.$id.'') or die(print_r($bdd->errorInfo()));

}
header('Location: profil.php?page=view_enseignants');
?>
