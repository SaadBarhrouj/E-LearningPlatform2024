<?php
include('./includes/connection.inc.php');
include('./includes/fn.inc.php');
require_once './includes/header.inc.php';
include('./includes/side_profile.inc.php');

// Récupération de tous les cours

$cours=array();
$userID = $_SESSION['userID'];
$sql = "SELECT * FROM module WHERE proprietaire= $userID";
$result = mysqli_query($conn, $sql);

if ($result) {
    $cours = mysqli_fetch_all($result, MYSQLI_ASSOC);
    // Further processing of the fetched data
} else {
    echo "Error: " . mysqli_error($conn); // Output the specific MySQL error
}
?>

<!-- Code HTML pour afficher tous les cours -->
  <section class="all-courses">
    <div class="container">
        <h2 style="text-align: center; font-size: 4rem; color:var(--main-color); margin:50px;">Mes Cours</h2>
        <div class="course-list">
            <?php foreach ($cours as $cour) { ?>
            <div class="course-card">
                <h3 class="course-title"><?php echo $cour['titre']; ?></h3>
                <p class="course-details">
                    <strong>Mots clés :</strong> <span><?php echo $cour['mots_cles']; ?></span><br>
                    <strong>Code du cours :</strong> <span><?php echo $cour['Code_Cours']; ?></span><br>
                    <strong>Cible :</strong> <span><?php echo $cour['cible']; ?></span><br>
                    <strong>Prérequis :</strong> <span><?php echo $cour['prerequis']; ?></span><br>
                    <strong>Propriétaire :</strong> <span><?php echo $cour['proprietaire']; ?></span><br>
                    <strong>Progressif :</strong> <span><?php echo $cour['est_progressif'] ? 'Oui' : 'Non'; ?></span>
                </p>
            </div>
            <?php } ?>
        </div>
    </div>
</section> 


<?php include 'foot.php'; ?>
