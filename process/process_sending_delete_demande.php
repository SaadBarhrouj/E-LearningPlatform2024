<?php 
    include('../includes/connection.inc.php');
    $contenu = (isset($_POST['raison']))? $_POST['raison'] : "Demande de suppresion de compte";

    $stmt = $conn->prepare("insert into message (idExpediteur,contenu,est_lu) values (?,?,0) ");
    $stmt->bind_param("is", $_POST['userId'], $contenu);
    
    if($stmt->execute())
        header('Location: ../profile.php?message=Demande envoyée');
    else
        header('Location: ../profile.php?message=Demande non envoyée');

?>