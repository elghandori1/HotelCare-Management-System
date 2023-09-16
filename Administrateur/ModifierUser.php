<?php
session_start();
if (!isset($_SESSION["login"])  || !isset($_SESSION["role"]) || $_SESSION["role"] !== "AdminPage.php") {
  header("location:page_connexion.php");
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
    $stm=$db->prepare("select * from utilisateurs where id_user=?");
    $stm->execute([$_GET["ref"]]);
    $result = $stm->fetch(PDO::FETCH_ASSOC);
    if ($result) {
?>
      <form action="" method="POST">
        <!-- nom input -->
        <div class="form-outline mb-4">
          <input type="text" value="<?=$result['nom_user']?>" name="nomUser" id="form2Example1" class="form-control" placeholder="le nom utilisateur" />
        
        </div>

        <!-- login input -->
        <div class="form-outline mb-4">
          <input type="text" value="<?=$result['login_user']?>" name="loginUser" id="form2Example2" class="form-control" placeholder="entre login" />
          
        </div>

        <!-- Password input -->
        <div class="form-outline mb-4">
          <input type="text" value="<?=$result['password_user']?>" name="passwordUser" id="form2Example2" class="form-control" placeholder="entre password" />
        </div>

        <!-- roles input -->
        <div class="form-outline mb-4">
          <select class="form-select" name="RolsUser" id="">
            <option value="ReclamePage.php" <?= ($result["role"] == "ReclamePage.php") ? "selected" : "" ?>>reclamateur</option>
            <option value="TechnicienPage.php"<?= ($result["role"] == "TechnicienPage.php") ? "selected" : "" ?>>Technicien</option>
            <option value="DirecteurPage.php"<?= ($result["role"] == "DirecteurPage.php") ? "selected" : "" ?>>directeur</option>
            <option value="AdminPage.php"<?= ($result["role"] == "AdminPage.php") ? "selected" : "" ?>>Adminestrateur</option>
          </select>
        </div>
        <!-- Submit button -->
        <button type="submit" name="ModierUser" class="btn btn-success btn-block mb-4">Modifier</button>
        <button type="reset" class="btn btn-danger btn-block mb-4">Annuler</button>
        </div>
      </form>
      <?php  
     try {
        if (isset($_POST['ModierUser'])) {
            $nom_user = $_POST['nomUser'];
            $login_User = $_POST['loginUser'];
            $password_User = $_POST['passwordUser'];
            $Rols_User = $_POST['RolsUser'];
    
            if (!empty($nom_user) && !empty($login_User) && !empty($password_User) && !empty($Rols_User)) {
                $stm = $db->prepare("UPDATE utilisateurs SET nom_user=:nomuser, login_user=:loginuser, password_user=:passuser, pages=:rolsuser WHERE id_user=:ref");
                $flag = $stm->execute([
                    ":nomuser" => $nom_user,
                    ":loginuser" => $login_User,
                    ":passuser" => $password_User,
                    ":rolsuser" => $Rols_User,
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