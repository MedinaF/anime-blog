
<?php
// src/Models/Comment.php
class Comment {
    private $id;
    private $article_id;
    private $author_name;
    private $content;
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
    public function getAuthorName() { return $this->author_name; }
    public function getContent() { return $this->content; }
    public function getCreatedAt() { return $this->created_at; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setArticleId($article_id) { $this->article_id = $article_id; }
    public function setAuthorName($author_name) { $this->author_name = $author_name; }
    public function setContent($content) { $this->content = $content; }
    public function setCreatedAt($created_at) { $this->created_at = $created_at; }

    public function getFormattedDate() {
        return date('d M Y à H:i', strtotime($this->created_at));
    }
}
?>
