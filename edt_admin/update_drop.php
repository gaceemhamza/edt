<?php include ("../backend/connexion_bdd.php");?>
<?php

//update.php

if(isset($_POST["id"]))
{
 $query = "
 UPDATE seance 
 SET start_seance=:start_seance, end_seance=:end_seance
 WHERE num_seance=:id
 ";
 $statement = $bdd->prepare($query);
 $statement->execute(
  array(
   ':start_seance' => $_POST['start'],
   ':end_seance' => $_POST['end'],
   ':id'   => $_POST['id']
  )
 );
}

?>