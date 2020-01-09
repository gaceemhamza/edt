<?php include ("../backend/connexion_bdd.php"); ?>
<?php


if(isset($_POST["id"]))
{
 $query = "
 UPDATE seance 
 SET libelle_seance=:libelle_seance, num_salle=:num_salle, color_seance=:color_seance, commentaire=:commentaire, type_seance=:type_seance
 WHERE num_seance=:id
 ";
 $statement = $bdd->prepare($query);
 $statement->execute(
array(
    ':libelle_seance' => $_POST['title'],
    ':num_salle' => $_POST['salle'],
    ':color_seance' => $_POST['color'],
    ':commentaire' => $_POST['commentaire'],
    ':type_seance' => $_POST['nature'],
    ':id'   => $_POST['id']
)
);
}
header('location:index.php');
?>