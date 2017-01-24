<!--
  ①Bootstrapの公式サイトからファイルをダウンロード
  ②jQueryの公式サイトからファイルをダウンロード
  ③プロジェクト作成 (フォルダ)
  ④bootstrapのフォルダ名をassetsに変更しプロジェクト内に移動
  ⑤jQueryファイルをassets/js/に移動
  ⑥index.phpをプロジェクト内に作成
  ⑦HTML雛形コーディング
  ⑧index.php内でlinkタグでbootstrap.cssを読み込み
  ⑨index.php内でscriptタグでjQuery.jsを読み込み
  ⑩index.php内でscriptタグでbootstrap.jsを読み込み
  ⑪コーディングスタート
 -->

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title></title>
  <!-- bootstrap.cssを読み込む -->
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
</head>
<body>


  <!-- jQuery.jsを読み込む -->
  <script type="text/javascript" src="assets/js/jquery-3.1.1.min.js"></script>
  <!-- jQuery migrateファイルの読み込み - 古いバージョンへの対応 -->

  <!-- bootstrap.jsを読み込む -->
  <script type="text/javascript" src="assets/js/bootstrap.js"></script>
</body>
</html>
