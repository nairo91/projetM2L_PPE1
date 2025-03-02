
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Tournois</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
            max-width: 1200px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            background: white;
        }
        .table th, .table td {
            text-align: center;
        }

        /* Conteneur stylisé pour la sélection du tournoi */
.select-container {
    text-align: center;
    padding: 20px;
    background: #0077cc;
    color: white;
    border-radius: 10px;
    max-width: 400px;
    margin: auto;
}

/* Style des menus déroulants */
select {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    background-color: #9ec4f5;
    font-size: 16px;
    cursor: pointer;
}

/* Effet sur le menu déroulant au focus */
select:focus {
    outline: none;
    box-shadow: 0 0 5px rgba(0, 119, 204, 0.8);
}

/* Appliquer un fond blanc uniquement au menu déroulant du choix du tournoi */
#tournoiSelect {
    background-color: white !important;
    color: black;
}

/* Garder les autres menus déroulants (ex: sélection du gagnant) en bleu */
select:not(#tournoiSelect) {
    background-color: #9ec4f5 !important;
    color: black;
}

 /* Amélioration des boutons "Mettre à jour" */
 .update-btn {
            display: inline-block;
            background-color: #0077cc;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s ease-in-out, transform 0.1s ease-in-out;
            margin-top: 5px;
        }

        .update-btn:hover {
            background-color: #005fa3;
            transform: scale(1.05);
        }

        .update-btn:active {
            background-color: #004080;
            transform: scale(0.95);
        }

        /* Conteneur stylisé pour les scores */
        .score-container {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px; /* Espacement entre les éléments */
    background: #e3f2fd; /* Couleur bleue claire pour le fond */
    padding: 10px;
    border-radius: 8px;
    max-width: 250px;
    margin-top: 10px; /* Espacement au-dessus */
    margin-bottom: 20px; /* Espacement sous le score */
    display: flex;
    flex-wrap: nowrap;
    justify-content: space-between;
}


/* Style des champs de score */
.score-input {
    width: 50px;
    height: 40px;
    text-align: center;
    font-size: 18px;
    font-weight: bold;
    border: 2px solid #0077cc; /* Bordure bleue */
    border-radius: 5px;
    background-color: white;
}


    </style>
</head>
<body>
    <div class="container">
<?php 
include('config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['gagnant'], $_POST['idMatch'], $_POST['scoreEquipe1'], $_POST['scoreEquipe2'])) {
        $idMatch = intval($_POST['idMatch']);
        $gagnant = intval($_POST['gagnant']);
        $scoreEquipe1 = intval($_POST['scoreEquipe1']);
        $scoreEquipe2 = intval($_POST['scoreEquipe2']);

        $queryUpdate = "UPDATE Matchs SET winner = ?, scoreEquipe1 = ?, scoreEquipe2 = ? WHERE idMatch = ?";
        $stmtUpdate = $conn->prepare($queryUpdate);
        $stmtUpdate->bind_param("iiii", $gagnant, $scoreEquipe1, $scoreEquipe2, $idMatch);
        $stmtUpdate->execute();

        genererPhaseSuivante($conn, $idMatch);
    }
}

