<?php
// ob_start();
session_start();
require_once "Send.php";
if (!isset($_SESSION["login"]) || !isset($_SESSION["role"]) || $_SESSION["role"] !== "ReclamePage.php") {
  header("location:page_connexion.php");
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
    <title>Reclame Page</title>
    <link rel="stylesheet" href="bootrap/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

<!-- Include SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- SweetAlert library -->
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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

  .hestorique{
    text-decoration: none;
  }
  .hestorique:hover{
    text-decoration: underline;
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

<?php require('config.php') ?>

<body>


<div class="container">
<div class="background" id="background"></div>

<section class="card shadow col-12 mt-4" style="background-color: #eee;" >

<!-- Navbar -->
<nav aria-label="breadcrumb" class="navbar navbar-expand-lg rounded m-2 bg-light">

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


<!-- end-nav-bar -->
<section class="d-flex mt-4 px-4 justify-content-between align-items-center">

<h3 class="text-purple ">SUIVIES DES TRAVAUX TECHNIQUE</h3>
<div><a href="Reclamateur/hestoriqueReclamateur.php" class="text-primary hestorique">hestorique de probleme </a></div>
</section>

<!-- formulaire -->
<form action="" method="post" class="body card m-4 border p-3">
  <div class="form-group  mt-4 d-flex justify-content-between align-items-center">
   <div class="col-sm-2 col-form-label fs-5 mx-4 text-purple2 "> N/CHAMBRE</div>

  <!-- numsChambres-probleme -->
  <div style="width: 500px;" >
  <input type="text" name="numsChambres" value="<?php if(isset($_POST['numsChambres'])) echo $_POST['numsChambres']; ?>" class="form-control" placeholder="entre les numeros des chambres" />
  </div>
     
   <!-- end-numsChambres-probleme -->
  </div>

  <div class="form-group mt-4  d-flex justify-content-between align-items-center">
    <div class="col col-form-label fs-5 text-purple2 mx-4">TRAVAUX DEMANDER</div>
    <div style="width: 500px;">
    <textarea style="height: 80px;" name="description" class="form-control" placeholder="entrez une description"><?php if (isset($_POST['description'])) echo $_POST['description']; ?></textarea>
</div>

  </div>

<div class="btns d-flex justify-content-center gap-3 mt-4">
<button type="submit" class="btn btn-success col-4" name="send">valider</button>
<button type="reset" class="btn btn-danger  col-4">annuler</button>
</div>

</form>
</section>

<!-- end-formulaire -->
<?php 
 try {
  if (isset($_POST["send"])) {
    
      $idUser=$_SESSION["id"];
      $nom_reclamateur =$_SESSION["nom_user"];
      $numsChambres = $_POST["numsChambres"];
      $description = $_POST["description"];
      $errors = array();
 
 if(empty($numsChambres)) {
  $errors[] = "Le champ N/CHAMBRE est required.";
}
 if(empty($description)) {
  $errors[] = "Le champ TRAVAUX DEMANDER est required.";
}

$sweetAlertConfig = "";

if (!empty($errors)) {
  $sweetAlertConfig = "swal('Erreur', '" . implode("\\n", $errors) . "', 'error');";
}

else {

        $stmt = $db->prepare("INSERT INTO gestionstraveaux VALUES (default,:idUser,:num_chambre,NOW(),NOW(),NOW(),NOW(),:status_gest)");
        $flag= $stmt->execute([":idUser" => $idUser,":num_chambre"=> $numsChambres,":status_gest" =>"no-valid"]);
        $id_gestion = $db->lastInsertId();
        

        $id_usr= $_SESSION["id"];
        $reclam = $db->prepare("INSERT INTO convrsations VALUES (default,:idGestion,:idUser,:descriptions,NOW())");
        $infos = $reclam->execute([
            ":idGestion"=>$id_gestion,
            ":idUser"=>$id_usr,
            ":descriptions" => $description   
        ]);
        if ($flag && $infos) {
          $sweetAlertConfig = "swal('Bravo!', 'Ajout réussi!', 'success');";
        } else {
          $sweetAlertConfig = "swal('Oops!', 'Echec!', 'error');";
        }
      }
  }
} catch (Exception | Error $e) {
  echo "Erreur : " . $e->getMessage();
}
// ob_end_flush();
}
?>
</div>

<script>
  <?php
    echo $sweetAlertConfig; 
  ?>

</script>


</body>

</html>