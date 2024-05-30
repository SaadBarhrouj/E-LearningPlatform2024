<?php
include('../includes/connection.inc.php');
if(session_status() === PHP_SESSION_NONE) session_start();

if(isset( $_POST['chapitre_ids'])) {
    if (isset($_POST['action'])) $action = $_POST['action'];
    $chapitre_ids = $_POST['chapitre_ids'];
    foreach ($chapitre_ids as $chapitre_id) {
        if($action == 'Lecture') {
            $contenu = $_POST['contenu'];
            header("Location: ../lectureProgressif.php?contenu=$contenu");
        } else {
            $sql = "UPDATE chapitre SET `accessible` = 1 WHERE IdChap = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $chapitre_id);
            $stmt->execute();
            
        // Vérifier si la mise à jour a réussi
            if ($stmt->affected_rows > 0) {
                // Redirection vers la page précédente ou une autre page de votre choix
                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit(); // Assure que le script s'arrête après la redirection
            } else {
                // Gérer le cas où la mise à jour a échoué
                
                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit();
            }
        }
    }
}
?>
