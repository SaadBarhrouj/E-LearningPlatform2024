<?php include('./includes/connection.inc.php');?>

<?php
    function isUserAdmin($conn, $userID){
        $stmt = $conn->query("select count(*) as nb from admin where id = ".$userID);
        $res = $stmt->fetch_assoc();
        return ($res['nb'] > 0)? true : false ;
    }
    function est_lu($text, $lu){
        if($lu == 0)
            return "<strong>".$text."</strong>";
        else    
            return $text;
    }

// <!-- checking if session is an admin's session -->
    if(session_status() === PHP_SESSION_NONE) session_start(); 

    $condition = !$_SESSION['userID'] || (isset($_SESSION['userID']) && !isUserAdmin($conn, $_SESSION['userID']));
    if($condition){
        header('Location: ./EnL_aDmIN/adminLogin.php');
    }
?>

<div class="sub-title">
    <div class="title-content">
        Boîte de <span>réception</span>
    </div> 
</div>

<?php
$sql = "SELECT * FROM message WHERE idRecepteur is null and idCours is null order by date_envoi desc";
$result = $conn->query($sql);
// Afficher les messages
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    ?> 
        <div class="message">
            <span><?= est_lu($row["idExpediteur"], $row['est_lu'])?> : </span> <!-- sender -->
            <span><?= est_lu($row["date_envoi"], $row['est_lu']) ?></span> </br> <!-- date d'envoie -->
            <span>
                <?= est_lu(substr($row["contenu"],0,10), $row['est_lu']); ?>... <!-- overview content -->
            </span>
            <span onclick="update_est_lu(<?= $row['id'] ?>); open_readMessage(parseInt(<?=$row['idExpediteur']?>), '<?= $row['date_envoi']?>' , `<?=$row['contenu']?>`);">Voir Message&gt;</span>
        </div>
           
   <?php }
}?>
