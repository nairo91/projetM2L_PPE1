<?php
session_start();
include('config.php');
require('fpdf/fpdf.php'); // Vérifiez que le chemin vers fpdf.php est correct

// Vérifier que les données nécessaires sont transmises via POST
if (!isset($_POST['totalMatchs'])) {
    die("Données non spécifiées pour l'export PDF.");
}

// --- Recalculer les statistiques globales ---
// 1) Nombre total de matchs
$queryTotalMatchs = "SELECT COUNT(*) AS total_matchs FROM Matchs";
$result = mysqli_query($conn, $queryTotalMatchs);
$row = mysqli_fetch_assoc($result);
$totalMatchs = $row['total_matchs'];

// 2) Moyenne de buts par match
$queryMoyenneButs = "
    SELECT AVG(scoreEquipe1 + scoreEquipe2) AS avg_goals
    FROM Matchs
    WHERE scoreEquipe1 IS NOT NULL AND scoreEquipe2 IS NOT NULL
";
$result = mysqli_query($conn, $queryMoyenneButs);
$row = mysqli_fetch_assoc($result);
$moyenneButs = round($row['avg_goals'], 2);

// 3) Match le plus scoré avec noms des équipes
$queryMaxScore = "
    SELECT e1.nomEquipe AS equipe1, e2.nomEquipe AS equipe2, 
           (m.scoreEquipe1 + m.scoreEquipe2) AS total_buts
    FROM Matchs m
    LEFT JOIN Equipe e1 ON m.idEquipe1 = e1.idEquipe
    LEFT JOIN Equipe e2 ON m.idEquipe2 = e2.idEquipe
    ORDER BY total_buts DESC
    LIMIT 1
";
$result = mysqli_query($conn, $queryMaxScore);
$row = mysqli_fetch_assoc($result);
$matchPlusScore = $row['equipe1'] . " VS " . $row['equipe2'];
$maxButs = $row['total_buts'];

// 4) Nombre total de tournois
$queryTotalTournois = "SELECT COUNT(*) AS total_tournois FROM Tournois";
$result = mysqli_query($conn, $queryTotalTournois);
$row = mysqli_fetch_assoc($result);
$totalTournois = $row['total_tournois'];

// --- Nouvelle section : Participation par équipe sur tous les tournois ---
$teamsParticipation = []; 

// Récupérer la liste de toutes les équipes
$queryTeams = "SELECT idEquipe, nomEquipe FROM Equipe";
$resTeams = mysqli_query($conn, $queryTeams);

while ($team = mysqli_fetch_assoc($resTeams)) {
    $idEquipe = $team['idEquipe'];
    $nomEquipe = $team['nomEquipe'];
    
    // Pour chaque équipe, compter le nombre de tournois distincts auxquels elle participe
    $queryTeamParticipation = "
    SELECT COUNT(DISTINCT i.idTournois) AS nbParticipations
    FROM impliquer i
    JOIN Tournois t ON i.idTournois = t.idTournois
    WHERE i.idEquipe = $idEquipe
";
$resTeam = mysqli_query($conn, $queryTeamParticipation);

    $rowTeam = mysqli_fetch_assoc($resTeam);
    $nbParticipations = $rowTeam['nbParticipations'];
    
    // Calcul du taux de participation par équipe par rapport au nombre total de tournois
    $rate = $totalTournois > 0 ? ($nbParticipations / $totalTournois) * 100 : 0;
    
    $teamsParticipation[] = [
        'idEquipe' => $idEquipe,
        'nomEquipe' => $nomEquipe,
        'nbParticipations' => $nbParticipations,
        'rate' => $rate
    ];
}

// --- Génération du PDF ---
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10, 'Statistiques Globales', 0, 1, 'C');
$pdf->Ln(5);

// Statistiques sur les matchs
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10, 'Statistiques sur les matchs :', 0, 1);
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,10, 'Nombre total de matchs joues : ' . $totalMatchs, 0, 1);
$pdf->Cell(0,10, 'Moyenne de buts par match : ' . $moyenneButs, 0, 1);
$pdf->Cell(0,10, 'Match le plus score : ' . $matchPlusScore . ' avec ' . $maxButs . ' buts cumules', 0, 1);
$pdf->Ln(5);

// Statistiques sur les tournois
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10, 'Statistiques sur les tournois :', 0, 1);
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,10, 'Nombre total de tournois organises : ' . $totalTournois, 0, 1);
$pdf->Ln(5);

// Participation par équipe
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10, 'Participation par equipe', 0, 1);
$pdf->SetFont('Arial','B',10);
// En-têtes du tableau
$pdf->Cell(25, 8, 'ID Equipe', 1, 0, 'C');
$pdf->Cell(50, 8, 'Nom Equipe', 1, 0, 'C');
$pdf->Cell(40, 8, 'Tournois part.', 1, 0, 'C');
$pdf->Cell(40, 8, 'Taux (%)', 1, 1, 'C');

$pdf->SetFont('Arial','',10);
foreach ($teamsParticipation as $team) {
    $pdf->Cell(25, 8, $team['idEquipe'], 1, 0, 'C');
    $pdf->Cell(50, 8, $team['nomEquipe'], 1, 0, 'C');
    $pdf->Cell(40, 8, $team['nbParticipations'], 1, 0, 'C');
    $pdf->Cell(40, 8, round($team['rate'],2).' %', 1, 1, 'C');
}

// Nettoyer le buffer de sortie pour éviter l'erreur "Some data has already been output"
if (ob_get_length()) {
    ob_end_clean();
}

// Sortie du PDF et forcer le téléchargement
$pdf->Output('D', 'Statistiques_Globales.pdf');
exit;
?>
