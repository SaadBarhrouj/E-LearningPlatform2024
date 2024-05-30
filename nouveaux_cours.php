<?php
include('./includes/connection.inc.php');
include('./includes/fn.inc.php');
require_once'./includes/header.inc.php';
include('./includes/side_profile.inc.php');
if(session_status() === PHP_SESSION_NONE) session_start(); 
if(!$_SESSION['userID']){
    header('Location: login.php');
}

$sql = "SELECT module.titre AS titre_cours,module.presentation,module.cible,module.prerequis,module.est_progressif,module.id,utilisateurs.nom AS nom_proprietaire, utilisateurs.image AS prof_image
FROM module
JOIN utilisateurs ON module.proprietaire = utilisateurs.id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$cours = $result->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="./css/style.css">
    <script defer src="./js/script.js"></script>
   <!-- Mettez ici vos balises meta et titre -->
</head>
<body>
<?php if(!isset($_GET["data"])){?>
    <div <?php if(isset($_GET['details'])) echo 'class="blurred"'; ?>>
        <section class="home-grid">
            <div class="sub-title">
                <h4 class='title-content'>Cours <span>disponibles</span></h4>
            </div>
            <?php if (!empty($cours)) { ?>
                <?php foreach ($cours as $cour) {?>
                    <?php if (!estDejaInscrit($conn, $_SESSION['userID'],$cour['id'])){?>
                        <!--apres mettre $_SESSION['id_cours'] a la place de 1-->
                        <div class="box">
                            <div class="course-item">
                                
                                <div class="course-item-image">
                                    <img src="./users_images/<?php echo $cour['prof_image']; ?>" width='100' alt="">
                                </div>
                                <div class="course-item-text">
                                    <div class="cour-infos">
                                        <div class="cour-nom" style="margin-bottom:3%;margin-left:3%;">
                                            <h4><?php echo $cour['titre_cours'] ?></h4>
                                            <div class="cour-prof">
                                                <h4 class="prof-nom">Prof. &nbsp;<?php echo $cour['nom_proprietaire'] ?></h4>
                                            </div>
                                        </div>
                                        
                                        <div style="display:flex;flex-direction:row;column-gap:2%;">
                                            <form action="./process/process_addCours.php" method="POST">
                                                <input type="hidden" name="id_cours" value="<?php echo $cour['id']; ?>">
                                                <div class="btn-incri">
                                                    <button type="submit" class="btn delete-btn">S'inscrire</button>
                                                </div> 
                                                <textarea name="code_cours" placeholder="Code du cours..." required style="width:100%;cursor:text;"></textarea>
                                            </form>
                                            <form  method="GET">
                                                <div class="btn-incri">
                                                    <button class="btn delete-btn" name="details">Details</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="inscription-box">
                                <div class="icon">
                                    <i class="fa-regular fa-circle-xmark"></i>
                                </div>
                                <div class="pass-box">
                                    <!-- Ici vous pouvez mettre des informations supplémentaires sur le cours -->
                                </div>
                            </div>
                        </div>
                    <?php }else{?>
                        <div class="box">
                            <div class="course-item">
                                
                                <div class="course-item-image">
                                    <img src="./users_images/<?php echo $cour['prof_image']; ?>" width='100' alt="">
                                </div>
                                <div class="course-item-text">
                                    <div class="cour-infos">
                                        <div class="cour-nom" style="margin-bottom:3%;margin-left:3%;">
                                            <h4><?php echo $cour['titre_cours'] ?></h4>
                                            <div class="cour-prof">
                                                <h4 class="prof-nom">Prof. &nbsp;<?php echo $cour['nom_proprietaire'] ?></h4>
                                            </div>
                                        </div>
                                        
                                        <div style="display:flex;flex-direction:row;column-gap:2%;">
                                            <span style="color:var(--bleu);white-space:nowrap;margin-right:2%;margin-top:2%;font-size:2rem"><em>Deja inscrit!</em></span>
                                            <form  method="GET">
                                                <div class="btn-incri">
                                                    <button class="btn delete-btn" name="details">Details</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>


                        <?php }?>
                <?php }?>
            <?php } else { ?>
                <div class="sub-title"><center><p class='title-content'>Pas de cours disponibles pour le moment.</p></center></div>
            <?php } ?>
        </section>
    </div>
    
    <?php 
    }elseif(isset($_GET["data"])){
        if($_GET["data"]=="empty"){
            echo "
            <center>
                <div class=\"sub-title\" >
                    <h4 class='title-content'>
                        <span><strong>Aucun résultat trouvé<strong>
                </div></h4>
            </center>";
        }else{
            $data = explode(',', $_GET["data"]);
            
            echo"<section class=\"home-grid\">";
            foreach ($data as $titre) {
                //var_dump($titre);//reviens
                $sql = "SELECT module.titre titre_cours,module.presentation,module.cible,module.prerequis,module.est_progressif,module.id,utilisateurs.nom AS nom_proprietaire, utilisateurs.image AS prof_image
                FROM module
                JOIN utilisateurs ON module.proprietaire = utilisateurs.id
                WHERE module.titre=?
                ";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $titre);
                $stmt->execute();
                $result = $stmt->get_result();
                $cours = $result->fetch_all(MYSQLI_ASSOC);
                //var_dump($_SERVER['PHP_SELF']);
                ?>
                
                    <div class="sub-title">
                    <?php mysqli_data_seek($result,0);
                    foreach ($cours as $cour) {?>
                        <?php if (!estDejaInscrit($conn, $_SESSION['userID'],$cour['id'])){?>
                        <div class="box" >
                            <div class="course-item">
                                
                                <div class="course-item-image">
                                    <img src="./users_images/<?php echo $cour['prof_image']; ?>" width='100' alt="">
                                </div>
                                <div class="course-item-text">
                                    <div class="cour-infos">
                                        <div class="cour-nom" style="margin-bottom:3%;margin-left:3%;">
                                            <h4><?php echo $cour['titre_cours'] ?></h4>
                                            <div class="cour-prof">
                                                <h4 class="prof-nom">Prof. &nbsp;<?php echo $cour['nom_proprietaire'] ?></h4>
                                            </div>
                                        </div>
                                        
                                        <div style="display:flex;flex-direction:row;column-gap:2%;">
                                            <form action="./process/process_addCours.php" method="POST">
                                                <input type="hidden" name="id_cours" value="<?php echo $cour['id']; ?>">
                                                <div class="btn-incri">
                                                    <button type="submit" class="btn delete-btn">S'inscrire</button>
                                                </div> 
                                                <textarea name="code_cours" placeholder="Code du cours..." required style="width:100%;cursor:text;"></textarea>
                                            </form>
                                            <form  method="GET">
                                                <div class="btn-incri">
                                                    <button class="btn delete-btn" name="details">Details</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="inscription-box">
                                <div class="icon">
                                    <i class="fa-regular fa-circle-xmark"></i>
                                </div>
                                <div class="pass-box">
                                    <!-- Ici vous pouvez mettre des informations supplémentaires sur le cours -->
                                </div>
                            </div>
                        </div>
                        </div>
            <?php }else{?>
                <div class="box">
                            <div class="course-item">
                                
                                <div class="course-item-image">
                                    <img src="./users_images/<?php echo $cour['prof_image']; ?>" width='100' alt="">
                                </div>
                                <div class="course-item-text">
                                    <div class="cour-infos">
                                        <div class="cour-nom" style="margin-bottom:3%;margin-left:3%;">
                                            <h4><?php echo $cour['titre_cours'] ?></h4>
                                            <div class="cour-prof">
                                                <h4 class="prof-nom">Prof. &nbsp;<?php echo $cour['nom_proprietaire'] ?></h4>
                                            </div>
                                        </div>
                                        
                                        <div style="display:flex;flex-direction:row;column-gap:2%;">
                                            <span style="color:var(--bleu);white-space:nowrap;margin-right:2%;margin-top:2%;font-size:2rem"><em>Deja inscrit!</em></span>
                                            <form  method="GET">
                                                <div class="btn-incri">
                                                    <button class="btn delete-btn" name="details">Details</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>




                <?php }?>
        <?php
            }
        }
    }
    }
    ?>
    <?php if(isset($_GET['details'])) { ?>
        <!-- Message container pour afficher le message -->
        <div class="message-container" id="messageContainer">
            <div class="sub-title"><h1 class='title-content'><span>Details du cours <?php echo $cour['titre_cours']?><span></h1></div>
            <h1>Proprietaire du cours: M. <?php echo $cour['nom_proprietaire'] ?></h1>
            <br>
            <h1>Titre: <?php echo $cour['titre_cours'] ?></h1>
            <br>
            <h1>Presentation: <?php echo $cour['presentation'] ?></h1>
            <br>
            <h1>Cible: <?php echo $cour['cible'] ?></h1>
            <br>
            <h1>Prerequis: <?php echo $cour['prerequis'] ?></h1>
            <br>
            <h1>Acces direct a tous les chapitres: <?php echo ($cour['est_progressif'])?"NON":"OUI" ;?></h1>
            <br>
            <h1>Prix: Gratuit</h1>
            <br>
            <center><button onclick="closeDetails()" style="background-color:transparent;font-weight:bold;"><h2>Fermer</h2></button></center>
        </div>
    <?php }?>


</body>

</html>
