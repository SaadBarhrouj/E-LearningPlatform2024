<?php
include("./includes/header.inc.php");
session_unset();
session_destroy();
?><!-- si le remember me token n'est pas selectionne-->

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

   <?php include('./includes/navAccueil.php') ?>
   <div class="home">
      <div class="homeContent">
         <div class="form-container" style="margin-top: 12rem;">
            <form action="process/process_login.php" method="POST">
               <h3>SE CONNECTER</h3>
               <label for="mail">VOTRE EMAIL <span>*</span></label>
               <input id="mail" type="email" name="email" placeholder="Entrez votre email..." required maxlength="50" class="box">
               <label for="password">VOTRE MOT DE PASSE <span>*</span></label>
               <input id="password" type="password" name="password" placeholder="Entrez votre mot de passe..." required maxlength="20" class="box">

               <?php echo isset($_GET['error'])? "<span style=\"color: var(--red);\">E-mail ou mot de passe invalide.</span>" : ""; ?>
               <input type="submit" value="SE CONNECTER" name="send" class="btn main-btn" style="margin-left: 24%; margin-top: 4rem;">
            </form>
         </div>
      </div>
      <div class="image">
         <img src="images/online.png" alt="home-image">
      </div>
   </div>
    
   <!-- custom js file link  -->
   <script src="js/script.js"></script>
</body>
</html>