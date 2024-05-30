<?php include('./includes/connection.inc.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css">
    <title>EnL home</title>
</head>
<body>
    <!-- Cookieee-->
    <?php
    // Vérifie si le cookie "cookiesAccepted" est défini et s'il est égal à true
    if (!isset($_COOKIE['cookiesAccepted']) || $_COOKIE['cookiesAccepted'] !== 'true') {
        // Si les cookies ne sont pas acceptés ou le cookie n'est pas défini, affiche la bannière de cookies
        echo '<div class="cookie-banner" id="cookieBanner">
            En utilisant notre site, vous acceptez notre utilisation de cookies. 
            <button class="cookie-btn" onclick="acceptCookies()">Accepter</button>
            <button class="cookie-btn" onclick="rejectCookies()">Refuser</button>
        </div>';
    }
    ?>
                

    <?php include('./includes/navAccueil.php') ?>
    <div class="home">
        <div class="homeContent">
            <div class="welcome">
                <h2>Explorez l'éducation en ligne sur <span>"EnL"</span> : des cours passionnants, des instructeurs experts. Développez vos compétences dès maintenant !</h2>
                <blockquote class="citation">
                    « L'éducation est l'arme la plus puissante que l'on puisse utiliser pour changer le monde » 
                    <span>-Nelson Mandela.</span>
                </blockquote>
                <div class="option">
                    <a href="register.php" role="button" aria-pressed="true" class="btn-getStarted">Commencer maintenant</a>
                </div>
            </div>
        </div>
        <div class="image">
            <img src="images/online.png" alt="home-image">
        </div>
    </div>

    <script src="js/script.js"></script>
    <!-- Script pour gérer l'acceptation des cookies -->
    <script>
        function acceptCookies() {
            // Enregistre l'acceptation des cookies dans un cookie nommé "cookiesAccepted" avec une durée de validité de 30 jours
            document.cookie = "cookiesAccepted=true; max-age=" + 7 * 24 * 60 * 60;
            // Recharge la page pour masquer la bannière de cookies
            document.getElementById('cookieBanner').style.display='none';
        }

        function rejectCookies() {
            // Enregistre le refus des cookies dans un cookie nommé "cookiesAccepted" avec une durée de validité de 30 jours
            document.cookie = "cookiesAccepted=false; max-age=" + 7 * 24 * 60 * 60;
            // Recharge la page pour masquer la bannière de cookies
            document.getElementById('cookieBanner').style.display='none';
        }
    </script>
</body>
</html>
