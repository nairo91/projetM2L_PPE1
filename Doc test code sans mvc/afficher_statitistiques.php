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

// --- Requêtes SQL pour les statistiques globales ---

// 1) Nombre total de matchs
$queryTotalMatchs = "SELECT COUNT(*) AS total_matchs FROM Matchs";
$resultTotal = mysqli_query($conn, $queryTotalMatchs);
$rowTotal = mysqli_fetch_assoc($resultTotal);
$totalMatchs = $rowTotal['total_matchs'];

// 2) Moyenne de buts par match
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

// 4) Nombre total de tournois
$queryTotalTournois = "SELECT COUNT(*) AS total_tournois FROM Tournois";
$resultTournois = mysqli_query($conn, $queryTotalTournois);
$rowTournois = mysqli_fetch_assoc($resultTournois);
$totalTournois = $rowTournois['total_tournois'];

// 5) (Ancien calcul global du taux de participation pour un tournoi spécifique)
//    Ici, on calcule ce taux par rapport à un nombre attendu (ex: 8 équipes)
//    On garde ce code si besoin, mais nous allons ajouter le tableau par équipe.
$expectedEquipes = 8;
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
$tauxParticipationGlobal = 0;
if ($expectedEquipes > 0) {
    $tauxParticipationGlobal = ($nbEquipesParticipant / $expectedEquipes) * 100;
}

// --- Nouvelle Section : Participation par équipe sur tous les tournois ---

// On récupère la liste de toutes les équipes
$queryTeams = "SELECT idEquipe, nomEquipe FROM Equipe";
$resultTeams = mysqli_query($conn, $queryTeams);
$teamsParticipation = [];

while ($team = mysqli_fetch_assoc($resultTeams)) {
    $idEquipe = $team['idEquipe'];
    $nomEquipe = $team['nomEquipe'];
    
    // Pour chaque équipe, compter le nombre de tournois distincts auxquels elle participe
    $queryTeamParticipation = "SELECT COUNT(DISTINCT i.idTournois) AS nbParticipations
FROM impliquer i
JOIN Tournois t ON i.idTournois = t.idTournois
WHERE i.idEquipe = ?
";
    $stmtTeam = $conn->prepare($queryTeamParticipation);
    $stmtTeam->bind_param("i", $idEquipe);
    $stmtTeam->execute();
    $resultTeam = $stmtTeam->get_result();
    $rowTeam = $resultTeam->fetch_assoc();
    $nbParticipations = $rowTeam['nbParticipations'];
    
    // Calcul du taux de participation par équipe (par rapport au nombre total de tournois)
    $rate = $totalTournois > 0 ? ($nbParticipations / $totalTournois) * 100 : 0;
    
    $teamsParticipation[] = [
        'idEquipe' => $idEquipe,
        'nomEquipe' => $nomEquipe,
        'nbParticipations' => $nbParticipations,
        'rate' => $rate
    ];
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
        /* Styles pour le tableau de participation par équipe */
        .teams-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .teams-table th, .teams-table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        .teams-table th {
            background-color: #0077cc;
            color: #fff;
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
        </div>

        <div class="stats-section">
            <h2>Participation par équipe</h2>
            <table class="teams-table">
                <tr>
                    <th>ID Équipe</th>
                    <th>Nom de l'équipe</th>
                    <th>Tournois participés</th>
                    <th>Total de tournois</th>
                    <th>Taux de participation (%)</th>
                </tr>
                <?php foreach ($teamsParticipation as $team): ?>
                    <tr>
                        <td><?php echo $team['idEquipe']; ?></td>
                        <td><?php echo htmlspecialchars($team['nomEquipe']); ?></td>
                        <td><?php echo $team['nbParticipations']; ?></td>
                        <td><?php echo $totalTournois; ?></td>
                        <td><?php echo round($team['rate'], 2); ?>%</td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <form method="POST" action="export_pdf.php">
            <input type="hidden" name="totalMatchs" value="<?php echo $totalMatchs; ?>">
            <input type="hidden" name="moyenneButs" value="<?php echo $moyenneButs; ?>">
            <input type="hidden" name="matchPlusScore" value="<?php echo $matchPlusScore; ?>">
            <input type="hidden" name="maxButs" value="<?php echo $maxButs; ?>">
            <input type="hidden" name="totalTournois" value="<?php echo $totalTournois; ?>">
            <input type="hidden" name="tauxParticipation" value="<?php echo round($tauxParticipationGlobal, 2); ?>">
  
            <button type="submit">Exporter en PDF</button>
        </form>
    </div>
</body>
</html>
