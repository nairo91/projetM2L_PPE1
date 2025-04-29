<?php
session_start();
include 'config.php';

// Vérifiez si le joueur est connecté
if (!isset($_SESSION['pseudo'])) {
    header('Location: connexion_joueur.php');
    exit();
}

$pseudo_joueur = $_SESSION['pseudo'];

// Récupérer la liste des équipes
$query = "SELECT idEquipe, nomEquipe FROM Equipe";
$result = mysqli_query($conn, $query);

// Gestion de la soumission du formulaire pour rejoindre une équipe
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idEquipe = intval($_POST['idEquipe']);

    // Vérifier si le joueur fait déjà partie de l'équipe
    $queryCheck = "
    SELECT * FROM appartenir 
    WHERE idJoueur = (SELECT idJoueur FROM Joueurs WHERE pseudo='$pseudo_joueur') 
    AND idEquipe = '$idEquipe'";
    $resultCheck = mysqli_query($conn, $queryCheck);

    if (mysqli_num_rows($resultCheck) > 0) {
        // Le joueur est déjà dans l'équipe
        $message = "Vous faites déjà partie de cette équipe.";
    } else {
        // Si le joueur ne fait pas encore partie de l'équipe, l'ajouter
        $query = "
        INSERT INTO appartenir (idJoueur, idEquipe) 
        VALUES (
            (SELECT idJoueur FROM Joueurs WHERE pseudo='$pseudo_joueur'), 
            '$idEquipe'
        )";

        if (mysqli_query($conn, $query)) {
            $message = "Vous avez rejoint l'équipe avec succès.";
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
    <title>Rejoindre une Équipe</title>
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
        }

        .btn:hover {
            background-color: #00aaaa;
        }

        .message {
            color: red;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .success {
            color: green;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Rejoindre une Équipe</h1>

    <!-- Message d'erreur ou de succès -->
    <?php if (!empty($message)) { ?>
        <div class="message <?php echo (strpos($message, 'succès') !== false) ? 'success' : ''; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php } ?>

    <form method="POST">
        <label for="idEquipe">Choisir une équipe :</label>
        <select name="idEquipe" id="idEquipe" required>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <option value="<?php echo htmlspecialchars($row['idEquipe']); ?>">
                    <?php echo htmlspecialchars($row['nomEquipe']); ?>
                </option>
            <?php } ?>
        </select>
        <input type="submit" class="btn" value="Rejoindre">
    </form>

    <a href="accueil.php" class="btn">Retour à l'accueil</a>
</div>

</body>
</html>
