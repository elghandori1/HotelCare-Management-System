<link rel="stylesheet" href="../bootrap/bootstrap.min.css">
<?php
require("../config.php");
if (isset($_GET["ref"])) { 
    $stm = $db->prepare("DELETE conv FROM convrsations conv
    JOIN gestionsTraveaux g ON conv.id_gestion = g.idgestions
    WHERE g.id_utilisateur =?;");
    $flag1 = $stm->execute([$_GET["ref"]]);

    $stm = $db->prepare("DELETE FROM gestionsTraveaux WHERE id_utilisateur =?");
    $flag2 = $stm->execute([$_GET["ref"]]);

    $stm = $db->prepare("DELETE FROM utilisateurs WHERE id_user=?");
    $flag3 = $stm->execute([$_GET["ref"]]);

    if ($flag1 && $flag2 && $flag3){
    echo '<div class=" container text-center alert alert-success mt-1" id="success-alert">
    Suppresion réussi
    </div>';
    echo "<div><a class='btn btn-success' href='../AdminPage.php'> page d'accuill</a></div>";
    }else{
        echo  '<div class=" container text-center alert alert-danger" id="error-alert">Echec :(</div>';
        echo "<div><a class='btn btn-success' href='../AdminPage.php'> page d'accuill</a></div>";
    }
}
