<?php
session_start();
if (!isset($_SESSION["login"]) || !isset($_SESSION["role"]) || $_SESSION["role"] !== "TechnicienPage.php") {
  header("location: page_connexion.php");
  die();
}
else{
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technicien Page</title>
    <link rel="stylesheet" href="bootrap/bootstrap.min.css">
</head>
<style>
      .text-purple{
     color: #1E2D59;
  }
  .text-purple2{
     color: #585F73;
  }
  .bg-purple{
    background-color: #1E2D59;
  }
  table tbody tr:hover {
	background: #eee;
}


.background {
  background: url("./images/bg2.jpg")no-repeat center center/cover;
  position: absolute;
  top: 0px;
  bottom: 0px;
  left: 0px;
  right: 2px;
  z-index: -1;
  filter: blur(6px);
}


</style>
<body>
<div class="background" id="background"></div>

<div  class="container card shadow-lg mt-2 col-12" style="background-color: #eee;">
<nav class="navbar navbar-expand-lg  rounded m-2 bg-light"  >

<div class="container d-flex justify-content-between">
  <div>
     <img src="images/logo-vichy.jpg"height="40"alt="logo vichy" loading="lazy"style="margin-top: -1px;"/>
  </div>
  
  <div>
    <div class="d-flex justify-content-center align-items-center">
    <div class="container text-success"> <b class="text-purple">nom d'utilisateur: </b><?= $_SESSION["nom_user"] ?></div>
        <a class="btn  btn-danger me-3e text-light px-3 me-2" href="page_connexion.php">Deconnecté</a>
    </div>
  </div>

</div>
</nav>


<section class="d-flex px-4 justify-content-between align-items-center">



<h3 class="text-danger my-3">les Problemes reclammé</h3>
<?php 
require('./config.php');

function getDataFilter($filter,$db, $page, $itemsPerPage) {
  $offset = ($page - 1) * $itemsPerPage;

  if ($filter === 'tout') {
      $stm = $db->prepare("SELECT u.nom_user,MIN(gt.idgestionT) as idgestionT, gt.Num_chambre, c.conver_message, 
      gt.date_validation, gt.date_reclamation , gt.status_gestion FROM utilisateurs u 
      INNER JOIN gestionsTraveaux gt ON u.id_user = gt.id_utilisateur INNER JOIN convrsations c 
      ON gt.idgestionT = c.id_gestion GROUP BY gt.idgestionT 
      ORDER BY gt.idgestionT DESC LIMIT $offset, $itemsPerPage");
      $stm->execute();
      return $stm->fetchAll(PDO::FETCH_ASSOC);
  } else {
    $stm = $db->prepare("SELECT u.nom_user,MIN(gt.idgestionT) as idgestionT, gt.Num_chambre, c.conver_message,
    gt.date_validation, gt.date_reclamation , gt.status_gestion FROM utilisateurs u INNER JOIN 
    gestionsTraveaux gt ON u.id_user = gt.id_utilisateur INNER JOIN convrsations c 
    ON gt.idgestionT = c.id_gestion WHERE gt.status_gestion = ? GROUP BY gt.idgestionT 
    ORDER BY gt.idgestionT DESC LIMIT $offset, $itemsPerPage");
      $stm->execute([$filter]);
      return $stm->fetchAll(PDO::FETCH_ASSOC);
  }
}

$itemsPerPage = 10;

// Récupérer le filtre depuis le formulaire
$filter_valid = isset($_POST['filter_valid']) ? $_POST['filter_valid'] : 'tout';

// Récupérer le numéro de page depuis l'URL
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Récupérer les données en fonction du filtre sélectionné et de la pagination
$tab = getDataFilter($filter_valid, $db, $page, $itemsPerPage);

// Compter le nombre total de lignes pour la pagination
if ($filter_valid === 'tout') {
    $totalRows = $db->query("SELECT COUNT(*) FROM gestionsTraveaux")->fetchColumn();
} else {
    $stm = $db->prepare("SELECT COUNT(*) FROM gestionsTraveaux WHERE status_gestion = ?");
    $stm->execute([$filter_valid]);
    $totalRows = $stm->fetchColumn();
}

// Calculer le nombre total de pages
$totalPages = ceil($totalRows / $itemsPerPage);
?>

<form action="" method="post">
    <div class="d-flex gap-1">
        <select class="form-select" name="filter_valid">
            <option value="tout" <?php if($filter_valid === 'tout') echo "selected"; ?>>tout</option>
            <option value="valid" <?php if($filter_valid === 'valid') echo "selected"; ?>>valid</option>
            <option value="no-valid"<?php if($filter_valid === 'no-valid') echo "selected"; ?>>no valid</option>
            <option value="en-coure"<?php if($filter_valid === 'en-coure') echo "selected"; ?>>en coure</option>
        </select>
        <button name="rechercher" class="btn btn-primary">rechercher</button>
    </div>
</form>
</section>
<table class="table table-bordered bg-light">
    <thead style="font-size: 13px; text-align: center;">
        <tr>
            <th>#id</th>
            <th>NOM DE RECLAMATEUR</th>
            <th>N/CHAMBRE</th>
            <th>DEMANDER</th>
            <th>DETE RECLAMATION</th>
            <th>STATUS</th>
            <th>ACTION</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tab as $ligne) : ?>
            <tr>
                <td class="d-flex justify-content-center">
                <b class="text-danger"><?= $ligne["idgestionT"]?></b>
                </td>
                
                <td style="word-wrap: break-word;">
                <?= $ligne["nom_user"] ?>
              </td>
                
                <td class="col-3" style="word-wrap: break-word;">
                <div style="max-height:100px;min-width:120px;overflow: auto;"><?= $ligne["Num_chambre"] ?></div>
                </td>
                <td class="col-4" style="word-wrap: break-word;">
                    <div style="max-height:100px;min-width:140px;overflow: auto;"><?= $ligne["conver_message"]?></div>
                </td>
                <td><?= $ligne["date_reclamation"]?></td>
                <td>
                    <?php if ($ligne["status_gestion"] === "no-valid") : ?>
                        <span class="badge bg-danger"><?= $ligne["status_gestion"] ?></span>
                    <?php elseif ($ligne["status_gestion"] === "en-coure") : ?>
                        <span class="badge bg-warning"><?= $ligne["status_gestion"] ?></span>
                    <?php else : ?>
                        <span class="badge bg-success"><?= $ligne["status_gestion"] ?></span>
                    <?php endif ?>
                </td>
                <td class="d-flex justify-content-center align-items-center">
                <a href='./Technicien/ModifierTechnicien.php?ref=<?=$ligne["idgestionT"]?>' class="btn btn-success text-center mx">Modifier</a>
                <a href='Technicien/DetailsTechnicien.php?ref=<?= $ligne["idgestionT"]?>' class="btn btn-warning text-center mx-1">Details</a>
             </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
<!-- Pagination -->
<div class="d-flex justify-content-end">
    <nav aria-label="Page navigation">

        <ul class="pagination">
            <?php if ($page > 1) : ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page - 1 ?>&filter_valid=<?= $filter_valid ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo; Prev</span>
                    </a>
                </li>

                <li class="page-item active">
                <span class="page-link">Page: <?= $page ?></span>
            </li>
            <?php endif ?>


            <?php if ($page < $totalPages) : ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page + 1 ?>&filter_valid=<?= $filter_valid ?>" aria-label="Next">
                        <span aria-hidden="true">Next &raquo;</span>
                    </a>
                </li>
            <?php endif ?>
        </ul>
    </nav>
</div>
<!-- end Pagination -->




    </div>
</body>
</html>
<?php } ?>