function genererPhaseSuivante($conn, $idMatch) {
    $query = "SELECT idTournois, phase FROM Matchs WHERE idMatch = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idMatch);
    $stmt->execute();
    $result = $stmt->get_result();
    $match = $result->fetch_assoc();

    $idTournois = $match['idTournois'];
    $phaseActuelle = $match['phase'];

    $prochainePhase = [
        'Quart de finale' => 'Demi-finale',
        'Demi-finale' => 'Finale'
    ];

    if (isset($prochainePhase[$phaseActuelle])) {
        $phaseSuivante = $prochainePhase[$phaseActuelle];

        $queryGagnants = "SELECT winner FROM Matchs WHERE idTournois = ? AND phase = ? AND winner IS NOT NULL";
        $stmt = $conn->prepare($queryGagnants);
        $stmt->bind_param("is", $idTournois, $phaseActuelle);
        $stmt->execute();
        $result = $stmt->get_result();

        $gagnants = [];
        while ($row = $result->fetch_assoc()) {
            $gagnants[] = $row['winner'];
        }

        if ((($phaseActuelle === 'Quart de finale') && count($gagnants) === 4) ||
            (($phaseActuelle === 'Demi-finale') && count($gagnants) === 2)) {

            for ($i = 0; $i < count($gagnants); $i += 2) {
                $queryInsert = "INSERT INTO Matchs (idTournois, idEquipe1, idEquipe2, phase) VALUES (?, ?, ?, ?)";
                $stmtInsert = $conn->prepare($queryInsert);
                $stmtInsert->bind_param("iiis", $idTournois, $gagnants[$i], $gagnants[$i + 1], $phaseSuivante);
                $stmtInsert->execute();
            }
        }
    }
}

function afficherPhases($conn, $idTournois) {
    $phases = ['Quart de finale', 'Demi-finale', 'Finale'];
    foreach ($phases as $phase) {
        echo "<h3>$phase</h3><div class='matches'>";
        $query = "SELECT m.idMatch, m.idEquipe1, m.idEquipe2, e1.nomEquipe AS equipe1, e2.nomEquipe AS equipe2, m.winner, m.scoreEquipe1, m.scoreEquipe2,
                         (SELECT nomEquipe FROM Equipe WHERE idEquipe = m.winner) AS winnerName
                  FROM Matchs m 
                  LEFT JOIN Equipe e1 ON m.idEquipe1 = e1.idEquipe
                  LEFT JOIN Equipe e2 ON m.idEquipe2 = e2.idEquipe
                  WHERE m.idTournois = ? AND m.phase = ? ORDER BY m.idMatch";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("is", $idTournois, $phase);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($match = $result->fetch_assoc()) {
            echo "<div class='match'>{$match['equipe1']} VS {$match['equipe2']}<br>";
            echo "<form method='POST'>
                    <input type='hidden' name='idMatch' value='{$match['idMatch']}'>
                    <label>Score: </label>
                      <input type='number' name='scoreEquipe1' value='{$match['scoreEquipe1']}' min='0' class='score-input'> -
                        <input type='number' name='scoreEquipe2' value='{$match['scoreEquipe2']}' min='0' class='score-input'>
                    <label>Gagnant: </label>
                    <select name='gagnant'>
                        <option value='{$match['idEquipe1']}'>{$match['equipe1']}</option>
                        <option value='{$match['idEquipe2']}'>{$match['equipe2']}</option>
                    </select>
                    <input type='submit' value='Mettre à jour' class='update-btn'>
                  </form>";
            echo "<strong>Gagnant : {$match['winnerName']}</strong>";
            echo "</div>";
        }
        
        echo "</div>";
    }
    afficherStatistiques($conn, $idTournois);
}

function afficherStatistiques($conn, $idTournois) {
    echo "<h3>Statistiques des Équipes</h3><table border='1'>
          <tr><th>Équipe</th><th>Victoires</th><th>Défaites</th><th>Buts Marqués</th><th>Buts Encaissés</th></tr>";

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

$queryTournois = "SELECT idTournois, nomTournois FROM Tournois";
$resultTournois = $conn->query($queryTournois);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer les Tournois</title>
   <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
        .matches { margin: 20px auto; max-width: 800px; }
        .match { padding: 15px; background: #e0f7fa; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 10px; text-align: center; }
        th { background-color: #0077cc; color: white; }

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

    </style>

</head>
<body>
<h1>Gérer les Tournois</h1>

<div class="select-container">
<form method="GET" action="">
    <label for="tournoi">Sélectionnez un tournoi :</label>
    <select name="tournoi" id="tournoiSelect" onchange="this.form.submit()">
        <option value="">-- Choisissez un tournoi --</option>
        <?php
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
    afficherPhases($conn, $idTournois);
}
?>


<a href="accueil.php">Retour à l'accueil</a>
</body>
</html>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
