
<?php
// src/Views/home.php
$pageTitle = 'Accueil';
$pageDescription = 'Découvrez les derniers articles sur les animes japonais';

ob_start();
?>

<section class="hero">
    <div class="hero-content">
        <h1 class="hero-title">
            <span class="gradient-text">Bienvenue dans l'univers</span>
            <span class="highlight">des Animes</span>
        </h1>
        <p class="hero-subtitle">
            Découvrez des critiques, analyses et actualités sur vos animes préférés
        </p>
        <div class="hero-actions">
            <a href="#articles" class="btn btn-primary">
                <i class="fas fa-scroll"></i> Découvrir les articles
            </a>
            <a href="<?= BASE_URL ?>admin/create" class="btn btn-secondary">
                <i class="fas fa-plus"></i> Écrire un article
            </a>
        </div>
    </div>
    <div class="hero-decoration">
        <div class="floating-elements">
            <span class="element">🌸</span>
            <span class="element">⚔️</span>
            <span class="element">🔥</span>
            <span class="element">⭐</span>
            <span class="element">🌟</span>
        </div>
    </div>
</section>

<section id="articles" class="articles-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Derniers Articles</h2>
            <p class="section-subtitle">Plongez dans l'actualité de vos animes favoris</p>
        </div>
        
        <?php if (!empty($articles)): ?>
            <div class="articles-grid">
                <?php foreach ($articles as $article): ?>
                    <article class="article-card" data-aos="fade-up">
                        <div class="article-image">
                            <?php if ($article->getImageUrl()): ?>
                                <img src="<?= htmlspecialchars($article->getImageUrl()) ?>" 
                                     alt="<?= htmlspecialchars($article->getTitle()) ?>"
                                     loading="lazy">
                            <?php else: ?>
                                <div class="placeholder-image">
                                    <?php
                                    $emojis = ['🔥', '⚔️', '🌟', '⭐', '🌸', '🎭', '🏮', '🗾'];
                                    echo $emojis[array_rand($emojis)];
                                    ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($article->getCategory()): ?>
                                <span class="article-category"><?= htmlspecialchars($article->getCategory()) ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="article-content">
                            <h3 class="article-title">
                                <a href="<?= BASE_URL ?>article/<?= $article->getId() ?>">
                                    <?= htmlspecialchars($article->getTitle()) ?>
                                </a>
                            </h3>
                            
                            <p class="article-excerpt">
                                <?= htmlspecialchars($article->getShortExcerpt(120)) ?>
                            </p>
                            
                            <div class="article-meta">
                                <span class="article-date">
                                    <i class="fas fa-calendar"></i>
                                    <?= $article->getFormattedDate() ?>
                                </span>
                                
                                <div class="article-stats">
                                    <span class="stat-item">
                                        <i class="fas fa-heart"></i>
                                        <?= $article->getLikesCount() ?>
                                    </span>
                                    <span class="stat-item">
                                        <i class="fas fa-comment"></i>
                                        <?= $article->getCommentsCount() ?>
                                    </span>
                                </div>
                            </div>
                            
                            <a href="<?= BASE_URL ?>article/<?= $article->getId() ?>" class="read-more">
                                Lire la suite <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon">📝</div>
                <h3>Aucun article pour le moment</h3>
                <p>Commencez par créer votre premier article !</p>
                <a href="<?= BASE_URL ?>admin/create" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Créer un article
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<button class="floating-add" onclick="window.location.href='<?= BASE_URL ?>admin/create'" title="Nouvel article">
    <i class="fas fa-plus"></i>
</button>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/layout.php';
?>