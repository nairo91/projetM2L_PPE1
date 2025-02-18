<?php
session_start(); // Démarrer la session pour gérer les connexions

require_once 'Model/UserModel.php'; // Inclure le modèle utilisateur

class UserController {
    private $model;

    public function __construct($model) {
        $this->model = $model; // Injection du modèle dans le contrôleur
    }

    public function login() {
        $error_message = ""; // Message d'erreur initialisé à vide

        // Vérifier si le formulaire a été soumis
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Récupérer les valeurs saisies par l'utilisateur
            $pseudo = $_POST['pseudo'];
            $mot_de_passe = $_POST['mot_de_passe'];

            // Utiliser le modèle pour chercher l'utilisateur
            $user = $this->model->getUser($pseudo, $mot_de_passe);

            if ($user) {
                // Si l'utilisateur existe, sauvegarder dans la session et rediriger
                $_SESSION['pseudo'] = $user['pseudo'];
                header("Location: accueil.php"); // Page de destination après connexion
                exit();
            } else {
                // Si les identifiants sont incorrects, afficher un message d'erreur
                $error_message = "Pseudo ou mot de passe incorrect.";
            }
        }

        // Charger la vue de connexion avec le message d'erreur (s'il existe)
        include 'View/login.php';
    }
}
?>
