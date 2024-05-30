<?php include("./includes/connection.inc.php");?>
<?php 
    if(isset($_POST["data"]) || isset( $_POST["search_box"])) {
        if(isset($_POST["data"])) $data = $_POST["data"];
        if(isset($_POST["search_box"])) $data = $_POST["search_box"];
        $sql="SELECT * FROM module WHERE titre LIKE '%$data%'
            OR presentation LIKE '%$data%'
            OR mots_cles LIKE '%$data%'
            OR Code_Cours LIKE '%$data%'
            OR cible LIKE '%$data%'
            OR prerequis LIKE '%$data%';
        ";
    
    $result = $conn->query($sql);
    // Vérifier s'il y a des résultats
    if ($result->num_rows > 0) {
        $retourHTML = "<center><h3 style=\"font-weight:bold;color:var(--black);\"> $result->num_rows résultat(s) trouvé(s) :</h3></center>";
        $retourHTML .= "\n<ul>";
        $data=array();
        while ($row = $result->fetch_assoc()) {
            $retourHTML .= "<li>" . $row["titre"] . "</li>";//document.getElementById('search_box').value = this.textContent
            $data[]=$row["titre"];
        }
        $retourHTML .= "</ul>";
        if (isset($_POST["data"])) {
            echo $retourHTML;
        }
        if (isset($_POST["search_box"])) {
            $data = implode(',', $data);
            header("Location: ./nouveaux_cours.php?data=$data");//mettre des if http_referer
            exit(); // Arrêter l'exécution du script après la redirection
        }
    } else {
        if (isset($_POST["data"])) {
            echo "<center><strong><h3 style=\"color:var(--black);\">Aucun résultat trouvé<h3></strong></center>";
        }
        if (isset($_POST["search_box"])) {
            header("Location: ./nouveaux_cours.php?data=empty");
            exit(); // Arrêter l'exécution du script après la redirection
        }
    }
    
}
?>