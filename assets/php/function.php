<?php

  // 404ページにリダイレクト
  function redirectNotfound() {
    header("HTTP/1.1 404 Not Found");
    include $_SERVER['DOCUMENT_ROOT'] . '/404.html';
    exit;
  }

  // パラメータのチェック
  function checkParam($totalPage) {
    if(isset($_GET['page']) && (int)$_GET['page'] === 1) {
      header("Location: ./index.php", true, 301);
      exit;
    } elseif(isset($_GET['page']) && (int)$_GET['page'] > (int)$totalPage) {
      redirectNotfound();
    }
  }

  // jsonファイルのdecode
  function getData($json) {
    $data = file_get_contents($json);
    return json_decode($data, true);
  }

  // 現在のページを取得
  function getCurrentPage() {
    if(isset($_GET['page'])) {
      return (int)$_GET['page'];
    } else {
      return 1;
    }
  }

  // 現在のページに表示するデータの取得
  function getShowData($data, $currentPage, $dataLimit) {
    // データの開始位置
    $dataStart = ($currentPage - 1) * $dataLimit;
    // 全データ,記事データの開始位置,切り取り件数,取得した配列のキーを0からの連番に
    return array_slice($data, $dataStart, $dataLimit, true);
  }

  // ページャーに表示する番号一覧
  function getPagerNums($start,$end) {
    $pagerNums = [];
    for ($i = $start; $i <= $end; $i++) {
      $pagerNums[] = $i;
    }
    return $pagerNums;
  }

  // ページ番号でデータにフィルタかける
  // function getShowData($currentPage, $dataLimit, $data) {
  //   return array_filter($data, function($i) use ($currentPage, $dataLimit) {
  //     // 論理積
  //     return $i >= ($currentPage - 1) * $dataLimit && $i < $currentPage * $dataLimit;
  //   }, ARRAY_FILTER_USE_KEY);
  // }
  // $showData = getShowData($currentPage, $dataLimit, $data);

  // 詳細ページのデータ取得
  function getArticleData($data, $currentUri) {
    $article = '';
    foreach($data as $i => $dataItem) {
      if($dataItem['path'] === '/hoge/'. $currentUri. '/') {
        $article = $i;
        return $article;
      }
    }
  }

  function getCurrentUri() {
    $uri = rtrim($_SERVER["REQUEST_URI"], '/');
    $uri = substr($uri, strrpos($uri, '/') + 1);
    return $uri;
  }


?>