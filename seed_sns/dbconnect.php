<?php
    // データベースへ接続 (例外処理)
    // try catch文
    // try部分に例外が起きそうな処理を
    // catch部分に例外が起きたときの処理を記述

    $dsn = 'mysql:dbname=seed_sns;host=localhost';
    $user = 'root';
    $password = 'mysql';

    try{
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->query('SET NAMES utf8');
    }catch(PDOException $e){
        // $eは$errorの略で、try部分で出たエラーを取得する
        echo 'データベース接続時エラー: ' . $e->getMessage();
        exit();
    }
?>
