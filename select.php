<?php
//1. DB接続します

try {
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DBConnection Error:'.$e->getMessage());
}

//２．データ登録SQL作成
$sql = "SELECT * FROM gs_bm_table;";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("SQL_Error:".$error[2]);
}else{
  // 表のヘッダーを設定
  $view .= "<table class='table'>";
  $view .= "<tr><th>ID</th><th>書籍名</th><th>書籍URL</th><th>コメント</th><th>登録日時</th></tr>";

  // データを表形式で表示
  while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= "<tr>";
    $view .= "<td>".$res['id']."</td><td>".$res['title']."</td><td>".$res['url']."</td><td>".$res['comment']."</td><td>".$res['indate']."</td>";
    $view .= "</tr>";
  }
  $view .= "</table>";
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ブックマーク一覧</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">ブックマーク登録</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron"><?=$view?></div>
</div>
<!-- Main[End] -->

</body>
</html>

