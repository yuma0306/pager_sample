<?php
  function getArticleData($data, $endUri) {
    $article = '';
    foreach($data as $i => $dataItem) {
      if($dataItem['path'] === '/hoge/'. $endUri. '/') {
        $article = $i;
        return $article;
      }
    }
  }
?>