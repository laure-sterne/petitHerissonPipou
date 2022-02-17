<?php 
session_start();
include './header.html' ?>

<div id="wrapper" >

    <aside>
        <h2>Présentation</h2>
        <p>Bienvenue sur notre réseau social !</p>
    </aside>

    <main>
        <article>
            <h2>Inscription</h2>
            <?php
            /* TRAITEMENT DU FORMULAIRE

            Etape 1 : vérifier si on est en train d'afficher ou de traiter le formulaire
            Si on recoit un champ email rempli, il y a une chance que ce soit un traitement */
            $enCoursDeTraitement = isset($_POST['email']);
            if ($enCoursDeTraitement) {
                /* On ne fait ce qui suit que si un formulaire a été soumis.
                Etape 2 : récupérer ce qu'il y a dans le formulaire @todo => c'est là que votre travaille se situe
                Observez le résultat de cette ligne de débug (vous l'effacerez ensuite) */
                // echo "<pre>" . print_r($_POST, 1) . "</pre>";
                // et complétez le code ci dessous en remplaçant les ???
                $new_id = $POST['id'];
                $new_email = $_POST['email'];
                $new_alias = $_POST['alias'];
                $new_passwd = $_POST['password'];


                // Etape 3 : Ouvrir une connexion avec la base de donnée.
                $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");

                // Etape 4 : Petite sécurité pour éviter les injection sql : https://www.w3schools.com/sql/sql_injection.asp
                $new_email = $mysqli->real_escape_string($new_email);
                $new_alias = $mysqli->real_escape_string($new_alias);
                $new_passwd = $mysqli->real_escape_string($new_passwd);
                // On crypte le mot de passe pour éviter d'exposer notre utilisatrice en cas d'intrusion dans nos systèmes
                $new_passwd = md5($new_passwd);
                /* NB : md5 est pédagogique mais n'est pas recommandée pour une vraies sécurité

                Etape 5 : construction de la requête */
                $lInstructionSql = "INSERT INTO users (id, email, password, alias) "
                        . "VALUES (NULL, "
                        . "'" . $new_email . "', "
                        . "'" . $new_passwd . "', "
                        . "'" . $new_alias . "'"
                        . ");";

                // Etape 6 : exécution de la requête
                $ok = $mysqli->query($lInstructionSql);
                if ( ! $ok) {
                    echo "L'inscription a échouée : " . $mysqli->error;
                } else {
                    echo "Votre inscription est un succès : " . $new_alias;
                    echo " <a href='login.php'>Connectez-vous.</a>";
                }
            } ?>

            <form action="registration.php" method="post">
                <input type='hidden'name='???' value='achanger'>
                <dl>
                    <dt><label for='alias'>Pseudo</label></dt>
                    <dd><input type='text'name='alias'></dd>
                    <dt><label for='email'>E-Mail</label></dt>
                    <dd><input type='email' name='email'></dd>
                    <dt><label for='password'>Mot de passe</label></dt>
                    <dd><input type='password' name='password'></dd>
                </dl>
                <input type='submit'>
            </form>
        </article>
    </main>
</div>

</body>
</html>