<?php

//connexion à la base de données
include("connexion_bdd.php");

// Suppression une UE
if (isset($_GET['id_ue'])){
    $id=$_GET['id_ue'];
   
    //requete de suppression
   $delete = $bdd -> query('DELETE  FROM ue WHERE code_ue="'.$id.'"') or die(print_r($bdd->errorInfo()));
    
}
header('Location:profil.php?page=view_ue'); 
?>