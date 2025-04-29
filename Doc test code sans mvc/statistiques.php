<?php
include 'config.php';
session_start();

if (!isset($_SESSION['pseudo'])) {
    header("Location: connexion_joueur.php");
    exit;
}

$pseudo_joueur = $_SESSION['pseudo'];

// Récupérer l'ID du joueur connecté
$id_joueur_query = "SELECT idJoueur FROM Joueurs WHERE pseudo = '$pseudo_joueur'";
$result_id_joueur = $conn->query($id_joueur_query);
$id_joueur = $result_id_joueur->fetch_assoc()['idJoueur'];

// Mettre à jour les statistiques si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_match = intval($_POST['id_match']);
    $nombre_buts = intval($_POST['nombre_buts']);
    $nombre_passes_decisives = intval($_POST['nombre_passes_decisives']);
    $nombre_arrets = intval($_POST['nombre_arrets']);

    $update_stats_query = "
        UPDATE participer 
        SET nombre_buts = '$nombre_buts', nombre_passes_decisives = '$nombre_passes_decisives', nombre_arrets = '$nombre_arrets' 
        WHERE idJoueur = '$id_joueur' AND idMatch = '$id_match'
    ";
    
    if ($conn->query($update_stats_query) === TRUE) {
        echo "<script>alert('Statistiques mises à jour avec succès.');</script>";
    } else {
        echo "<script>alert('Erreur lors de la mise à jour des statistiques : " . $conn->error . "');</script>";
    }
}

// Récupérer les statistiques du joueur pour chaque match
$query = "
    SELECT m.idMatch, m.nomMatch, m.type_match, p.nombre_buts, p.nombre_passes_decisives, p.nombre_arrets, m.ville
    FROM participer p
    JOIN Matchs m ON p.idMatch = m.idMatch
    WHERE p.idJoueur = '$id_joueur'
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            background-color: #333;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
        }

        h1, h2 {
            text-align: center;
            color: #fff;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 2.5em;
        }

        h2 {
            font-size: 2em;
            color: #00aaff;
        }

        form {
            margin-bottom: 30px;
            padding: 15px;
            background-color: #444;
            border-radius: 10px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #ddd;
        }

        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #555;
            color: #fff;
        }

        input[type="submit"] {
            background-color: #00aaff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0088cc;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: center;
            color: #fff;
            border: 1px solid #555;
        }

        th {
            background-color: #00aaff;
            font-size: 1.2em;
        }

        td {
            background-color: #444;
        }

        tr:hover td {
            background-color: #555;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #00aaff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #0088cc;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Tableau récapitulatif des statistiques -->
        <h2>Résumé des Statistiques</h2>
        <table>
            <tr>
				<th>Nom du Match</th>

                <th>Type de Match</th>
                <th>Ville</th>
                <th>Buts</th>
                <th>Passes Décisives</th>
                <th>Arrêts</th>
            </tr>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php
                // Réinitialiser le pointeur du résultat pour parcourir les lignes
                $result->data_seek(0);

                while ($row = $result->fetch_assoc()): ?>
                    <tr>
						<td><?php echo htmlspecialchars($row['nomMatch']); ?></td>

                        <td><?php echo htmlspecialchars($row['type_match']); ?></td>
                        <td><?php echo htmlspecialchars($row['ville']); ?></td>
                        <td><?php echo htmlspecialchars($row['nombre_buts']); ?></td>
                        <td><?php echo htmlspecialchars($row['nombre_passes_decisives']); ?></td>
                        <td><?php echo htmlspecialchars($row['nombre_arrets']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Aucune statistique disponible pour ce joueur.</td>
                </tr>
            <?php endif; ?>
        </table>

        <h1>Statistiques de <?php echo htmlspecialchars($pseudo_joueur); ?></h1>

        <?php if ($result && $result->num_rows > 0): ?>
            <?php
            // Réinitialiser le pointeur du résultat pour parcourir à nouveau les lignes
            $result->data_seek(0);

            while ($row = $result->fetch_assoc()): ?>
                <h2>Match: <?php echo htmlspecialchars($row['nomMatch']); ?></h2>

                <form method="post" action="">
                    <input type="hidden" name="id_match" value="<?php echo $row['idMatch']; ?>">
                    <label>Buts:</label>
                    <input type="number" name="nombre_buts" value="<?php echo $row['nombre_buts']; ?>" min="0"><br>
                    <label>Passes décisives:</label>
                    <input type="number" name="nombre_passes_decisives" value="<?php echo $row['nombre_passes_decisives']; ?>" min="0"><br>
                    <label>Arrêts:</label>
                    <input type="number" name="nombre_arrets" value="<?php echo $row['nombre_arrets']; ?>" min="0"><br>
                    <input type="submit" value="Mettre à jour">
                </form>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Aucune statistique disponible pour ce joueur.</p>
        <?php endif; ?>

        <a href="accueil.php">Retour à l'accueil</a>
    </div>
</body>
</html>
