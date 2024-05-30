<?php 
session_start();
session_unset();
session_destroy();
// include("../includes/header.inc.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>
   <header class="headerHome">   
         <div class="left-content">
               <a href="#" class="logo">
                  <img src="../logo/logo.png" class='logo' width='50' alt="">
               </a>
         </div>
         <div class="rightContent">
               <nav class="navbar">
                  <a href="#" role="button" aria-pressed="true" class="home-navbar-btn">Connexion</a>
               </nav>
               
               <div class="icons" >
                  <div id="toggle-btn" class="ri-sun-line"></div>
               </div>
         </div>
   </header>
   <div class="home">
      <div class="homeContent" style="margin-top: 10rem;">
         <div class="form-container">
            <form action="../process/process_login.php" method="POST">
               <h3>Se connecter en tant qu'Administrateur</h3>
               <input type="checkbox" name="isAdmin" id="isAdmin" checked hidden> <br> <br>
               <label for="mail">VOTRE EMAIL <span>*</span></label>
               <input id="mail" type="email" name="email" placeholder="ENTREZ VOTRE EMAIL..." required maxlength="50" class="box">
               <label for="password" >VOTRE MOT DE PASSE <span>*</span></label>
               <input id="password" type="password" name="password" placeholder="ENTREZ VOTRE MOT DE PASSE..." required maxlength="20" class="box">

               <input type="submit" value="SE CONNECTER" name="send" class="btn main-btn" style="margin-left: 24%; margin-top: 4rem;">

            </form>
         </div>
      </div>
      <div class="image">
         <img src="../images/online.png" alt="home-image">
      </div>
   </div>
  
<script src="../js/script.js"></script>
</body>
</html>
