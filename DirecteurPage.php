<?php
session_start();
if (!isset($_SESSION["login"]) || !isset($_SESSION["role"]) || $_SESSION["role"] !== "DirecteurPage.php") {
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
    <title>Vichy thermalia</title>

    <link rel="shortcut icon" href="#"/>

    <link rel="icon" href="images/logoHoute.jpg" type="image/gif/png">
    <link rel="stylesheet" href="bootrap/bootstrap.min.css">
</head>

<style>
body{
    background-color: #313a46;
    margin:5px 0px;
}

.bg-custom {
    background-color: #313a46!important;
}

.card-box {
    padding: 20px;
    border-radius: 3px;
    margin-bottom: 30px;
    background-color: #fff;
}

.inbox-widget{
    min-height: 250px;
    max-height: 250px;
    overflow: auto;
   
}
.inbox-widget .inbox-item img {
    width: 40px;
}

.inbox-widget .inbox-item {
    border-bottom: 1px solid #f3f6f8;
    overflow: hidden;
    padding: 10px 0;
    position: relative
}

.inbox-widget .inbox-item .inbox-item-img {
    display: block;
    float: left;
    margin-right: 15px;
    width: 40px
}

.inbox-widget .inbox-item img {
    width: 40px
}

.inbox-widget .inbox-item .inbox-item-author {
    color: #313a46;
    display: block;
    margin: 0
}

.inbox-widget .inbox-item .inbox-item-text {
    color: #98a6ad;
    display: block;
    font-size: 14px;
    margin: 0
}

.inbox-widget .inbox-item .inbox-item-date {
    color: #98a6ad;
    font-size: 11px;
    position: absolute;
    right: 7px;
    top: 12px
}

.comment-list .comment-box-item {
    position: relative
}

.comment-list .comment-box-item .commnet-item-date {
    color: #98a6ad;
    font-size: 11px;
    position: absolute;
    right: 7px;
    top: 2px
}

.comment-list .comment-box-item .commnet-item-msg {
    color: #313a46;
    display: block;
    margin: 10px 0;
    font-weight: 400;
    font-size: 15px;
    line-height: 24px
}

.comment-list .comment-box-item .commnet-item-user {
    color: #98a6ad;
    display: block;
    font-size: 14px;
    margin: 0
}

.comment-list a+a {
    margin-top: 15px;
    display: block
}

/* .ribbon-box{
 
} */
.ribbon-box .ribbon-primary {
    background: #2d7bf4;
}

.ribbon-box .ribbon {
    position: relative;
    float: left;
    clear: both;
    padding: 5px 12px 5px 12px;
    margin-left: -30px;
    margin-bottom: 15px;
    font-family: Rubik,sans-serif;
    -webkit-box-shadow: 2px 5px 10px rgba(49,58,70,.15);
    -o-box-shadow: 2px 5px 10px rgba(49,58,70,.15);
    box-shadow: 2px 5px 10px rgba(49,58,70,.15);
    color: #fff;
    font-size: 13px;
}
.text-custom {
    color: #02c0ce!important;
}

.badge-custom {
    background: #02c0ce;
    color: #fff;
}
.badge {
    font-family: Rubik,sans-serif;
    -webkit-box-shadow: 0 0 24px 0 rgba(0,0,0,.06), 0 1px 0 0 rgba(0,0,0,.02);
    box-shadow: 0 0 24px 0 rgba(0,0,0,.06), 0 1px 0 0 rgba(0,0,0,.02);
    padding: .35em .5em;
    font-weight: 500;
}
.text-muted {
    color: #98a6ad!important;
}

.font-13 {
    font-size: 13px!important;
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
<div class="container">
<div class="background" id="background"></div>

    <div class="container card col-12 shadow" style="background-color: #eee;">
        <!-- start row-1 -->
        <div class="row">
            <div class="col-sm-12">
                <!-- meta -->
                <nav aria-label="breadcrumb" class=" container d-flex justify-content-between navbar navbar-expand-lg  rounded bg-light mb-3 mt-1">
                    <!-- <div class="row"> -->
                        <div>
                            <h4 class="mt-1 mb-1 text-dark"> <b>Bonjour : </b> <span class="text-primary"><?= $_SESSION["nom_user"] ?></span></h4>
                        </div>
                        <div >
                            <div class="text-right">
                                <a class="btn  btn-danger me-3e text-light px-3 me-2"  href="page_connexion.php">Deconnecté</a>
                            </div>
                        </div>
                    
                </nav>
                <!--/ meta -->
            </div>
        </div>
        <!-- end row-1 -->

        <!-- partie profil -->
        <div class="d-flex justify-content-between p-2">
            <div class="col-4">
                <!-- Personal-Information -->
                <?php 
                  require('config.php');
                  $users=$db->prepare('SELECT * FROM `utilisateurs`');
                  $users->execute();
                  $AfchUser=$users->fetchAll(PDO::FETCH_ASSOC);
                  $numUsers = $users->rowCount();
                ?>

                <div class="card-box card shadow ribbon-box">
                    <div class="ribbon ribbon-primary">les utilisateurs <span style="background-color: red; padding:4px; border-radius: 25px;"><?=$numUsers?></span></div>
                    <div class="clearfix"></div>
                    <div class="inbox-widget">
                        <?php 
                      
                        if($AfchUser){
                            foreach ($AfchUser as $ligneAficherUser){
                                ?>
                            <div class="inbox-item">
                                <div class="inbox-item-img"><img src="images/blank-profile.png" class="rounded-circle" alt=""></div>
                                <p class="inbox-item-author"><?=$ligneAficherUser["nom_user"] ?></p>
                                <p class="inbox-item-text text-primary">
                                    <?php 
                                    if($ligneAficherUser["role"]==="DirecteurPage.php"){
                                      echo"directeur général";
                                    }elseif($ligneAficherUser["role"]==="TechnicienPage.php"){
                                        echo 'Technicien';
                                    }elseif($ligneAficherUser["role"]==="AdminPage.php"){
                                        echo 'Administrateur';
                                    }
                                    else{
                                        echo 'Reclamateur';
                                    }
                                    ?>
                                </p>
                            </div>
                                <?php 
                            }
                        }else{
                            echo 'vide !!';
                        }
                        ?>
                    </div>
                </div>
            </div>
        <!-- end-partie-profil -->

       <!-- start les statistic -->
       <div class="col-7 ">
        <div class="col-12 bg-primary text-light text-center "  style="padding:12px; border-radius:4px;font-weight: 700;">les statictiques :</div>

        <div class="col-12 staticHut d-flex justify-content-center mt-3" >
        <div class="col-4 m-1 card shadow text-center" style="height: 110px;">
                            <h6 class="text-muted text-uppercase mt-3">Total validé</h6>
                            <h2 class="" data-plugin="counterup">
                                <?php 
                                 $valid = $db->prepare("SELECT COUNT(*) FROM `gestionstraveaux` WHERE status_gestion='valid'");
                                 $valid->execute();
                                 $totalValid = $valid->fetch(PDO::FETCH_ASSOC);
                                 echo $totalValid['COUNT(*)'];
                                ?>
                            </h2>
        </div>
                    <!-- end col -->
                    <div class="col-4 m-1 card shadow text-center" style="height: 110px;">
                        
                        <h6 class="text-muted text-uppercase mt-3">total no-validé</h6>
                        <h2 class="">
                        <?php 
                             $valid = $db->prepare("SELECT COUNT(*) FROM `gestionstraveaux` WHERE status_gestion='no-valid'");
                             $valid->execute();
                             $totalValid = $valid->fetch(PDO::FETCH_ASSOC);
                             echo $totalValid['COUNT(*)'];
                            ?>
                        </h2>
                    
                </div>
                <!-- end col -->
                <div class="col-4 m-1 card shadow text-center" style="height: 110px;">
                        
                        <h6 class="text-muted text-uppercase mt-3">Total en-coure</h6>
                        <h2 class="" data-plugin="counterup">
                        <?php 
                             $valid = $db->prepare("SELECT COUNT(*) FROM `gestionstraveaux` WHERE status_gestion='en-coure'");
                             $valid->execute();
                             $totalValid = $valid->fetch(PDO::FETCH_ASSOC);
                             echo $totalValid['COUNT(*)'];
                            ?>
                        </h2>
                   
                </div>
                <!-- end col -->    
        </div>
        <div class="total d-flex justify-content-center">
        <div class="col-6 m-2 card shadow text-center" style="height: 110px;">
                        
                        <h6 class="text-muted text-uppercase mt-3">Total</h6>
                        <h2 class="" data-plugin="counterup">
                        <?php 
                             $valid = $db->prepare("SELECT COUNT(*) FROM `gestionstraveaux`");
                             $valid->execute();
                             $totalValid = $valid->fetch(PDO::FETCH_ASSOC);
                             echo $totalValid['COUNT(*)'];
                            ?>
                        </h2>
                   
                </div>
        </div>
        </div>
         <!-- end-start les statistic -->
                    </div>

                    <!-- start_table_infos  -->
                <?php
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

<!-- start-table -->
<div class="card-box card shadow">
    <!-- partie_rechercher -->
    <section class="d-flex px-4 justify-content-between align-items-center mb-4">
        <h4 class="text-primary">lES DOMONDES</h4>

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

<!-- start_table_infos -->
    <div class="table-responsive" style="max-height:750px;min-width:50%;overflow: auto;">
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
                    <a href="./directeurGeneral/DetailsDirecteur.php?ref=<?=$ligne["idgestionT"]?>" class="btn btn-success">Details</a>
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


  <!-- end_table_infos  -->
                    
                    

                </div>





<!-- hnakan -->
            <!-- end col -->
        <!-- diklwla hna knt -->
        <!-- end row -->
    </div>
    <!-- container -->
</div>
</body>
</html>
<?php } ?>