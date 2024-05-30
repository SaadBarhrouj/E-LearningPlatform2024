<?php
include('./includes/connection.inc.php');
include('./includes/fn.inc.php');
require_once'./includes/header.inc.php';
if(session_status() === PHP_SESSION_NONE) session_start(); 
if(isset($_GET['courID'])) {
    $nomCours=$_GET['nomCours'];
    $courID = $_GET['courID'];
    $sql = "SELECT * FROM chapitre WHERE IdModule = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $courID);
    $stmt->execute();
    $result = $stmt->get_result();
if(!est_progressif($conn,$courID,$nomCours)){
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "
            <section class=\"home-grid\">
                <div class=\"box\">
                    <div class=\"course-item\">
                        <div class=\"course-item-text\">
                            <div class=\"cour-infos\">
                                <div class=\"cour-nom\">
                                    <h4> $row[contenu]</h4>
                                </div>
                                <div class=\"cour-infos\" style=\"column-gap:2%;\">
                                    <div class=\"center_div\">
                                        <button class=\"btn main-btn\" onclick=\"window.open('./ressources_cours/$row[contenu]', '_blank')\">Lecture</button>

                                        </a>
                                    </div> 
                                    <div class=\"center_div\" >
                                        <button class=\"btn delete-btn\" onclick=\"alert('hey, good job!')\">Done</button>
                                    </div> 
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </section>
            ";

        }
    } else {
        echo "<div class=\"sub-title\" style=\"margin-left:30%;margin-top:10%\"><h1 class='title-content'>Aucun <span>chapitre</span> disponible pour ce cours.</h1><div>";
    }
}else{
    if($result->num_rows > 0) {
        mysqli_data_seek($result, 0);
        
        $chapitrePrecedentDone = true; 
        while($row = $result->fetch_assoc()) {
            echo '<form action="./process/process_chapitre.php" method="POST">';
            echo "
            <section class=\"home-grid\" style=\"padding-bottom:0\">
            <div class=\"box\">
                <div class=\"course-item\">
                     <div class=\"course-item-text\">
                         <div class=\"cour-infos\">
                             <div class=\"cour-nom\">
                                 <h4>$row[contenu]</h4>
                             </div>
                             <div class=\"cour-infos\" style=\"column-gap:2%;\">
                                <input type=\"hidden\" name=\"chapitre_ids[]\" value=\"". $row['IdChap'] ."\">
                                <input type=\"hidden\" name=\"contenu\" value=\"". $row['contenu'] . "\">
                                <div class=\"center_div\">

                                    <a>
                                        <button class=\"btn main-btn\" type=\"submit\" name=\"action\" value=\"Lecture\" " . ($chapitrePrecedentDone ? "" : " disabled style=\"background-color:darkgrey\"").">Lecture</button>
                                    </a>
                                </div>
                                <div class=\"center_div\" >
                                    <button class=\"btn delete-btn\" type=\"submit\" name=\"action\" value=\"$row[IdChap]\"" . ($chapitrePrecedentDone ? "" : " disabled style=\"background-color:darkgrey\"") . " onclick=\"alert('Hey that\'s very good, keep up the good work')\">Done</button>;
                                </div> 
                             </div>
                        </div>
                        
                     </div>
                  </div>
            </div>
            </section>
            </form>
            ";
            $chapitrePrecedentDone = $row['accessible'] == 1;
        }
    } else {
        echo "<div class=\"sub-title\" style=\"margin-left:30%;margin-top:10%\"><h1 class='title-content'>Aucun <span>chapitre</span> disponible pour ce cours.</h1><div>";
    }
    

}
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/style.css">
    <script defer src="./js/script.js"></script>
</head>
<body>
    <div class="side-bar" style="display:flex;flex-direction:row;">

        <div class="profile" style="display:flex;flex-direction:row;column-gap:1%;">

            <div class="button-container">
            
                <div class="side-bar">
                    <?php echo "<div class=\"sub-title\" ><h1 class='title-content'>Module <span>$nomCours</span></h1><div>";?>
                    <button type="button" class="custom-button" onclick="toggleUnderline(this)">
                        <h1 class="button-text title-content"  style="margin-top:10%;"><span>Ressources</span></h1>
                    </button>
                    <br>
                    <br>
                    <div class="dropdown-content" id="ressourcesDropdown" style="overflow-y: auto; max-height: 400px;">
                        <?php 
                    if(!est_progressif($conn,$courID,$nomCours)){
                        if($result->num_rows > 0) {
                            mysqli_data_seek($result, 0);
                            while($row = $result->fetch_assoc()) {
                                echo "
                                <div class=\"course-item-text\">
                                <center><div class=\"cour-nom\">
                                <a style=\"color:white;font-weight:bold;\" href=\"./ressources_cours/$row[contenu]\" ><h4 class=\"button-text title-content\">". $row['contenu']."
                                <svg width=\"74\" height=\"20\" fill=\"none\" stroke=\"currentColor\" stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" viewBox=\"0 -2 25 24\" xmlns=\"http://www.w3.org/2000/svg\">
                                    <path d=\"M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4\"></path>
                                    <path d=\"m7 10 5 5 5-5\"></path>
                                    <path d=\"M12 15V3\"></path>
                                </svg>
                                " ."</h4></a>
                                </div>
                                </center>
                                </div>";

                            }
                        }
                    else {
                            echo "<h4 class='title-content' style=\"font-size:100%;\">Auccune <span>ressource</span> disponible pour ce cours.</h4>";
                        } 
                    }else{
                        if($result->num_rows > 0) {
                            mysqli_data_seek($result, 0);
                            
                            $chapitrePrecedentDone = true; 
                            while($row = $result->fetch_assoc()) {
                                echo "
                                <div class=\"course-item-text\">
                                <center><div class=\"cour-nom\">
                                <a style=\"color:white;font-weight:bold;display:".($chapitrePrecedentDone ? "":'none')."\" href=\"ressources_cours/$row[contenu].pdf\" ><h4 class=\"button-text title-content\">". $row['contenu']."
                                <svg style=\"display:".($chapitrePrecedentDone ? "":'none')."\"; width=\"74\" height=\"20\" fill=\"none\" stroke=\"currentColor\" stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" viewBox=\"0 -2 25 24\" xmlns=\"http://www.w3.org/2000/svg\">
                                    <path d=\"M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4\"></path>
                                    <path d=\"m7 10 5 5 5-5\"></path>
                                    <path d=\"M12 15V3\"></path>
                                </svg>
                                " ."</h4></a>
                                </div>
                                </center>
                                </div>";
                                $chapitrePrecedentDone = $row['accessible'] == 1;
                            }
                    }
                 } ?>
                    </div>
                </div>
            </div>


        </div>
        </div>
        

</body>
</html>
<?php }else{ 
    
    header('Location: home_etudiant.php');}
    ?>
