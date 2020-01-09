<?php  include ("../backend/connexion_bdd.php"); ?>
<?php 

$niveau= $_POST['niveau'];

$sql = "SELECT * FROM diplome where niveau=:niveau ";
$result = $bdd->prepare($sql); 
$result->execute(array('niveau'=>$niveau));
while($row = $result->fetch()) {
    $code_diplome=$row['code_diplome'];
    $lib_diplome = $row['libelle_diplome'];
    $retour .= "<option value='$code_diplome'>{$lib_diplome}</option>";
}
echo $retour;
?>