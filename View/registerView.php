<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <style>
        /* Vos styles CSS ici */
    </style>
</head>
<body>
<div class="container">
    <h2>Inscription</h2>
    <?php if (!empty($error_message)): ?>
        <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
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
