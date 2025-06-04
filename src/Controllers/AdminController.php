
<?php
// src/Controllers/AdminController.php
require_once __DIR__ . '/../Repositories/ArticleRepository.php';
require_once __DIR__ . '/../Repositories/CommentRepository.php';

class AdminController {
    private $articleRepo;
    private $commentRepo;

    public function __construct() {
        $this->articleRepo = new ArticleRepository();
        $this->commentRepo = new CommentRepository();
    }

    public function dashboard() {
        $articles = $this->articleRepo->findAll('published');
        $drafts = $this->articleRepo->findAll('draft');
        $comments = $this->commentRepo->findAll();
        $stats = $this->articleRepo->getStats();
        
        require_once __DIR__ . '/../Views/admin/dashboard.php';
    }

    public function createArticle() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $content = trim($_POST['content'] ?? '');
            $excerpt = trim($_POST['excerpt'] ?? '');
            $imageUrl = trim($_POST['image_url'] ?? '');
            $category = trim($_POST['category'] ?? '');
            $status = $_POST['status'] ?? 'published';
            
            if ($title && $content) {
                // Générer un extrait automatique si non fourni
                if (!$excerpt) {
                    $excerpt = substr(strip_tags($content), 0, 200) . '...';
                }
                
                $articleData = [
                    'title' => htmlspecialchars($title),
                    'content' => $content, // Garde le HTML pour le contenu
                    'excerpt' => htmlspecialchars($excerpt),
                    'image_url' => filter_var($imageUrl, FILTER_VALIDATE_URL) ? $imageUrl : null,
                    'category' => htmlspecialchars($category),
                    'status' => $status
                ];
                
                if ($this->articleRepo->create($articleData)) {
                    $_SESSION['success'] = 'Article créé avec succès';
                    header('Location: ' . BASE_URL . 'admin');
                } else {
                    $_SESSION['error'] = 'Erreur lors de la création';
                }
            } else {
                $_SESSION['error'] = 'Le titre et le contenu sont requis';
            }
        }
        
        require_once __DIR__ . '/../Views/admin/create_article.php';
    }

    public function editArticle($id) {
        $article = $this->articleRepo->findById($id);
        
        if (!$article) {
            $_SESSION['error'] = 'Article non trouvé';
            header('Location: ' . BASE_URL . 'admin');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $content = trim($_POST['content'] ?? '');
            $excerpt = trim($_POST['excerpt'] ?? '');
            $imageUrl = trim($_POST['image_url'] ?? '');
            $category = trim($_POST['category'] ?? '');
            $status = $_POST['status'] ?? 'published';
            
            if ($title && $content) {
                if (!$excerpt) {
                    $excerpt = substr(strip_tags($content), 0, 200) . '...';
                }
                
                $articleData = [
                    'title' => htmlspecialchars($title),
                    'content' => $content,
                    'excerpt' => htmlspecialchars($excerpt),
                    'image_url' => filter_var($imageUrl, FILTER_VALIDATE_URL) ? $imageUrl : null,
                    'category' => htmlspecialchars($category),
                    'status' => $status
                ];
                
                if ($this->articleRepo->update($id, $articleData)) {
                    $_SESSION['success'] = 'Article modifié avec succès';
                    header('Location: ' . BASE_URL . 'admin');
                } else {
                    $_SESSION['error'] = 'Erreur lors de la modification';
                }
            } else {
                $_SESSION['error'] = 'Le titre et le contenu sont requis';
            }
        }
        
        require_once __DIR__ . '/../Views/admin/edit_article.php';
    }

    public function deleteArticle($id) {
        if ($this->articleRepo->delete($id)) {
            $_SESSION['success'] = 'Article supprimé avec succès';
        } else {
            $_SESSION['error'] = 'Erreur lors de la suppression';
        }
        
        header('Location: ' . BASE_URL . 'admin');
    }

    public function deleteComment($id) {
        if ($this->commentRepo->delete($id)) {
            $_SESSION['success'] = 'Commentaire supprimé avec succès';
        } else {
            $_SESSION['error'] = 'Erreur lors de la suppression';
        }
        
        header('Location: ' . BASE_URL . 'admin');
    }
}
?>