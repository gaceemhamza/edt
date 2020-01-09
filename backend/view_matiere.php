<?php
// demarrage de la session et recupération de l'utilisateur connecté
include('verify_session.php');

?>

    <div class="table-responsive">
        <H1 class="h1" align="center" id="titreEditeur"><?php echo $_SESSION['niveau']." ".$_SESSION['libelle_diplome'] ; ?></H1>

    <!--Zone de Recherche-->
    <form action=""  method="post" enctype="multipart/form-data">

     <div class="alert alert-primary">
            <label for="niveau">Niveau</label>
            <select name="niveau" id="niveau" required>
            <option  selected>Choisir un Niveau</option>
            <?php
            //lorsque l'administrateur se connecte
                if($_SESSION['profil']==1){
                    $sql = "SELECT distinct niveau FROM diplome";
            }else{ //lorsque un éditeur se connecte

                $sql = 'SELECT niveau FROM diplome Where code_diplome regexp "'.$_SESSION['code_diplome'].'"' ;

            }
            //echo $sql;
                $result = $bdd->query($sql);
                while($row = $result->fetch()) {
                    $niveau = $row['niveau'];
                    echo "<option  value='$niveau'>{$niveau}</option>";
                }
            ?>

          </select>

            <label for="diplome" >Choisir un Diplome</label>
            <select name="diplome" id="diplome" required>

          </select>

            <label for="ue">UE</label>
            <select name="ue" id="ue" required>
                <option selected>Choisir une UE</option>

          </select>

          <input class="btn btn-outline-success" type="submit" name="recherche" value="Recherche">
    </div>
</form>
    <!-- Script ajax pour la recherche-->
<script>

$(function () {

    $("#niveau").change(function (event) {

        remplirDiplome();

    });

});

 $(function () {

    $("#diplome").change(function (event) {

        remplirUe();

    });

});

function remplirDiplome() {

        var niveau = $('#niveau').val();
    var dataString = 'niveau=' + niveau;
    $.ajax({
        type: 'post',
        url: 'get_diplome.php',
        dataType: "html", // le fichier php fait un echo de code HTML
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        data: dataString,
        success : function(code_html, statut){
            $("#diplome").html("<option value=''>Veuillez choisir un diplome</option>" + code_html);
        }
    });
}

function remplirUe() {

    var diplome = $('#diplome').val();
    var dataString = 'diplome=' + diplome;
    $.ajax({
        type: 'post',
        url: 'get_ue.php',
        dataType: "html", // le fichier php fait un echo de code HTML
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        data: dataString,
        success : function(code_html, statut){
            $("#ue").html("<option value=''>Veuillez choisir une UE </option>" + code_html);
        }
    });
}

</script>

        <?php

        //recuperation de la saisie de recherche
        if(isset($_POST['recherche'])){

                $libniv=$_POST['niveau'];
                $cdiplome=$_POST['diplome'];
                $cue=$_POST['ue'];
               $matiere = $bdd->query('SELECT num_matiere,libelle_matiere, libelle_ue, niveau, libelle_diplome, volume_horaire From matiere
                join ue on matiere.code_ue=ue.code_ue
                join diplome on ue.code_diplome=diplome.code_diplome
                Where diplome.code_diplome  regexp "'.$cdiplome.'"
                AND diplome.niveau regexp "'.$libniv.'"
                AND ue.code_ue regexp "'.$cue.'" ORDER BY libelle_matiere ASC') or die(print_r($bdd->errorInfo()));
        }
        else{
                if($_SESSION['profil']==1){ // requête par defaut pour l'administrateur
                    $req='SELECT num_matiere,libelle_matiere, libelle_ue, niveau, libelle_diplome, volume_horaire From matiere
                    join ue on matiere.code_ue=ue.code_ue
                    join diplome on ue.code_diplome=diplome.code_diplome
                    ORDER BY libelle_matiere ASC';
                                        }
                else if($_SESSION['profil']==2){ //requête par defaut pour éditeur
                    $req='SELECT num_matiere,libelle_matiere, libelle_ue, niveau, libelle_diplome, volume_horaire From matiere
                    join ue on matiere.code_ue=ue.code_ue
                    join diplome on ue.code_diplome=diplome.code_diplome
                    AND diplome.code_diplome regexp "'.$_SESSION['code_diplome'].'"
                    ORDER BY libelle_matiere ASC';
                                        }
                //lecture de tous enregistrements
                $matiere = $bdd->query($req) or die(print_r($bdd->errorInfo()));

        } ?>
        <table  align="center" class="table table-striped">
    <thead>
    <tr>
    <td colspan="3" align="center"><span id="occurrence" class="btn btn-primary btn-sm"></span></td>
    <td colspan="3" align="right"><a href="add_matiere.php" class="btn btn-danger">Ajouter Matière</a></td>
    </tr>
    <tr>
      <th scope="col">Libellé matière</th>
      <th scope="col">Volume horaire </th>
      <th scope="col">Libellé UE</th>
      <th scope="col" id="dipTitre">Diplôme</th>
      <th scope="col" colspan="2">Actions</th>
    </tr>
    </thead>
    <tbody class="table table-hover">


        <?php
        $occ=0;
        //recuperation des informations de chaque ligne
        while ($contenu = $matiere->fetch()){

            $occ+=1;
        ?>

        <tr>
           <!-- <td><?php //echo ++$i; ?></td> -->
            <td><?php echo $contenu['libelle_matiere']; ?></td>
            <td><?php echo $contenu['volume_horaire']." H"; ?></td>
            <td><?php echo $contenu['libelle_ue']; ?></td>
            <td class="dipValeur"><?php echo $contenu['niveau']." ".$contenu['libelle_diplome']; ?></td>
            <td><a href="edit_matiere.php?id_matiere=<?php echo $contenu['num_matiere'];?>"><img class="icon" src="img/update.png" alt="editer"/></a></td>
            <td>
                <a href="delete_matiere.php?id_matiere=<?php echo $contenu['num_matiere'];?>" onclick="return(confirm('Voulez vous supprimer <?php echo $contenu['libelle_matiere']."? "; ?>'))"><img class="icon" src="img/delete.png" alt="supprimer"/></td>
        </tr>
        <?php
          };

          $matiere->closeCursor();
        ?>

    </table>
    </div>
    <script>

         var nbre = <?php echo json_encode($occ); ?>;

         document.getElementById("occurrence").innerHTML= "Matières trouvées:  "+ nbre;
    </script>
            <script>
            $(function(){

             //On cache les titres et le formulaire de recherche qui seront affichés en fonction du profil utilisateur
                $('#titreAdmin').hide();
                $('#titreEditeur').hide();

                //la colonne diplome
                $('#dipTitre').hide();
                $('.dipValeur').hide();

            //On recupère la variable de session et on affiche le titre adéquat
            var profil = <?php echo json_encode($_SESSION['profil']); ?> ;
            if(profil==1){

                $('#titreAdmin').show();
                $('#selected').show();
                $('#SearchBox').show();
                $('#dipTitre').show();
                $('.dipValeur').show();
            }else{
                $('#titreEditeur').show();


            }

            })
        </script>
