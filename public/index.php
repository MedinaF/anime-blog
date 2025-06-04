
<?php
// public/index.php
session_start();
require_once __DIR__ . '/../database/config.php';

// Routeur simple
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace('/anime-blog/public', '', $uri);
$uri = trim($uri, '/');

// Inclure les contrôleurs
require_once __DIR__ . '/../src/Controllers/ArticleController.php';
require_once __DIR__ . '/../src/Controllers/CommentController.php';
require_once __DIR__ . '/../src/Controllers/AdminController.php';

$articleController = new ArticleController();
$commentController = new CommentController();
$adminController = new AdminController();

// Routes
switch (true) {
    case $uri === '' || $uri === 'home':
        $articleController->index();
        break;
        
    case preg_match('/^article\/(\d+)$/', $uri, $matches):
        $articleController->show($matches[1]);
        break;
        
    case preg_match('/^category\/(.+)$/', $uri, $matches):
        $articleController->category(urldecode($matches[1]));
        break;
        
    case $uri === 'search':
        $articleController->search();
        break;
        
    case $uri === 'like':
        $articleController->like();
        break;
        
    case $uri === 'comment/add':
        $commentController->add();
        break;
        
    case preg_match('/^comment\/delete\/(\d+)$/', $uri, $matches):
        $commentController->delete($matches[1]);
        break;
        
    case $uri === 'admin':
        $adminController->dashboard();
        break;
        
    case $uri === 'admin/create':
        $adminController->createArticle();
        break;
        
    case preg_match('/^admin\/edit\/(\d+)$/', $uri, $matches):
        $adminController->editArticle($matches[1]);
        break;
        
    case preg_match('/^admin\/delete\/(\d+)$/', $uri, $matches):
        $adminController->deleteArticle($matches[1]);
        break;
        
    case preg_match('/^admin\/comment\/delete\/(\d+)$/', $uri, $matches):
        $adminController->deleteComment($matches[1]);
        break;
        
    default:
        header('HTTP/1.0 404 Not Found');
        require_once __DIR__ . '/../src/Views/404.php';
        break;
}
?>