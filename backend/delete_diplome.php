<?php

//connexion à la base de données
include("connexion_bdd.php");

// Suppression du diplome selectionné
if (isset($_GET['id_diplome'])){
    $id=$_GET['id_diplome'];

    //requete de suppression
   $delete = $bdd -> query('DELETE  FROM diplome WHERE code_diplome="'.$id.'"') or die(print_r($bdd->errorInfo()));

}
header('Location:profil.php?page=view_diplome');
?>
