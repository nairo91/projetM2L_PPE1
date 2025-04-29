<?php
include 'config.php';
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['pseudo'])) {
    header("Location: connexion_joueur.php"); // Redirige vers la connexion si non connecté
    exit();
}

// Récupérer le rôle de l'utilisateur
$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
     <style>
        .logo {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 80px;
            height: auto;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            background-image: url('football_field_background.jpg');
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
            min-height: 100vh; /* Assure une hauteur minimale */
            display: flex;
            flex-direction: column;
        }

        .header {
            background-color: rgb(50 53 50 / 90%);
            padding: 20px;
            text-align: center;
            color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .header h1 {
            margin: 0;
            font-size: 3em;
            text-shadow: 2px 2px 4px #000;
        }

        .nav {
            margin: 20px 0;
            text-align: center;
        }

        .nav a, .nav .dropbtn {
            background-color: #00aaff;
            color: white;
            padding: 15px 25px;
            margin: 10px;
            text-decoration: none;
            display: inline-block;
            border-radius: 10px;
            font-size: 1.2em;
            transition: background-color 0.3s, transform 0.3s;
        }

        .nav a:hover, .nav .dropbtn:hover {
            background-color: #00aaff61;
            transform: scale(1.1);
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #00aaff;
            min-width: 200px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        .dropdown-content a:hover {
            background-color: #00aaff61;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-top: 50px;
            flex: 1; /* Permet d'étendre la section */
        }

        .footer {
            text-align: center;
            padding: 20px;
            background-color: rgb(50 53 50 / 90%);
            color: white;
            position: relative; /* Plus de position fixe */
            width: 100%;
        }

        .video-container {
            border: 5px solid #333;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 800px;
            height: 400px;
            margin: 20px auto;
            position: relative;
        }

        iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .spacer {
            height: 300px; /* Ajoute de l'espace en bas pour "étirer" la page */
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Bienvenue sur le site de Trouve Ton Match</h1>
    <img src="logo.png" alt="Logo" class="logo">
</div>

<div class="nav">
    <a href="accueil.php">Accueil</a>
    
    <div class="dropdown">
        <button class="dropbtn">Match</button>
        <div class="dropdown-content">
            <a href="creer_match.php">Créer un match</a>
            <a href="rejoindre_match.php">Rejoindre un match</a>
        </div>
    </div>
    
    <a href="statistiques.php">Voir mes statistiques</a>
	<div class="dropdown">
        <button class="dropbtn">Tournoi</button>
        <div class="dropdown-content">
            <a href="creer_tournoi.php">Créer un tournoi</a>
            <a href="afficher_tournois.php">Afficher tournoi</a>
            <?php if ($role === 'admin'): ?>
                <a href="gerer_tournois.php">Gérer les tournois</a>
            <?php endif; ?>
        </div>
    </div>
	
	<div class="dropdown">
        <button class="dropbtn">Equipe</button>
        <div class="dropdown-content">
            <a href="creer_equipe.php">Créer une equipe</a>
            <a href="rejoindre_equipe.php">Rejoindre une equipe</a>
        </div>
    </div>

    <a href="index.html">Se déconnecter</a>
</div>
<div class="video-container">
        <iframe src="https://www.youtube.com/embed/Yq7Yy8H5J-8?autoplay=1&mute=1&controls=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
</div>
<div class="container">
    <h2>À propos du site</h2>
    <p>
        Ce site vous permet de gérer vos matchs et tournois de football, de suivre vos performances, et bien plus encore.
    </p>
    <p>
        Utilisez les liens ci-dessus pour naviguer vers les différentes fonctionnalités.
    </p>
</div>

<div class="footer">
    &copy; 2025 - Site de gestion de football
</div>

</body>
</html>
