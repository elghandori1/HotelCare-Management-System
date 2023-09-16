<?php 
session_start();
require("../config.php");
    // Définir le nom du fichier PDF à télécharger
    $date = date("Y/m/d");
    $filename="les reclamations date:'. $date .'.pdf";
$stm = $db->prepare("SELECT MIN(gt.idgestions) as idgestions, 
u.nom_user, gt.Num_chambre, c.conver_message, gt.date_reclamation, 
gt.Hour_reclamation, gt.date_validation, gt.Hour_validation, gt.status_gestion 
FROM utilisateurs u INNER JOIN gestionsTraveaux gt ON u.id_user = gt.id_utilisateur 
INNER JOIN convrsations c ON gt.idgestions = c.id_gestion WHERE u.pages = 'ReclamePage.php' 
GROUP BY gt.idgestions ORDER BY gt.idgestions DESC");
$stm->execute();

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
        $this->Cell(0, 10, 'Les reclamation dans Date '.date('d/m/Y'), 1, 0, 'C');
        // $this->Cell(30,10,'Reclamation Details');
        // $this->Ln(12);
        // $this->Cell(30,10,'Reclamation Details');
        // Saut de ligne
        $this->Ln(15);
    }

    // Pied de page
    function Footer()
    {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-20);
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

// En-tête du tableau
$pdf->SetFont('Arial', '', 8);
$pdf->SetFillColor(230, 230, 230);
$pdf->Cell(30, 8, 'Nom RC', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'N/CHMBR', 1, 0, 'C', true);
$pdf->Cell(40, 8, 'DEMANDE', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'DATE RECL', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'DATE VALID', 1, 0, 'C', true);
$pdf->Cell(20, 8, 'STATUS', 1, 0, 'C', true);
$pdf->Ln();

// Contenu du tableau
$pdf->SetFont('Arial', '', 8);
$pdf->SetFillColor(255, 255, 255);
foreach ($stm->fetchAll() as $row) {
$pdf->Cell(30, 8, $row["nom_user"], 1, 0, 'C', false);
$pdf->Cell(30, 8, $row["Num_chambre"], 1, 0, 'C', false);
$pdf->Cell(40, 8, $row["conver_message"], 1, 'C', false);
$pdf->Cell(30, 8, $row["date_reclamation"], 1, 0, 'C', false);
$pdf->Cell(30, 8, $row["date_validation"], 1, 0, 'C', false);
$pdf->Cell(20, 8, $row["status_gestion"], 1, 0, 'C', true);
$pdf->Ln();
}

// Téléchargement du fichier PDF
$pdf->Output('D', $filename); // D pour téléchargement direct









//=============================================
    // Définir le nom du fichier PDF à télécharger
//     $date = date("Y/m/d");
//     $filename="les reclamations date:'. $date .'.pdf";
//     //---------------------
//     require("../config.php");
//     $stm = $db->prepare("SELECT MIN(gt.idgestions) as idgestions, 
//     u.nom_user, gt.Num_chambre, c.conver_message, gt.date_reclamation, 
//     gt.Hour_reclamation, gt.date_validation, gt.Hour_validation, gt.status_gestion 
//     FROM utilisateurs u INNER JOIN gestionsTraveaux gt ON u.id_user = gt.id_utilisateur 
//     INNER JOIN convrsations c ON gt.idgestions = c.id_gestion WHERE u.pages = 'ReclamePage.php' 
//     GROUP BY gt.idgestions ORDER BY gt.idgestions DESC");
//     $stm->execute();
  
// require('../fpdfBiblio/fpdf.php');

// class PDF extends FPDF
// {
//     // En-tête
//     function Header()
//     {
//         // Logo
//         $this->Image('../images/logo-vichy.jpg',10,6,30);
//         // Police Arial gras 15
//         $this->SetFont('Arial','B',15);
//         // // Décalage à droite
//         // $this->Cell(80);
//         $this->Ln(15);
//         // Titre
//         $this->Cell(0, 10, 'Les reclamation dans Date '.date('d/m/Y'), 1, 0, 'C');
//         // $this->Cell(30,10,'Reclamation Details');
//         $this->Ln(12);
//         $this->Cell(30,10,'Reclamation Details');
//         // Saut de ligne
//         $this->Ln(15);
//     }

