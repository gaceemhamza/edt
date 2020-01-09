<?php
include ("../backend/connexion_bdd.php");
include ("verify_session.php");
$code_dip=$_SESSION['code_diplome'];
// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=EDT_'.$code_dip.'.csv');
print "\xEF\xBB\xBF";

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// output the column headings
fputcsv($output, array('Date', 'Heure début', 'Heure fin', ' Salle','Enseignant', 'Enseignement','Code UE'),';');

// fetch the data
$sql= "SELECT seance.libelle_seance, seance.start_seance, seance.end_seance, seance.groupe_seance, seance.type_seance, seance.num_salle, seance.enseignant_seance, ue.code_ue FROM seance join matiere on seance.num_matiere=matiere.num_matiere join ue on matiere.code_ue=ue.code_ue join diplome on ue.code_diplome=diplome.code_diplome where diplome.code_diplome='{$code_dip}' ORDER BY num_seance";
$req = $bdd->prepare($sql);
$req->execute();
$result = $req->fetchAll();
// loop over the rows, outputting them
foreach($result as $row){
    fputcsv($output, array(date('Y-m-d',strtotime($row['start_seance'])), date('H:i',strtotime($row['start_seance'])), date('H:i',strtotime($row['end_seance'])), $row['num_salle'], $row['enseignant_seance'], $row['libelle_seance'], $row['code_ue']),';');
}

fclose($output);
?>
