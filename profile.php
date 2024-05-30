<?php
include('./includes/connection.inc.php');
include('./includes/fn.inc.php');
require_once'./includes/header.inc.php';
if(session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>profile</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body


<section class="user-profile">

   <center><h1 class="heading">Votre Profil</h1><center>

   <div class="info">

      <div class="user">
         <img src="./users_images/<?php echo $_SESSION['image'] ?>" class="image" alt="">
         <h3 class="name"><?php echo $_SESSION['name'] ?></h3>
         <p class="role"><?php echo $_SESSION['user']?></p>
          <div class='center_div' style="flex-direction: row; width: 40%; margin: 5rem auto;">
            <a href="update_profil.php" class="btn main-btn">update profile</a>
            <form method="get">
               <button type="submit" name="details" class="btn delete-btn">Supprimer compte</button>
            </form>
         </div>
      </div>
      <h1><?php echo (isset($_GET['message']))? $_GET['message'] : ""; ?></h1>  
   </div>

   <?php if(isset($_GET['details'])){?>

      <!-- Message container pour afficher le box de confirmation et envoyer la raison de demande de suppression -->
      <div class="popUp">
         <div class="message-container" id="messageContainer">
            <div class="sub-title"><h1 class='title-content'>Demande de <span>suppression de compte<span></h1></div>
            
            <form action="./process/process_sending_delete_demande.php" method="post" style="text-align: left; font-size: 1.5rem;">
               <div class="center_div">
                  <div>
                     <input type="number" name="userId" id="userId" value="<?= $_SESSION['userID']?>" hidden>
                     <label for="nom">Nom&Prenom:  </label> <input type="text" name="nom" id="nom" value="<?= $_SESSION['name'].' '.$_SESSION['prenom'] ?>" readonly>
                     <br>
                     <label for="mail">Mail:  </label> <input type="text" name="mail" id="mail" value="<?= $_SESSION['email'] ?>" readonly>
                     <br>
                     <label for="raison">Raison: </label> <br>
                     <textarea name="raison" id="raison" cols="30" rows="5"></textarea>
                  </div>
               </div>
               <div class='center_div' style="flex-direction: row; width: 60%; margin: .8rem auto;">
                  <label style="margin: 0rem 1rem;" onclick="closeDetails()" class="btn main-btn">Annuler</label>
                  <button style="margin: 0rem 1rem;" type="submit" class="btn delete-btn">Envoyer</button>
               </div>
            </form>   
         </div>
      </div>

   <?php } ?>

</section>


<!-- custom js file link  -->
<script src="js/script.js"></script>

   
</body>
</html>