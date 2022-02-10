<?php include './header.html' ?>

<div id="wrapper">          
    <aside>
        <img src = "hedgehog_profile.png" alt = "Portrait de l'utilisatrice"/>
        <section>
            <h3>Présentation</h3>
            <p>Sur cette page vous trouverez la liste des personnes qui suivent 
                les messages de l'utilisatrice n° <?php echo intval($_GET['user_id']) ?>
            </p>

        </section>
    </aside>

    <main class='contacts'>
        <?php
        // Etape 1 : récupérer l'id de l'utilisateur
        $userId = intval($_GET['user_id']);

        // Etape 2 : se connecter à la base de donnée
        $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");

        // Etape 3 : récupérer le nom de l'utilisateur
        $laQuestionEnSql = "
            SELECT users.*
            FROM followers
            LEFT JOIN users ON users.id=followers.following_user_id
            WHERE followers.followed_user_id='$userId'
            GROUP BY users.id
            ";

        $lesInformations = $mysqli->query($laQuestionEnSql);

        /* Etape 4 : @todo => faire la boucle while de parcours des abonnés et mettre les bonnes valeurs ci dessous */
        while ($userId = $lesInformations->fetch_assoc()) { 
        ?>
            <article>
                <img src="hedgehog_profile.png" alt="blason"/>
                <h3><a href="wall.php?user_id=<?php echo $userId['id'] ?>"><?php echo $userId['alias'] ?></a></h3>
                <p><?php echo $userId['id'] ?></p>
            </article>
        <?php } ?>       
    </main>

</div>

</body>
</html>