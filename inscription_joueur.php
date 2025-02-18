<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $age = intval($_POST['age']);
    $pseudo = $_POST['pseudo'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $niveau = $_POST['niveau'];

    $query = "INSERT INTO Joueurs (nom, prenom, age, pseudo, niveau, mot_de_passe) 
              VALUES ('$nom', '$prenom', $age, '$pseudo', '$niveau', '$mot_de_passe')";

    if (mysqli_query($conn, $query)) {
        header("Location: connexion_joueur.php");
        exit();
    } else {
        $error_message = "Erreur lors de l'inscription : " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #e9f5ff;
            color: #333;
            margin: 0;
            padding: 0;
            background-image: url('football_background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            text-align: center;
        }
        h2 {
            color: #fff;
            margin-bottom: 20px;
            text-shadow: 2px 2px #000;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        input[type="text"],
        input[type="password"],
        input[type="number"],
        select {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error {
            color: #f44336;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Inscription</h2>
    <?php if (isset($error_message)): ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form method="post" action="">
        <input type="text" name="nom" placeholder="Nom" required>
        <input type="text" name="prenom" placeholder="Prénom" required>
        <input type="number" name="age" placeholder="Âge" required>
        <input type="text" name="pseudo" placeholder="Pseudo" required>
        <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
        <select name="niveau" required>
            <option value="" disabled selected>Niveau</option>
            <option value="Débutant">Débutant</option>
            <option value="Joueur occasionnel">Joueur occasionnel</option>
            <option value="Expert">Expert</option>
        </select>
        <input type="submit" value="S'inscrire">
    </form>
</div>
</body>
</html>
