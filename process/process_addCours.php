<?php
if(session_status()==PHP_SESSION_NONE) session_start();
// Inclure le fichier de connexion à la base de données
include('../includes/connection.inc.php');
include('../includes/fn.inc.php');

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les données du formulaire sont présentes
    if (isset($_POST['id_cours']) && isset($_POST['code_cours'])) {
        // Récupérer les données du formulaire
        $idCours = $_POST['id_cours'];
        $_SESSION['id_cours']= $idCours;
        $codeCours = $_POST['code_cours'];
        // Vérifier si le code du cours est correct 
        $codeCoursCorrect = verificationCodeCours($conn,$codeCours);
        
        if ($codeCoursCorrect) {
            // Inscrire l'utilisateur au cours dans la base de données
            //checker si deja inscrit (a implementer)
            $stmt = $conn->prepare("INSERT INTO courssuivis (idEtudiant, idCours) VALUES (?, ?)");
            $stmt->bind_param("ii", $_SESSION["userID"], $idCours);
            var_dump($_SESSION['userID']);
            var_dump($idCours);
            //var_dump($stmt->execute());
            if ($stmt->execute()) {
                // Redirection vers une page de succès
                header("Location: ../home_etudiant.php");
                exit();
            } else {
                // Erreur lors de l'inscription
                exit();
            }
        } else {
            echo "Code cours incorrect!";
            header("Location: ../nouveaux_cours.php");
            exit();
            
        }
    } else {
        // Données du formulaire manquantes
        exit();
    }
} else {
    // Accès direct à la page sans soumission du formulaire
    exit();
}
?>
