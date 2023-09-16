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
.text_Th_size{
    font-size: 11px;
    margin: 5px;
    text-align: center;
}
.textLign-center{
    text-align: center;
}



.button-supprimier{
 background-color: red;
  border-radius: 8px;
  border-style: none;
  box-sizing: border-box;
  color: #FFFFFF;
  cursor: pointer;
  display: inline-block;
  font-family: "Haas Grot Text R Web", "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 12px;
  font-weight: 500;
  line-height: 20px;
  list-style: none;
  margin: 0;
  outline: none;
  padding: 5px;
  position: relative;
  text-align: center;
  text-decoration: none;
  transition: color 100ms;
  vertical-align: baseline;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
}

/* .button-ajout{
  background-color: #3C91E6;
    width: 200px;
}
.button-ajout:hover,
.button-ajout:focus {
  background-color: blue;
}

.button-modif{
  background-color: #03c703;
} */

.button-supprimier:hover,
.button-supprimier:focus {
    background-color: brown;

}
.text-none{
    color: white;
    text-decoration: none;
}
#idGest{
    font-size: 13px;
    color: red;
}
</style>
<?php
require('../config.php');
?>
<section id="sec">
<div class="bg-table">
        <?php

        $stm = $db->prepare("SELECT MIN(gt.idgestionT) as idgestionT,u.nom_user, gt.Num_chambre, c.conver_message, 
        gt.date_validation, gt.date_reclamation ,gt.Hour_reclamation,gt.Hour_validation, gt.status_gestion FROM utilisateurs u 
        INNER JOIN gestionsTraveaux gt ON u.id_user = gt.id_utilisateur INNER JOIN convrsations c 
        ON gt.idgestionT = c.id_gestion GROUP BY gt.idgestionT 
      ORDER BY gt.idgestionT DESC");
$stm->execute();
$tab = $stm->fetchAll(PDO::FETCH_ASSOC);
        ?>
<div class="table-responsive" style="max-height:750px;min-width:50%;overflow: auto;">
    <table>
                            <thead >
                                <tr>
                                    <th class='text_Th_size'>ID</th>
                                    <th class='text_Th_size'>NOM RC</th>
                                    <th class='text_Th_size'>N/CHAMBRE</th>
                                    <th class='text_Th_size'>DETE RECL</th>
                                    <th class='text_Th_size'>HEURE RECL</th>
                                    <th class='text_Th_size'>DATE VALID</th>
                                    <th class='text_Th_size'>HEURE VALID</th>
                                    <th class='text_Th_size'>STATUS</th>
                                    <th class='text_Th_size'>ACTION</th>
                                </tr>
                            </thead>
                <tbody>
                            <?php foreach ($tab as $ligne) : ?>
                <tr>
                <td class="textLign-center" id="idGest">#<?=$ligne["idgestionT"]?></td>
                <td  class="textLign-center"><?= $ligne["nom_user"] ?></td>
                <td class="textLign-center">
                    <div style="max-height:100px;min-width:125px;overflow: auto;"><?= $ligne["Num_chambre"]?>
                </div>
               </td>
                <td ><?= $ligne["date_reclamation"] ?></td>
                <td ><?= $ligne["Hour_reclamation"] ?></td>
                <?php 
                    if($ligne["status_gestion"]==='no-valid'|| $ligne["status_gestion"]==='en-coure'){
                    ?>
                    <td ><b class="text-danger">----------</b></td>
                    <td ><b class="text-danger">----------</b></td>
                    <?php
                      }else{
                        ?>
                         <td style="font-size: 15px;"><?= $ligne["date_validation"] ?></td>
                         <td><?= $ligne["Hour_validation"] ?></td>
                        <?php
                        }
                     ?>

                <?php 
                if( $ligne["status_gestion"]==='no-valid'){
                ?>
              <td  style="background-color:#ff788e;"><?= $ligne["status_gestion"] ?></td>
                <?php 
                }elseif( $ligne["status_gestion"]==='en-coure'){
                    ?>
                    <td style="background-color:#faff7e;"><?= $ligne["status_gestion"] ?></td>
                <?php 
                }else{
                    ?>
                      <td  style="background-color:#74f2bc ;"><?= $ligne["status_gestion"] ?></td>
                    <?php
                }
                ?>
                     <td > 
                        
                        <a onclick="return confirm('Voulez vous supprimer')"  href="Administrateur/SupprimerGestion.php?ref=<?=$ligne["idgestionT"]?>" class="text-none">
                            <button class="button-supprimier">
                            Supprimier
                           </button>
                        </a>
                       
                       
                    </td>
            </tr>
            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

    </div>
</section>