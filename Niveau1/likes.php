<?php 
session_start();

function addLike($userId, $postId) {
    $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");

    $userId = intval($mysqli->real_escape_string($userId));
    $postId = $mysqli->real_escape_string($postId);

    $lInstructionSql = "INSERT INTO likes "
    . "(id, user_id, post_id) "
    . "VALUES (NULL, "
    . $userId . ", "
    . $postId . ");"
    ;

    echo $lInstructionSql;

    $ok = $mysqli->query($lInstructionSql);
    if ( ! $ok) {
        echo "Something wrong happened... " . $mysqli->error;
    } else {
        echo "Message liké";
    }
}
// $userId = $_SESSION['connected_id'];
// $postId = $post['id'];



?>