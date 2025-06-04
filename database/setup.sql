-- database/setup.sql
CREATE DATABASE IF NOT EXISTS anime_blog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE anime_blog;

-- Table des articles
CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    excerpt TEXT,
    image_url VARCHAR(500),
    category VARCHAR(100),
    status ENUM('draft', 'published') DEFAULT 'published',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table des commentaires
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    author_name VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE
);

-- Table des likes/dislikes
CREATE TABLE likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    type ENUM('like', 'dislike') NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
    UNIQUE KEY unique_vote (article_id, ip_address)
);

-- Données de test
INSERT INTO articles (title, content, excerpt, image_url, category) VALUES
('Demon Slayer : Analyse complète de Mugen Train', 
'Le film Demon Slayer: Mugen Train a marqué l\'histoire de l\'animation japonaise. Dans cet article, nous analysons en profondeur les techniques d\'animation, le développement des personnages et l\'impact émotionnel de cette œuvre exceptionnelle.

L\'arc de Mugen Train nous plonge dans une aventure épique où Tanjiro, Zenitsu et Inosuke accompagnent le Pilier des Flammes, Kyojuro Rengoku, dans une mission périlleuse. L\'animation de studio Ufotable atteint ici des sommets d\'excellence.

Les combats contre les démons sont chorégraphiés avec une précision millimétrique, chaque mouvement de sabre étant sublimé par des effets visuels à couper le souffle. La technique de respiration des flammes de Rengoku est particulièrement impressionnante.

Le développement émotionnel des personnages est remarquable. Rengoku incarne parfaitement l\'idéal du samouraï, sacrifiant sa vie pour protéger les innocents. Son combat final contre Akaza reste l\'un des moments les plus marquants de l\'anime.', 
'Analyse approfondie du film Demon Slayer: Mugen Train, ses techniques d\'animation révolutionnaires et son impact émotionnel.',
'https://example.com/demon-slayer-mugen-train.jpg',
'Analyse'),

('Attack on Titan : Décryptage de la fin', 
'Après plus de 10 ans de publication, Attack on Titan s\'achève enfin. Cette conclusion divise les fans, mais mérite une analyse approfondie pour comprendre les choix narratifs d\'Hajime Isayama.

Le final révèle la véritable nature du conflit : un cycle de haine perpétuel entre les peuples. Eren Yeager, devenu l\'antagoniste de sa propre histoire, incarne la tragédie de celui qui sacrifie tout pour sa vision du monde.

L\'Assaut des Titans Primordiaux représente l\'apogée de la violence dans l\'œuvre. Isayama nous confronte aux conséquences ultimes de la guerre et de la vengeance. Les images apocalyptiques reflètent l\'horreur de l\'humanité face à ses propres démons.

La rédemption d\'Armin et Mikasa symbolise l\'espoir d\'un avenir meilleur. Leur capacité à pardonner et à construire un monde nouveau contraste avec la voie destructrice choisie par Eren.

Cette fin complexe et nuancée confirme Attack on Titan comme une œuvre majeure de notre époque, questionnant nos certitudes sur la guerre, la liberté et la nature humaine.',
'Décryptage de la conclusion controversée d\'Attack on Titan et analyse des choix narratifs d\'Hajime Isayama.',
'https://example.com/attack-on-titan-final.jpg',
'Critique'),

('Les studios d\'animation incontournables en 2024', 
'L\'industrie de l\'animation japonaise continue d\'évoluer avec des studios qui repoussent constamment les limites de l\'art. Découvrons les acteurs majeurs qui façonnent l\'anime moderne.

**Studio Mappa** : Depuis la reprise d\'Attack on Titan, Mappa s\'impose comme le nouveau géant. Leurs projets incluent Chainsaw Man, Jujutsu Kaisen, et de nombreuses autres adaptations ambitieuses. Leur style unique mélange animation traditionnelle et CGI de pointe.

**Wit Studio** : Les créateurs de l\'anime Vivy et des premières saisons d\'Attack on Titan continuent d\'innover. Leur approche artistique privilégie la beauté visuelle et l\'émotion.

**Studio Trigger** : Héritiers de l\'esprit de Gainax, ils nous offrent des œuvres débridées comme Kill la Kill et Promare. Leur style explosif et coloré redéfinit l\'animation moderne.

**Ufotable** : Maîtres absolus des effets visuels, ils continuent d\'éblouir avec Demon Slayer. Leur technique de mélange 2D/3D est révolutionnaire.

**Studio Bones** : Piliers de l\'industrie avec My Hero Academia et Mob Psycho 100, ils maintiennent un niveau de qualité constant depuis des décennies.',
'Tour d\'horizon des studios d\'animation japonais qui marquent l\'année 2024 par leur innovation et leur excellence.',
'https://example.com/anime-studios-2024.jpg',
'Actualité');

INSERT INTO comments (article_id, author_name, content) VALUES
(1, 'Otaku_Master', 'Excellente analyse ! Le film m\'a vraiment marqué, surtout la scène finale avec Rengoku. Studio Ufotable a vraiment fait du travail exceptionnel.'),
(1, 'AnimeFan2024', 'Je suis complètement d\'accord sur l\'animation. Les effets de flammes étaient juste parfaits !'),
(2, 'TitanFan', 'Fin controversée mais je pense qu\'Isayama a voulu nous faire réfléchir. C\'est plus profond qu\'il n\'y paraît.'),
(3, 'StudioLover', 'Mappa et Ufotable dominent vraiment en ce moment. Hâte de voir leurs prochains projets !');

INSERT INTO likes (article_id, type, ip_address) VALUES
(1, 'like', '192.168.1.1'),
(1, 'like', '192.168.1.2'),
(1, 'like', '192.168.1.3'),
(2, 'like', '192.168.1.1'),
(2, 'dislike', '192.168.1.4'),
(3, 'like', '192.168.1.1'),
(3, 'like', '192.168.1.2');