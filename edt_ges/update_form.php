<?php  include ("../backend/connexion_bdd.php"); ?>
<?php


if(isset($_POST["id"]))
{
 $query = "
 UPDATE seance
 SET num_salle=:num_salle, commentaire=:commentaire
 WHERE num_seance=:id
 ";
 $statement = $bdd->prepare($query);
 $statement->execute(
array(

    ':num_salle' => $_POST['salle'],

    ':commentaire' => $_POST['commentaire'],

    ':id'   => $_POST['id']
)
);
 //header('location:index.php');
}

?>
