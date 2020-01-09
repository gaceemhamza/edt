<?php
include("connexion_bdd.php");

if(isset($_POST['code_ue'])) {
        $code_ue          = $_POST['code_ue'];
        $libelle_ue       = $_POST['lib_ue'];
        $code_diplome     = $_POST['code_diplome'];

   /* if($_SESSION['profil']==1){
        $code_diplome     = $_POST['code_diplome'];

    }else if($_SESSION['profil']==2){
        $code_diplome     = $_SESSION['code_diplome'];
    }*/


    // $sql = 'SELECT * FROM ue where code_ue=:code_ue';
    // $result = $bdd->prepare($sql);
    // $result->execute(array('code_ue' =>$code_ue));
    // $count = $result->rowCount();
    // if($count > 0){
    //      echo 'Ce code est déjà utilisé';
    // }
    // else{

        $sql = 'INSERT INTO ue (code_ue, libelle_ue, code_diplome) ';

        $sql.= 'VALUES(:code_ue, :libelle_ue, :code_dip)';

        $prep = $bdd->prepare($sql);

        $result=$prep->execute(array(
            'code_ue' =>$code_ue,
            'libelle_ue' =>$libelle_ue,
            'code_dip' =>$code_diplome
        ));
       // header('Location:view_ue.php');
    // }
}

?>
