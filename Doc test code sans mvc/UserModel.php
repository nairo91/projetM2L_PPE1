class UserModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getUser($pseudo, $mot_de_passe) {
        $query = "SELECT * FROM Joueurs WHERE pseudo = ? AND mot_de_passe = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $pseudo, $mot_de_passe);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
