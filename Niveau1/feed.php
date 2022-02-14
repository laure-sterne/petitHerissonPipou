<?php 
session_start();
include './header.html' ?>

<div id="wrapper">
    <?php
    /* Cette page est TRES similaire à wall.php. 
    Vous avez sensiblement à y faire la meme chose.
    Il y a un seul point qui change c'est la requete sql.

    Etape 1 : Le mur concerne un utilisateur en particulier */
    $userId = intval($_GET['user_id']);
    
    // Etape 2 : se connecter à la base de donnée
    $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");
    ?>

    <aside>
        <?php
        //Etape 3 : récupérer le nom de l'utilisateur
        $laQuestionEnSql = "SELECT * FROM `users` WHERE id= '$userId' ";
        $lesInformations = $mysqli->query($laQuestionEnSql);
        $user = $lesInformations->fetch_assoc();

        // @todo : afficher le résultat de la ligne ci dessous, remplacer XXX par l'alias et effacer la ligne ci-dessous
        // echo "<pre>" . print_r($user, 1) . "</pre>";
        // ?>
        <img src="hedgehog_profile.png" alt="Portrait de l'utilisatrice"/>
        <section>
            <h3>Présentation</h3>
                <p>Sur cette page vous trouverez tous les message des utilisatrices
                auxquel est abonnée l'utilisatrice <?php echo $user['alias'] ?> (n° <?php echo $userId ?>) </p>
        </section>
    </aside>

    <main>
        <?php
        // Etape 3 : récupérer tous les messages des abonnements
        $laQuestionEnSql = "
            SELECT posts.content,
            posts.created,
            users.alias as author_name,
            users.id as user_id,   
            count(likes.id) as like_number,  
            GROUP_CONCAT(DISTINCT tags.label) AS taglist,
            GROUP_CONCAT(DISTINCT tags.id) AS taglistid
            FROM followers 
            JOIN users ON users.id=followers.followed_user_id
            JOIN posts ON posts.user_id=users.id
            LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
            LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
            LEFT JOIN likes      ON likes.post_id  = posts.id 
            WHERE followers.following_user_id='$userId' 
            GROUP BY posts.id
            ORDER BY posts.created DESC  
            ";

        $lesInformations = $mysqli->query($laQuestionEnSql);
        if ( ! $lesInformations) {
            echo("Échec de la requete : " . $mysqli->error);
        }

        /* Etape 4 : @todo => Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php
        A vous de retrouver comment faire la boucle while de parcours... */
        while ($post = $lesInformations->fetch_assoc()) {
            // echo "<pre>" . print_r($post, 1) . "</pre>";
        ?>                
            <article>
                <h3>
                    <time datetime='2020-02-01 11:12:13' > <?php echo $post['created'] ?></time>
                </h3>
                <address> <a href="wall.php?user_id=<?php echo $post['user_id'] ?>"><?php echo $post['author_name'] ?></a></address>
                <div>
                    <p><?php echo $post['content'] ?></p>
                </div>                                            
                <footer>
                    <small>♥ <?php echo $post['like_number'] ?></small>
                    <a href="tags.php?tag_id=<?php echo $post['taglistid'] ?>">#<?php echo $post['taglist'] ?></a>
                </footer>
            </article>
        <?php } ?>
    </main>

</div>

</body>
</html>