<?php  include ("../backend/connexion_bdd.php"); ?>
<?php

//delete.php

if(isset($_POST["id"]))
{
    
 $query = "
 DELETE from seance WHERE num_seance=:id
 ";
 $statement = $bdd->prepare($query);
 $statement->execute(
  array(
   ':id' => $_POST['id']
  )
 );
}

?>