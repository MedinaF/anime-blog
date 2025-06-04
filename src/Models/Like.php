
<?php
// src/Models/Like.php
class Like {
    private $id;
    private $article_id;
    private $type;
    private $ip_address;
    private $created_at;

    public function __construct($data = []) {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }

    private function hydrate($data) {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // Getters
    public function getId() { return $this->id; }
    public function getArticleId() { return $this->article_id; }
    public function getType() { return $this->type; }
    public function getIpAddress() { return $this->ip_address; }
    public function getCreatedAt() { return $this->created_at; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setArticleId($article_id) { $this->article_id = $article_id; }
    public function setType($type) { $this->type = $type; }
    public function setIpAddress($ip_address) { $this->ip_address = $ip_address; }
    public function setCreatedAt($created_at) { $this->created_at = $created_at; }
}
?>