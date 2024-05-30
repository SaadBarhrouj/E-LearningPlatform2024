<!-- RECUPERATION DES DONNEES DE LA BASE DE DONNEES -->
<?php
    //fetching total number of profs and students
    $queryOnUser = $conn->prepare("SELECT COUNT(*) as nb from utilisateurs group by role");
    
    $queryOnUser->execute();
    $result = $queryOnUser->get_result();
    $nbUser=$result->fetch_all(MYSQLI_ASSOC);

    //fetching total number of course
    $queryOnModule = $conn->query("SELECT COUNT(*) as nbcours from module");
    $nbCourse = $queryOnModule->fetch_assoc();

    //fetching total number of admin's message
    $queryOnMessage = $conn->query("SELECT count(*) as nbMsg, est_lu FROM message WHERE idRecepteur is null and idCours is null group by est_lu");
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
    
?>