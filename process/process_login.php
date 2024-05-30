<?php
include('../includes/connection.inc.php');
include('../includes/fn.inc.php');

if (isset($_POST['send'])) {
    session_start();
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $user = (isset($_POST['isAdmin']) && $_POST['isAdmin'] == "on")? 
                login_user($conn, $email, $password, true) : login_user($conn, $email, $password);

    if (!empty($user)) {
        $_SESSION['userID'] = $user['id'];
        $_SESSION['email'] = $user['mail'];
        $_SESSION['user'] = $user['role'];
        $_SESSION['image'] = $user['image'];
        $_SESSION['name'] = $user['nom'];
        $_SESSION['prenom'] = $user['prenom'];
        if ($user['role'] == 'professeur') {
            header('Location: ../home_professeur.php');
            exit;
        } elseif ($user['role'] == 'administrateur'){
            header('Location: ../adminDashboard.php');
            exit;
        } 
        else {
            header('Location: ../home_etudiant.php');
            exit;
        }
    } else {
        header('Location: ../login.php?error=1');
        exit;
    }
}
?>
