<?php include('../includes/connection.inc.php'); ?>
<?php
    $stmtToDelUser = $conn->prepare("delete from utilisateurs where id=".$_GET['id']);
     
    echo "<span style=\"display: none;\">";
    echo ($stmtToDelUser->execute())? "<br>Suppresion avec succès.<br>" : "<br>La suppresion a échouée.<br>";
    echo "</span>";
    include_once("./listeUser.php");
?>