
<?php
// src/Views/layout.php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'AnimeBlog' ?> - Découvrez l'univers des animes</title>
    <meta name="description" content="<?= $pageDescription ?? 'Blog dédié aux animes japonais, critiques, analyses et actualités' ?>">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="nav-container">
            <div class="logo">
                <a href="<?= BASE_URL ?>">🌸 AnimeBlog</a>
            </div>
            <nav class="main-nav">
                <ul class="nav-links">
                    <li><a href="<?= BASE_URL ?>">Accueil</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle">Catégories <i class="fas fa-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <?php if (isset($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <li><a href="<?= BASE_URL ?>category/<?= urlencode($cat) ?>"><?= htmlspecialchars($cat) ?></a></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <li><a href="<?= BASE_URL ?>search">Recherche</a></li>
                </ul>
            </nav>
            <div class="header-actions">
                <form class="search-form" action="<?= BASE_URL ?>search" method="GET">
                    <input type="text" name="q" placeholder="Rechercher..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
                <a href="<?= BASE_URL ?>admin" class="admin-btn">
                    <i class="fas fa-cog"></i> Admin
                </a>
            </div>
        </div>
    </header>

    <main class="main-content">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['success']) ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        
        <?= $content ?>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>🌸 AnimeBlog</h3>
                <p>Votre passion pour les animes japonais</p>
            </div>
            <div class="footer-section">
                <h4>Navigation</h4>
                <ul>
                    <li><a href="<?= BASE_URL ?>">Accueil</a></li>
                    <li><a href="<?= BASE_URL ?>search">Recherche</a></li>
                    <li><a href="<?= BASE_URL ?>admin">Administration</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Catégories</h4>
                <ul>
                    <?php if (isset($categories)): ?>
                        <?php foreach (array_slice($categories, 0, 5) as $cat): ?>
                            <li><a href="<?= BASE_URL ?>category/<?= urlencode($cat) ?>"><?= htmlspecialchars($cat) ?></a></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> AnimeBlog - Tous droits réservés</p>
        </div>
    </footer>

    <button class="scroll-top" onclick="scrollToTop()">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script src="<?= BASE_URL ?>js/script.js"></script>
</body>
</html>