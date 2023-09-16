<?php
session_start();
if (!isset($_SESSION["login"]) || !isset($_SESSION["role"]) || $_SESSION["role"] !== "AdminPage.php") {
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
    <title>AjouterUser</title>
  </head>

  <body style="background-color: #1E2D59;">

    <section class="container  col-6 bg-light rounded-3 p-3 my-4">
      <div class="mb-5 d-flex justify-content-between align-items-center">
        <h3 class="text-primary">Ajouter un Utilisateur </h3>
        <a href="../AdminPage.php"> page d'accuill</a>
      </div>
      <form action="" method="POST">
        <!-- nom input -->
        <div class="form-outline mb-4">
          <input type="text" name="nomUser" id="form2Example1" class="form-control" placeholder="le nom utilisateur" />
          <label class="form-label text-danger" for="form2Example1">le nom utilisateur</label>
        </div>

        <!-- login input -->
        <div class="form-outline mb-4">
          <input type="text" name="loginUser" id="form2Example2" class="form-control" placeholder="entre login" />
          <label class="form-label text-danger" for="form2Example2">Login</label>
        </div>

        <!-- Password input -->
        <div class="form-outline mb-4">
          <input type="password" name="passwordUser" id="form2Example2" class="form-control" placeholder="entre password" />
          <label class="form-label text-danger" for="form2Example2">Password</label>
        </div>

        <!-- roles input -->
        <div class="form-outline mb-4">
          <select class="form-select" name="RolsUser" id="">
            <option value="ReclamePage.php">reclamateur</option>
            <option value="TechnicienPage.php">Technicien</option>
            <option value="DirecteurPage.php">directeur</option>
            <option value="AdminPage.php">Adminestrateur</option>
          </select>
          <label class="form-label text-danger" for="form2Example2">Roles</label>
        </div>
        <!-- Submit button -->
        <button type="submit" name="AjouterUser" class="btn btn-success btn-block mb-4">Ajouter</button>
        <button type="reset" class="btn btn-danger btn-block mb-4">Annuler</button>
        </div>
      </form>
      <?php
      try {
        if (isset($_POST['AjouterUser'])) {
          $nom_user = $_POST['nomUser'];
          $login_User = $_POST['loginUser'];
          $password_User = $_POST['passwordUser'];
          $Rols_User = $_POST['RolsUser'];

          if (!empty($nom_user) && !empty($login_User) && !empty($password_User) && !empty($Rols_User)) {
            $stm = $db->prepare("insert into utilisateurs values(default,:nomuser,:loginuser,:passuser,:rolsuser)");
            $flag = $stm->execute([":nomuser" => $nom_user, ":loginuser" => $login_User, ":passuser" => $password_User, ":rolsuser" => $Rols_User]);
            if ($flag) {
              echo '<div class=" container text-center alert alert-success mt-1" id="success-alert">Ajout réussi</div>';
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
      ?>

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