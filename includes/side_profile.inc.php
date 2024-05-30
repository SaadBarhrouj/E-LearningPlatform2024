<?php $is_newCours_page = basename($_SERVER['PHP_SELF']) === 'nouveaux_cours.php';?>
<?php if(session_status()==PHP_SESSION_NONE) session_start();?>
<div class="side-bar">

   <div id="close-btn">
      <i class="fas fa-times"></i>
   </div>

   <div class="profile">
      <img src="./users_images/<?php echo $_SESSION['image'] ?>" class="image" alt="">
      <h3 class="name"><?php echo $_SESSION['name']?></h3>
      <p class="role"><?php echo $_SESSION['user'] ?></p>
      <a href="profile.php" class='btn-container ' ><button  class="btn  main-btn">voir profile</button></a>
      <?php if($_SESSION['user'] == 'etudiant' && !$is_newCours_page){ ?>
         <div class="out">
            <form method="GET" action="./nouveaux_cours.php">
                  <div class="btn-container">
                     <button type='submit' class="btn main-btn">Inscriptions Cours</button>
                  </div> 
            </form>
         </div>
      <?php } else if ($is_newCours_page){?>
         <div class="out">
            <form method="GET" action="./home_etudiant.php">
                  <div class="btn-container">
                     <button type='submit' name='home_etudiant' class="btn main-btn">Retour aux Cours</button>
                  </div> 
            </form>
         </div>
         <?php }?>
      <div class="out">
         <form method="GET" action="./logout.php">
            <div class="btn-container">
               <button type='submit' name='out' class="btn delete-btn">Deconnexion</button>
            </div> 
         </form>
      </div>
     

   </div>

 <!-- //navar items -->
</div>