//     // Pied de page
//     function Footer()
//     {
//         // Positionnement à 1,5 cm du bas
//         $this->SetY(-15);
//         // Police Arial italique 8
//         $this->SetFont('Arial','I',8);
//         // Numéro de page
//         $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
//     }
// }

// // Instanciation de la classe dérivée
// $pdf = new PDF(orientation:'P',unit:'mm',size:'A4');
// $pdf->AliasNbPages();
// $pdf->AddPage();


// // Définition de la police de caractères et de la taille de texte
// $pdf->SetFont('Arial','',8);
// $pdf->SetMargins(10, 10, 10);

// $pdf->Cell(30, 10, 'Nom RC', 1);
// $pdf->Cell(30, 10, 'N/CHMBR', 1);
// $pdf->Cell(40, 10, 'DEMANDE', 1);
// $pdf->Cell(30, 10, 'DATE RECL', 1);
// $pdf->Cell(30, 10, 'HEURE RECL', 1);
// $pdf->Cell(30, 10, 'DATE VALID', 1);
// $pdf->Cell(30, 10, 'HEURE VALI', 1);
// $pdf->Cell(20, 10, 'STATUS', 1);
// $pdf->Ln();
// // Boucle pour afficher les données
// foreach ($stm->fetchAll() as $row) {
//     $pdf->Cell(30, 10, $row["nom_user"], 1);
//     $pdf->Cell(30, 10, $row["Num_chambre"], 1);
//     $pdf->MultiCell(40, 10, $row["conver_message"], 1);
//     $pdf->Cell(30, 10, $row["date_reclamation"], 1);
//     $pdf->Cell(30, 10, $row["Hour_reclamation"], 1);
//     if($row["status_gestion"]==='no-valid'|| $row["status_gestion"]==='en-coure'){
//         $pdf->Cell(30, 10, '----------', 1);
//         $pdf->Cell(30, 10, '----------', 1);
//     } else {
//         $pdf->Cell(30, 10, $row["date_validation"], 1);
//         $pdf->Cell(30, 10, $row["Hour_validation"], 1);
//     }
//     if($row["status_gestion"]==='no-valid'){
//         $pdf->Cell(20, 10, $row["status_gestion"], 1, 0, '', true);
//     } elseif($row["status_gestion"]==='en-coure'){
//         $pdf->Cell(20, 10, $row["status_gestion"], 1, 0, '', true);
//     } else {
//         $pdf->Cell(20, 10, $row["status_gestion"], 1, 0, '', false);
//     }





//=============================================

    // $pdf->Cell(0,10,'Nom reclamateur : '.$row['nom_user'],0,1);
    // $pdf->Cell(0,10,'Num de chamnre : '.$row['Num_chambre'],0,1);
    // $pdf->Cell(0,10,'Date de reclamation : '.$row['date_reclamation'],0,1);
    // $pdf->Cell(0,10,'Heure de reclamation : '.$row['Hour_reclamation'],0,1);
    // if ($row["status_gestion"]==='no-valid' || $row["status_gestion"]==='en-coure') {
    //     $pdf->Cell(0,10,'Date de validation : vide',0,1);
    //     $pdf->Cell(0,10,'Heure de validation : vide',0,1);
    // } else {
    //     $pdf->Cell(0,10,'Date de validation : '.$row['date_validation'],0,1);
    //     $pdf->Cell(0,10,'Heure de validation : '.$row['Hour_validation'],0,1);
    // }
    // $pdf->Cell(0,10,'Status : '.$row['status_gestion'],0,1);
    // $pdf->Cell(0,10,'Num de BON : '.$row['Num_BON'],0,1);
    // $pdf->Ln(10);


    //}


// Affichage du document
$pdf->Output('D', $filename);

?>