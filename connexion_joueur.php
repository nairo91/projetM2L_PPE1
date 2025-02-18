<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pseudo = $_POST['pseudo'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Requête pour récupérer les informations de l'utilisateur
    $query = "SELECT * FROM joueurs WHERE pseudo = '$pseudo' AND mot_de_passe = '$mot_de_passe'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['pseudo'] = $pseudo;
        $_SESSION['role'] = $row['role']; // Stocke le rôle dans la session

        // Redirection selon le rôle
        if ($row['role'] === 'admin') {
            header("Location: accueil_admin.php");
        } else {
            header("Location: accueil.php");
        }
        exit();
    } else {
        $error_message = "Pseudo ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
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
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #555;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin: 10px 0 5px;
            color: #333;
        }

        input[type="text"], input[type="password"] {
            padding: 10px;
            font-size: 16px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            padding: 10px;
            font-size: 16px;
            color: #fff;
            background: #00aaff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background: #0088cc;
        }

        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Connexion</h1>
        <?php if (isset($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="pseudo">Pseudo</label>
            <input type="text" name="pseudo" id="pseudo" required>
            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" name="mot_de_passe" id="mot_de_passe" required>
            <input type="submit" value="Se connecter">
        </form>
    </div>
</body>
</html>
