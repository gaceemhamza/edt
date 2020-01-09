<?php

//connexion à la base de données
include("connexion_bdd.php");

// Suppression du diplome selectionné
if (isset($_GET['id_matiere'])){
    $id=$_GET['id_matiere'];

    //requete de suppression
   $delete = $bdd -> query('DELETE  FROM matiere WHERE num_matiere="'.$id.'"') or die(print_r($bdd->errorInfo()));

}
header('Location:profil.php?page=view_matiere');
?>
