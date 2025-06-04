
// config.php
<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'anime_blog');
define('DB_USER', 'root');
define('DB_PASS', '');
define('BASE_URL', 'http://localhost/anime-blog/public/');
define('UPLOAD_DIR', 'uploads/');

// Autoloader simple
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/src/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});
?>