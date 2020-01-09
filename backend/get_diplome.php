<?php
include("connexion_bdd.php");
include('verify_session.php');

$niveau= $_POST['niveau'];
//si l'utilisateur connecté est admin
if($_SESSION['profil']==1){$sql = "SELECT * FROM diplome where niveau=:niveau ";
                        }else if($_SESSION['profil']==2){//l'utilisateur connecté est un éditeur
                            $codeD = $_SESSION['code_diplome'];
                            $sql = "SELECT * FROM diplome where niveau=:niveau and code_diplome=:code_diplome";

                        }
$result = $bdd->prepare($sql);

if($_SESSION['profil']==1){
    $result->execute(array('niveau'=>$niveau));}
else if($_SESSION['profil']==2){
    $result->execute(array('niveau'=>$niveau,'code_diplome'=>$codeD));
}

while($row = $result->fetch()) {
    $code_diplome=$row['code_diplome'];
    $lib_diplome = $row['libelle_diplome'];
    $retour .= "<option value='$code_diplome'>{$lib_diplome}</option>";
}
echo $retour;
?>
