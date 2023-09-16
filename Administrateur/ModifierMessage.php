<?php
session_start();
if (!isset($_SESSION["login"]) || !isset($_SESSION["page"]) || $_SESSION["page"] !== "AdminPage.php") {
  header("location: page_connexion.php");
  die();
} else {
  require("../config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootrap/bootstrap.min.css">
    <title>ModifierUser</title>
</head>
<body style="background-color: #1E2D59;">



<section class="container  col-6 bg-light rounded-3 p-3 my-4">
      <div class="mb-5 d-flex justify-content-between align-items-center">
        <h3 class="text-success">Modifier un Utilisateur </h3>
        <a href="../AdminPage.php"> page d'accuill</a>
      </div>
      <?php 
 if (isset($_GET["ref"])) {
    $stm=$db->prepare("SELECT * FROM `gestionstraveaux` INNER JOIN  
    convrsations  on gestionstraveaux.idgestions=convrsations.id_gestion 
    WHERE convrsations.idConver=?");
    $stm->execute([$_GET["ref"]]);
    $result = $stm->fetch(PDO::FETCH_ASSOC);
    if ($result) {
?>
      <form action="" method="POST">
        <!-- nom input -->
     

        <!-- login input -->
        <div class="form-outline mb-4">
         <textarea name="nvdescreiption" class="form-control"  placeholder="modifier la descriptions" cols="70"  rows="5"><?=$result['conver_message']?></textarea>
          
        </div>

        <!-- Submit button -->
        <button type="submit" name="ModierMessage" class="btn btn-success btn-block mb-4">Modifier</button>
        <button type="reset" class="btn btn-danger btn-block mb-4">Annuler</button>
        </div>
      </form>
      <?php  
     try {
        if (isset($_POST['ModierMessage'])) {
         $nvdescreiption=$_POST["nvdescreiption"];
    
            if (!empty($nvdescreiption)) {
                $stm = $db->prepare("UPDATE convrsations SET conver_message=:nvconver WHERE idConver=:ref");
                $flag = $stm->execute([
                    ":nvconver" => $nvdescreiption,
                    ":ref" => $_GET["ref"]
                ]);
              
                if ($flag) {
                    echo '<div class=" container text-center alert alert-success mt-1" id="success-alert">Modifier réussi</div>';
                } else {
                    echo  '<div class=" container text-center alert alert-danger" id="error-alert">Echec :(</div>';
                }
            } else {
                echo '<div class=" container text-center alert alert-danger mt-1">Tous les champs sont obligatoires!</div>';
            }
        }
    } catch (Exception | Error $e) {
        echo "Erreur : " . $e->getMessage();
    }
    
    } }?>
</section>

<script>
      // Sélectionner les éléments de classe "alert-success" et "alert-danger"
      const successAlert = document.getElementById("success-alert");
      const errorAlert = document.getElementById("error-alert");

      // Ajouter des gestionnaires d'événements "click" aux éléments sélectionnés
      successAlert.addEventListener("click", function() {
        // Supprimer l'élément du DOM
        successAlert.remove();
      });

      errorAlert.addEventListener("click", function() {
        // Supprimer l'élément du DOM
        errorAlert.remove();
      });
    </script>
</body>
</html>

<?php } ?>