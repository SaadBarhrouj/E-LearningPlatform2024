<!-- RECUPERATION DES DONNEES DE LA BASE DE DONNEES -->
<?php include("./includes/connection.inc.php");?>
<?php
    $query = $conn->prepare("SELECT * from message WHERE idRecepteur=?");
    $query->bind_param("i", $_SESSION['userID']);
    $query->execute();
    $messagesRecus = $query->get_result();
    
    //fetching total number of profs and students
    $queryOnUser = $conn->prepare("SELECT COUNT(*) as nb from utilisateurs group by role");
    
    $queryOnUser->execute();
    $result = $queryOnUser->get_result();
    $nbUser=$result->fetch_all(MYSQLI_ASSOC);

    //fetching total number of course
    $queryOnModule = $conn->query("SELECT COUNT(*) as nbcours from module");
    $nbCourse = $queryOnModule->fetch_assoc();

    //fetching total number of admin's message
    $queryOnMessage = $conn->query("SELECT count(*) as nbMsg, est_lu FROM message WHERE idRecepteur = '".$_SESSION['userID']."' group by est_lu");
    $nbMessage = $queryOnMessage->fetch_all(MYSQLI_ASSOC);
   
    $nb_lu = 0; $nb_non_lu = 0;
    //check the first row returned
    if(isset($nbMessage[0]['nbMsg']) && $nbMessage[0]['est_lu'] == 0)
        $nb_non_lu = $nbMessage[0]['nbMsg'];
    elseif(isset($nbMessage[0]['nbMsg']) && $nbMessage[0]['est_lu'] == 1)
        $nb_lu = $nbMessage[0]['nbMsg'];

    //check the second row returned
    if(isset($nbMessage[1]['nbMsg']) && $nbMessage[1]['est_lu'] == 0)
        $nb_non_lu = $nbMessage[1]['nbMsg'];
    elseif(isset($nbMessage[1]['nbMsg']) && $nbMessage[1]['est_lu'] == 1)
        $nb_lu = $nbMessage[1]['nbMsg'];
    //marquer le tout comme lu

    if(isset($_GET['mesgID'])) {
        $mesgIDs = explode(',', $_GET['mesgID']);
        foreach($mesgIDs as $mesgID) {
            $query = $conn->prepare("UPDATE message SET est_lu = 1 WHERE id = ?");
            $query->bind_param("i", $mesgID);
            $query->execute();
        }
        header("Location: home_etudiant.php");
        exit();
    
    }
?>
<?php 
 if(isset($_GET['action']) && isset($_GET['message_id'])){
    header("Location: home_etudiant.php");
    $id = $_GET['message_id'];
    $q = $conn->prepare("UPDATE message SET est_lu = 1 WHERE id = ?");
    $q->bind_param("i", $id);
    $q->execute();
    header("Location: home_etudiant.php");
}
?>