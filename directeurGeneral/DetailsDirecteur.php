<?php 
session_start();
if (!isset($_SESSION["login"]) || !isset($_SESSION["role"]) || $_SESSION["role"] !== "DirecteurPage.php") {
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
    <title>Document</title>
    <link rel="stylesheet" href="../bootrap/bootstrap.min.css">
</head>
<style>
      .bg-purple{
    background-color: #1E2D59;
  }
  .messages_box {
    min-height: 360px;
    max-height: 450px;
    min-width: 400px;
    margin: 10px 0;
    overflow: auto;
    padding: 5px 10px;
    /* border-top: 1px solid #999; */
   
}
.messages_box .message {
   margin-bottom: 15px;
   padding: 8px;
   box-shadow: 0 0 10px rgba(0,0,0,0.1);
   width: 350px;
}
.messages_box .message span {
    font-weight: bold;
    font-size: 14px;
}
.messages_box div {
    word-break: break-all;
    font-size: 13px;
}
.your_message {
    border: 1px solid #1877f2;
    border-radius: 10px 10px 10px 0;
}
.your_message span {
    color: #1877f2;
}
.others_message {
    border: 1px solid #999;
    margin-left: auto;
    border-radius: 10px 10px 0 10px;
}
.others_message span {
    color: #333;
}
.date {
    color: #ccc;
}
.send_message {
    border-top: 1px solid #1E2D59;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    
    /* flex-direction: column; */
    padding: 10px
}
.send_message textarea {
    width: 85%;
    resize: none;
    border-radius: 6px;
   border: 1px solid #1877f2;
    outline: 0;
    padding: 5px;
   font-size: 13px;
   margin-top: 6px;
}
.send_message #Envoi{
    width: 15%;
    height: 50px;
    padding: 5px 0;
    border-radius: 6px;
    /* background-color: #1877f2; */
    color: #fff;
    font-size: 13px;
    border: 1px solid #1877f2;
    cursor: pointer;
    margin-top: 6px;
}

table  tr:hover {
	background: #eee;
}

