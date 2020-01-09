<?php 

function view_users(){
    global $bdd;
    $sql = "SELECT * FROM utilisateur";
    $result = $bdd->query($sql);  
    while($row = $result->fetch()) {
        $user_id            = $row['identifiant_user'];
        $user_login         = $row['login_user'];
        $user_name          = $row['nom_user'];
        $user_firstname     = $row['prenom_user'];
        $user_mail          = $row['mail_user'];
        $user_id_profil     = $row['num_profil'];
        
        echo "<tr>";
        echo "<td>$user_id </td>";
        echo "<td>$user_login</td>";
        echo "<td>$user_name</td>";
        echo "<td>$user_firstname</td>";
        echo "<td>$user_mail </td>";
        $sql = "SELECT * FROM profil WHERE num_profil = {$user_id_profil} ";
        $res= $bdd->query($sql);  
        while($row2 =$res->fetch()) {
            $profil_id = $row2['num_profil'];
            $profil = $row2['libelle_profil'];
            echo "<td>$profil</td>";
        }
        echo "<td><a href='edit_utilisateurs.php?user_id={$user_id}'>Modifier</a></td>";
        echo "<td><a href=''>Supprimer</a></td>";
        echo "</tr>";
    }
}

function confirmQuery($result) {
    global $bdd;
    if(!$result) {
       die(print_r($bdd->errorInfo()));
    }else{
        echo "<p class='bg-success'>Utilisateur Ajouté. </a></p>";
    }
}


function add_users(){
    global $bdd;
    $login      = $_POST['login'];
    $password   = $_POST['mdp'];
    $nom        = $_POST['nom'];
    $prenom     = $_POST['prenom'];
    $email      = $_POST['email'];
    $profil_id  = $_POST['profil']; 
    $etat=0;
    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));
    
    $sql = 'SELECT * FROM utilisateur where login_user= :login';
    $result = $bdd->prepare($sql);
    $result->execute(array('login' =>$login));
    $count = $result->fetchColumn();
    if($count > 0){
         echo 'Ce login est déjà utilisé';
    }
    else{
        $sql = 'INSERT INTO utilisateur(login_user, mdp_user, nom_user, prenom_user, mail_user, num_profil, etat) ';
    
        $sql.= 'VALUES(:login, :password, :nom, :prenom, :email, :profil_id, ? );'; 
        
        $prep = $bdd->prepare($sql); 
    
        $result=$prep->execute(array(
            'login' =>$login,
            'password' =>$password,
            'nom' =>$nom,
            'prenom' =>$prenom,
            'email' =>$email,
            'profil_id' =>$profil_id,
            'etat' =>$etat
        ));
    
        confirmQuery($result);
        }
    }

function select_profils(){
    global $bdd;
    $sql = "SELECT * FROM profil";
    $result = $bdd->query($sql);
    while($row = $result->fetch()) {
        $profil_id = $row['num_profil'];
        $profil = $row['libelle_profil'];
        echo "<option value='".$profil_id."'>$profil</option>";
    }
}



?>
