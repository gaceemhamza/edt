
<?php

include ("verify_session.php");
include ("../backend/connexion_bdd.php");
$code_dip=$_SESSION['code_diplome'];

$data = array();

$query = "SELECT seance.num_seance, seance.libelle_seance, seance.start_seance, seance.end_seance, seance.groupe_seance, seance.type_seance, seance.color_seance, seance.num_salle, seance.enseignant_seance FROM seance join matiere on seance.num_matiere=matiere.num_matiere join ue on matiere.code_ue=ue.code_ue join diplome on ue.code_diplome=diplome.code_diplome where diplome.code_diplome='{$code_dip}' ORDER BY num_seance";
//echo $query;
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
  'enseignant' => utf8_encode($row["enseignant_seance"])
  //'commentaire' => utf8_encode($row["commentaire"])
 );
    //echo $row["enseignant_seance"];
    //echo $row["libelle_seance"];
    //echo $row["start_seance"];

}

$newJsonString = json_encode($data);
file_put_contents('json/events_'.$code_dip.'.json', $newJsonString);

echo json_encode($data);


?>
