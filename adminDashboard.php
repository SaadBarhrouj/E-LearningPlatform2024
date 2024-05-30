<?php include('./includes/connection.inc.php'); ?>
<?php include('./includes/header.inc.php'); ?>
<?php
    function isUserAdmin($conn, $userID){
        $stmt = $conn->query("select count(*) as nb from admin where id = ".$userID);
        $res = $stmt->fetch_assoc();
        return ($res['nb'] > 0)? true : false ;
    }
?>

<!-- checking if session is an admin's session -->
<?php
    if(session_status() === PHP_SESSION_NONE) session_start(); 

    $condition = !$_SESSION['userID'] || (isset($_SESSION['userID']) && !isUserAdmin($conn, $_SESSION['userID']));
    if($condition){
        header('Location: ./EnL_aDmIN/adminLogin.php');
    }
?>

<!-- RECUPERATION DES DONNEES GENERALES DE LA BASE DE DONNEES -->
<?php include('./process/process_fetching_data_by_admin.php'); ?>

<!-- HTML CONTENT -->
<section >
    <?php include('./includes/side_profile.inc.php'); ?>

    <div class="ongletBtn">
        <button class="items-btn active-item" onclick="openTab(event, 'tab1')"> Générales</button>
        <button class="items-btn" onclick="openTab(event, 'tab2')">Professeur</button>
        <button class="items-btn" onclick="openTab(event, 'tab3')">Etudiant</button>
        <button class="items-btn" onclick="openTab(event, 'tab4')">
            Message  
            <?php echo ($nb_non_lu > 0)? "<span>".$nb_non_lu."</span>" : "" ?>
        </button>
    </div>

    <!-- General information content -->
    <div id="tab1" class="ongletContent" style="display: block;">
        <?php include('./EnL_aDmIN/general_info.php') ?>
    </div>

    <!-- Prof information -->
    <div id="tab2" class="ongletContent">
        <div class="tab2Content">
            <div class="listeProf liste">
                <!-- tableau des Profs ici -->
            </div>
            <hr>
            <div class="coursProf" style="display: none;">
                <!-- Liste des cours selon le prof choisi est affichée ici -->
            </div>
        </div>
    </div>

    <!-- Student information -->
    <div id="tab3" class="ongletContent">
        <div class="tab2Content">
            <div class="listeEtudiant liste">
                <!-- tableau des étudiants ici -->
                
            </div>
            <hr>
            <div class="cours_suivis" style="display: none;">
                <!-- Liste des cours selon le prof choisi est affichée ici -->

            </div>
        </div>
    </div>

    <!-- Boîte de réception -->
    <div id="tab4" class="ongletContent">
        <div class="tab2Content">
            <div class="boite_recep">
                <!-- boîte de réception -->
            </div>
            <hr>
            <div class="msg_content" style="display: none;">
                <!-- Contenu du message -->

            </div>
        </div>
    </div>

</section>

<div class="popUp" style="display: none;">
    <div class="content ">
        <input type="number" name="userId" id="userId" value="" hidden>
        <input type="text" name="userRole" id="userRole" value="" hidden>
        <span> <!-- Confirmation text --></span> <br>
        <div>
            <button class="delete-btn" onclick="delUser(parseInt(document.querySelector('.content #userId').value), document.querySelector('.content #userRole').value)">Effacer</button>
            <button class="main-btn" onclick="hidePopUp();">Annuler</button>
        </div>
    </div>
</div>

<script src="./js/admin_script.js"></script>
<?php include('./includes/footer.inc.php'); ?>
