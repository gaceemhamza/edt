<?php include ("../backend/connexion_bdd.php"); ?>
<?php 

$ue= $_POST['ue'];

$sql = "SELECT * FROM matiere where code_ue=:ue ";
$result = $bdd->prepare($sql); 
$result->execute(array('ue'=>$ue));
while($row = $result->fetch()) {
    $num_matiere=$row['num_matiere'];
    $libelle_matiere = $row['libelle_matiere'];
    $retour .= "<option value='$num_matiere'>{$libelle_matiere}</option>";
}
echo $retour;
?>