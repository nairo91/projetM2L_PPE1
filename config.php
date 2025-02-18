<?php
$servername = "localhost";
$username = "root";  // Mettez ici votre nom d'utilisateur MySQL
$password = "";  // Mettez ici votre mot de passe MySQL
$dbname = "gestion_football";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}
?>
