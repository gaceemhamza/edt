<?php
include("connexion_bdd.php");
include("verify_session.php");
?>
<!DOCTYPE html>
<html>
    <!--Fichier a adapter en fonction des valeur à modifier-->
<head>
<title>LISTE ENSEIGNANTS</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script></script>
</head>
<body>
    <div class="table-responsive">
        <H1 class="h1" align="center" id="titreAdmin">Tableau de bord Enseignant</H1>
        <H1 class="h1" align="center" id="titreEditeur"><?php echo $_SESSION['niveau']." ".$_SESSION['libelle_diplome'] ; ?></H1>

    <!--Zone de Recherche-->
    <form id="SearchBox" class="form-inline" method="post" action="<?php $_SERVER['PHP_SELF']?>">
        <div style="margin-left:auto; margin-right:auto;"  class="alert alert-primary">
            <input class="form-control mr-sm-2" name="listdegree" list="diplomes" placeholder="libellé diplome">
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
                </div>
        </form>
    <table  align="center" class="table table-striped">
    <thead>
    <tr>
     <!-- <th scope="col">Ordre</th> -->
      <th scope="col">Nom</th>
      <th scope="col">Prenom(s)</th>
      <th scope="col">Email</th>
      <th scope="col">Telephone</th>
      <th scope="col">Matières</th>
      <th scope="col"  colspan="2"></th>
    </tr>
    </thead>
    <tbody class="table table-hover">
        <?php

        //compteurs
        $i=0;

        //occurrences
        $occEns=0;

        //recuperation de la saisie de recherche
        if(isset($_POST['listdegree']) && $_POST['listdegree']!="libellé diplome"){
            //rechercher l'utilisateur saisi
            $ligne = $bdd->query('SELECT * From enseignant
                                  join intervenir  on enseignant.num_enseignant = intervenir.num_enseignant
                                  where intervenir.code_diplome regexp "'.$_POST['listdegree'].'" ORDER BY nom_enseignant ASC') or die(print_r($bdd->errorInfo()));
        }
        else if(empty($_POST['listdegree'])){

            //lecture de tous enregistrements par groupe de 20
            if($_SESSION['profil']==1){
                $ligne = $bdd->query('SELECT * From enseignant ORDER BY nom_enseignant ASC') or die(print_r($bdd->errorInfo()));
            }else if($_SESSION['profil']==2){
                $ligne = $bdd->query('SELECT * From enseignant
                                  join intervenir  on enseignant.num_enseignant = intervenir.num_enseignant
                                  where intervenir.code_diplome regexp "'.$_SESSION['code_diplome'].'" ORDER BY nom_enseignant ASC') or die(print_r($bdd->errorInfo()));
            }
           
        }

        //icone distinguant enseignant simple et enseignant avec un profil -->
        $info = $bdd->query('SELECT * From utilisateur') or die(print_r($bdd->errorInfo()));

        //creation du tableau d'email
        $list=array();
        while($icon = $info ->fetch()){
            array_push($list,$icon['mail_user']);

        }

            $info->closeCursor();

        //recuperation des informations de chaque ligne d'enseignant
        while ($enseignant = $ligne->fetch()){

            //On compte le nombre de ligne
            $occEns+=1;
        ?>
        <tr>
            <td><?php echo $enseignant['nom_enseignant']; ?></td>
            <td><?php echo $enseignant['prenom_enseignant']; ?></td>
            <td><?php echo $enseignant['mail_enseignant']; ?></td>
            <td><?php echo $enseignant['tel_enseignant']; ?></td>
            <td><ul class="list-group"><?php

               //1er cas: l'utilisateur ne fait pas de tri par diplome
                if(empty($_POST['listdegree'])){ //on distingue les utilisateurs
                    if($_SESSION['profil']==1){//administrateur
                        //recupération des matière enseignées de chaque enseignant
                        $champs="matiere.num_matiere, matiere.libelle_matiere, enseigner.num_enseignant, ue.libelle_ue, diplome.code_diplome";
                        $matieres_prof = $bdd->query('SELECT DISTINCT '.$champs.'
                        From matiere Join enseigner
                        on matiere.num_matiere = enseigner.num_matiere
                        join enseignant on enseigner.num_enseignant= '.$enseignant['num_enseignant'].'
                        join ue on ue.code_ue = matiere.code_ue
                        join diplome on diplome.code_diplome = ue.code_diplome');

                    } else if($_SESSION['profil']==2){ //editeur
                        //recupération des matière enseignées de chaque enseignant
                        $diplome=$_SESSION['code_diplome'];
                       $champs="matiere.num_matiere, matiere.libelle_matiere, enseigner.num_enseignant, ue.libelle_ue, diplome.code_diplome";
                        $matieres_prof = $bdd->query('SELECT DISTINCT '.$champs.'
                         From matiere Join enseigner
                         on matiere.num_matiere = enseigner.num_matiere
                         join enseignant on enseigner.num_enseignant= '.$enseignant['num_enseignant'].'
                         join ue on ue.code_ue = matiere.code_ue
                         join diplome on diplome.code_diplome = ue.code_diplome where diplome.code_diplome regexp "'.$diplome.'"');

                        /* $req='SELECT DISTINCT '.$champs.'
                         From matiere Join enseigner
                         on matiere.num_matiere = enseigner.num_matiere
                         join enseignant on enseigner.num_enseignant= '.$enseignant['num_enseignant'].'
                         join ue on ue.code_ue = matiere.code_ue
                         join diplome on diplome.code_diplome = ue.code_diplome AND diplome.code_diplome regexp "'.$diplome.'"';

                         echo $req; */
                    }
                                        }else{
                //2e cas: l'utilisateur fait un affichage par diplome
                $diplome=$_POST['listdegree'];
                $champs="matiere.num_matiere, matiere.libelle_matiere, enseigner.num_enseignant, ue.libelle_ue, diplome.code_diplome";
                $matieres_prof = $bdd->query('SELECT DISTINCT '.$champs.'
                                    From matiere Join enseigner
                                    on matiere.num_matiere = enseigner.num_matiere
                                    join enseignant on enseigner.num_enseignant= '.$enseignant['num_enseignant'].'
                                    join ue on ue.code_ue = matiere.code_ue
                                    join diplome on diplome.code_diplome = ue.code_diplome
                                    where diplome.code_diplome regexp "'.$diplome.'"');
                                    }
                        //affichage des matières tant qu'il y en a
                        while($matiere = $matieres_prof->fetch()){
                            echo "<li  class=\"list-group-item d-flex justify-content-between align-items-center\">".$matiere['libelle_matiere']." <b class=\"dip\">(".$matiere['code_diplome'].")</b></li>";

                        } ?></ul></td>
            <td><a href="edit_enseignants.php?id_ens=<?php echo $enseignant['num_enseignant'];?>" class="btn btn-outline-warning">Modifier</a></td>
            <td><a href="delete_enseignants.php?id_ens=<?php echo $enseignant['num_enseignant'];?>" class="btn btn-outline-danger" onclick="return(confirm('Voulez vous supprimer <?php echo $enseignant['prenom_enseignant'].' '.$enseignant['nom_enseignant']."? "; ?>'))">Supprimer</a></td>
        </tr>
        <?php

        }

          $ligne->closeCursor();
        ?>
    </tbody>
        <br/>
    <nav class="container text-center"><section  class="btn alert-warning"><?php if($occEns==0) {echo "Aucun enseignant trouvé";} else if ($occEns==1) {?><span class="badge badge-danger"><?php echo $occEns;?></span> Enseignant trouvé<?php } else {?><span class="badge badge-danger"><?php echo $occEns;?></span> Enseignants trouvés <?php } ?>
        </section>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="add_enseignants.php" id="ajout_ens" class="btn btn-danger">Ajouter enseignant</a>
        </nav>
        <br/>

    </table>
        </div>
        <script>
            $(function(){

             //On cache les titres et le formulaire de recherche qui seront affichés en fonction du profil utilisateur
                $('#titreAdmin').hide();
                $('#titreEditeur').hide();
                $('#SearchBox').hide();
                $('.dip').hide();

            //On recupère la variable de session et on affiche le titre adéquat
            var profil = <?php echo json_encode($_SESSION['profil']); ?> ;

            if(profil==1){
                $('#titreAdmin').show();
                $('#SearchBox').show();
                $('.dip').show();
            } else if(profil==2){
               // alert(profil);
                $('#titreEditeur').show();
                $('#ajout_ens').hide();

            }

            });
        </script>
</body>
</html>
