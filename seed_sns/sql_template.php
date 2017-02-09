<?php
// INSERT文

// ①INSERT INTO `テーブル名` (`カラム1`, `カラム2`, `カラム3`) VALUES ("値1", "値2", "値3")
// ②INSERT INTO `テーブル名` SET `カラム1`="値1", `カラム2`="値2", `カラム3`="値3"

// SELECT文
// 複数条件付き
// SELECT * FROM `テーブル名` WHERE 条件1 AND 条件2

// テーブルのリレーションシップ
// MySQL → RDB (Relational Database)
// 一回のsql文で複数テーブルから条件を元に関連するデータを取得する手法
// SELECT * FROM テーブルA, テーブルB WHERE 関連条件
// SELECT * FROM `tweets`, `members` WHERE `members`.member_id = `tweets`.member_id

// テーブルの結合
// 外部結合 : LEFT JOIN
// SELECT * FROM テーブルA LEFT JOIN テーブルB
// 左にあるテーブルが主データとなり、関連する情報を右テーブルから結合させる

// AS句
// A AS a
// tweets AS t, members AS m
// SELECT * FROM `tweets` AS t, `members` AS m WHERE m.member_id = t.member_id ORDER BY t.created DESC

// カラムの指定
// SELECT * FROM `tweets` WHERE `tweet_id`=1
// アスタリスク * → ワイルドカード = 全部
// SELECT カラム1, カラム2 FROM `テーブル`
// SELECT t.*, m.nick_name, m.picture_path FROM `tweets` AS t, `members` AS m WHERE m.member_id = t.member_id ORDER BY t.created DESC

// COUNT()関数
// 取得したデータの件数を返してくれる
// SELECT COUNT(*) FROM `テーブル`
?>















