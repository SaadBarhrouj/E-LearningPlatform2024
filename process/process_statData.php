<?php
    //fetching a prof's famous courses
    $sql = "select m.*, count(cs.idCours) as nbInscrit from module as m join courssuivis as cs on cs.idCours = m.id group by m.id,m.titre, cs.idCours order by nbInscrit desc limit 4";
    $stmtOnModule = $conn->query($sql);
    $coursesPop = $stmtOnModule->fetch_all(MYSQLI_ASSOC);
    
    //fetching famous prof
    $sql = "select curs.nom, curs.prenom, curs.mail,curs.image, count(curs.id) as nbSuiveur from 
                (select p.*,cs.idEtudiant, count(p.id) as nbCoursSuivisParUnEtd from utilisateurs as p 
                        join module as m on p.id = m.proprietaire
                        join courssuivis as cs on cs.idCours = m.id
                        where p.role = 'professeur'
                        group by p.id, cs.idEtudiant) as curs
                group by curs.id
                order by nbSuiveur desc limit 4";
    $stmtOnProf = $conn->query($sql);
    $profPop = $stmtOnProf->fetch_all(MYSQLI_ASSOC);

    //fetching active student
    $sql = "select e.*, count(e.id) as nbCoursSuivis from utilisateurs as e 
            join courssuivis as cs on cs.idEtudiant = e.id
            where e.role = 'etudiant'
            group by e.id
            order by nbCoursSuivis desc limit 4";
    $stmtOnStd = $conn->query($sql);
    $etudiantActif = $stmtOnStd->fetch_all(MYSQLI_ASSOC);
    
?>