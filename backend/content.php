<div class="contenu">
  <div>
      <?php
      if(isset($_GET['page'])){
          include($_GET['page'].'.php');

      } else { //ici, on défini un fichier inclut par défaut si GET n'est pas renseigné
      //  header('Location:index.php');
    }
      ?>
  </div>
</div>
