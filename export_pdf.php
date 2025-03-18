<?php
// export_pdf.php

// 1. Inclure la configuration et la bibliothèque FPDF
include('config.php');
require('fpdf/fpdf.php'); // Chemin vers fpdf.php (ex: "fpdf/fpdf.php" si fpdf est au même niveau que ce fichier)

// 2. Vérifier si l'ID du tournoi est bien passé en paramètre
if (!isset($_GET['tournoi'])) {
    die("Tournoi non spécifié.");
}
$idTournois = intval($_GET['tournoi']);

// 3. Récupérer le nom du tournoi
$tournoiQuery = "SELECT nomTournois FROM Tournois WHERE idTournois = ?";
$stmtTournoi = $conn->prepare($tournoiQuery);
$stmtTournoi->bind_param("i", $idTournois);
$stmtTournoi->execute();
$resultTournoi = $stmtTournoi->get_result();
$tournoi = $resultTournoi->fetch_assoc();
$nomTournoi = $tournoi['nomTournois'];

// 4. Créer un nouveau document PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10, 'Tournoi : '.$nomTournoi, 0, 1, 'C');
$pdf->Ln(5);

// 5. Afficher la liste des matchs
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10, 'Matches :', 0, 1);
$pdf->SetFont('Arial','',10);

$queryMatchs = "
    SELECT m.idMatch, m.phase, e1.nomEquipe AS equipe1, e2.nomEquipe AS equipe2, 
           m.scoreEquipe1, m.scoreEquipe2, g.nomEquipe AS winner 
    FROM Matchs m
    LEFT JOIN Equipe e1 ON m.idEquipe1 = e1.idEquipe 
    LEFT JOIN Equipe e2 ON m.idEquipe2 = e2.idEquipe
    LEFT JOIN Equipe g ON m.winner = g.idEquipe
    WHERE m.idTournois = ? 
    ORDER BY FIELD(m.phase, 'Quart de finale', 'Demi-finale', 'Finale'), m.idMatch
";
$stmtMatchs = $conn->prepare($queryMatchs);
$stmtMatchs->bind_param("i", $idTournois);
$stmtMatchs->execute();
$resultMatchs = $stmtMatchs->get_result();

$currentPhase = null;
while ($match = $resultMatchs->fetch_assoc()) {
    if ($match['phase'] !== $currentPhase) {
        $currentPhase = $match['phase'];
        // Titre de la phase
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(0,10, 'Phase : '.$currentPhase, 0, 1);
        $pdf->SetFont('Arial','',10);
    }
    // Affichage du match
    $ligneMatch = $match['equipe1'].' vs '.$match['equipe2'].' - Score: '.$match['scoreEquipe1'].' - '.$match['scoreEquipe2'].' - Gagnant: '.$match['winner'];
    $pdf->Cell(0,10, $ligneMatch, 0, 1);
}
$pdf->Ln(5);

// 6. Afficher les statistiques des équipes
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10, 'Statistiques des Équipes :', 0, 1);

// En-têtes du tableau
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,10, 'Équipe', 1);
$pdf->Cell(30,10, 'Victoires', 1);
$pdf->Cell(30,10, 'Défaites', 1);
$pdf->Cell(30,10, 'Buts Marqués', 1);
$pdf->Cell(30,10, 'Buts Encaissés', 1);
$pdf->Ln();

$pdf->SetFont('Arial','',10);

$queryStats = "
    SELECT e.nomEquipe,
           SUM(CASE WHEN m.winner = e.idEquipe THEN 1 ELSE 0 END) AS victoires,
           SUM(CASE WHEN m.winner != e.idEquipe AND (m.idEquipe1 = e.idEquipe OR m.idEquipe2 = e.idEquipe) THEN 1 ELSE 0 END) AS defaites,
           SUM(CASE WHEN m.idEquipe1 = e.idEquipe THEN m.scoreEquipe1 ELSE m.scoreEquipe2 END) AS buts_marques,
           SUM(CASE WHEN m.idEquipe1 = e.idEquipe THEN m.scoreEquipe2 ELSE m.scoreEquipe1 END) AS buts_encaisses
    FROM Equipe e
    LEFT JOIN Matchs m ON e.idEquipe = m.idEquipe1 OR e.idEquipe = m.idEquipe2
    WHERE m.idTournois = ?
    GROUP BY e.idEquipe
";
$stmtStats = $conn->prepare($queryStats);
$stmtStats->bind_param("i", $idTournois);
$stmtStats->execute();
$resultStats = $stmtStats->get_result();

while ($row = $resultStats->fetch_assoc()) {
    $pdf->Cell(40,10, $row['nomEquipe'], 1);
    $pdf->Cell(30,10, $row['victoires'], 1);
    $pdf->Cell(30,10, $row['defaites'], 1);
    $pdf->Cell(30,10, $row['buts_marques'], 1);
    $pdf->Cell(30,10, $row['buts_encaisses'], 1);
    $pdf->Ln();
}

// 7. Générer et forcer le téléchargement du PDF
$pdf->Output('D', 'Tournoi_'.$nomTournoi.'.pdf');
