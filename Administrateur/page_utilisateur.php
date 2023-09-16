<style>
@import url('https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Poppins:wght@400;500;600;700&display=swap');

* {
	margin: 0;
	padding: 0;
	box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}
#sec {
    margin: 40px;
}
.bg-table{
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  padding: 16px;
  margin-bottom: 40px;
  background-color: #ffffff;
  border-radius: 4px;
}
table {
	width: 100%;
	border-collapse: collapse;
}
table th {
	padding-bottom: 12px;
	font-size: 17px;
	text-align: left;
	border-bottom: 1px solid #3C91E6;
}
table td {
	padding: 16px 0;
}
table tr td:first-child {
	display: flex;
	align-items: center;
	grid-gap: 12px;
	padding-left: 6px;
}
table tbody tr:hover {
	background: #eee;
}

/* btns CSS */
.btn-Ajouter{
  display:flex;
  justify-content: end;
  padding: 10px;
}

.button-ajout, .button-modif ,.button-delet{
  /* background-color: #3C91E6; */
  border-radius: 8px;
  border-style: none;
  box-sizing: border-box;
  color: #FFFFFF;
  cursor: pointer;
  display: inline-block;
  font-family: "Haas Grot Text R Web", "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 14px;
  font-weight: 500;
  height: 40px;
  line-height: 20px;
  list-style: none;
  margin: 0;
  outline: none;
  padding: 10px 16px;
  position: relative;
  text-align: center;
  text-decoration: none;
  transition: color 100ms;
  vertical-align: baseline;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
}

.button-ajout{
  background-color: #3C91E6;
    width: 200px;
}
.button-ajout:hover,
.button-ajout:focus {
  background-color: blue;
}

.button-modif{
  background-color: #03c703;
}
.button-modif:hover,
.button-modif:focus {
  background-color: green;
}
.button-delet{
  background-color: #fa083c;
}
.button-delet:hover,
.button-delet:focus {
  background-color: #c9012d;
}


</style>
<?php
require('../config.php');
?>
<section id="sec">
    <div class="btn-Ajouter">
        <a href="Administrateur/AjouterUser.php"><button class="button-ajout">Ajouter</button></a>
    </div>
       
    <div class="bg-table">
        <?php
        $stm = $db->prepare("SELECT * FROM `utilisateurs`");
        $stm->execute();
        $tab = $stm->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <table>
          <thead>
             <tr>
                <th style="text-align: center;">nom utilisateur</th>
                <th style="text-align: center;">Login </th>
                <th style="text-align: center;">Password</th>
                <th style="text-align: center;">le Role</th>
                <th style="text-align: center;">Action</th>
            </tr>
          </thead>
           <tbody>

           
            <?php foreach ($tab as $ligne) : ?>
                <tr>
                    <td style="text-align: center;"><?=$ligne['nom_user'] ?></td>
                    <td style="text-align: center;"><?=$ligne['login_user'] ?></td>
                    <td style="text-align: center;"><?=$ligne['password_user'] ?></td>
                    <td style="text-align: center;"><?php 
                    if($ligne['role']==='AdminPage.php'){
                        echo "Adminestrateur";
                    }elseif($ligne['role']==='TechnicienPage.php'){
                        echo 'Technecien';
                    }elseif($ligne['role']==="DirecteurPage.php"){
                        echo 'derecteur general';
                    }else{
                        echo 'Reclamateur';
                    }
                    ?></td>
                    <td style="text-align: center;">
                        <a  href="Administrateur/ModifierUser.php?ref=<?=$ligne['id_user']?>">
                        
                          <button class="button-modif" >modifier</button>
                        </a> 
                        <a onclick="return confirm('Voulez vous supprimer')" href="Administrateur/SupprimierUser.php?ref=<?=$ligne['id_user']?>">
                          <button  class="button-delet" >supprimer</button>
                        </a>
                        
                    </td>
                </tr>
                <?php endforeach;?>
                </tbody>
    </div>

</section>



<!-- <script>
       var lienAjou = document.querySelector("a[href='Administrateur/AjouterUser.php']");
      var contenuDiv = document.querySelector("#contnt");

      lienAjou.addEventListener("click", function(e) {
        e.preventDefault();

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
            contenuDiv.innerHTML = xhr.responseText;
          }
        };
        xhr.open("GET", "AjouterUser.php", true);
        xhr.send();
      });
</script> -->
