
<?php

//load.php

include ("../backend/connexion_bdd.php");
//echo $_GET['diplome'];
$code_dip= $_GET['diplome'];

$data = array();

$query = "SELECT * FROM seance where groupe_seance='{$code_dip}' ORDER BY num_seance";

$statement = $bdd->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

foreach($result as $row)
{
 $data[] = array(
  'id'   => $row["num_seance"],
  'title'   => utf8_encode($row["libelle_seance"]),
  'start'   => $row["start_seance"],
  'end'   => $row["end_seance"],
  'groupe' => utf8_encode($row["groupe_seance"]),
  'nature' => utf8_encode($row["type_seance"]),
  'color' => $row["color_seance"],
  'salle' => utf8_encode($row["num_salle"]),
  'enseignant' => utf8_encode($row["enseignant_seance"]),
  'commentaire' => utf8_encode($row["commentaire"])
 );
  /* echo $row["num_seance"];
    echo $row["libelle_seance"];
    echo $row["start_seance"];
    echo $row["end_seance"];*/

}
$newJsonString = json_encode($data);
file_put_contents('json/events_'.$code_dip.'.json', $newJsonString);
echo json_encode($data);

//header('Location: index.php');
?>
