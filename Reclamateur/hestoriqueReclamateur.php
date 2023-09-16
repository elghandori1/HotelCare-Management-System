<?php 
 session_start();
 if (!isset($_SESSION["login"])) {
   header("location:../page_connexion.php");
   die();
 }else{
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hestorique Reclamateur</title>
    <link rel="stylesheet" href="../bootrap/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
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
  .border-purple{
    border: 1px solid  #1E2D59;
  }
  table tbody tr:hover {
	background: #eee;
}

.background {
  background: url("../images/bg2.jpg")no-repeat center center/cover;
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

<div class="container">
<div class="background" id="background"></div>


<div class='card shadow-lg my-2 p-1 col-12' style="background-color: #eee;">

<nav class="navbar navbar-expand-lg rounded mb-3 bg-light" aria-label="breadcrumb" >

<div class="container d-flex justify-content-between">
  <div>
     <img src="../images/logo-vichy.jpg"height="40"alt="logo vichy" loading="lazy"style="margin-top: -1px;"/>
  </div>
  
  <div>
    <div class="d-flex align-items-center gap-3">
        <a href="../ReclamePage.php" class="text-primary">page accuill</a>
        <a class="btn  btn-danger me-3e text-light px-3 me-2" href="../page_connexion.php">Deconnecté</a>
    </div>
  </div>
</div>
</nav>


<section class="d-flex px-4 justify-content-between align-items-center">
<h3 class="text-danger my-3"> LES HESTORIQUE DES PROBLEMES</h3>

<?php 
require('../config.php');

function getDataFilter($filter,$db, $page, $itemsPerPage) {
  $offset = ($page - 1) * $itemsPerPage;

  if ($filter === 'tout') {
      $stm = $db->prepare("SELECT MIN(gt.idgestionT) as idgestionT, gt.Num_chambre, c.conver_message, 
      gt.date_validation, gt.date_reclamation , gt.status_gestion FROM utilisateurs u 
      INNER JOIN gestionsTraveaux gt ON u.id_user = gt.id_utilisateur INNER JOIN convrsations c 
      ON gt.idgestionT = c.id_gestion GROUP BY gt.idgestionT 
    ORDER BY gt.idgestionT DESC LIMIT $offset, $itemsPerPage");
      $stm->execute();
      return $stm->fetchAll(PDO::FETCH_ASSOC);
  } else {
      $stm = $db->prepare("SELECT MIN(gt.idgestionT) as idgestionT, gt.Num_chambre, c.conver_message,
      gt.date_validation, gt.date_reclamation , gt.status_gestion FROM utilisateurs u INNER JOIN 
      gestionsTraveaux gt ON u.id_user = gt.id_utilisateur INNER JOIN convrsations c 
      ON gt.idgestionT = c.id_gestion WHERE gt.status_gestion = ? GROUP BY gt.idgestionT 
      ORDER BY gt.idgestionT DESC LIMIT $offset, $itemsPerPage");
      $stm->execute([$filter]);
      return $stm->fetchAll(PDO::FETCH_ASSOC);
  }
}

$itemsPerPage = 6;

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
            <th>N/CHAMBRE</th>
            <th>DEMANDER</th>
            <th>DETE RECLAMATION</th>
            <th>DATE VALIDATION</th>
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
                <td class="col-3" style="word-wrap: break-word;">
                    <div style="max-height:100px;min-width:120px;overflow: auto;"><?= $ligne["Num_chambre"] ?></div>
                </td>
                <td class="col-4" style="word-wrap: break-word;">
                    <div style="max-height:100px;min-width:140px;overflow: auto;"><?= $ligne["conver_message"]?></div>
                </td>
                <td class="col-2"><?= $ligne["date_reclamation"]?></td>

                <td class="col-2">
                    <?php if ($ligne["status_gestion"] === "no-valid" || $ligne["status_gestion"] === "en-coure") : ?>
                        <b class="text-danger">----------</b>
                    <?php else : ?>
                        <?= $ligne["date_validation"] ?>
                    <?php endif ?>
                </td>

                <td>
                    <?php if ($ligne["status_gestion"] === "no-valid") : ?>
                        <span class="badge bg-danger"><?= $ligne["status_gestion"] ?></span>
                    <?php elseif ($ligne["status_gestion"] === "en-coure") : ?>
                        <span class="badge bg-warning"><?= $ligne["status_gestion"] ?></span>
                    <?php else : ?>
                        <span class="badge bg-success"><?= $ligne["status_gestion"] ?></span>
                    <?php endif ?>
                </td>
                <td>
                    <a href="DetailsReclamateur.php?ref=<?=$ligne["idgestionT"]?>" class="btn btn-success">Details</a>
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
</div>

</body>
</html>

<?php } ?>