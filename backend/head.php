<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="author" content="Equipe EDT" >
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link type="text/css" href="jquery-ui/css/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <title>DDAME - Gestion de l'emploi du temps</title>
</head>
<body>
  <header class="index_h" id="header_index">
    <a href="https://www.univ-tlse2.fr/" target="_blank"><img id="logo_JJ"src="imgs/logo_JJ.png" alt="Université Jean Jaurès" height="40px" width="167.33px"></a>
    <h1 class="nomdusite">DDAME<br>Gestion de l'emploi du temps</h1>
    <a href="index.php"><img id="logo_EDT" src="imgs/logo_EDT.png" alt="DDAME-EDT" height="84px" width="89.04px"></a>
    <div class="logout" id="logout">
      <form action="deconnexion.php" method="post" id="login">
      <span class="salut"><?php echo 'Bonjour, '.$_SESSION['prenom']." ".strtoupper($_SESSION['nom']).', on est le '.$_SESSION['date']; ?></span>
      <button type="submit" value="Déconnexion" class="connex" name="deconnect">Déconnexion</button>
      </form>
    </div>
  </header>
