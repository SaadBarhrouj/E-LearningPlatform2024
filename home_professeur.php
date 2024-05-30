<?php
 //for connect
 include('./includes/connection.inc.php');
 include('./includes/fn.inc.php');
 require_once './includes/header.inc.php';
 include('./includes/side_profile.inc.php');

 if(session_status() === PHP_SESSION_NONE) session_start(); 

 //vérifie la session si c'est vraiment un user (prof ou etudiant) et rediriger vers login
 $condition = !$_SESSION['userID'] || (isset($_SESSION['userID']) && !isUser($conn, $_SESSION['userID']));
 if($condition){
     header('Location: ./login.php');
 }
 $userID=$_SESSION['userID'];

//ajouter module
if (isset($_POST['ajouter_module'])) {
    if (!empty($_POST['titre']) && !empty($_POST['Code_Cours'])) {
        $titre = $_POST['titre'];
        $presentation = $_POST['presentation'];
        $mots_cles = $_POST['mots_cles'];
        $cible = $_POST['cible'];
        $prerequis = $_POST['prerequis'];
        $code_cours = $_POST['Code_Cours'];
        $proprietaire = $_SESSION['userID'];
        $userID=$_SESSION['userID'];
        // Vérification de la visibilité progressive
        $est_progressif = isset($_POST['progressif']) && $_POST['progressif'] === 'progressif' ? 1 : 0;

        // Génération d'un ID de cours aléatoire (modifié pour éviter les doublons)
        $courID = uniqid();

        $sql = "INSERT INTO module(titre, presentation, mots_cles, Code_Cours, cible, prerequis, est_progressif, proprietaire)
                VALUES('$titre', '$presentation', '$mots_cles', '$code_cours', '$cible', '$prerequis', $est_progressif, $proprietaire)";

        $query = mysqli_query($conn, $sql);

        if ($query) {
            echo 'Le cours a été ajouté avec succès';
        } else {
            echo 'Erreur lors de l\'ajout du cours';
        }
    }
}

  //get all modules from db

    $sql_cours = "SELECT * FROM module WHERE proprietaire = ?";

    $stmt = mysqli_prepare($conn, $sql_cours);
    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $cours = mysqli_fetch_all($result, MYSQLI_ASSOC);

    //suprimer un module
    if (isset($_POST['suprimer_module']) && $_SERVER["REQUEST_METHOD"] == "POST" ) {
        // Récupérer l'ID du module à supprimer
        $moduleID = $_POST['moduleID'];
    
        // Requête de suppression
        $requete = "DELETE FROM module WHERE id = ?";
    
        // Préparation de la requête
        $statement = $conn->prepare($requete);
    
        // Liaison des paramètres
        $statement->bind_param("i", $moduleID);
    
        // Exécution de la requête
        $resultat = $statement->execute();
    }    
    //ajouter un chapitre
    if (isset($_POST['ajouter_cousre_item'])) {
        if(!empty($_POST['chapitre_nom']) && !empty($_FILES['contenu']['name']) && !empty($_POST['module_nom'])){
          $chapitre_content_nom=$_FILES['contenu']['name'];
          $chapitre_content_tmp=$_FILES['contenu']['tmp_name'];
          $module_nom=$_POST['module_nom'];
          $destination='./ressources_cours/';
          $select_parent="SELECT * FROM module WHERE titre='$module_nom'";
          $stmtOnModule = $conn->query($select_parent);
          $moduleParent = $stmtOnModule->fetch_all(MYSQLI_ASSOC);

            foreach ($moduleParent as $module) {
                if($module['proprietaire'] == $_SESSION['userID']){

                    $stmtChap = $conn->prepare("insert into chapitre(IdModule, contenu, `accessible`) VALUES(?, ?, ?)");
                    $stmtChap->bind_param("isi", $module['id'], $chapitre_content_nom, $est_accessible);
                }
            }
       
            $succes = 0;
            if($stmtChap->execute() != false){
            move_uploaded_file($chapitre_content_tmp,$destination.$chapitre_content_nom);
                $succes = 1;
            $message = 'Le chapitre a été ajoute avec succes';
            }
            else{
                $succes = 1;
                $message = 'Echec d\'ajout...';
            }
          
        }
       }
