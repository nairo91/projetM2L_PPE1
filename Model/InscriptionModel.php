<?php
class InscriptionModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registerUser($nom, $prenom, $age, $pseudo, $mot_de_passe, $niveau) {
        $query = "INSERT INTO Joueurs (nom, prenom, age, pseudo, niveau, mot_de_passe) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssisss", $nom, $prenom, $age, $pseudo, $niveau, $mot_de_passe);

        if ($stmt->execute()) {
            return true;
        } else {
            return "Erreur : " . $this->conn->error;
        }
    }
}
?>
