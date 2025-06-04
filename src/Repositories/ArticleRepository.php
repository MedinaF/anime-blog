
<?php
// src/Repositories/ArticleRepository.php
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Models/Article.php';

class ArticleRepository {
    private $conn;
    private $table = 'articles';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function findAll($status = 'published') {
        $query = "SELECT a.*, 
                  COUNT(DISTINCT CASE WHEN l.type = 'like' THEN l.id END) as likes_count,
                  COUNT(DISTINCT CASE WHEN l.type = 'dislike' THEN l.id END) as dislikes_count,
                  COUNT(DISTINCT c.id) as comments_count
                  FROM " . $this->table . " a 
                  LEFT JOIN likes l ON a.id = l.article_id 
                  LEFT JOIN comments c ON a.id = c.article_id 
                  WHERE a.status = :status 
                  GROUP BY a.id 
                  ORDER BY a.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        
        $articles = [];
        while ($row = $stmt->fetch()) {
            $articles[] = new Article($row);
        }
        
        return $articles;
    }

    public function findById($id) {
        $query = "SELECT a.*, 
                  COUNT(DISTINCT CASE WHEN l.type = 'like' THEN l.id END) as likes_count,
                  COUNT(DISTINCT CASE WHEN l.type = 'dislike' THEN l.id END) as dislikes_count,
                  COUNT(DISTINCT c.id) as comments_count
                  FROM " . $this->table . " a 
                  LEFT JOIN likes l ON a.id = l.article_id 
                  LEFT JOIN comments c ON a.id = c.article_id 
                  WHERE a.id = :id 
                  GROUP BY a.id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        $row = $stmt->fetch();
        return $row ? new Article($row) : null;
    }

    public function findByCategory($category) {
        $query = "SELECT a.*, 
                  COUNT(DISTINCT CASE WHEN l.type = 'like' THEN l.id END) as likes_count,
                  COUNT(DISTINCT CASE WHEN l.type = 'dislike' THEN l.id END) as dislikes_count,
                  COUNT(DISTINCT c.id) as comments_count
                  FROM " . $this->table . " a 
                  LEFT JOIN likes l ON a.id = l.article_id 
                  LEFT JOIN comments c ON a.id = c.article_id 
                  WHERE a.category = :category AND a.status = 'published'
                  GROUP BY a.id 
                  ORDER BY a.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category', $category);
        $stmt->execute();
        
        $articles = [];
        while ($row = $stmt->fetch()) {
            $articles[] = new Article($row);
        }
        
        return $articles;
    }

    public function search($term) {
        $query = "SELECT a.*, 
                  COUNT(DISTINCT CASE WHEN l.type = 'like' THEN l.id END) as likes_count,
                  COUNT(DISTINCT CASE WHEN l.type = 'dislike' THEN l.id END) as dislikes_count,
                  COUNT(DISTINCT c.id) as comments_count
                  FROM " . $this->table . " a 
                  LEFT JOIN likes l ON a.id = l.article_id 
                  LEFT JOIN comments c ON a.id = c.article_id 
                  WHERE (a.title LIKE :term OR a.content LIKE :term) 
                  AND a.status = 'published'
                  GROUP BY a.id 
                  ORDER BY a.created_at DESC";
        
        $searchTerm = '%' . $term . '%';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':term', $searchTerm);
        $stmt->execute();
        
        $articles = [];
        while ($row = $stmt->fetch()) {
            $articles[] = new Article($row);
        }
        
        return $articles;
    }

    public function create($articleData) {
        $query = "INSERT INTO " . $this->table . " 
                  (title, content, excerpt, image_url, category, status) 
                  VALUES (:title, :content, :excerpt, :image_url, :category, :status)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':title', $articleData['title']);
        $stmt->bindParam(':content', $articleData['content']);
        $stmt->bindParam(':excerpt', $articleData['excerpt']);
        $stmt->bindParam(':image_url', $articleData['image_url']);
        $stmt->bindParam(':category', $articleData['category']);
        $stmt->bindParam(':status', $articleData['status']);
        
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        
        return false;
    }

    public function update($id, $articleData) {
        $query = "UPDATE " . $this->table . " 
                  SET title = :title, content = :content, excerpt = :excerpt, 
                      image_url = :image_url, category = :category, status = :status,
                      updated_at = CURRENT_TIMESTAMP
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $articleData['title']);
        $stmt->bindParam(':content', $articleData['content']);
        $stmt->bindParam(':excerpt', $articleData['excerpt']);
        $stmt->bindParam(':image_url', $articleData['image_url']);
        $stmt->bindParam(':category', $articleData['category']);
        $stmt->bindParam(':status', $articleData['status']);
        
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getCategories() {
        $query = "SELECT DISTINCT category FROM " . $this->table . " 
                  WHERE category IS NOT NULL AND category != '' 
                  ORDER BY category";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $categories = [];
        while ($row = $stmt->fetch()) {
            $categories[] = $row['category'];
        }
        
        return $categories;
    }

    public function getStats() {
        $query = "SELECT 
                    COUNT(*) as total_articles,
                    COUNT(CASE WHEN status = 'published' THEN 1 END) as published_articles,
                    COUNT(CASE WHEN status = 'draft' THEN 1 END) as draft_articles
                  FROM " . $this->table;
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch();
    }
}
?>