
<?php
// src/Controllers/CommentController.php
require_once __DIR__ . '/../Repositories/CommentRepository.php';

class CommentController {
    private $commentRepo;

    public function __construct() {
        $this->commentRepo = new CommentRepository();
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $articleId = $_POST['article_id'] ?? null;
            $authorName = trim($_POST['author_name'] ?? '');
            $content = trim($_POST['content'] ?? '');
            
            if ($articleId && $authorName && $content) {
                $commentData = [
                    'article_id' => $articleId,
                    'author_name' => htmlspecialchars($authorName),
                    'content' => htmlspecialchars($content)
                ];
                
                if ($this->commentRepo->create($commentData)) {
                    header('Location: ' . BASE_URL . 'article/' . $articleId . '#comments');
                } else {
                    $_SESSION['error'] = 'Erreur lors de l\'ajout du commentaire';
                    header('Location: ' . BASE_URL . 'article/' . $articleId);
                }
            } else {
                $_SESSION['error'] = 'Tous les champs sont requis';
                header('Location: ' . BASE_URL . 'article/' . $articleId);
            }
        }
    }

    public function delete($id) {
        if ($this->commentRepo->delete($id)) {
            $_SESSION['success'] = 'Commentaire supprimé avec succès';
        } else {
            $_SESSION['error'] = 'Erreur lors de la suppression';
        }
        
        header('Location: ' . $_SERVER['HTTP_REFERER'] ?? BASE_URL . 'admin');
    }
}
?>
