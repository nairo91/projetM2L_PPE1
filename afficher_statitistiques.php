<?php
session_start();
include 'config.php';

// Vérifier que l'utilisateur est connecté et a le rôle 'analyste'
if (!isset($_SESSION['pseudo']) || $_SESSION['role'] !== 'analyste') {
    header("Location: connexion_joueur.php");
    exit();
}

// On récupère l'ID du tournoi (par exemple via GET)
$idTournois = isset($_GET['tournoi']) ? intval($_GET['tournoi']) : 0;

// --- Requêtes SQL pour les statistiques ---

$queryTotalMatchs = "SELECT COUNT(*) AS total_matchs FROM Matchs";
$resultTotal = mysqli_query($conn, $queryTotalMatchs);
$rowTotal = mysqli_fetch_assoc($resultTotal);
$totalMatchs = $rowTotal['total_matchs'];


$queryMoyenneButs = "
    SELECT AVG(scoreEquipe1 + scoreEquipe2) AS avg_goals
    FROM Matchs
    WHERE (scoreEquipe1 IS NOT NULL AND scoreEquipe2 IS NOT NULL)
";
$resultMoy = mysqli_query($conn, $queryMoyenneButs);
$rowMoy = mysqli_fetch_assoc($resultMoy);
$moyenneButs = round($rowMoy['avg_goals'], 2);

// 3) Match le plus scoré avec noms des équipes
$queryMaxScore = "
    SELECT m.idMatch, m.scoreEquipe1, m.scoreEquipe2, 
           e1.nomEquipe AS equipe1, e2.nomEquipe AS equipe2, 
           (m.scoreEquipe1 + m.scoreEquipe2) AS total_buts
    FROM Matchs m
    LEFT JOIN Equipe e1 ON m.idEquipe1 = e1.idEquipe
    LEFT JOIN Equipe e2 ON m.idEquipe2 = e2.idEquipe
    ORDER BY total_buts DESC
    LIMIT 1
";
$resultMax = mysqli_query($conn, $queryMaxScore);
$rowMax = mysqli_fetch_assoc($resultMax);
$matchPlusScore = $rowMax['equipe1'] . " VS " . $rowMax['equipe2'];
$maxButs = $rowMax['total_buts'];


$queryTotalTournois = "SELECT COUNT(*) AS total_tournois FROM Tournois";
$resultTournois = mysqli_query($conn, $queryTotalTournois);
$rowTournois = mysqli_fetch_assoc($resultTournois);
$totalTournois = $rowTournois['total_tournois'];


// 5) Taux de participation des équipes pour le tournoi actuel

// Définir le nombre d'équipes attendu pour chaque tournoi (par exemple, 8)
$expectedEquipes = 8;

// Récupérer le nombre d'équipes participantes pour le tournoi actuel
$queryParticipations = "
    SELECT COUNT(DISTINCT idEquipe) AS nbEquipesParticipant
    FROM impliquer
    WHERE idTournois = ?
";
$stmtPart = $conn->prepare($queryParticipations);
$stmtPart->bind_param("i", $idTournois);
$stmtPart->execute();
$resultPart = $stmtPart->get_result();
$rowPart = $resultPart->fetch_assoc();
$nbEquipesParticipant = $rowPart['nbEquipesParticipant'];

// Calcul du taux de participation en pourcentage
$tauxParticipation = 0;
if ($expectedEquipes > 0) {
    $tauxParticipation = ($nbEquipesParticipant / $expectedEquipes) * 100;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord Analyste</title>
    <!-- Ajout d'une police Google Fonts pour un style moderne -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        h1, h2 {
            text-align: center;
        }
        h1 {
            margin-bottom: 30px;
            color: #0077cc;
        }
        h2 {
            margin-top: 40px;
            color: #005fa3;
        }
        p {
            font-size: 1.1em;
            margin: 10px 0;
        }
        strong {
            color: #0077cc;
        }
        .dashboard {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }
        button {
            background-color: #0077cc;
            color: #fff;
            border: none;
            padding: 12px 25px;
            font-size: 1em;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: block;
            margin: 30px auto;
        }
        button:hover {
            background-color: #005fa3;
        }
        .stats-section {
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h1>Tableau de bord de l'Analyste</h1>

        <div class="stats-section">
            <h2>Statistiques sur les matchs</h2>
            <p>Nombre total de matchs joués : <strong><?php echo $totalMatchs; ?></strong></p>
            <p>Moyenne de buts par match : <strong><?php echo $moyenneButs; ?></strong></p>
            <p>Match le plus scoré : 
               <strong><?php echo $matchPlusScore . " avec " . $maxButs . " buts cumulés"; ?></strong>
            </p>
        </div>

        <div class="stats-section">
            <h2>Statistiques sur les tournois</h2>
            <p>Nombre total de tournois organisés : <strong><?php echo $totalTournois; ?></strong></p>
            <p>Taux de participation des équipes : 
               <strong><?php echo round($tauxParticipation, 2); ?>%</strong>
            </p>
        </div>

       
        <form method="POST" action="export_pdf.php">
            <input type="hidden" name="totalMatchs" value="<?php echo $totalMatchs; ?>">
            <input type="hidden" name="moyenneButs" value="<?php echo $moyenneButs; ?>">
            <input type="hidden" name="matchPlusScore" value="<?php echo $matchPlusScore; ?>">
            <input type="hidden" name="maxButs" value="<?php echo $maxButs; ?>">
            <input type="hidden" name="totalTournois" value="<?php echo $totalTournois; ?>">
            <input type="hidden" name="tauxParticipation" value="<?php echo round($tauxParticipation, 2); ?>">
            <button type="submit">Exporter en PDF</button>
        </form>
    </div>
</body>
</html>
