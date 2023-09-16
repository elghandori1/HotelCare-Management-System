<?php 
session_start();
if(isset($_GET["ref"])&& !empty($_GET["ref"])){

    // Définir le nom du fichier PDF à télécharger
    $date = date("Y/m/d");
    $filename="la reclamation N/".$_GET["ref"].'date:'.$date.'.pdf';
    //---------------------
    require("../config.php");
    $stm = $db->prepare('SELECT * FROM `utilisateurs` INNER JOIN gestionstraveaux on
    utilisateurs.id_user=gestionstraveaux.id_utilisateur INNER JOIN 
    (SELECT id_gestion, conver_message FROM convrsations cv inner join gestionstraveaux
    gs on  gs.idgestionT=cv.id_gestion GROUP BY id_gestion) AS sub
    ON gestionstraveaux.idgestionT = sub.id_gestion
    where gestionstraveaux.idgestionT=? LIMIT 1');
   $stm->execute([$_GET["ref"]]);
require('../fpdfBiblio/fpdf.php');

class PDF extends FPDF
{
    // En-tête
    function Header()
    {
        // Logo
        $this->Image('../images/logo-vichy.jpg',10,6,30);
        // Police Arial gras 15
        $this->SetFont('Arial','B',15);
        // // Décalage à droite
        // $this->Cell(80);
        $this->Ln(15);
        // Titre
        $this->Cell(0, 10, 'La reclamation N/'.$_GET["ref"].' du Date '.date('d/m/Y'), 1, 0, 'C');
        // $this->Cell(30,10,'Reclamation Details');
        $this->Ln(16);
        $this->Cell(30,10,'Reclamation Details');
        // Saut de ligne
        $this->Ln(15);
    }

    // Pied de page
    function Footer()
    {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        // Police Arial italique 8
        $this->SetFont('Arial','I',8);
        // Numéro de page
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

// Instanciation de la classe dérivée
$pdf = new PDF(orientation:'P',unit:'mm',size:'A4');
$pdf->AliasNbPages();
$pdf->AddPage();

// Définition de la police de caractères et de la taille de texte
$pdf->SetFont('Arial','B',12);

// Boucle pour afficher les données
while($row =$stm->fetch()){
    $pdf->Cell(0,10,'Nom reclamateur : '.$row['nom_user'],0,1);
    $pdf->Cell(0,10,'Num de chamnre : '.$row['Num_chambre'],0,1);
    if ($row["status_gestion"]==='no-valid' || $row["status_gestion"]==='en-coure') {
        $pdf->Cell(0,10,'description : '.$row['conver_message'],0,1);
    }
    $pdf->Cell(0,10,'Date de reclamation : '.$row['date_reclamation'],0,1);
    $pdf->Cell(0,10,'Heure de reclamation : '.$row['Hour_reclamation'],0,1);
    $pdf->Cell(0,10,'Status : '.$row['status_gestion'],0,1);
    if ($row["status_gestion"]==='no-valid' || $row["status_gestion"]==='en-coure') {
        $pdf->Cell(0,10,'Date de validation : vide',0,1);
        $pdf->Cell(0,10,'Heure de validation : vide',0,1);
    } else {
        $pdf->Cell(0,10,'Date de validation : '.$row['date_validation'],0,1);
        $pdf->Cell(0,10,'Heure de validation : '.$row['Hour_validation'],0,1);

        $id_user = $_SESSION["id"];
        $id_gestion = intval($_GET["ref"]);

        $stmt = $db->prepare("SELECT id_gestion, id_utilisateur, conver_message
            FROM convrsations
            WHERE id_gestion = :id_gestion
            ORDER BY id_gestion ASC;
        ");
        
        $stmt->execute([":id_gestion" => $id_gestion]);
        
        $messagesByUser = [];
        
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $msg) {
            $idUser = $msg["id_utilisateur"];
        
            if (!isset($messagesByUser[$idUser]) && !empty($msg["conver_message"])) {
                $messagesByUser[$idUser] = $msg["conver_message"];
            }
        }
        
        foreach ($messagesByUser as $idUser => $message) {
            if ($idUser === $id_user && !empty($message)) {
                $pdf->MultiCell(0, 10, 'description: ' . $message, 0, 1);
            } elseif (!empty($message)) {
                $pdf->MultiCell(0, 10, 'reponds: ' . $message, 0, 1);
            }
        }
    }

    $pdf->Ln(10);
}


// Affichage du document
$pdf->Output('D', $filename);
}else{
    echo"errur 404!";
}
?>