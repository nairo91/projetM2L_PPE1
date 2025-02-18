<?php
    session_start();
    include 'config.php';

    $query_equipes = "SELECT idEquipe, nomEquipe FROM Equipe";
    $result_equipes = mysqli_query($conn, $query_equipes);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nomTournoi = $_POST['nomTournoi'];
        $villeTournoi = $_POST['villeTournoi'];
        $equipes = $_POST['equipes'];

        if (count($equipes) === 8) {
            $query_insert_tournoi = "INSERT INTO Tournois (nomTournois, villeTournois) VALUES ('$nomTournoi', '$villeTournoi')";
            mysqli_query($conn, $query_insert_tournoi);
            $idTournois = mysqli_insert_id($conn);

            foreach ($equipes as $idEquipe) {
                $query_impliquer = "INSERT INTO impliquer (idEquipe, idTournois) VALUES ('$idEquipe', '$idTournois')";
                mysqli_query($conn, $query_impliquer);
            }

            for ($i = 0; $i < count($equipes); $i += 2) {
                if (isset($equipes[$i + 1])) {
                    $query_match = "INSERT INTO Matchs (type_match, idEquipe1, idEquipe2, phase, idTournois) VALUES ('Quart de finale', ?, ?, 'Quart de finale', ?)";
                    $stmt_match = $conn->prepare($query_match);
                    $stmt_match->bind_param("iii", $equipes[$i], $equipes[$i + 1], $idTournois);
                    $stmt_match->execute();
                }
            }

            echo "Tournoi créé avec succès avec les matchs de quart de finale.";
        } else {
            echo "Vous devez sélectionner exactement 8 équipes.";
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un tournoi</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
            padding: 20px;
            text-align: center;
        }
        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: inline-block;
            max-width: 400px;
            width: 100%;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .team-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        .team-card {
            background-color: #e0f7fa;
            border: 2px solid transparent;
            padding: 15px;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.2s, border-color 0.2s;
        }
        .team-card:hover {
            transform: translateY(-5px);
            border-color: #0077cc;
        }
        .team-card.selected {
            background-color: #0077cc;
            color: white;
            border-color: #005fa3;
        }
        input[type="checkbox"] {
            display: none;
        }
        input[type="submit"] {
            background-color: #00aaff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0088cc;
        }
        a {
            display: block;
            margin-top: 15px;
            color: #0077cc;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        function toggleSelection(card) {
            const checkbox = card.querySelector('input[type="checkbox"]');
            checkbox.checked = !checkbox.checked;
            card.classList.toggle('selected', checkbox.checked);
        }
    </script>
</head>
<body>

<h1>Créer un tournoi</h1>
<form method="POST">
    <label for="nomTournoi">Nom du tournoi :</label>
    <input type="text" name="nomTournoi" required>

    <label for="villeTournoi">Ville :</label>
    <input type="text" name="villeTournoi" required>

    <h3>Choisissez 8 équipes pour le tournoi :</h3>
    <div class="team-grid">
        <?php while ($row = mysqli_fetch_assoc($result_equipes)) { ?>
            <div class="team-card" onclick="toggleSelection(this)">
                <input type="checkbox" name="equipes[]" value="<?php echo $row['idEquipe']; ?>">
                <?php echo $row['nomEquipe']; ?>
            </div>
        <?php } ?>
    </div>

    <input type="submit" value="Créer le tournoi">
    <a href="accueil.php">Retour à l'accueil</a>
</form>

</body>
</html>
