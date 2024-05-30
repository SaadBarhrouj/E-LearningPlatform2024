<?php
// Vérifier si une session est déjà active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclure les fichiers nécessaires
include('./includes/connection.inc.php');
include('./includes/fn.inc.php');
require_once './includes/header.inc.php';
include('./includes/side_profile.inc.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
    exit; // Assurez-vous de terminer le script après la redirection
}

// Récupérer les informations de l'utilisateur connecté
$userID = $_SESSION['userID'];
$sql = "SELECT * FROM utilisateurs WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    die('Erreur de préparation de la requête SQL : ' . mysqli_error($conn));
}
mysqli_stmt_bind_param($stmt, "i", $userID);
if (!mysqli_stmt_execute($stmt)) {
    die('Erreur lors de l\'exécution de la requête SQL : ' . mysqli_error($conn));
}
$result = mysqli_stmt_get_result($stmt);
if (!$result) {
    die('Erreur lors de la récupération du résultat : ' . mysqli_error($conn));
}
$user = mysqli_fetch_assoc($result);
if (!$user) {
    die('Aucun utilisateur trouvé avec cet ID.');
}

// Vérifier si le formulaire de modification a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifier_profil'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $mail = $_POST['mail'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Mettre à jour les informations dans la base de données
    $sql_update = "UPDATE utilisateurs SET nom=?, prenom=?, mail=?, password=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql_update);
    if (!$stmt) {
        die('Erreur de préparation de la requête SQL : ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "ssssi", $nom, $prenom, $mail, $mot_de_passe, $userID);
    if (!mysqli_stmt_execute($stmt)) {
        die('Erreur lors de l\'exécution de la requête SQL : ' . mysqli_error($conn));
    }
    
    // Vérifier si la mise à jour a réussi
    if (mysqli_affected_rows($conn) > 0) {
        $message = "Profil mis à jour avec succès.";
    } else {
        $error = "Aucune modification apportée au profil.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de profil des Profs</title>
</head>
<body>
    <h1>Gestion de profil des Profs</h1>
    
    <?php if (isset($message)) { ?>
        <p style="color: green;"><?php echo $message; ?></p>
    <?php } ?>
    
    <?php if (isset($error)) { ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php } ?>
    
   <section class="home-grid">
   <form method="POST">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>"><br><br>
        
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($user['prenom']); ?>"><br><br>
        
        <label for="mail">E-mail :</label>
        <input type="email" id="mail" name="mail" value="<?php echo htmlspecialchars($user['mail']); ?>"><br><br>
        
        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" value="<?php echo htmlspecialchars($user['password']); ?>"><br><br>
        
        <button type="submit" name="modifier_profil">Modifier le profil</button>
    </form>
    </section>
</body>
</html>
