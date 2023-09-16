<?php  session_start();
if (!isset($_SESSION["login"])) {
  header("location: page_connexion.php");
  die();
}else{

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier</title>
    <link rel="stylesheet" href="../bootrap/bootstrap.min.css">
    <script src="sweet\node_modules\sweetalert\dist\sweetalert.min.js"></script>
  <link rel="stylesheet" type="text/css" href="sweet\node_modules\sweetalert\dist\sweetalert.css">

 <!-- SweetAlert library -->
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <style>

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
</head>


<body class="d-flex justify-content-center align-items-center bg-dark" >
<?php 
require("../config.php");

if (isset($_GET["ref"]) && !empty($_GET["ref"])) {

    $stm = $db->prepare("SELECT nom_user,conver_message,status_gestion from
    utilisateurs u INNER JOIN gestionstraveaux gt ON u.id_user = gt.id_utilisateur 
    INNER JOIN convrsations c ON gt.idgestionT = c.id_gestion 
    WHERE gt.idgestionT =?");
    $stm->execute([$_GET["ref"]]);

    if ($stm->rowCount() > 0) {
        $result = $stm->fetch(PDO::FETCH_ASSOC);
    ?>

  <div class="background" id="background"></div>
  <div class="container card col-10 mt-3">
    <div class="d-flex justify-content-between align-items-center m-3">
       <h2 class="text-primary">Modifier</h2>
       <a href="../TechnicienPage.php" class="btn btn-warning">page accuill</a>
    </div>
     
    <form action="" method="post">

      <div class="d-flex justify-content-around align-items-center m-3">
      <div class=" fs-5 text-success mx-4">nom_resrtvateur</div>
          <div >
            <input type="text" value="<?=$result['nom_user']; ?>" readonly name="nom_reclamateur" class="form-control" placeholder="votre nom et prenom" style="width: 500px;">
          </div>
       </div>

      <div class="d-flex justify-content-around align-items-center m-3">
        <div class=" fs-5 text-success mx-4">type_probleme</div>
          <div >
            <textarea readonly name="type_probleme" class="form-control" id="" rows="4" style="width: 500px;"><?=$result['conver_message']; ?></textarea>
          </div>
      </div>

      <div class="d-flex justify-content-around align-items-center m-3">
        <div class=" fs-5 text-success mx-4">changer le status</div>

        <div>
        <select name="select_valid"  class="form-select" style="width: 500px;">
        <?php if ($result['status_gestion'] == "valid"): ?>
            <option value="valid" selected>valid</option>
            <option value="no-valid">no valid</option>
            <option value="en-coure">en coure</option>

        <?php elseif ($result['status_gestion'] =="no-valid"): ?>
            <option value="valid" >valid</option>
            <option value="no-valid" selected>no valid</option>
            <option value="en-coure">en coure</option>
        <?php elseif ($result['status_gestion'] =="en-coure"): ?>
            <option value="valid" >valid</option>
            <option value="no-valid" >no valid</option>
            <option value="en-coure"selected>en coure</option>
        <?php endif; ?>
         
        </select>
        </div>
      </div>

      <div class="d-flex justify-content-around align-items-center m-3">
        <div class=" fs-5 text-success mx-4">commantaire</div>
           <div style="width: 500px;" >
              <input type="text" name="description" style="height: 80px;"  class="form-control"  placeholder="entrez un description">
          </div>
      </div>
  <div class="d-flex mb-3 justify-content-center">
  <button class="btn-valider btn btn-success" style="width: 300px;" name="valider"> valider</button>
  </div>
      
        </form>
    </div>
   
   <?php 
//--------traitement-------------

if (isset($_POST['valider'])) {
  if (!empty($_POST['select_valid'])) {
      $date_modif = date('Y/m/d');
      $time_modif = date('H:i:s');

      // Update the database
      $stm = $db->prepare("UPDATE gestionstraveaux SET status_gestion=:val, date_validation=:date_val, Hour_validation=:timeVal WHERE idgestionT=:ref");
      $flag = $stm->execute([
          ":val" => $_POST['select_valid'],
          ":date_val" => $date_modif,
          ":timeVal" => $time_modif,
          ":ref" => $_GET["ref"]
      ]);

      // Insert into the conversations table (no need to check if description is provided)
      $id_usr = $_SESSION["id"];
      $id_Gest = $_GET["ref"];
      $description = isset($_POST['description']) ? $_POST['description'] : null;
      $reclam = $db->prepare("INSERT INTO convrsations VALUES (DEFAULT, :idGestion, :idUser, :descriptions, NOW())");
      $infos = $reclam->execute([
          ":idGestion" => $id_Gest,
          ":idUser" => $id_usr,
          ":descriptions" => $description
      ]);


      if ($flag) {
          $sweetAlertConfig = "swal('Bravo!', 'La Modification a Réussi !', 'success');";
      } else {
          $sweetAlertConfig = "swal('Oops!', 'Il y a un Problème', 'error');";
      }
  }
}

    } else {
    ?>
    <div class=" container col-12">
      <div class="   mt-3 text-center alert alert-danger">
        Aucun résultat trouvé pour cette référence :( 
      </div>
       <div><a href="../TechnicienPage.php" class="btn btn-primary">page accuill</a></div>
    </div>
      
      <?php 
         }
} else {
?>
  <div class=" container col-12">
      <div class=" mt-3 text-center alert alert-danger">
      La référence est manquante ou vide :( 
      </div>
       <div><a href="../TechnicienPage.php" class="btn btn-primary">page accuill</a></div>
    </div>
<?php 
   
}
?>  
  <!-- Display the SweetAlert -->
  <script>
        <?php echo $sweetAlertConfig; ?>
    </script>
</body>
</html>
<?php } ?>