<?php
//include('connection.inc.php');
function estDejaInscrit($conn, $idEtudiant, $idCours) {
    $sql = "SELECT COUNT(*) AS total FROM courssuivis WHERE idEtudiant = ? AND idCours = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $idEtudiant, $idCours);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['total'] > 0;
}

function verificationCodeCours($conn,$codeCours){
    $sql = "SELECT id FROM module WHERE BINARY Code_Cours = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $codeCours);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0){
        return true;
    }else{
        return false;
    }
}
function valider($conn, $username, $password) {
    $errors = array();
    if (empty($username)) {
        $errors[] = "Le nom d'utilisateur ne doit pas être vide";
    } elseif (strlen($username) < 3) {
        $errors[] = "Le nom d'utilisateur doit avoir au moins 3 caractères";
    } else {
        // Vérifie si le pseudo existe déjà
        if (check_user_pseudo($conn, $username)) {
            $errors[] = "Le pseudo existe déjà";
        }
    }
    if (empty($password)) {
        $errors[] = "Le mot de passe ne doit pas être vide";
    } elseif (strlen($password) < 3) {
        $errors[] = "Le mot de passe doit avoir au moins 3 caractères";
    }
    return $errors;
}

function check_user_pseudo($conn, $username) {
    $sql = "SELECT * FROM USERS WHERE NAME = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $results = $stmt->get_result();
    return $results->num_rows > 0;
}
function check_user_exist($conn, $name, $prenom, $email, $password, $userType) {
    $table = ($userType == "administrateur")? "admin" : "UTILISATEURS";
    $sql = "SELECT * FROM ". $table." WHERE MAIL = ? AND NOM = ? AND PRENOM = ? AND PASSWORD = ?";
    $hashed_password = hash('sha256', $password);
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $email,$name,$prenom,$hashed_password);
    $stmt->execute();
    $results = $stmt->get_result();
    return $results->num_rows > 0;
}

function register($conn, $name, $prenom, $email, $password, $image_name, $userType) {
    $table = ($userType == "administrateur")? "admin" : "UTILISATEURS";
    $hashed_password = hash('sha256', $password);
    $sql = "INSERT INTO ".$table." (nom, prenom, mail, password, image, role) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $prenom, $email, $hashed_password, $image_name, $userType);
    return $stmt->execute();
}

function login_user($conn, $username, $password, $isAdmin = false)
{
    //$hashed_password = hash('sha256', $password);
    $table = ($isAdmin)? "admin" : "utilisateurs";
    $sql = "SELECT * FROM ". $table ." WHERE mail = ? AND password = ?";
    $hashed_password = hash('sha256', $password);
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss",$username,$hashed_password);
    $stmt->execute();
    $results = $stmt->get_result();
    return $results->fetch_assoc();
}
function save_remember_token($conn,$user_id,$token) {
    $sql = "UPDATE USERS SET remember_token = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si",$token,$user_id);
    return $stmt->execute();
}
function save_reset_token($conn,$user_id,$token) {
    $sql = "UPDATE USERS SET reset_token = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si",$token,$user_id);
    return $stmt->execute();
}
function est_progressif($conn,$idCours,$nomCours){
    $sql="SELECT est_progressif FROM module where id=? AND titre=?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("is",$idCours,$nomCours);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['est_progressif'];
}

function getChapter($conn,$courID){
    $sql = "SELECT * FROM chapitre WHERE IdModule = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $courID);
    $stmt->execute();
    return  $stmt->get_result();
}
//vérifier si c'est un user et le rediriger vers login
function isUser($conn, $userID){
    $stmt = $conn->query("select count(*) as nb from utilisateurs where id = ".$userID);
    $res = $stmt->fetch_assoc();
    echo $res['nb'];
    return ($res['nb'] > 0)? true : false ;
}
?>
