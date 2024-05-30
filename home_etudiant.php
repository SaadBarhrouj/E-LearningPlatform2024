<?php
include('./includes/connection.inc.php');
include('./includes/fn.inc.php');
require_once('./includes/header.inc.php');
include('./includes/side_profile.inc.php');

if(session_status() === PHP_SESSION_NONE) session_start(); 

$condition = !$_SESSION['userID'] || (isset($_SESSION['userID']) && !isUser($conn, $_SESSION['userID']));
if($condition){
    header('Location: ./login.php');
}
//var_dump($_SESSION['userID']);
// Récupérer les cours depuis la base de données
$sql = "SELECT module.titre AS titre_cours,utilisateurs.image ,utilisateurs.nom AS nom_proprietaire,courssuivis.idCours
FROM courssuivis
JOIN module ON courssuivis.idCours = module.id
JOIN utilisateurs ON module.proprietaire = utilisateurs.id
WHERE courssuivis.idEtudiant = ?;";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION["userID"]);
$stmt->execute();
$result = $stmt->get_result();
$cours = $result->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<script defer src="./js/script.js"></script>
</head>
<body>
<section class="home-grid">
    <div class="sub-title">
        <h4 class='title-content'>Mes <span>cours</span></h4>
    </div>
    <?php if (!empty($cours)) { ?>
        <?php foreach ($cours as $cour) {?>
            <div class="box">
                <div class="course-item">
                     <!-- Si vous avez une image de cours, remplacez le chemin src -->
                     <div class="course-item-image">
                          <img src="./users_images/<?php echo $cour['image']; ?>" width='100' alt="">
                     </div>
                     <div class="course-item-text">
                         <div class="cour-infos">
                             <div class="cour-nom">
                                 <h4><?php echo $cour['titre_cours'] ?></h4>
                             </div>
                             <div class="cour-infos" style="column-gap:2%;">
                                <div class="center_div">
                                    <a href="lecture.php?courID=<?php echo $cour['idCours']; ?>&nomCours=<?php echo $cour['titre_cours']; ?>">

                                        <button class="btn main-btn">Lire cours</button>
                                    </a>
                                </div> 
                                <div class="center_div">
                                    <button class="btn delete-btn" onclick="confirmDesinscription(<?php echo $cour['idCours']?>)">Se desinscrire</button>
                                </div> 
                             </div>
                        </div>
                         <div class="cour-prof">
                            <h4 class="prof-nom">Prof. <?php echo $cour['nom_proprietaire'] ?></h4>
                         </div>
                     </div>
                  </div>
            </div>
            
        <?php }?>
    <?php } else { ?>
        <div class="sub-title"><center><p class='title-content'>Vous n'etes inscrit a auccun cours pour le moment.</p></center></div>
    <?php } ?>
</section>
</body>
</html>
