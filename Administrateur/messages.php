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

    .bg-table {
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
    .bg-table{
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  padding: 16px;
  margin-bottom: 40px;
  background-color: #ffffff;
  border-radius: 4px;
}

.button-modif{
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
</style>
<?php
require('../config.php');
?>
<section id="sec">
<div class="bg-table">
    <table>
        <thead>
            <tr>
            <th style="text-align: center;">nom utilisateur</th>
            <th style="text-align: center;">message</th>
            <th style="text-align: center;">Date de message</th>
            <th style="text-align: center;">action</th>
        </tr>
        </thead>
         <tbody>
        <?php
        $stmt = $db->prepare("SELECT * FROM `convrsations`
        INNER JOIN utilisateurs ON convrsations.id_utilisateur = utilisateurs.id_user");
        $stmt->execute();
        $conversations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($conversations) {
            foreach ($conversations as $conversation) {
        ?>
                <tr>
                    <td ><?=$conversation["nom_user"]?></td>
                    <td>
                    <div style="max-height:80px;max-width:500px;overflow:auto; ">
                         <?=$conversation["conver_message"]?>
                    </div>    
                   </td>
                    <td style="text-align: center;"><?=$conversation["date_conversation"]?></td>
                    <td style="text-align: center;">
                        <a href="Administrateur/ModifierMessage.php?ref=<?=$conversation["idConver"]?>">
                            <button class="button-modif">modifier</button>
                        </a>
                    </td>
                </tr>
        <?php
            }
        }
        ?>
        </tbody>
    </table>
</div>
</section>