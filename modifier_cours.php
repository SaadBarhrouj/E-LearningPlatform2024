<?php
include('./includes/connection.inc.php');
include('./includes/fn.inc.php');
require_once './includes/header.inc.php';
include('./includes/side_profile.inc.php');

if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
    exit; // Assurez-vous de terminer le script après la redirection
}

if (isset($_GET['courID'])) {
    $courID = $_GET['courID'];
    $sql = "SELECT * FROM module WHERE id = $courID";
    $query = mysqli_query($conn, $sql);
    $cour = mysqli_fetch_assoc($query);
}

if (isset($_POST['modifier_course'])) {
    // Récupérer les données du formulaire
    $titre = $_POST['titre'];
    $presentation = $_POST['presentation'];
    $mots_cles = $_POST['mots_cles'];
    $cible = $_POST['cible'];
    $prerequis = $_POST['prerequis'];
    $code_cours = $_POST['Code_Cours'];
    $est_progressif = isset($_POST['progressif']) && $_POST['progressif'] === 'progressif' ? 1 : 0;

    // Mettre à jour les données du cours dans la base de données
    $sql = "UPDATE module SET titre = '$titre', presentation = '$presentation', mots_cles = '$mots_cles', cible = '$cible', prerequis = '$prerequis', Code_Cours = '$code_cours', est_progressif = $est_progressif WHERE id = $courID";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        $message = 1;
    } else {
        $message = 0;
    }
}
?>

<style>
    .myform {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .input-pass {
        margin-bottom: 10px;
    }

    
    .input-pass input[type="radio"] {
        width: 300px; /* Ajustez la largeur selon vos besoins */
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        transition: all 0.3s; /* Transition pour le survol */
        font-size: 10px; /* Taille de police */
    }
    .input-pass input[type="text"] {
        width: 300px; /* Ajustez la largeur selon vos besoins */
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        transition: all 0.3s; /* Transition pour le survol */
        font-size: 15px; /* Taille de police */
    }
    /* Ajout de styles pour le survol */
    .input-pass input[type="text"]:hover,
    .input-pass input[type="radio"]:hover {
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.3); /* Ombre de boîte au survol */
    }

    .input-pass label {
        font-size: 20px;
        font-weight: 700;
        color: var(--black);
    }

    .main-btn {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
</style>


<form method="POST" class="myform">
    <?php
        if(isset($message)){
            echo ($message == 1)? "<span style=\"color: var(--bleu);\">Le cours a été modifié avec succès.</span>" :
                                  "<span style=\"color: var(--red);\">Erreur lors de la modification du cours</span>";
        }
    ?>
    <div class="input-pass">
        <label for="titre">Intitule du cours:</label>
        <input type="text" id="titre" name='titre' class="box" value="<?php echo $cour['titre']; ?>">
    </div>
    <div class="input-pass">
        <label for="presentation">Presentation du cours:</label>
        <input type="text" id="presentation" name='presentation' class="box" value="<?php echo $cour['presentation']; ?>">
    </div>
    <div class="input-pass">
        <label for="mots_cles" >Mots cles se rapportant au cours:</label>
        <input type="text" id="mots_cles" name='mots_cles' class="box" value="<?php echo $cour['mots_cles']; ?>">
    </div>
    <div class="input-pass">
        <label for="cible" >Public vise:</label>
        <input type="text" id="cible" name='cible' class="box" value="<?php echo $cour['cible']; ?>">
    </div>
    <div class="input-pass">
        <label for="prerequis" >Prerequis:</label>
        <input type="text" id="prerequis" name='prerequis' class="box" value="<?php echo $cour['prerequis']; ?>">
    </div>
    <div class="input-pass">
        <label for="Code_Cours" >Entrez le mot de pass du cours:</label>
        <input type="text" id="Code_Cours" name='Code_Cours' class="box" value="<?php echo $cour['Code_Cours']; ?>">
    </div>
    <div class="isProgBox">
        <span>
            <input type="radio" name="progressif" value="progressif" id="oui" <?php if ($cour['est_progressif']) echo "checked"; ?>><label id="oui">Visibilité Progressive</label>
        </span>
        <span>
            <input type="radio" name="progressif" value="non_progressif" id="non" <?php if (!$cour['est_progressif']) echo "checked"; ?>><label id="non">Visibilité Non Progressive</label>
        </span>
    </div>


    <!-- Ajoutez un champ hidden pour envoyer l'ID du cours -->
    <input type="hidden" name="courID" value="<?php echo $courID; ?>">

    <button type='submit' name='modifier_course' class='btn main-btn'>Modifier</button>
</form>



<?php include 'foot.php'; ?>
