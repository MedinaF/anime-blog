
<?php
// src/Repositories/LikeRepository.php
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Models/Like.php';

class LikeRepository {
    private $conn;
    private $table = 'likes';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function addLike($articleId, $type, $ipAddress) {
        // Vérifier si l'IP a déjà voté
        if ($this->hasVoted($articleId, $ipAddress)) {
            // Supprimer le vote existant
            $this->removeVote($articleId, $ipAddress);
        }
        
        $query = "INSERT INTO " . $this->table . " 
                  (article_id, type, ip_address) 
                  VALUES (:article_id, :type, :ip_address)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':article_id', $articleId);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':ip_address', $ipAddress);
        
        return $stmt->execute();
    }

    public function hasVoted($articleId, $ipAddress) {
        $query = "SELECT id FROM " . $this->table . " 
                  WHERE article_id = :article_id AND ip_address = :ip_address";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':article_id', $articleId);
        $stmt->bindParam(':ip_address', $ipAddress);
        $stmt->execute();
        
        return $stmt->fetch() !== false;
    }

    public function getUserVote($articleId, $ipAddress) {
        $query = "SELECT type FROM " . $this->table . " 
                  WHERE article_id = :article_id AND ip_address = :ip_address";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':article_id', $articleId);
        $stmt->bindParam(':ip_address', $ipAddress);
        $stmt->execute();
        
        $result = $stmt->fetch();
        return $result ? $result['type'] : null;
    }

    public function removeVote($articleId, $ipAddress) {
        $query = "DELETE FROM " . $this->table . " 
                  WHERE article_id = :article_id AND ip_address = :ip_address";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':article_id', $articleId);
        $stmt->bindParam(':ip_address', $ipAddress);
        
        return $stmt->execute();
    }

    // public function getArticleStats($articleId) {
    //     $query = "SELECT 
    //                 COUNT(CASE WHEN type = 'like' THEN 1 END) as likes,

}