<?php
session_start();
include 'config.php';

// Vérifiez si le joueur est connecté
if (!isset($_SESSION['pseudo'])) {
    header('Location: connexion_joueur.php');
    exit();
}

$pseudo_joueur = $_SESSION['pseudo'];

// Gestion de la soumission du formulaire pour créer un match
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_match = $_POST['nom_match'];
    $type_match = $_POST['type_match'];
    $nombre_joueurs_recherches = $_POST['nombre_joueurs_recherches'];
    $ville = $_POST['ville'];

    // Insérer le nouveau match avec le nom
    $query = "INSERT INTO Matchs (nomMatch, type_match, nombre_joueurs_recherches, ville) 
              VALUES ('$nom_match', '$type_match', '$nombre_joueurs_recherches', '$ville')";
    
    if (mysqli_query($conn, $query)) {
        // Récupérer l'ID du match récemment créé
        $idMatch = mysqli_insert_id($conn);

        // Insérer automatiquement le créateur dans l'équipe
        $queryEquipe = "INSERT INTO Equipe (nomEquipe) VALUES ('$type_match')";
        if (mysqli_query($conn, $queryEquipe)) {
            $idEquipe = mysqli_insert_id($conn);

            // Mettre à jour le match avec l'ID de l'équipe
            $updateMatch = "UPDATE Matchs SET idEquipe = '$idEquipe' WHERE idMatch = '$idMatch'";
            mysqli_query($conn, $updateMatch);

            // Insérer automatiquement dans `appartenir`
            $queryAppartenir = "
            INSERT INTO appartenir (idJoueur, idEquipe) 
            VALUES (
                (SELECT idJoueur FROM Joueurs WHERE pseudo='$pseudo_joueur'), 
                '$idEquipe'
            )";

            if (mysqli_query($conn, $queryAppartenir)) {
                // Insérer automatiquement dans `participer`
                $queryParticiper = "
                INSERT INTO participer (idJoueur, idMatch) 
                VALUES (
                    (SELECT idJoueur FROM Joueurs WHERE pseudo='$pseudo_joueur'), 
                    '$idMatch'
                )";

                if (mysqli_query($conn, $queryParticiper)) {
                    // Message de succès
                    echo "Le match '$nom_match' a été créé et vous avez été automatiquement ajouté à l'équipe et au match.";
                } else {
                    echo "Erreur lors de l'ajout du joueur au match : " . mysqli_error($conn);
                }
            } else {
                echo "Erreur lors de l'ajout du joueur à l'équipe : " . mysqli_error($conn);
            }
        } else {
            echo "Erreur lors de la création de l'équipe : " . mysqli_error($conn);
        }
    } else {
        echo "Erreur lors de la création du match : " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un Match</title>
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

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
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
            margin-bottom: 10px;
        }

        .btn:hover {
            background-color: #00aaaa;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Créer un Match</h1>

    <form method="POST">
        <label for="nom_match">Nom du Match:</label>
        <input type="text" name="nom_match" id="nom_match" required>

        <label for="type_match">Type de Match:</label>
        <select name="type_match" id="type_match" required>
            <option value="Amical">Amical</option>
            <option value="Compétition">Compétition</option>
            <option value="Tournoi">Tournoi</option>
            <option value="Exhibition">Exhibition</option>
            <!-- Ajoute d'autres options si nécessaire -->
        </select>

        <label for="nombre_joueurs_recherches">Nombre de Joueurs Recherchés:</label>
        <input type="number" name="nombre_joueurs_recherches" id="nombre_joueurs_recherches" required>

        <label for="ville">Ville:</label>
        <input type="text" name="ville" id="ville" required>

        <input type="submit" class="btn" value="Créer le match">
    </form>

    <a href="accueil.php" class="btn">Retour à l'accueil</a>
</div>

</body>
</html>
