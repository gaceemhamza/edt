<div class="table-responsive">
<!--Zone de Recherche-->

<nav class="navbar navbar-light bg-light justify-content-between">
    <a class="navbar-brand"></a>
    <form class="form-inline" method="post">
        <input class="form-control mr-sm-2" name="listdegree" list="diplomes" placeholder="Rechercher un diplôme">
        <datalist id="diplomes">
        <?php
           //Recupération de la liste des diplomes
            $diplome = $bdd->query('SELECT * From diplome ORDER BY libelle_diplome ASC') or die(print_r($bdd->errorInfo()));

        //affichage des diplomes tant qu'il y en a
             while($degree= $diplome->fetch()){
                   echo "<option value=\"".$degree['code_diplome']."\">".$degree['code_diplome']."-->".$degree['libelle_diplome']."</option>";
               }
        ?>
        </datalist>
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Recherche</button>
    </form>
</nav>
<table  align="center" class="table table-striped">
<thead>
<tr>
 <!-- <th scope="col">Ordre</th> -->
  <th scope="col">Nom</th>
  <th scope="col">Prénom(s)</th>
  <th scope="col">Email</th>
  <th scope="col">Téléphone</th>
  <th scope="col">Matière(s)</th>
  <th scope="col"  colspan="2">Actions</th>
</tr>
</thead>
<tbody class="table table-hover">
    <?php

    //compteurs
    $i=0;

    //occurrences
    $occEns=0;

    //recuperation de la saisie de recherche
    if(isset($_POST['listdegree']) && $_POST['listdegree']!="Rechercher un dipl"){
        //rechercher l'utilisateur saisi
        $ligne = $bdd->query('SELECT * From enseignant
                              join intervenir  on enseignant.num_enseignant = intervenir.num_enseignant
                              where intervenir.code_diplome regexp "'.$_POST['listdegree'].'" ORDER BY nom_enseignant ASC') or die(print_r($bdd->errorInfo()));
    }
    else if(empty($_POST['listdegree'])){

        //lecture de tous enregistrements par groupe de 20
       $ligne = $bdd->query('SELECT * From enseignant ORDER BY nom_enseignant ASC LIMIT 0,20') or die(print_r($bdd->errorInfo()));
    }
    //recuperation des informations de chaque ligne
    while ($enseignant = $ligne->fetch()){

        //On compte le nombre de ligne
        $occEns+=1;
    ?>
    <tr>
        <!-- <td><?php // echo ++$i; ?></td> -->
        <td><?php echo $enseignant['nom_enseignant']; ?></td>
        <td><?php echo $enseignant['prenom_enseignant']; ?></td>
        <td><?php echo $enseignant['mail_enseignant']; ?></td>
        <td><?php echo $enseignant['tel_enseignant']; ?></td>
        <td><ul class="list-group"><?php
            //recupération des matière enseignées de chaque enseignant
           // $champs="matiere.num_matiere, matiere.libelle_matiere, enseigner.num_enseignant, enseigner.volume_horaire, ue.libelle_ue, diplome.code_diplome";
           $champs="matiere.num_matiere, matiere.libelle_matiere, enseigner.num_enseignant, ue.libelle_ue, diplome.code_diplome";

           //1er cas: l'utilisateur ne fait pas de tri par diplome
            if(empty($_POST['listdegree'])){
            $matieres_prof = $bdd->query('SELECT DISTINCT '.$champs.'
                                        From matiere Join enseigner
                                        on matiere.num_matiere = enseigner.num_matiere
                                        join enseignant on enseigner.num_enseignant= '.$enseignant['num_enseignant'].'
                                        join ue on ue.code_ue = matiere.code_ue
                                        join diplome on diplome.code_diplome = ue.code_diplome
                                        ');
                                    }else{
            //2e cas: l'utilisateur fait un affichage par diplome
            $diplome=$_POST['listdegree'];
            $matieres_prof = $bdd->query('SELECT DISTINCT '.$champs.'
                                From matiere Join enseigner
                                on matiere.num_matiere = enseigner.num_matiere
                                join enseignant on enseigner.num_enseignant= '.$enseignant['num_enseignant'].'
                                join ue on ue.code_ue = matiere.code_ue
                                join diplome on diplome.code_diplome = ue.code_diplome
                                where diplome.code_diplome regexp "'.$diplome.'"
                                ');
                                }
                    //affichage des matières tant qu'il y en a
                    while($matiere= $matieres_prof->fetch()){
                        echo "<li  class=\"list-group-item d-flex justify-content-between align-items-center\">".$matiere['libelle_matiere']." <b>(".$matiere['code_diplome'].")</b></li>";

                    }
            ?></ul></td>
        <td><a href="edit_enseignants.php?id_ens=<?php echo $enseignant['num_enseignant'];?>"><img class="icon" src="img/update.png" alt="editer"/></a></td>
        <td>
            <a href="delete_enseignants.php?id_ens=<?php echo $enseignant['num_enseignant'];?>" onclick="return(confirm('Voulez vous supprimer <?php echo $enseignant['prenom_enseignant'].' '.$enseignant['nom_enseignant']."? "; ?>'))"><img class="icon" src="img/delete.png" alt="supprimer"/></td>
    </tr>
    <?php
      };
      $ligne->closeCursor();
    ?>
</tbody>
    <br/>
<nav class="container text-center"><section  class="btn alert-warning"><?php if($occEns==0) {echo "Aucun enseignant trouvé";} else if ($occEns==1) {?><span class="badge badge-danger"><?php echo $occEns;?></span> Enseignant trouvé<?php } else {?><span class="badge badge-danger"><?php echo $occEns;?></span> Enseignants trouvés<?php } ?>
    </section>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="add_enseignants.php" class="btn btn-danger">Ajouter un enseignant</a>
    <a href="#" class="btn btn-danger">Assigner un diplôme</a>
    <a href="#" class="btn btn-danger">Assigner une matière</a>
    </nav>
    <br/>

</table>
    </div>
