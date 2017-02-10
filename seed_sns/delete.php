<?php
session_start();
require('dbconnect.php');

// ログインチェック
if (isset($_SESSION['id'])) {
    // 削除処理
    // $tweet_id = $_GET['tweet_id'];
    $tweet_id = $_REQUEST['tweet_id'];

    // ログインしているユーザーの投稿データか？
    $sql = 'SELECT * FROM `tweets` WHERE `tweet_id` = ?';
    $data = array($tweet_id);

    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $tweet = $stmt->fetch(PDO::FETCH_ASSOC);
    // $tweet['member_id'] → 削除しようとしているツイートデータの投稿ユーザーIDがわかる

    if ($tweet['member_id'] == $_SESSION['id']) {
        $sql = 'DELETE FROM `tweets` WHERE `tweet_id` = ?';
        $data = array($tweet_id);

        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);
    }

}

header('Location: index.php');
exit();
?>
