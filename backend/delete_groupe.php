<?php

//connexion à la base de données
include("connexion_bdd.php");

// Suppression du diplome selectionné
if (isset($_GET['groupe_id'])){
    $id=$_GET['groupe_id'];

    //requete de suppression
   $delete = $bdd -> query('DELETE  FROM groupe WHERE num_groupe="'.$id.'"') or die(print_r($bdd->errorInfo()));

}
header('Location:profil.php?page=view_groupe');
?>
