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
   <title>Contact</title>
   <!-- font awesome cdn link  -->
   <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"
    rel="stylesheet"
   />
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body> 


<section class="contact">

   <div class="row">

      <div class="image">
         <img src="images/contact-img.svg" alt="">
      </div>

      <form action="" method="post">
         <h3>Nous contacter</h3>
         <input type="text" placeholder="Votre nom" name="name" required maxlength="50" class="box">
         <input type="email" placeholder="Voitre email" name="email" required maxlength="50" class="box">
         <input type="number" placeholder="Votre numéro" name="number" required maxlength="50" class="box">
         <textarea name="msg" class="box" placeholder="Votre message" required maxlength="1000" cols="30" rows="10"></textarea>
         <input type="submit" value="send message" class="btn main-btn" name="submit">
      </form>

   </div>

   <div class="box-container">

      <div class="box">
         <i class="fas fa-phone"></i>
         <h3>Téléphone</h3>
         <a href="tel:1234567890">+212777479547</a>
         <a href="tel:1112223333">+212777479548</a>
      </div>
      
      <div class="box">
         <i class="fas fa-envelope"></i>
         <h3>e-mail</h3>
         <a href="mailto:enl@gmail.com">enl@gmail.come</a>
         <a href="mailto:enladmin@gmail.com">enladmin@gmail.come</a>
      </div>

      <div class="box">
         <i class="fas fa-map-marker-alt"></i>
         <h3>Adresse</h3>
         <a href="#">Tétouan - Maroc</a>
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