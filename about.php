<?php
include('./includes/connection.inc.php');
include('./includes/fn.inc.php');
require_once'./includes/header.inc.php';
if(session_status() === PHP_SESSION_NONE) session_start();
if(!$_SESSION['name']){
   header('Location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>
   <!-- font awesome cdn link  -->
   <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"
    rel="stylesheet"
   />
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- //home grid -->
<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/about-img.svg" alt="">
      </div>

      <div class="content">
         <h3>pourquoi choisir nous?</h3>
         <p>
            Choisir notre plateforme d'éducation en ligne est une décision éclairée pour plusieurs raisons. Tout d'abord, nous offrons une vaste gamme de cours dans divers domaines, adaptés à tous les niveaux d'apprentissage. Que vous soyez un débutant cherchant à acquérir de nouvelles compétences ou un professionnel désireux de se perfectionner, notre plateforme propose des cours pertinents et de qualité pour répondre à vos besoins. De plus, notre approche pédagogique interactive et engageante vous permet d'apprendre à votre propre rythme, où que vous soyez et quand vous le souhaitez. Enfin, notre équipe d'instructeurs qualifiés et notre soutien technique dévoué sont là pour vous accompagner à chaque étape de votre parcours d'apprentissage. Rejoignez-nous dès aujourd'hui et commencez à réaliser vos objectifs éducatifs avec confiance et succès.
         </p>
      </div>

   </div>

   <div class="box-container">

      <div class="box">
         <i class="fas fa-graduation-cap"></i>
         <div>
            <h3>+10k</h3>
            <p>Cours</p>
         </div>
      </div>

      <div class="box">
         <i class="fas fa-user-graduate"></i>
         <div>
            <h3>+40k</h3>
            <p>Etudiants</p>
         </div>
      </div>

      <div class="box">
         <i class="fas fa-chalkboard-user"></i>
         <div>
            <h3>+2k</h3>
            <p>Professeurs</p>
         </div>
      </div>
   </div>

</section> 


<!-- <footer class="footer">

   &copy; copyright @ 2022 by <span>mr. web designer</span> | all rights reserved!

</footer> -->

<!-- custom js file link  -->
<script src="js/script.js"></script>

   
</body>
</html>