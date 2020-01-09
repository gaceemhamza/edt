<?php
include("connexion_bdd.php");
include('verify_session.php');
include("functions.php");
include('head.php');
if($_SESSION['profil']==1){
  include('menu.php');
} elseif ($_SESSION['profil']==2) {
  include('menu_editeur.php');
} elseif ($_SESSION['profil']==3) {
  header ('Location:../edt_ges/index.php');
}
include('content.php');
include('footer.php');
 ?>
