<?php

session_start();
include('./includes/connection.inc.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['idExpediteur'], $_POST['contenu'], $_POST['id']) && !empty($_POST['idExpediteur']) && !empty($_POST['contenu']) && !empty($_POST['id'])) {
        $idExpediteur = $_POST['idExpediteur'];
        $contenu = $_POST['contenu'];
        $idMesg = $_POST['id'];
        $idRecepteur = null;
    
        // Récupération de l'id du récepteur
        $sqlR = "SELECT idExpediteur FROM message WHERE id=?";
        $stmtR = $conn->prepare($sqlR);
        $stmtR->bind_param("i", $idMesg);
        $stmtR->execute();
        $result=$stmtR->get_result();
        if ($result->num_rows > 0) {
            // Récupérer la première ligne de résultats
            $row = $result->fetch_assoc();
            // Extraire la valeur de la colonne idExpediteur
            $idRecepteur = $row['idExpediteur'];
        }

        
            // Envoi du message
            $sqlInsert = "INSERT INTO message (idExpediteur, idRecepteur, contenu) VALUES (?, ?, ?)";
            $stmtInsert = $conn->prepare($sqlInsert);
            $stmtInsert->bind_param("iis", $idExpediteur, $idRecepteur, $contenu);
            if ($stmtInsert->execute()) {
                echo "Reponse envoyee avec succes!!";
                
                header("Location: $_SERVER[HTTP_REFERER]");
            } else {
                echo "Erreur lors de l'envoi de la réponse : " . $stmtInsert->error;
            }
        
    }else if (isset($_POST['destinataire'])&& isset($_POST['contenu']) && (!empty($_POST['destinataire'])||$_POST['destinataire']=="0") && !empty($_POST['contenu'])) {
            // Récupérez les données du formulaire
            $destinataire = $_POST['destinataire'];
            $contenu = $_POST['contenu'];
            $idExpediteur = $_SESSION['userID']; 
            if($destinataire!="0"){
                // Code pour se connecter à la base de données
                // Utilisation d'une requête préparée pour l'insertion sécurisée des données
                $sql_insert = "INSERT INTO message (idCours, idExpediteur, idRecepteur, contenu, est_annonce) VALUES (NULL, ?, ?, ?, 0)";
                $stmt = $conn->prepare($sql_insert);
                $stmt->bind_param('iis', $idExpediteur, $destinataire, $contenu);
                
                if ($stmt->execute()) {
                    // Message inséré avec succès
                    $stmt->close();
                    $conn->close();

                   header("Location: $_SERVER[HTTP_REFERER]"); // Redirection
                  
                    exit();
                } else {
                    // Erreur lors de l'insertion du message
                    echo "Erreur lors de l'insertion du message : " . $conn->error;
                }

                // Fermer la connexion à la base de données
                $stmt->close();
                $conn->close();
            }else {
                // Sélectionner tous les étudiants inscrits au cours du professeur
                $sql = "SELECT u.id, u.nom, u.prenom
                        FROM utilisateurs u
                        INNER JOIN courssuivis cs ON u.id = cs.idEtudiant
                        INNER JOIN module m ON cs.idCours = m.id
                        WHERE m.proprietaire = $_SESSION[userID]";
                $result = $conn->query($sql);
            
                // Vérifier s'il y a des résultats
                if ($result->num_rows > 0) {
                    // Parcourir chaque étudiant inscrit et envoyer un message
                    while ($row = $result->fetch_assoc()) {
                        // Préparer la requête d'insertion
                        $sql_insert = "INSERT INTO message (idCours, idExpediteur, idRecepteur, contenu, est_annonce) VALUES (NULL, ?, ?, ?, 0)";
                        $stmt = $conn->prepare($sql_insert);
                        // Lier les valeurs aux paramètres de la requête
                        $stmt->bind_param('iis', $_SESSION['userID'], $row['id'], $_POST['contenu']);
                        // Exécuter la requête d'insertion
                        $stmt->execute();
                    }
                }
                // Rediriger l'utilisateur après l'envoi du message

                header("Location: $_SERVER[HTTP_REFERER]");
                
            }
            
    } else {
        // Gérer les erreurs si des champs sont manquants ou vides
        echo "Veuillez remplir tous les champs du formulaire.";
        var_dump($_POST['idExpediteur']);
        var_dump($_POST['contenu']);
        var_dump($_POST['id']);
    }
}
?>