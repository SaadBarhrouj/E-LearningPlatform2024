<?php include("../includes/connection.inc.php") ?>

<?php
    //fetching a prof's courses
    $stmtOnModule = $conn->prepare("select * from utilisateurs where id = ?");
    $stmtOnModule->bind_param("i", $_REQUEST["idExp"]);
    $stmtOnModule->execute();
    $result = $stmtOnModule->get_result();
    $userInfo = $result->fetch_all(MYSQLI_ASSOC); 
?>

<div class="identity">
    <center>
        <img src="./users_images/<?= $userInfo[0]['image'] ?>" class="image" alt="">
        <h2 class="name"><?= $nomComplet = $userInfo[0]['nom'].' '.$userInfo[0]['prenom'] ?></h2>
    </center>
</div>
<div class="sub-title"><h3 class='title-content' style="font-size: initial;">Demande de <span>suppression de compte<span></h3></div>
<div class="contentBox">
    <span class="dateEnvoie"><?= $_GET['date_envoie'] ?></span>
    <div class="content">
        <?= $_GET['contenu'] ?>
    </div>
    <div class="action" onclick="confirmDel(<?=$userInfo[0]['id']?>, '<?=$userInfo[0]['role']?>', '<?= $nomComplet?>')">
        <button style="background-color: transparent;"><img src="./images/send.png" alt="send" width="28rem"></button>        
    </div>
</div>
<div><!-- formulaire pour répondre --></div>