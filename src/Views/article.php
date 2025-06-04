
<?php
// src/Views/article.php
$pageTitle = htmlspecialchars($article->getTitle());
$pageDescription = htmlspecialchars($article->getShortExcerpt(160));

ob_start();
?>

<article class="article-single">
    <div class="container">
        <header class="article-header">
            <div class="article-breadcrumb">
                <a href="<?= BASE_URL ?>">Accueil</a>
                <span class="separator">›</span>
                <?php if ($article->getCategory()): ?>
                    <a href="<?= BASE_URL ?>category/<?= urlencode($article->getCategory()) ?>">
                        <?= htmlspecialchars($article->getCategory()) ?>
                    </a>
                    <span class="separator">›</span>
                <?php endif; ?>
                <span class="current"><?= htmlspecialchars($article->getTitle()) ?></span>
            </div>
            
            <h1 class="article-title"><?= htmlspecialchars($article->getTitle()) ?></h1>
            
            <div class="article-meta">
                <div class="meta-left">
                    <span class="article-date">
                        <i class="fas fa-calendar"></i>
                        <?= $article->getFormattedDate() ?>
                    </span>
                    
                    <?php if ($article->getCategory()): ?>
                        <span class="article-category">
                            <i class="fas fa-tag"></i>
                            <a href="<?= BASE_URL ?>category/<?= urlencode($article->getCategory()) ?>">
                                <?= htmlspecialchars($article->getCategory()) ?>
                            </a>
                        </span>
                    <?php endif; ?>
                </div>
                
                <div class="meta-right">
                    <div class="article-actions">
                        <div class="like-buttons">
                            <button class="like-btn <?= $userVote === 'like' ? 'active' : '' ?>" 
                                    data-article="<?= $article->getId() ?>" 
                                    data-type="like">
                                <i class="fas fa-heart"></i>
                                <span class="count"><?= $article->getLikesCount() ?></span>
                            </button>
                            
                            <button class="dislike-btn <?= $userVote === 'dislike' ? 'active' : '' ?>" 
                                    data-article="<?= $article->getId() ?>" 
                                    data-type="dislike">
                                <i class="fas fa-thumbs-down"></i>
                                <span class="count"><?= $article->getDislikesCount() ?></span>
                            </button>
                        </div>
                        
                        <a href="<?= BASE_URL ?>admin/edit/<?= $article->getId() ?>" class="edit-btn" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </div>
            </div>
        </header>
        
        <?php if ($article->getImageUrl()): ?>
            <div class="article-image">
                <img src="<?= htmlspecialchars($article->getImageUrl()) ?>" 
                     alt="<?= htmlspecialchars($article->getTitle()) ?>">
            </div>
        <?php endif; ?>
        
        <div class="article-content">
            <?= nl2br($article->getContent()) ?>
        </div>
        
        <footer class="article-footer">
            <div class="share-buttons">
                <span>Partager :</span>
                <button onclick="shareArticle('twitter')" class="share-btn twitter">
                    <i class="fab fa-twitter"></i>
                </button>
                <button onclick="shareArticle('facebook')" class="share-btn facebook">
                    <i class="fab fa-facebook"></i>
                </button>
                <button onclick="copyLink()" class="share-btn copy">
                    <i class="fas fa-link"></i>
                </button>
            </div>
        </footer>
    </div>
</article>

<section id="comments" class="comments-section">
    <div class="container">
        <h3 class="comments-title">
            <i class="fas fa-comments"></i>
            Commentaires (<?= count($comments) ?>)
        </h3>
        
        <div class="comment-form-container">
            <h4>Laisser un commentaire</h4>
            <form class="comment-form" action="<?= BASE_URL ?>comment/add" method="POST">
                <input type="hidden" name="article_id" value="<?= $article->getId() ?>">
                
                <div class="form-group">
                    <label for="author_name">Nom *</label>
                    <input type="text" id="author_name" name="author_name" required maxlength="100">
                </div>
                
                <div class="form-group">
                    <label for="content">Commentaire *</label>
                    <textarea id="content" name="content" required rows="4" maxlength="1000"></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i>
                    Publier le commentaire
                </button>
            </form>
        </div>
        
        <?php if (!empty($comments)): ?>
            <div class="comments-list">
                <?php foreach ($comments as $comment): ?>
                    <div class="comment">
                        <div class="comment-header">
                            <div class="comment-author">
                                <i class="fas fa-user-circle"></i>
                                <?= htmlspecialchars($comment->getAuthorName()) ?>
                            </div>
                            <div class="comment-actions">
                                <span class="comment-date"><?= $comment->getFormattedDate() ?></span>
                                <a href="<?= BASE_URL ?>admin/comment/delete/<?= $comment->getId() ?>" 
                                   class="delete-btn" 
                                   onclick="return confirm('Supprimer ce commentaire ?')"
                                   title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                        <div class="comment-content">
                            <?= nl2br(htmlspecialchars($comment->getContent())) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-comments">
                <i class="fas fa-comment-slash"></i>
                <p>Aucun commentaire pour le moment. Soyez le premier à commenter !</p>
            </div>
        <?php endif; ?>
    </div>
</section>
