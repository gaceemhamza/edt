<div class="table-responsive">
<!--Zone de Recherche-->
<nav class="navbar navbar-light bg-light justify-content-between">
    <a class="navbar-brand"></a>
    <form class="form-inline" method="post">
      <input class="form-control mr-sm-2" name="username"  type="text" placeholder="Rechercher un utilisateur">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Recherche</button>
    </form>
</nav>
<table  align="center" class="table table-striped">
<thead>
<tr>
  <!--<th scope="col">Ordre</th> -->
  <th scope="col">Nom</th>
  <th scope="col">Prénom(s)</th>
  <th scope="col">Email</th>
  <th scope="col">Profil</th>
  <th scope="col">Diplome</th>
  <th scope="col">Login</th>
  <th scope="col">État</th>
  <th scope="col"  colspan="2">Actions</th>
</tr>
</thead>
<tbody class="table table-hover">
    <?php

    //compteurs
    $i=0;

    //occurrences
    $occActif=0;
    $occInactif=0;

    //recuperation de la saisie de recherche
    if(isset($_POST['username']) && $_POST['username']!="Rechercher un utilisateur"){
        //rechercher l'utilisateur saisi
        $ligne = $bdd->query('SELECT * From utilisateur where nom_user LIKE "%'.$_POST['username'].'%"
                             OR prenom_user LIKE "%'.$_POST['username'].'%" ORDER BY nom_user ASC LIMIT 0,20 ') or die(print_r($bdd->errorInfo()));
    }
    else if(empty($_POST['username'])){

        //lecture de tous enregistrements par groupe de 20
       $ligne = $bdd->query('SELECT * From utilisateur ORDER BY nom_user ASC LIMIT 0,20') or die(print_r($bdd->errorInfo()));
    }
    //recuperation des informations de chaque ligne
    while ($information = $ligne->fetch()){

        //Affichage des actifs et inactifs de la liste
        if($information['etat']==1) $occActif+=1;
        else $occInactif+=1;
    ?>
    <tr>
       <!-- <td><?php //echo ++$i; ?></td> -->
        <td><?php echo $information['nom_user']; ?></td>
        <td><?php echo $information['prenom_user']; ?></td>
        <td><?php echo $information['mail_user']; ?></td>
        <td><?php

            $profil = $bdd->query('SELECT * From profil where num_profil='.$information['num_profil'].'');
            $nomprofil= $profil->fetch();
            echo $nomprofil['libelle_profil'];
            ?></td>
            <td><?php
              $diplome = $bdd->query('SELECT code_diplome From gerer where identifiant_user='.$information['identifiant_user'].'');
              $codeD= $diplome->fetch();
              echo $codeD['code_diplome'];
        ?></td>
            <td><?php echo $information['login_user']; ?></td>
        <td><?php
            if($information['etat']==1) {?><a title="Activé" href="activate_utilisateurs.php?id_user=<?php echo $information['identifiant_user']."&amp;etat=".$information['etat']; ?>" onclick="return(confirm('Désactivation de  <?php echo $information['prenom_user'].' '.$information['nom_user']."? "; ?>'))"><img class="icon" src="img/validation.png" alt="Actif"/></a>
          <?php }else {?><a title="Desactivé" href="activate_utilisateurs.php?id_user=<?php echo $information['identifiant_user']."&amp;etat=".$information['etat']; ?>" onclick="return(confirm('Activation de <?php echo $information['prenom_user'].' '.$information['nom_user']."? "; ?>'))"><img src="img/inactif.png" class="icon" alt="inactif"/></a>
            <?php }; ?>
        </td>
        <td><a href="edit_utilisateurs.php?user_id=<?php echo $information['identifiant_user'];?>" ><img class="icon" src="img/update.png" alt="editer"/></a></td>
        <td>
            <a href="delete_utilisateurs.php?id_user=<?php echo $information['identifiant_user'];?>" onclick="return(confirm('Voulez vous supprimer <?php echo $information['prenom_user'].' '.$information['nom_user']."? "; ?>'))"><img class="icon" src="img/delete.png" alt="supprimer"/></td>
    </tr>
    <?php
      };
      $ligne->closeCursor();
    ?>
</tbody>
<tfoot>
<nav  class="container text-center"><article class="btn alert-primary">Utilisateurs actifs <span class="badge badge-success"><?php echo $occActif;?></span>
    </article>&nbsp;&nbsp;<article class="btn alert-warning">Utilisateurs inactifs <span class="badge badge-danger"><?php echo $occInactif;?></span></article>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="add_utilisateurs.php" class="btn btn-danger">Ajouter un utilisateur</a>
    <a href="add_affectation.php" class="btn btn-danger">Assigner un diplôme</a>
  </nav>
</tfoot>
</table>
    </div>
