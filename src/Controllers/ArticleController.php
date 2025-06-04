<?php
// src/Controllers/ArticleController.php
require_once __DIR__ . '/../Repositories/ArticleRepository.php';
require_once __DIR__ . '/../Repositories/CommentRepository.php';
require_once __DIR__ . '/../Repositories/LikeRepository.php';

class ArticleController {
    private $articleRepo;
    private $commentRepo;
    private $likeRepo;

    public function __construct() {
        $this->articleRepo = new ArticleRepository();
        $this->commentRepo = new CommentRepository();
        $this->likeRepo = new LikeRepository();
    }

    public function index() {
        $articles = $this->articleRepo->findAll();
        $categories = $this->articleRepo->getCategories();
        
        require_once __DIR__ . '/../Views/home.php';
    }

    public function show($id) {
        $article = $this->articleRepo->findById($id);
        
        if (!$article) {
            header('HTTP/1.0 404 Not Found');
            require_once __DIR__ . '/../Views/404.php';
            return;
        }
        
        $comments = $this->commentRepo->findByArticle($id);
        $userVote = $this->likeRepo->getUserVote($id, $_SERVER['REMOTE_ADDR']);
        
        require_once __DIR__ . '/../Views/article.php';
    }

    public function category($category) {
        $articles = $this->articleRepo->findByCategory($category);
        $categories = $this->articleRepo->getCategories();
        
        require_once __DIR__ . '/../Views/category.php';
    }

    public function search() {
        $term = $_GET['q'] ?? '';
        $articles = $term ? $this->articleRepo->search($term) : [];
        $categories = $this->articleRepo->getCategories();
        
        require_once __DIR__ . '/../Views/search.php';
    }

    public function like() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $articleId = $_POST['article_id'] ?? null;
            $type = $_POST['type'] ?? 'like';
            $ipAddress = $_SERVER['REMOTE_ADDR'];
            
            if ($articleId) {
                $this->likeRepo->addLike($articleId, $type, $ipAddress);
                $stats = $this->likeRepo->getArticleStats($articleId);
                
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'likes' => $stats['likes'],
                    'dislikes' => $stats['dislikes'],
                    'userVote' => $type
                ]);
            }
        }
    }
}
?>