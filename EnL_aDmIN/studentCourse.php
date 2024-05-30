<?php include("../includes/connection.inc.php") ?>

<?php
    $sql = "
        select m.id as id, m.titre as titre, concat(p.nom,' ',p.prenom) as prof 
        from
            utilisateurs as e
            join courssuivis as cs on cs.idEtudiant = e.id
            join module as m on m.id = cs.idCours
            join utilisateurs as p on p.id = m.proprietaire
        where cs.idEtudiant = ?";
    $stmtOnCours_suivis = $conn->prepare($sql);
    $stmtOnCours_suivis->bind_param("i", $_REQUEST["stdId"]);
    $stmtOnCours_suivis->execute();
    $result = $stmtOnCours_suivis->get_result();
    $courses = $result->fetch_all(MYSQLI_ASSOC);  
?>

<div class="identity">
    <center>
        <img src="./users_images/<?= $_REQUEST["stdImage"] ?>" class="image" alt="">
        <h2 class="name"><?= $_GET['stdName'] ?></h2>

        <h3>Cet étudiant suit <?= count($courses) ?> cours...</h3>
    </center>
</div>
<div class="courses liste">
    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Nombre Chapitre(s)</th>
                <th>Professeur</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($courses as $course) 
                {
            ?>
                    <tr>
                        <?php
                            $stmtChap = $conn->query("select count(*) as nbchap from module as m join chapitre as chap on m.id = chap.idModule where m.id=".$course['id']);
                            $nbChap = $stmtChap->fetch_assoc();
                        ?>
                        <td><?= $course['titre'] ?></td>
                        <td><?= $nbChap['nbchap'] ?></td>
                        <td><?= $course['prof'] ?></td>
                    </tr>
                   
            <?php }?>
        </tbody>

    </table>
</div>
