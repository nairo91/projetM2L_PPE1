<?php
session_start();
include 'config.php';

// Vérifiez si le joueur est connecté
if (!isset($_SESSION['pseudo'])) {
    header('Location: connexion_joueur.php');
    exit();
}

$pseudo_joueur = $_SESSION['pseudo'];

// Récupérer l'ID du joueur connecté
$id_joueur_query = "SELECT idJoueur FROM Joueurs WHERE pseudo = '$pseudo_joueur'";
$result_id_joueur = $conn->query($id_joueur_query);
$id_joueur = $result_id_joueur->fetch_assoc()['idJoueur'];

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomEquipe = mysqli_real_escape_string($conn, $_POST['nomEquipe']);

    // Insérer la nouvelle équipe dans la base de données
    $query = "INSERT INTO Equipe (nomEquipe) VALUES ('$nomEquipe')";
    
    if ($conn->query($query) === TRUE) {
        $idEquipe = $conn->insert_id;
        // Ajouter le joueur à cette équipe
        $query_appartenir = "INSERT INTO appartenir (idJoueur, idEquipe) VALUES ('$id_joueur', '$idEquipe')";
        $conn->query($query_appartenir);
        echo "Équipe créée avec succès et vous avez rejoint cette équipe.";
    } else {
        echo "Erreur lors de la création de l'équipe : " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer une équipe</title>
	 <style>
	body {
    background-color: #f4f4f4;
    font-family: Arial, sans-serif;
}

h1 {
    text-align: center;
    font-size: 36px;
    color: #0066ff;
    margin-top: 50px;
}

form {
    background-color: #333;
    border-radius: 10px;
    max-width: 500px;
    margin: 50px auto;
    padding: 30px;
    color: #fff;
    text-align: center;
}

label {
    font-size: 18px;
    color: #fff;
}

select {
    width: 100%;
    padding: 10px;
    margin-top: 20px;
    font-size: 16px;
    border-radius: 5px;
    border: none;
}

button, input[type="submit"], a {
    background-color: #00aaff;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    text-align: center;
    transition: background-color 0.3s ease;
}

button:hover, input[type="submit"]:hover, a:hover {
    background-color: #0088cc;
}

button:focus, input[type="submit"]:focus, a:focus {
    outline: none;
    box-shadow: 0 0 5px #007acc;
}

button:active, input[type="submit"]:active, a:active {
    background-color: #005f99;
}

}

	</style>
</head>
<body>
    <h1>Créer une équipe</h1>
    <form method="post">
        <label>Nom de l'équipe :</label>
        <input type="text" name="nomEquipe" required><br><br>
        <input type="submit" value="Créer l'équipe">
    </form>
    <a href="accueil.php">Retour à l'accueil</a>
</body>
</html>
