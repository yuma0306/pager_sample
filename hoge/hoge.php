<?php
ini_set('display_errors', 'On');
include $_SERVER['DOCUMENT_ROOT'] . '/assets/php/function.php';
$json = $_SERVER['DOCUMENT_ROOT'] . '/assets/data/test.json';
$data = getData($json);
$currentUri = getCurrentUri();
$article = getArticleData($data,$currentUri);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>hoge</title>
</head>
<body>
  <h1><?php echo $data[$article]['ttl']; ?></h1>
  <p><?php echo $data[$article]['txt']; ?></p>
</body>
</html>