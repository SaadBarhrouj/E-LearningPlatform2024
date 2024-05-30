<?php
include('../includes/connection.inc.php');
include('../includes/fn.inc.php');
session_start(); 

if (!isset($_SESSION['userID'])) {
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id_cours"])) {
    $idCours = $_GET["id_cours"];
    $idEtudiant = $_SESSION["userID"];

    // Préparer la requête SQL pour supprimer l'inscription
    $sql = "DELETE FROM courssuivis WHERE idEtudiant = ? AND idCours = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $idEtudiant, $idCours);

    // Exécuter la requête
    if ($stmt->execute()) {
        // Rediriger l'utilisateur vers une page de confirmation ou une autre page appropriée
        header('Location: ../home_etudiant.php');
        exit();
    } else {
        // Gérer les erreurs si la requête échoue
        echo "Erreur lors de la désinscription.";
    }
} else {
    // Rediriger l'utilisateur vers une page d'erreur s'il accède à cette page sans l'identifiant du cours
    header('Location: ../home_etudiant.php');
    exit();
}
?>