.head-title {
       display: flex;
       justify-content: end;
      } 

        .head-title .btn-download {
        text-decoration: none;
        padding:6px 16px;
        border-radius: 36px;
        background:  #3C91E6;
        color:  white;
        pointer-events: unset;
        display: flex;
        justify-content: center;
        align-items: center;
        grid-gap: 10px;
        font-weight: 500;
        margin: 10px;
        width: 200px;
      }
      .head-title .btn-download:hover{
        background-color: blue;
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

<?php 

require("../config.php");

if (isset($_GET["ref"]) && !empty($_GET["ref"])) {
  $stm = $db->prepare("SELECT * FROM `utilisateurs` INNER JOIN gestionsTraveaux on
   utilisateurs.id_user=gestionsTraveaux.id_utilisateur where 
   gestionsTraveaux.idgestionT=?");
  $stm->execute([$_GET["ref"]]);

  if ($stm->rowCount() > 0) {
      $data = $stm->fetch(PDO::FETCH_ASSOC);
  ?>


<body class="bg-purple">
<div class="background" id="background"></div>

<section style="background-color: #eee;" class="container mt-2">

<div class="container py-2">
<!-- navigateur -->
    <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
          <ul class="mb-0 list-unstyled d-flex justify-content-between">
            <li class="breadcrumb-item active" aria-current="page">plus details</li>
            <li class=" " aria-current="page">
              <a href="../DirecteurPage.php">page acuill</a>
              <?php 
              // if($_SERVER['HTTP_REFERER']==="http://localhost/vichy2/Technecien.php"){
              //   echo "<a href='Technecien.php'>page acuill</a></li>";
              // }
              // if($_SERVER['HTTP_REFERER']==="http://localhost/vichy2/hestorique.php"){
              //   echo "<a href='hestorique.php'>page acuill</a>";
              // }
              ?>
            </li>
          </ul>
        </nav>
      </div>
    </div>
<!-- end-navigateur -->
<!-- les donner -->
      <div class="d-flex justify-content-center gap-2">
        <div class="card mb-4 col-5">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <b class="mb-0">nom reclamateur :</b>
              </div>
              <div class="col">
                <p class="text-muted mb-0"><?=$data['nom_user'] ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col">
                <b class="mb-0">num de chamnre :</b>
              </div>
              <div class="col">
                <p class="text-muted mb-0"><?=$data['Num_chambre']?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col">
                <b class="mb-0">date de reclamation :</b>
              </div>
              <div class="col">
                <p class="text-muted mb-0"><?=$data['date_reclamation']?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col">
                <b class="mb-0">heure de reclamation :</b>
              </div>
              <div class="col">
                <p class="text-muted mb-0"><?=$data['Hour_reclamation']?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col">
                <b class="mb-0">date de validation :</b>
              </div>
              <div class="col">
                <?php 
                   if($data["status_gestion"]==='no-valid'|| $data["status_gestion"]==='en-coure'){
                ?>
                <p class="mb-0 text-danger"> vide </p>
                <?php }else{?>
                <p class="text-muted mb-0"><?=$data['date_validation']?></p>
                <?php }?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col">
                <b class="mb-0">heure de validation :</b>
              </div>
              <div class="col">
                <?php 
                   if($data["status_gestion"]==='no-valid'|| $data["status_gestion"]==='en-coure'){
                ?>
                <p class=" mb-0 text-danger"> vide </p>
                <?php }else{?>
                <p class="text-muted mb-0"><?=$data['Hour_validation']?></p>
                <?php }?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col">
                <b class="mb-0">status :</b>
              </div>
              <div class="col">
                <p class="text-muted mb-0"><?=$data['status_gestion']?></p>
              </div>
            </div>
            
          </div>
          <div class="head-title">
            <a href="TelchargerDERCT.php?ref=<?=$data['idgestionT']?>" class="btn-download">
              <i class='bx bxs-cloud-download'></i>
              <span class="text">Telecharger PDF</span>
            </a>
          </div>
        </div>
<!-- end-les donner -->

<!-- conversastion -->
        <div class="row col-7" >
          <div>
            <div class="card mb-4 mb-md-0">
           <div class="messages_box">
           <?php

$id_gestion = $_GET["ref"];
$stmt = $db->prepare("SELECT * FROM `convrsations`
INNER JOIN utilisateurs ON convrsations.id_utilisateur = utilisateurs.id_user 
WHERE id_gestion = :id_gest AND (utilisateurs.role = 'ReclamePage.php' 
OR utilisateurs.role = 'TechnicienPage.php') ORDER BY convrsations.idConver  ASC ");
$stmt->execute([":id_gest" => $id_gestion]);
$conversations = $stmt->fetchAll(PDO::FETCH_ASSOC);
if($conversations){
$message_class = "";
foreach ($conversations as $conversation) {
    if($conversation['role'] == 'ReclamePage.php' && $message_class != "your_message") {
        $message_class = "your_message";
    } 
    if($conversation['role'] == 'TechnicienPage.php' && $message_class != "others_message") {
        $message_class = "others_message";
    }
    if (!empty($conversation['conver_message'])) {
?>
    <div class="message <?= $message_class ?>">
        <span class="text-secondary"><?= $conversation['nom_user'] ?></span>
        <div class="text-<?= $message_class == "your_message" ? "success" : "danger" ?>">
            <?= $conversation['conver_message'] ?>
        </div>
        <div class="date"><?= $conversation['date_conversation'] ?></div>
    </div>
<?php
}}}else{
    echo '<div class=" container text-center  alert-danger mt-1 p-3"> aucun ): </div>';
}
?>
<!-- end-conversastion -->

      </div>
    </div>


</section>


<?php  
} else {
    ?>
        <div class=" container mt-3 text-center alert alert-danger">Aucun résultat trouvé pour cette référence :(</div>
        <div><a href="../DirecteurPage.php" class="btn btn-primary">page accuill</a></div>
      <?php 
         }
} else {
?>
 <div class=" container mt-3 text-center alert alert-danger">La référence est manquante ou vide </div>
       <div><a href="../DirecteurPage.php" class="btn btn-primary">page accuill</a></div>
<?php 
   
}
?> 
   <script>


// const formMessage=document.getElementById('formMessage');
// formMessage.onsubmit=(e)=>{
//   e.preventDefault()
// }







        //On actualise automatique le chat en utilisant AJAX
        // var message_box = document.querySelector('.messages_box');
        // setInterval(function(){
        //     var xhttp = new XMLHttpRequest();
        //     xhttp.onreadystatechange = function(){
        //         if(this.readyState == 4 && this.status == 200){
        //             message_box.innerHTML = this.responseText;
        //         }
        //     };
        //     xhttp.open("GET","Details.php" , true); // récupération de la page message
        //     xhttp.send()
        // },1000) // Actualiser le chat tous les 500 ms
    </script>
</body>
</html>
<?php } ?>