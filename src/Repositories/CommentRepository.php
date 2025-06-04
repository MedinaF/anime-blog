
<?php
// src/Repositories/CommentRepository.php
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Models/Comment.php';

class CommentRepository {
    private $conn;
    private $table = 'comments';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function findByArticle($articleId) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE article_id = :article_id 
                  ORDER BY created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':article_id', $articleId);
        $stmt->execute();
        
        $comments = [];
        while ($row = $stmt->fetch()) {
            $comments[] = new Comment($row);
        }
        
        return $comments;
    }

    public function findAll() {
        $query = "SELECT c.*, a.title as article_title 
                  FROM " . $this->table . " c
                  JOIN articles a ON c.article_id = a.id
                  ORDER BY c.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function create($commentData) {
        $query = "INSERT INTO " . $this->table . " 
                  (article_id, author_name, content) 
                  VALUES (:article_id, :author_name, :content)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':article_id', $commentData['article_id']);
        $stmt->bindParam(':author_name', $commentData['author_name']);
        $stmt->bindParam(':content', $commentData['content']);
        
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getStats() {
        $query = "SELECT COUNT(*) as total_comments FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch();
    }
}
?>