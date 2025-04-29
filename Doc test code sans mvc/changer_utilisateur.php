<?php
// Démarrage de la session et inclusion de la configuration
session_start();
include 'config.php';

// Seuls les administrateurs peuvent accéder à cette page
if (!isset($_SESSION['pseudo']) || $_SESSION['role'] !== 'admin') {
    header("Location: connexion_joueur.php");
    exit();
}

/**
 * Récupère les valeurs ENUM d'une colonne donnée.
 * 
 * @param mysqli $conn La connexion à la base de données.
 * @param string $table Nom de la table.
 * @param string $column Nom de la colonne.
 * @return array Tableau des valeurs ENUM.
 */
function getEnumValues($conn, $table, $column) {
    // Exécuter une requête pour obtenir la définition de la colonne
    $query = "SHOW COLUMNS FROM `$table` LIKE '$column'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    // La colonne 'Type' contient la chaîne ENUM('val1','val2',...)
    $type = $row['Type'];

    // Extraire les valeurs entre apostrophes à l'aide d'une expression régulière
    preg_match("/^enum\('(.*)'\)$/", $type, $matches);

    // Séparer les valeurs en utilisant "','" comme séparateur
    return explode("','", $matches[1]);
}

// Récupérer les rôles existants dans la table "joueurs"
$enumRoles = getEnumValues($conn, "joueurs", "role");

// -----------------------
// Mise à jour du rôle d'un utilisateur
// -----------------------
if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['update_user'])) {
    // Récupérer l'ID de l'utilisateur et le nouveau rôle envoyé par le formulaire
    $userId = intval($_POST['user_id']);
    $newRole = trim($_POST['role']);

    // Vérifier que le nouveau rôle est parmi les valeurs ENUM existantes
    if (in_array($newRole, $enumRoles)) {
        // Mettre à jour la table 'joueurs'
        $queryUpdate = "UPDATE joueurs SET role = ? WHERE idJoueur = ?";
        $stmt = $conn->prepare($queryUpdate);
        $stmt->bind_param("si", $newRole, $userId);
        $stmt->execute();
    } else {
        echo "<script>alert('Le rôle choisi n\'est pas valide.');</script>";
    }
}

// -----------------------
// Création d'un nouveau rôle
// -----------------------
if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['create_role'])) {
    $newRoleName = trim($_POST['new_role']);

    if (!empty($newRoleName)) {
        // Si le rôle n'existe pas déjà dans l'ENUM
        if (!in_array($newRoleName, $enumRoles)) {
            // Créer un nouveau tableau de valeurs en ajoutant le nouveau rôle
            $newEnumValues = array_merge($enumRoles, [$newRoleName]);
            // Recréer la chaîne ENUM (exemple : 'utilisateur','admin','analyste','nouveau')
            $enumString = "'" . implode("','", $newEnumValues) . "'";
            // Exécuter l'ALTER TABLE pour mettre à jour le type ENUM de la colonne 'role'
            $alterQuery = "ALTER TABLE joueurs MODIFY role ENUM($enumString) NOT NULL DEFAULT 'utilisateur'";
            if (mysqli_query($conn, $alterQuery)) {
                echo "<script>alert('Nouveau rôle ajouté avec succès.');</script>";
                // Actualiser le tableau des rôles pour inclure le nouveau rôle
                $enumRoles = getEnumValues($conn, "joueurs", "role");
            } else {
                echo "<script>alert('Erreur lors de l\'ajout du nouveau rôle.');</script>";
            }
        } else {
            echo "<script>alert('Ce rôle existe déjà.');</script>";
        }
    } else {
        echo "<script>alert('Veuillez saisir un rôle valide.');</script>";
    }
}

// -----------------------
// Récupération de la liste des utilisateurs
// -----------------------
$queryUsers = "SELECT idJoueur, pseudo, role FROM joueurs";
$resultUsers = mysqli_query($conn, $queryUsers);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Changer le rôle d'un utilisateur</title>
    <style>
        /* Style général */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        /* Conteneur principal */
        .container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        h1, h2 {
            text-align: center;
            color: #0077cc;
        }
        /* Tableau des utilisateurs */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #0077cc;
            color: #fff;
        }
        /* Formulaires */
        form {
            margin: 10px 0;
        }
        input[type="text"], select {
            padding: 8px;
            width: 200px;
            margin-right: 10px;
        }
        input[type="submit"] {
            padding: 8px 16px;
            background-color: #0077cc;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .role-form {
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Changer le rôle d'un utilisateur</h1>
        
        <h2>Liste des utilisateurs</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Pseudo</th>
                <th>Rôle actuel</th>
                <th>Modifier le rôle</th>
            </tr>
            <?php while ($user = mysqli_fetch_assoc($resultUsers)) { ?>
                <tr>
                    <td><?php echo $user['idJoueur']; ?></td>
                    <td><?php echo htmlspecialchars($user['pseudo']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td>
                        <form method="POST" class="role-form">
                            <input type="hidden" name="user_id" value="<?php echo $user['idJoueur']; ?>">
                            <select name="role">
                                <?php 
                                // Afficher toutes les valeurs ENUM récupérées dans le menu déroulant
                                foreach ($enumRoles as $roleOption) { ?>
                                    <option value="<?php echo $roleOption; ?>" <?php if ($user['role'] == $roleOption) echo "selected"; ?>>
                                        <?php echo ucfirst($roleOption); ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <input type="submit" name="update_user" value="Mettre à jour">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
        
        <h2>Créer un nouveau rôle</h2>
        <form method="POST">
            <input type="text" name="new_role" placeholder="Nouveau rôle">
            <input type="submit" name="create_role" value="Créer le rôle">
        </form>
    </div>
</body>
</html>
