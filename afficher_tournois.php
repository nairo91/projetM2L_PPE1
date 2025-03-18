

<?php
include('config.php');
require('fpdf/fpdf.php');

function afficherStatistiques($conn, $idTournois) {
    echo "<h3>Statistiques des Équipes</h3><table border='1' style='width: 100%; border-collapse: collapse; margin: 20px 0;'>
          <tr style='background-color: #0077cc; color: white;'><th>Équipe</th><th>Victoires</th><th>Défaites</th><th>Buts Marqués</th><th>Buts Encaissés</th></tr>";

    $query = "SELECT e.nomEquipe,
                     SUM(CASE WHEN m.winner = e.idEquipe THEN 1 ELSE 0 END) AS victoires,
                     SUM(CASE WHEN m.winner != e.idEquipe AND (m.idEquipe1 = e.idEquipe OR m.idEquipe2 = e.idEquipe) THEN 1 ELSE 0 END) AS defaites,
                     SUM(CASE WHEN m.idEquipe1 = e.idEquipe THEN m.scoreEquipe1 ELSE m.scoreEquipe2 END) AS buts_marques,
                     SUM(CASE WHEN m.idEquipe1 = e.idEquipe THEN m.scoreEquipe2 ELSE m.scoreEquipe1 END) AS buts_encaisses
              FROM Equipe e
              LEFT JOIN Matchs m ON e.idEquipe = m.idEquipe1 OR e.idEquipe = m.idEquipe2
              WHERE m.idTournois = ?
              GROUP BY e.idEquipe";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idTournois);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['nomEquipe']}</td><td>{$row['victoires']}</td><td>{$row['defaites']}</td><td>{$row['buts_marques']}</td><td>{$row['buts_encaisses']}</td></tr>";
    }
    echo "</table>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher les Tournois</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #1E90FF;
        }

        h2.phase-title {
            text-align: center;
            color: #0077cc;
            margin-top: 40px;
            margin-bottom: 20px;
            font-size: 1.5em;
        }

        .matches {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            margin: 20px auto;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            max-width: 800px;
        }

        .match {
            background-color: #e0f7fa;
            border: 1px solid #1E90FF;
            border-radius: 5px;
            padding: 15px;
            margin: 10px 0;
        }

        .match:hover {
            background-color: #b2ebf2;
        }

        a {
            background-color: #00aaff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin: 20px auto;
        }

        a:hover {
            background-color: #0077cc;
        }

        .select-container {
            background-color: #0077cc;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            margin: 20px auto;
            text-align: center;
            color: white;
        }

        select {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #e0f7fa;
            font-size: 16px;
            cursor: pointer;
        }

        select:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(0, 119, 204, 0.8);
        }
    </style>
</head>
<body>

<h1>Liste des Tournois</h1>

<div class="select-container">
    <form method="GET" action="">
        <label for="tournoi">Sélectionnez un tournoi :</label>
        <select name="tournoi" id="tournoi" onchange="this.form.submit()">
            <option value="">-- Choisissez un tournoi --</option>
            <?php
            $queryTournois = "SELECT idTournois, nomTournois FROM Tournois";
            $resultTournois = $conn->query($queryTournois);

            while ($tournoi = $resultTournois->fetch_assoc()) {
                $selected = (isset($_GET['tournoi']) && $_GET['tournoi'] == $tournoi['idTournois']) ? 'selected' : '';
                echo "<option value='{$tournoi['idTournois']}' $selected>{$tournoi['nomTournois']}</option>";
            }
            ?>
        </select>
    </form>
</div>

<?php
if (isset($_GET['tournoi'])) {
    $idTournois = intval($_GET['tournoi']);

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

    if ($resultMatchs->num_rows > 0) {
        $currentPhase = null;
        echo "<div class='matches'>";
        while ($match = $resultMatchs->fetch_assoc()) {
            $phase = htmlspecialchars($match['phase']);
            $equipe1 = $match['equipe1'] ? htmlspecialchars($match['equipe1']) : 'Équipe non définie';
            $equipe2 = $match['equipe2'] ? htmlspecialchars($match['equipe2']) : 'Équipe non définie';
            $score1 = isset($match['scoreEquipe1']) ? $match['scoreEquipe1'] : '-';
            $score2 = isset($match['scoreEquipe2']) ? $match['scoreEquipe2'] : '-';
            $winner = $match['winner'] ? htmlspecialchars($match['winner']) : 'Pas encore défini';

            if ($phase !== $currentPhase) {
                if ($currentPhase !== null) {
                    echo "</div><div class='matches'>";
                }
                echo "<h2 class='phase-title'>Phase : $phase</h2>";
                $currentPhase = $phase;
            }

            if ($equipe1 !== 'Équipe non définie' && $equipe2 !== 'Équipe non définie') {
                echo "<div class='match'>";
                echo "$equipe1 VS $equipe2<br>";
                echo "Score: $score1 - $score2<br>";
                echo "<strong>Gagnant : </strong>$winner";
                echo "</div>";
            }
        }
        echo "</div>";

        afficherStatistiques($conn, $idTournois);
    } else {
        echo "<p>Aucun match trouvé pour ce tournoi.</p>";
    }
} else {
    echo "<p>Sélectionnez un tournoi pour afficher les matchs.</p>";
}
?>

<a href="export_pdf.php?tournoi=<?php echo $idTournois; ?>">Exporter en PDF</a>

<a href="accueil.php">Retour à l'accueil</a>
</body>
</html>
