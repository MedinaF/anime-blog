
<?php
// src/Models/Article.php
class Article {
    private $id;
    private $title;
    private $content;
    private $excerpt;
    private $image_url;
    private $category;
    private $status;
    private $created_at;
    private $updated_at;
    private $likes_count;
    private $dislikes_count;
    private $comments_count;

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
    public function getTitle() { return $this->title; }
    public function getContent() { return $this->content; }
    public function getExcerpt() { return $this->excerpt; }
    public function getImageUrl() { return $this->image_url; }
    public function getCategory() { return $this->category; }
    public function getStatus() { return $this->status; }
    public function getCreatedAt() { return $this->created_at; }
    public function getUpdatedAt() { return $this->updated_at; }
    public function getLikesCount() { return $this->likes_count ?? 0; }
    public function getDislikesCount() { return $this->dislikes_count ?? 0; }
    public function getCommentsCount() { return $this->comments_count ?? 0; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setTitle($title) { $this->title = $title; }
    public function setContent($content) { $this->content = $content; }
    public function setExcerpt($excerpt) { $this->excerpt = $excerpt; }
    public function setImageUrl($image_url) { $this->image_url = $image_url; }
    public function setCategory($category) { $this->category = $category; }
    public function setStatus($status) { $this->status = $status; }
    public function setCreatedAt($created_at) { $this->created_at = $created_at; }
    public function setUpdatedAt($updated_at) { $this->updated_at = $updated_at; }
    public function setLikesCount($count) { $this->likes_count = $count; }
    public function setDislikesCount($count) { $this->dislikes_count = $count; }
    public function setCommentsCount($count) { $this->comments_count = $count; }

    public function getFormattedDate() {
        return date('d M Y', strtotime($this->created_at));
    }

    public function getShortExcerpt($length = 150) {
        if (strlen($this->excerpt) > $length) {
            return substr($this->excerpt, 0, $length) . '...';
        }
        return $this->excerpt;
    }
}
?>