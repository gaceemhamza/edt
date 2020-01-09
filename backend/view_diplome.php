    <div class="table-responsive">
    <!--Zone de Recherche-->
        <form class="form-inline" method="post" action="<?php $_SERVER['PHP_SELF']?>">
        <div class="alert alert-primary" style="margin-left:auto; margin-right:auto;">
          <input class="form-control mr-sm-2" name="item"  type="text" placeholder="saisir recherche" required>
          <select name="colonne">
                    <option value="all">Tous les champs</option>
                    <option value="code_diplome">code</option>
                    <option value="niveau">niveau</option>
                    <option value="libelle_diplome">libelle</option>
                    <option value="annee_debut">Annee de debut</option>
                    <option value="annee_fin">Annee de fin</option>

          </select>
            <button class="btn btn-outline-success my-2 my-sm-0" name="recherche" type="submit">Recherche</button>
       </div>
        </form>

    <table  align="center" class="table table-striped">
    <thead>
    <tr><td colspan="6" align="right"><a href="add_diplome.php" class="btn btn-danger">Ajouter Diplôme</a></td></tr>
    <tr>
      <!--<th scope="col">Ordre</th> -->
      <th scope="col">Code</th>
      <th scope="col">Niveau</th>
      <th scope="col">Libellé</th>
      <th scope="col">Année Académique</th>
      <th scope="col"  colspan="2"></th>
    </tr>
    </thead>
    <tbody class="table table-hover">
        <?php


        //recuperation de la saisie de recherche
        if(isset($_POST['colonne']) && isset($_POST['item'])){
            $champs=$_POST['colonne'];
            $choix=$_POST['item'];

            //recherche en fonction de critère choisi
            if($champs != "all"){

                $diplome = $bdd->query('SELECT * From diplome Where '.$champs.' regexp "'.$choix.'" ORDER BY niveau ASC') or die(print_r($bdd->errorInfo()));

            } else if($champs == "all"){
                $diplome = $bdd->query("SELECT * FROM diplome WHERE (code_diplome LIKE '%$choix%')
                OR (niveau LIKE '%$choix%')
                OR (libelle_diplome LIKE '%$choix%')
                OR (annee_debut LIKE '%$choix%')
                OR (annee_fin LIKE '%$choix%')
                ORDER BY niveau ASC") or die(print_r($bdd->errorInfo()));

            }

                   }
        else{

            //lecture de tous enregistrements par groupe de 20
           $diplome = $bdd->query('SELECT * From diplome ORDER BY niveau') or die(print_r($bdd->errorInfo()));
        }
        //recuperation des informations de chaque ligne
        while ($contenu = $diplome->fetch()){

        ?>
        <tr>
           <!-- <td><?php //echo ++$i; ?></td> -->
            <td><?php echo $contenu['code_diplome']; ?></td>
            <td><?php echo $contenu['niveau']; ?></td>
            <td><?php echo $contenu['libelle_diplome']; ?></td>
            <td><?php echo $contenu['annee_debut']." - ".$contenu['annee_fin']; ?></td>
            <td><a href="edit_diplome.php?id_diplome=<?php echo $contenu['code_diplome'];?>"><img class="icon" src="img/update.png" alt="editer"/></a></td>
            <td>
                <a href="delete_diplome.php?id_diplome=<?php echo $contenu['code_diplome'];?>" onclick="return(confirm('Voulez vous supprimer <?php echo $contenu['libelle_diplome']."? "; ?>'))"><img class="icon" src="img/delete.png" alt="supprimer"/></td>
        </tr>
        <?php
          };
          $diplome->closeCursor();
        ?>

    </table>
        </div>
