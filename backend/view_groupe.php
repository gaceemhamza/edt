<?php
include("connexion_bdd.php");
// demarrage de la session et recupération de l'utilisateur connecté
include('verify_session.php');
?>
<script>
        $(function(){
            $('#box').hide();
            $('#occurence').hide();
        });
</script>
    <div class="table-responsive">

         <!-- Mettre le diplome de l'utilisateur connecté si il n'est pas administrateur-->
        <div id="libelle" class="h1" align="center"><?php
            //recuperer le profil de l'utilisateur ($_SESSION['profil'])
            $profil=$_SESSION['profil'];
            $id_user=$_SESSION['id'];
            $code_diplome=$_SESSION['code_diplome'];

            $req="SELECT niveau, libelle_diplome FROM diplome
                  Join gerer on gerer.code_diplome=diplome.code_diplome AND  gerer.identifiant_user=$id_user;";

            $libelle=$bdd->query($req) or die(print_r($bdd->errorInfo()));

            $detail=$libelle->fetch();

            //longueur de la chaine retournee
            $niveau=strlen($detail['niveau']);
            $libel=strlen($detail['niveau']);

            //Recupérer son diplome et l'afficher
            if($profil != 1 && $niveau == 0 && $libel == 0){

                echo "<script>alert(\"Vous n\'êtes associez à aucun diplôme, contacter l\'administrateur\")</script>";
            }
            elseif($profil !=1 && $niveau != 0 && $libel != 0){
                echo $detail['niveau']." ".$detail['libelle_diplome'];
            }elseif($profil == 1){
                echo "Tableau de bord groupe";
            }
         ?></div>

        <!--Zone de Recherche-->
        <?php if($profil==1){ //on affiche le formulaire pour l'administrateur?>
            <script>
                $(function(){$('#box').show();})
            </script>
        <?php } ?>

        <form id="box" class="form-inline" method="post" action="<?php $_SERVER['PHP_SELF']?>">

          <div style="margin-left:auto; margin-right:auto;"  class="alert alert-primary"><input class="form-control mr-sm-2" name="diplome" id="diplome" type="text" placeholder="code diplome en Majuscule" required>
          <button class="btn btn-outline-success my-2 my-sm-0" name="recherche" type="submit">Recherche</button></div>
        </form>

        <!-- Mettre le nombre de groupe contenu dans le diplome-->
        <div id="occurence" style="margin-left:auto; margin-right:auto; width: 15rem; " class="card-header"></div>

        <!-- Mettre toute la table une colonne dans un div pour le centrer-->
    <div class="container">
    <div class="col-md-10 offset-md-1">
    <table  align="center" class="table table-striped">
    <thead>
    <tr><td colspan="3" align="right"><a href="add_groupe.php" class="btn btn-danger">Ajouter Groupe</a></td></tr>
    <tr>
      <th scope="col">Libellé</th>
      <th scope="col"  colspan="2">Actions</th>
    </tr>
    </thead>
    <tbody class="table table-hover">
        <?php

        //compteurs occurrence des resultats
        $i=0;

        // faire la recherche en fonction des profils
        if($profil==1){ //administrateur
                    //recuperation de la saisie de recherche
                    if(isset($_POST['recherche']) && $_POST['diplome']!="trie par diplome"){
                        $degree = $_POST['diplome'];
                        //rechercher l'utilisateur saisi
                        $ligne = $bdd->query('SELECT * From groupe where code_diplome LIKE "%'.$degree.'%" ORDER BY libelle_groupe ASC;') or die(print_r($bdd->errorInfo()));
                    }
                    else if(empty($_POST['diplome'])){

                        //lecture de tous enregistrements par groupe de 20
                    $ligne = $bdd->query('SELECT * From groupe ORDER BY libelle_groupe ASC;') or die(print_r($bdd->errorInfo()));
                    }
            } else { //editeurs
              $ligne = $bdd->query("SELECT * From groupe
                                    WHERE code_diplome = '$code_diplome' ORDER BY libelle_groupe ASC;") or die(print_r($bdd->errorInfo()));

              /*  $ligne = $bdd->query("SELECT * From groupe
                                      join diplome on groupe.code_diplome = diplome.code_diplome
                                      join gerer on diplome.code_diplome = gerer.code_diplome
                                      AND gerer.identifiant_user = $id_user ORDER BY libelle_groupe ASC;") or die(print_r($bdd->errorInfo())); */

            }
        //recuperation des informations de chaque ligne
        while ($information = $ligne->fetch()){

            //Affichage des actifs et inactifs de la liste
            $i+=1;

        ?>
        <tr>
           <!-- <td><?php //echo ++$i; ?></td> -->
            <td><?php echo $information['libelle_groupe']; ?></td>
            <td><a href="edit_groupe.php?groupe_id=<?php echo $information['num_groupe'];?>"><img class="icon" src="img/update.png" alt="editer"/></a></td>
            <td>
                <a href="delete_groupe.php?groupe_id=<?php echo $information['num_groupe'];?>" onclick="return(confirm('Voulez vous supprimer <?php echo $information['libelle_groupe']."? "; ?>'))"><img class="icon" src="img/delete.png" alt="supprimer"/></td>
        </tr>
        <?php
          };
          $ligne->closeCursor();
        ?>
    </tbody>
    </table>
        </div>
        </div>
    </div>
    <script>
        $(function(){
            var occ = <?php echo json_encode($i); ?>;

            if(occ ==0 ){
                document.getElementById("occurence").innerHTML= "Aucun groupe trouvé";
                        $("#occurence").show();
            } else if(occ > 1){
                document.getElementById("occurence").innerHTML= occ+" groupes trouvés ";
                        $("#occurence").show();
            }
        });
    </script>

    <!--Pluggin Jquery UI Important pour l'auto completion  -->
    <script type="application/javascript" src="jquery-ui/js/jquery-1.9.1.js"></script>
    <script type="application/javascript" src="jquery-ui/js/jquery-ui-1.10.3.custom.js"></script>

    <script type="application/javascript">
        $(function(){
        $("#diplome").on('input', function() {
        $("#diplome").autocomplete({source: 'autocomplete.php?req='+$("#diplome").val()});
        });
        });
    </script>
</body>
</html>
