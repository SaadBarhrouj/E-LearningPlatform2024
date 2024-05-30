<?php if(session_status() === PHP_SESSION_NONE) session_start(); 
if(isset($_SESSION['userID']) &&  $_SESSION['user']!="administrateur") include('etudiants_messages.php');
$is_lecture_page = basename($_SERVER['PHP_SELF']) === 'lecture.php';
$is_index_page = basename($_SERVER['PHP_SELF']) === 'index.php';
$is_login_page = basename($_SERVER['PHP_SELF']) === 'login.php';
$is_register_page = basename($_SERVER['PHP_SELF']) === 'register.php';
$is_lectureP_page = basename($_SERVER['PHP_SELF']) === 'lectureProgressif.php';
$is_admin_dashBoard = basename($_SERVER['PHP_SELF']) === 'adminDashboard.php';
$is_adminLogin = basename($_SERVER['PHP_SELF']) === 'adminLogin.php';
$is_admin_register = basename($_SERVER['PHP_SELF']) === 'admin_register.php';

$workdir = (!$is_admin_register && !$is_adminLogin)? "." : "..";

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
   <link rel="stylesheet" href="<?= $workdir ?>/css/style.css">
   <script defer src="<?= $workdir ?>/js/script.js"></script>
   <script defer src="<?= $workdir ?>/js/admin_script.js"></script>
</head>
<body>

<header class="header">
   <section class="flex">
      
      <div class="left-content">
         <a href="../logout.php" class="logo">
            <img src="<?= $workdir ?>/logo/logo.png" class='logo' width='50' alt="">
         </a>
      </div>
      <?php if(isset($_SESSION['userID']) && !$is_index_page && !$is_login_page && !$is_admin_dashBoard && !$is_register_page && isset($_SESSION['user']) && $_SESSION['user'] != "administrateur"){ ?>
         
            <nav class="navbar">
               <a href="<?php echo (isset($_SERVER['HTTP_REFERER']))?$_SERVER['HTTP_REFERER']:NULL?>"><i class="ri-home-4-fill"></i></i><span>home</span></a>
               <a href="devoir.php"><i class="ri-briefcase-fill"></i><span>devoirs</span></a>
               <a href="about.php"><i class="ri-question-mark"></i><span>a propos</span></a>
               <a href="contact.php"><i class="ri-mail-fill"></i><span>contact</span></a>
            </nav>
         
     
      <!-- Pour l'icone message: affichage message-->
      <div class="popUp" style="display: none;" id="msg">
         <div class="content" style="width:90%;height:90%;">
            <input type="number" name="userId" id="userId" value="" hidden>
            <input type="text" name="userRole" id="userRole" value="" hidden>
            <div>

               <div class="sub-title">
                  <div class="title-content">
                     <span>Boîte de réception</span>
                  </div> 
               </div>
            </div>
            <br>
          <table>
               <thead>
                  <tr>
                     <th>ID Message</th>
                     <th>Contenu</th>
                     <th>Reçu de </th>
                     <th>Cours</th>
                  </tr> 
               </thead>
            <tbody>
               <?php
                     $userID=$_SESSION['userID'];
                     // Récupérer les messages des étudiants pour cet administrateur
                     $message_execution = "SELECT message.id AS message_id, 
                     message.contenu AS message_contenu,
                     CONCAT_WS(' ', expediteur.nom, expediteur.prenom) AS expediteur_nom_prenom,
                     module.titre AS cours_titre
                     FROM message
                     INNER JOIN utilisateurs AS expediteur ON message.idExpediteur = expediteur.id
                     INNER JOIN module ON message.idCours = module.id
                     WHERE message.idRecepteur = $userID";

                     $result = mysqli_query($conn,$message_execution);
                     // Afficher les messages
                     if (mysqli_num_rows($result ) > 0) {
                         while($row = mysqli_fetch_assoc($result )) {
                           echo '<tr>
                           <td>' . $row['message_id'] . '</td>
                           <td>' . $row['message_contenu'] . '</td>
                           <td>' . $row['expediteur_nom_prenom'] . '</td>
                           <td>' . $row['cours_titre'] . '</td>
                           </tr>';
                         }
                     }
                    
               ?>
           </tbody>
         </table>
            <div>
               <button class="main-btn" onclick="hidePopUp();document.querySelector('.side-bar').style.display='flex'">Fermer</button>
            </div>
         </div>
      </div>
      <?php } ?>
         <!--Fin affichage -->
      <div class="icons">
         <?php if(!$is_index_page && !$is_login_page &&!$is_admin_dashBoard && isset($_SESSION['user']) && $_SESSION['user'] != "administrateur"){ ?>
            <button style="background-color:transparent" onclick="document.getElementById('msg').style.display='flex';document.querySelector('.side-bar').style.display='none';" > 
               <div id="menu-btn" class="ri-chat-1-line">              
                  <?php if(isset($_SESSION['userID'])) echo ($nb_non_lu > 0)? "<span style=\"background-color:red;border-radius:100%;padding:3%;padding-right:4%;padding-left:4%\">".$nb_non_lu."</span>" : "<span style=\"background-color:red;border-radius:100%;padding:3%;padding-right:4%;padding-left:4%\">0</span>" ?>
               </div>
            </button>
         <?php }?>
         <div id="toggle-btn" class="ri-sun-line"></div>
      </div>
      
   </section>

</header>
