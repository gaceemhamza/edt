<?php include ("connexion_bdd.php") ?>
<?php

$diplome= $_POST['diplome'];

$sql = "SELECT * FROM ue where code_diplome=:diplome ";
$result = $bdd->prepare($sql);
$result->execute(array('diplome'=>$diplome));
while($row = $result->fetch()) {
    $code_ue=$row['code_ue'];
    $libelle_ue = $row['libelle_ue'];
    $retour .= "<option value='$code_ue'>{$libelle_ue}</option>";
}
echo $retour;
?>