?>
<!-- head included in php file -->

<!-- //home grid -->
<section class="home-grid">
    <div class="statistics-container">
        <div class="statistics-content">
            <div class="statics-box">
                <div class="icon">
                <i class="ri-book-fill"></i>
                </div>
                <div class="static-name">
                   <a href="cours_de_professeur.php" class='btn main-btn'>mes Cours</a>
                </div>
            </div>

            <div class="statics-box">
                <div class="icon">
                <i class="ri-graduation-cap-fill"></i>
                </div>
                
                <div class="static-text">
                <a href="afficher_etudiants.php" class='btn main-btn'>Mes Etudiants</a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class='prof-dahboard'>
  <div class="left-content">
     <div class="add-course">
      <div class="sub-title">
         <h4 class="title-content">Ajouter <span>cours</span></h4>
      </div>
          <form method="POST" class="myform">
             <div class="input-pass">
                 <input type="text" name='titre' class="box" placeholder='Intitule du cours...' required>
             </div>
             <div class="input-pass">
                 <input type="text" name='presentation' class="box" placeholder='Presentation du cours...' required>
             </div>
             <div class="input-pass">
                 <input type="text" name='mots_cles' class="box" placeholder='Mots cles se rapportant au cours...' required>
             </div>
             <div class="input-pass">
                 <input type="text" name='cible' class="box" placeholder='Public vise...' required>
             </div>
             <div class="input-pass">
                 <input type="text" name='prerequis' class="box" placeholder='Prerequis...' required>
             </div>
             <div class="input-pass">
                 <input type="text" name='Code_Cours' class="box" placeholder='Entrez le mot de pass du cours...' required>
             </div>
             <div class="isProgBox">
                <span>
                    <input type="radio" name="progressif" value="progressif" id="oui"><label id="oui">Visibilité Progressive</label>
                </span>
                <span>
                    <input type="radio" name="progressif" value="non_progressif" id="non"><label id="non">Visibilité Non Progressive</label>
                </span>
            </div>

             <center><button type='submit' name='ajouter_module' class='btn main-btn'>ajouter</button><center>
         </form>
     </div>
     <div class="separator"></div>
     <div class="add-course-item">
        <div class="sub-title">
              <h4 class="title-content">Ajouter <span>chapitre</span></h4>
         </div>
         <form method="POST" class="myform" enctype="multipart/form-data">
             <div class="input-pass">
                 <input type="text" name='chapitre_nom' class="box" placeholder='Entrer le nom de chapitre...' required>
             </div>    
             <div class="input-pass">
                 <input type="file" name='contenu' class="box" required>
             </div>
             <div class="input-pass">
                 <input type="text" name='module_nom' class="box" placeholder='Entrer le nom de module...' required>
             </div> 
             <button type='submit' name='ajouter_cousre_item' class='btn main-btn'>ajouter</button>
          </form>
          <div class="message">
            <?php 
               if(isset($success)) {
               if($succes != 0){
                        echo "$message";
                }}
            ?>
          </div>
     </div>
  </div>
  <div class="right-content">
     <table class='pro_table'>
        <thead>
           <tr>
             <th>id</th>
             <th>titre</th>
             <th>modifier</th>
             <th>suprimer</th>
           </tr>
        </thead>
        <tbody>
         <?php foreach ($cours as $cour ) { ?>
              <tr>
                   <td><?php echo $cour['id'] ?></td>
                   <td><?php echo $cour['titre'] ?></td>
                   <td><a href="modifier_cours.php?courID=<?php echo $cour['id'] ?>"><div class="table_icon modify"><i class="ri-loop-left-line"></i></div></a></td>
                   <td>
                    <form  method="post">
                    <input type="hidden" name="moduleID" value="<?php echo $cour['id'] ?>">
                    <button type="submit" name='suprimer_module'><div class="table_icon delete"><i class="ri-delete-bin-fill"></i></div></button>
                   </form>
                   </td>
              </tr>
           <?php }?>
        </tbody>
</section>
<?php  include 'foot.php' ?>