<?php include('../includes/connection.inc.php'); 
    $stmt = $conn->query("update message set est_lu = 1 where id=".$_GET['id']);
?>

