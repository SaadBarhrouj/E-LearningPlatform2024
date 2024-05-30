<?php include("../includes/connection.inc.php") ?>

<?php
    //fetching a prof's courses
    $stmtOnModule = $conn->prepare("select * from module where proprietaire = ?");
    $stmtOnModule->bind_param("i", $_REQUEST["profId"]);
    $stmtOnModule->execute();
    $result = $stmtOnModule->get_result();
    $courses = $result->fetch_all(MYSQLI_ASSOC); 
    
?>

<div class="identity">
    <center>
        <img src="./users_images/<?= $_REQUEST["profImage"] ?>" class="image" alt="">
        <h2 class="name"><?= $_GET['profName'] ?></h2>

        <h3>Ce professeur a <?= count($courses) ?> cours...</h3>
    </center>
</div>
<div class="courses statistics-content" style="display: flex;">
    <?php
        foreach ($courses as $module) 
        {
    ?>
            <div class="module">
                <h2><?= $module['titre']?></h2> 
                <h4><?= $module['mots_cles']?></h4>
                <?php 
                    $stmtChap = $conn->query("select count(*) as nbchap from module as m join chapitre as chap on m.id = chap.idModule where m.id=".$module['id']);
                    $nbChap = $stmtChap->fetch_assoc();
                    echo $module['cible']. ' (Progressif: '; 
                    echo ($module['est_progressif']==1) ? 'Oui )' : 'Non )';
                    echo "<br>Contient ".$nbChap['nbchap']." chapitre(s)" ;
                ?>
            </div>
    <?php }?>
</div>
