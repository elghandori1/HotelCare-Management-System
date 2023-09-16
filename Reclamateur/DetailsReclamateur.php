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
    <title>Document</title>
    <link rel="stylesheet" href="../bootrap/bootstrap.min.css">
    
<script src="../bootrap/jquery-v3.js"></script>
     <!-- SweetAlert library -->
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>
<style>
    .bg-purple{
    background-color: #1E2D59;
  }
  .messages_box {
    min-height: 360px;
    max-height: 420px;
    min-width: 400px;
    overflow: auto;
    
    margin: 10px 0;
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



<body style="background-color: #1E2D59;">
<div class="background" id="background"></div>


<section style="background-color: #eee;" class="container mt-2" >

<div class="container py-2">
<!-- navigateur -->
    <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
          <ul class="mb-0 list-unstyled d-flex justify-content-between">
            <li class="breadcrumb-item active" aria-current="page">plus details</li>
            <li class="" aria-current="page"><a href="hestoriqueReclamateur.php">page acuill</a></li>
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
                <p class="text-danger mb-0"> vide </p>
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
                <p class="text-danger mb-0"> vide </p>
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
            <a href="TelchargerRCLPDF.php?ref=<?=$data['idgestionT']?>" class="btn-download">
              <i class='bx bxs-cloud-download'></i>
              <span class="text">Telecharger PDF</span>
            </a>
          </div>

        </div>
<!-- end-les donner -->


<!-- conversastion -->
<div class="row col-7">
  <div>
    <div class="card mb-4 mb-md-0">
      <div class="messages_box">

        <div id="load">
          <?php
          $id_gestion = $_GET["ref"];
          $id_user = $_SESSION["id"];
          $stmt = $db->prepare("SELECT * FROM convrsations WHERE id_gestion=:id_gest");
          $stmt->execute([":id_gest" => $id_gestion]);
          $conversations = $stmt->fetchAll(PDO::FETCH_ASSOC);

          foreach ($conversations as $conversation) {
            if ($conversation["id_utilisateur"] === $id_user) {
              if (!empty($conversation['conver_message'])) {
                ?>
                <div class="message your_message">
                  <span>Vous</span>
                  <div class="text-success"><?= $conversation['conver_message'] ?></div>
                  <div class="date"><?= $conversation['date_conversation'] ?></div>
                </div>
                <?php
              }
            } else {
              if (!empty($conversation['conver_message'])) {
                ?>
                <div class="message others_message">
                  <span class="text-secondary"><?php
                                                $others = $db->prepare("SELECT * FROM `utilisateurs` where id_user=?");
                                                $others->execute([$conversation["id_utilisateur"]]);
                                                $dataOther = $others->fetch(PDO::FETCH_ASSOC);
                                                echo $dataOther['nom_user'];
                                                ?></span>
                  <div class="text-danger"><?= $conversation['conver_message'] ?></div>
                  <div class="date"><?= $conversation['date_conversation'] ?></div>
                </div>
                <?php
              }
            }
          }
          ?>
</div>

</div>
<form action="" class="send_message" method="post">
  <textarea class="form-control" name="message" id="message" cols="30" rows="2" placeholder="Entre votre message"></textarea>
  <button type="submit" class="btn btn-primary" name="Send" id="Envoi">Envoiyer</button>
  <!-- <button type="submit" onclick="location.reload()"  class="btn btn-primary" name="Send" id="Envoi">Envoiyer</button> -->
</form>

<?php 
//-------traitement
if(isset($_POST['Send'])){
  if(!empty($_POST['message'])){
    $stmt=$db->prepare("INSERT INTO convrsations VALUES (default,:idGestion,:idUser,:descriptions,NOW())");
    $env=$stmt->execute([":idGestion"=>$id_gestion,":idUser"=>$id_user,":descriptions"=>$_POST['message']]);
    echo "<script>
    $(function(){
     $('#load').load('DetailsReclamateur/<?=$id_gestion?>')
   })
</script>";
    if($env){
         $sweetAlertConfig = "swal('Bravo!', 'envoiyer réussi !', 'success');";
              }else{
                $sweetAlertConfig = "swal('Oops!', 'Il y a un Problème', 'error');";
              }
  }
  else{
    $sweetAlertConfig = "swal('Attention!', 'Entrez un message obligatoire !', 'error');";

      }
}
 
?>

          
            </div>
          </div>
        </div>
<!-- end-conversastion -->

      </div>
    </div>


</section>


<?php  
} else {
    ?>
        <div class=" container col-12">
      <div class="   mt-3 text-center alert alert-danger">
        Aucun résultat trouvé pour cette référence :( 
      </div>
       <div><a href="../ReclamePage.php" class="btn btn-primary">page accuill</a></div>
    </div>
      <?php 
         }
} else {
?>
  <div class=" container col-12">
      <div class="   mt-3 text-center alert alert-danger">
      La référence est manquante ou vide :( 
      </div>
       <div><a href="../ReclamePage.php" class="btn btn-primary">page accuill</a></div>
    </div>
<?php 
   
}
?> 
<script>
  //Display the SweetAlert
  <?php echo $sweetAlertConfig; ?>


</script>

</body>
</html>
<?php } ?>