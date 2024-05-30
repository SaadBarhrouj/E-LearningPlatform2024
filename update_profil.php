<?php
include('./includes/connection.inc.php');
include('./includes/fn.inc.php');
require_once './includes/header.inc.php';
include('./includes/side_profile.inc.php');

if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
    exit; // Assurez-vous de terminer le script après la redirection//////////////////////////////////////
}
$user=array();

    $userID=$_SESSION['userID'];
    $sql = "SELECT * FROM utilisateurs WHERE id = $userID";
    $query = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($query);

///////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['modifier_profil'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userID = $_SESSION['userID']; 
    
    $sql = "UPDATE utilisateurs SET nom='$nom', prenom='$prenom', mail='$email', password='$password' WHERE id=$userID";
    $query = mysqli_query($conn, $sql);
}


?>
<style>
    .myform {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .input-pass {
        margin-bottom: 10px;
    }

    
    .input-pass input[type="radio"] {
        width: 300px; /* Ajustez la largeur selon vos besoins */
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        transition: all 0.3s; /* Transition pour le survol */
        font-size: 10px; /* Taille de police */
    }
    .input-pass input[type="text"], .input-pass input[type="password"] {
        width: 300px; /* Ajustez la largeur selon vos besoins */
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        transition: all 0.3s; /* Transition pour le survol */
        font-size: 15px; /* Taille de police */
    }
    /* Ajout de styles pour le survol */
    .input-pass input[type="text"]:hover,
    .input-pass input[type="radio"]:hover {
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.3); /* Ombre de boîte au survol */
    }

    .input-pass label {
        font-size: 20px;
        font-weight: 700;
        color: var(--black);
    }

    .main-btn {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
</style>
    <form method="POST" class="myform">
    <div class="input-pass">
        <label for="titre" style="font-weight: 500; font-size: 20px;">nom:</label>
        <input type="text" id="titre" name='nom' class="box" placeholder='nom...' value="<?php if(!empty($user)){echo $user['nom'];}   ?>">
    </div>
    <div class="input-pass">
        <label for="titre" style="font-weight: 500; font-size: 20px;">prenom:</label>
        <input type="text" id="titre" name='prenom' class="box" placeholder='prenom...' value="<?php if(!empty($user)){echo $user['prenom'];}   ?>">
    </div><div class="input-pass">
        <label for="titre" style="font-weight: 500; font-size: 20px;">email:</label>
        <input type="text" id="titre" name='email' class="box" placeholder='email...' value="<?php if(!empty($user)){echo $user['mail'];}   ?>">
    </div><div class="input-pass">
        <label for="titre" style="font-weight: 500; font-size: 20px;">password:</label>
        <input type="password" id="titre" name='password' class="box" placeholder='password...' value="<?php if(!empty($user)){echo $user['password'];}   ?>">
    <button type='submit' name='modifier_profil' class='btn main-btn'>Modifier</button>
</form>

<?php include 'foot.php'; ?>
