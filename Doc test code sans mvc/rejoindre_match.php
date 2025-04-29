<?php
session_start();
include 'config.php';

// Vérifiez si le joueur est connecté
if (!isset($_SESSION['pseudo'])) {
    header('Location: connexion_joueur.php');
    exit();
}

$pseudo_joueur = $_SESSION['pseudo'];

// Récupérer la liste des matchs
$query = "SELECT idMatch, nomMatch FROM Matchs";
$result = mysqli_query($conn, $query);

// Gestion de la soumission du formulaire pour rejoindre un match
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idMatch = intval($_POST['idMatch']);

    // Vérifier si le joueur est déjà inscrit au match
    $queryCheck = "
    SELECT * FROM participer WHERE idJoueur = 
    (SELECT idJoueur FROM Joueurs WHERE pseudo='$pseudo_joueur') AND idMatch = '$idMatch'";
    $resultCheck = mysqli_query($conn, $queryCheck);

    if (mysqli_num_rows($resultCheck) > 0) {
        // Si le joueur est déjà inscrit, afficher un message d'erreur
        $message = "Vous êtes déjà inscrit à ce match.";
    } else {
        // Si le joueur n'est pas inscrit, l'ajouter au match
        $query = "
        INSERT INTO participer (idJoueur, idMatch) 
        VALUES (
            (SELECT idJoueur FROM Joueurs WHERE pseudo='$pseudo_joueur'), 
            '$idMatch'
        )";

        if (mysqli_query($conn, $query)) {
            $message = "Vous avez rejoint le match avec succès.";
        } else {
            $message = "Erreur : " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rejoindre un Match</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-weight: bold;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #00aaff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
			margin-bottom : 20 px;
        }

        .btn:hover {
            background-color: #00aaaa;
        }

        .message {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Rejoindre un Match</h1>

    <!-- Message d'erreur ou de succès -->
    <div class="message">
        <?php 
        if (isset($message)) {
            echo $message;
        }
        ?>
    </div>

    <form method="POST">
        <label for="idMatch">Choisir un match :</label>
        <select name="idMatch" id="idMatch" required>
            <option value="">Choisissez un match</option>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <option value="<?php echo htmlspecialchars($row['idMatch'] ?? ''); ?>">
                    <?php echo htmlspecialchars($row['nomMatch'] ?? ''); ?>
                </option>
            <?php } ?>
        </select>
        <br><br>
        <input type="submit" class="btn" value="Rejoindre">
    </form>

    <a href="accueil.php" class="btn">Retour à l'accueil</a>
</div>

</body>
</html>
