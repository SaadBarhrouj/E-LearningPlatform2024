<?php include('./process/process_statData.php') ?>

<fieldset class="statistics-content">
    <legend>Informations Générales</legend>
    <div id="nbProf" class="adminStat" style="justify-content: center;">
        <center><img src="./images/teacher.svg" alt="teacher" width="60rem"></center>
        <?php echo (isset($nbUser[0]['nb']))? $nbUser[1]['nb'] : '0'?> <br> 
        Professeurs
    </div>

    <div id="nbEtudiant" class="adminStat" style="justify-content: center;">
        <center><img src="./images/student.svg" alt="student" width="60rem"></center>
        <?php echo (isset($nbUser[1]['nb']))? $nbUser[0]['nb'] : '0'?> <br> 
        Etudiants
    </div>

    <div id="nbCours" class="adminStat" style="justify-content: center;">
        <center><img src="./images/course.svg" alt="course" width="60rem"></center>
        <?= $nbCourse['nbcours'] ?> <br> Cours
    </div>

    <div id="nbMessage" class="adminStat" style="justify-content: center;">
        <center><img src="./images/messages.svg" alt="message" width="60rem"></center>
        <?=  $nb_non_lu + $nb_lu ?> <br>  
        Message
    </div>
</fieldset>
<fieldset>
    <legend>Les Cours les plus populaires...</legend>
    <div class="statistics-content" style="display: flex;">
        <?php
            foreach ($coursesPop as $module) 
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
                        echo "<br>Contient ".$nbChap['nbchap']." chapitre(s)<br><br>" ;
                    ?>
                    <span style="font-size: 1.5rem; color: var(--main-color)"> <span style="font-size: 1.6rem;"><?= $module['nbInscrit']?></span> étudiant(s) inscrit(s)</span>
                </div>
        <?php }?>
    </div>
</fieldset>
<fieldset>
    <legend>Les Professeurs les plus suivis...</legend>
    <div class="statistics-content" style="display: flex;">
        <?php
            foreach ($profPop as $prof) 
            {
        ?>
                <div class="identity profPop">
                    <center>
                        <img src="./users_images/<?= $prof['image'] ?>" class="image" alt="">
                        <h1 class="name"><?= $prof['nom'].' '.$prof['prenom']  ?></h1>
                        <h2 style="text-decoration: underline;"><?= $prof['mail'] ?></h2>

                        <span style="color: var(--main-color); font-size: 1.4rem;">Ce professeur est suivi par <span style="font-size: 1.6rem;"><?= $prof['nbSuiveur'] ?></span> étudiants...</span>
                    </center>
                </div>
        <?php }?>
    </div>
</fieldset>

<fieldset>
    <legend>Les étudiants les plus actifs</legend>
    <div class="statistics-content" style="display: flex;">
        <?php
            foreach ($etudiantActif as $etudiant) 
            {
        ?>
                <div class="identity profPop">
                    <center>
                        <img src="./users_images/<?= $etudiant['image'] ?>" class="image" alt="">
                        <h1 class="name"><?= $etudiant['nom'].' '.$etudiant['prenom']  ?></h1>
                        <h2 style="text-decoration: underline;"><?= $etudiant['mail'] ?></h2>

                        <span style="color: var(--main-color); font-size: 1.4rem;">Cet étudiant suit <span style="font-size: 1.6rem;"><?= $etudiant['nbCoursSuivis'] ?></span> cours...</span>
                    </center>
                </div>
        <?php }?>
    </div>
</fieldset>