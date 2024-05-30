<?php
include('./includes/connection.inc.php');
include('./includes/fn.inc.php');
require_once './includes/header.inc.php';
include('./includes/side_profile.inc.php');

if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['userID'])) {
    header('Location: ./login.php');
    exit; // Assurez-vous de terminer le script après la redirection
}

// Traitement du formulaire d'affichage des étudiants
if (isset($_POST['afficher_etudiants'])) {
    // Afficher les étudiants qui suivent chaque cours
    $query = "
        SELECT 
            m.titre AS titre_cours,
            GROUP_CONCAT(u.nom, ' ', u.prenom) AS etudiants
        FROM 
            utilisateurs as u
        JOIN 
            courssuivis cs ON u.id = cs.idEtudiant
        JOIN 
            module m ON cs.idCours = m.id
        WHERE 
            u.role = 'etudiant'
        GROUP BY 
            m.titre
        ORDER BY 
            m.titre;
    ";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<h2>Étudiants par cours :</h2>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<h3>{$row['titre_cours']}</h3>";
            echo "<p>{$row['etudiants']}</p>";
        }
    } else {
        echo "<center><p>Aucun étudiant trouvé.</p></center>";
    }
}

// code pour selecter tous les etudaint qui suivent les cours de prof
//sql code pour appliquer la requete
$sql = "select e.nom as nom, e.prenom as prenom, e.image as image, e.mail as mail, m.titre as titre from utilisateurs as e 
        join courssuivis as cs on e.id = cs.idEtudiant 
        join module as m on cs.idCours = m.id
        where m.proprietaire = ?;";

// Préparation de la requête
$stmt = $conn->prepare($sql);
$etudiants='';
if ($stmt) {
    // Paramètre du professeur a laid de session sto
    $professeur_id =$_SESSION['userID'];
    
    // Liaison des paramètres
    $stmt->bind_param("i", $professeur_id);


    // Exécution de la requête
    $stmt->execute();

    // Récupération des résultats
    $result = $stmt->get_result();

    // Vérification s'il y a des résultats
    // if ($result->num_rows > 0) {
    //     // Affichage des résultats
    //     while ($row = $result->fetch_assoc()) {
    //       $etudiants.= `
    //           <div class="course-item">
    //             <div class="course-item-image">
    //                <img src="./users_images/`.$row['image'].`" width='100' alt="">
    //             </div>
    //             <div class="course-item-text">
    //               <div class="cour-infos">
    //                   <div class="cour-nom">
    //                       <h4>`.$row['titre'].`</h4>
    //                   </div>
    //                   <div class="btn-incri">
    //                       <button>inscrire</button>
    //                   </div>
    //               </div>
    //               <div class="cour-prof">
    //                  <h4 class="prof-nom">pr.jourani</h4>
    //               </div>
    //               </div>
    //          </div>
    //        `;
    //     }
    // } else {
    //     $etudiants="<center><p>Aucun étudiant ne suit votre cours.</p></center>";
    // }
}
?>

<!-- Votre code HTML existant... -->

 <section class='home-grid'>
      <div class="sub-title">
          <div class="title-content">Etudiant suivent <span>mes cours</span></div>
      </div>
          
         <div style="display: flex; flex-direction: row;">
            <?php
                foreach ($result as $etudiant) 
                {
            ?>
                    <div class="identity profPop">
                        <center>
                            <img src="./users_images/<?= $etudiant['image'] ?>" class="image" alt="">
                            <h1 class="name"><?= $etudiant['nom'].' '.$etudiant['prenom']  ?></h1>
                            <h2 style="text-decoration: underline;"><?= $etudiant['mail'] ?></h2>

                            <span style="color: var(--main-color); font-size: 1.4rem;">
                                Cet étudiant suit le cours : 
                                <span style="font-size: 1.6rem;"><?= $etudiant['titre'] ?></span>
                            </span>
                        </center>
                    </div>
            <?php }?>
         </div>
 </section>

<!-- Votre code HTML existant... -->

<?php include 'foot.php'; ?>