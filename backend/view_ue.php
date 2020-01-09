<?php
// demarrage de la session et recupération de l'utilisateur connecté
include('verify_session.php');

?>
    <div class="table-responsive">
        <H1 class="h1" align="center" id="titreEditeur"><?php echo $_SESSION['niveau']." ".$_SESSION['libelle_diplome'] ; ?></H1>
    <!--Zone de Recherche-->
        <form id="SearchBox" class="form-inline" method="post" action="<?php $_SERVER['PHP_SELF']?>">
        <div style="margin-left:auto; margin-right:auto;"  class="alert alert-primary">
          <input class="form-control mr-sm-2" name="element"  list="diplome" type="text" placeholder="choisir diplome" required>
          <datalist id="diplome">
            <?php
               //Recupération de la liste des diplomes
                $diplome = $bdd->query('SELECT * From diplome ORDER BY libelle_diplome ASC') or die(print_r($bdd->errorInfo()));

            //affichage des diplomes tant qu'il y en a
                 while($degree= $diplome->fetch()){
                       echo "<option value=\"".$degree['code_diplome']."\">".$degree['code_diplome']."-->".$degree['libelle_diplome']."</option>";
                   }
            ?>
            </datalist>
            <button class="btn btn-outline-success my-2 my-sm-0" name="recherche" type="submit">Recherche</button>
            </div>
        </form>
    <div class="container">
    <div class="col-md-10 offset-md-1">
    <table  align="center" class="table table-striped">
    <thead>
    <tr><td colspan="6" align="right"><a href="add_ue.php" class="btn btn-danger">Ajouter UE</a></td></tr>
    <tr>
      <!--<th scope="col">Ordre</th> -->
      
      <th scope="col" id="dipTitre">Diplôme</th>
      <th scope="col">Code</th>
      <th scope="col">Libellé</th>
      <th scope="col"  colspan="2">Actions</th>
    </tr>
    </thead>
    <tbody class="table table-hover">
        <?php

        //recuperation de la saisie de recherche
        if(isset($_POST['element']) && ($_POST['element'])!="choisir diplome"){

            $choix=addslashes($_POST['element']);

            $ue = $bdd->query('SELECT code_ue, libelle_ue, niveau, libelle_diplome From ue
            join diplome on ue.code_diplome=diplome.code_diplome
            Where ue.code_diplome  regexp "'.$choix.'" ORDER BY libelle_diplome, libelle_ue, code_ue ASC') or die(print_r($bdd->errorInfo()));

        }
        else{

            //si l'utilisateur est un administrateur
            if($_SESSION['profil']==1){
            //lecture de tous enregistrements
            $ue = $bdd->query('SELECT code_ue, libelle_ue, niveau, libelle_diplome From ue
            join diplome on ue.code_diplome=diplome.code_diplome ORDER BY libelle_diplome, libelle_ue, code_ue ASC') or die(print_r($bdd->errorInfo()));

            }else if($_SESSION['profil']==2){ //connexion d'un éditeur
            //Lecture des enregistrements de sa promotion
             $ue = $bdd->query('SELECT code_ue, libelle_ue, niveau, libelle_diplome From ue
             join diplome on ue.code_diplome=diplome.code_diplome
             where ue.code_diplome regexp "'.$_SESSION['code_diplome'].'" ORDER BY libelle_diplome, libelle_ue, code_ue ASC') or die(print_r($bdd->errorInfo()));

            }
    }
        //recuperation des informations de chaque ligne
        while ($contenu = $ue->fetch()){

        ?>
        <tr>
           <!-- <td><?php //echo ++$i; ?></td> -->
            <td class="dipValeur"><?php echo $contenu['niveau']." ".$contenu['libelle_diplome']; ?></td>
            <td><?php echo $contenu['code_ue']; ?></td>
            <td><?php echo $contenu['libelle_ue']; ?></td>
            <td><a href="edit_ue.php?id_ue=<?php echo $contenu['code_ue'];?>" ><img class="icon" src="img/update.png" alt="editer"/></a></td>
            <td>
                <a href="delete_ue.php?id_ue=<?php echo $contenu['code_ue'];?>" onclick="return(confirm('Voulez vous supprimer <?php echo $contenu['libelle_ue']."? "; ?>'))"><img class="icon" src="img/delete.png" alt="supprimer"/></a></td>
        </tr>
        <?php
          };
          $ue->closeCursor();
        ?>

    </table>
            </div>
        </div>
    </div>
        <script>
            $(function(){

             //On cache les titres et le formulaire de recherche qui seront affichés en fonction du profil utilisateur
                $('#titreAdmin').hide();
                $('#titreEditeur').hide();
                $('#SearchBox').hide();

                //la colonne diplome
                $('#dipTitre').hide();
                $('.dipValeur').hide();

            //On recupère la variable de session et on affiche le titre adéquat
            var profil = <?php echo json_encode( $_SESSION['profil']); ?> ;

            if(profil==1){
                $('#titreAdmin').show();
                $('#SearchBox').show();
                $('#dipTitre').show();
                $('.dipValeur').show();
            }else{
                $('#titreEditeur').show();

            }

            })
        </script>
