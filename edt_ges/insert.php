<?php  include ("../backend/connexion_bdd.php"); ?>
<?php
//insert.php

if(isset($_POST["title"]))
{
        $sql ="SELECT * FROM enseignant where num_enseignant=:num_enseignant";
        $req = $bdd->prepare($sql);
        $req->execute(array( 'num_enseignant' => $_POST['enseignant']));
        //$prof = $req->fetchAll();
        while($prof = $req->fetch()) {
            $nom=$prof['nom_enseignant'];
            $prenom=$prof['prenom_enseignant'];


        $enseignant=$nom.' '.$prenom;   
        }   
    
        $query = "
        INSERT INTO seance (libelle_seance, num_matiere, start_seance, end_seance, groupe_seance, type_seance, commentaire,color_seance, num_salle, num_enseignant, enseignant_seance) VALUES (:libelle_seance, :num_matiere, :start_seance, :end_seance, :groupe_seance, :type_seance, :commentaire, :color_seance, :salle, :num_enseignant, :enseignant_seance)";
        $statement = $bdd->prepare($query);
        $statement->execute(
        array(
            'libelle_seance'  => $_POST['title'],
            'num_matiere'  => $_POST['matiere'],
            'start_seance'  => $_POST['start'],
            'end_seance'  => $_POST['end'],
            'groupe_seance'  => $_POST['groupe'],
            'type_seance'  => $_POST['nature'],
            'commentaire'  => $_POST['commentaire'],
            'color_seance'  => $_POST['color'],
            'num_enseignant'  => $_POST['enseignant'],
            'enseignant_seance'  => $enseignant,
            'salle'  => $_POST['salle']
        )
        );


}

header('Location: '.$_SERVER['HTTP_REFERER']);


?>