<?php
  ini_set('display_errors', 'On');
  include $_SERVER['DOCUMENT_ROOT'] . '/assets/php/function.php';

  // ----- 記事データの処理 -----
  // 現在のページ番号取得
  $currentPage = getCurrentPage();
  // データ取得
  $json = $_SERVER['DOCUMENT_ROOT'] . '/assets/data/test.json';
  $data = getData($json);
  // データの総数
  $count = count($data);
  // 1ページに表示するデータ件数
  $dataLimit = 3;
  // ページ及びページャーの総数
  $totalPage = ceil($count / $dataLimit);
  // パラメータのチェック
  checkParam($totalPage);
  // 現在のページに表示するデータの取得
  $showData = getShowData($data, $currentPage, $dataLimit);
  // ----- /記事データの処理 -----

  // ----- ページャーの処理 -----
  $pageDir = '/';
  $pagePath = $pageDir . '?page=';
  // 現在のページから前後に表示するページャーの数
  $pageRange = 2;
  // ページャーに表示する最初のページ番号
  $start = max($currentPage - $pageRange, 1);
  // ページャーに表示する最後のページ番号
  $end = min($currentPage + $pageRange, $totalPage);
  // ページャーに表示する番号一覧
  $pagerNums = getPagerNums($start, $end);
  // ----- /ページャーの処理 -----

  // ----- ボタンの処理 -----
  // 戻るボタンのリンク
  $prevNum = max($currentPage - 1, 1);
  // 次へボタンのリンク
  $nextNum = min($currentPage + 1, $totalPage);
  // ----- /ボタンの処理 -----
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>top</title>
  <link rel="stylesheet" href="/assets/css/reset.css">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
  <!-- 記事一覧 -->
  <ul class="article">
    <?php foreach($showData as $hogeItem): ?>
      <li class="article__item">
        <a href="<?php echo $hogeItem['path']; ?>">
          <p class="article__ttl"><?php echo $hogeItem['ttl']; ?></p>
          <p class="article__txt"><?php echo $hogeItem['txt']; ?></p>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
  <!-- /記事一覧 -->
  <!-- ボタン -->
  <div class="btn">
    <?php if($currentPage !== 1): ?>
      <a href="<?php echo $pagePath . $prevNum; ?>">前へ</a>
    <?php endif; ?>
    <?php if($currentPage < $totalPage): ?>
      <a href="<?php echo $pagePath . $nextNum; ?>">次へ</a>
    <?php endif; ?>
  </div>
  <!-- /ボタン -->
  <!-- ページャー -->
  <ul class="pager">
    <!-- 1ページ目 -->
    <?php if($currentPage === 1): ?>
      <li>
        <span class="pager__current">1</span>
      </li>
    <?php else: ?>
      <li>
        <a class="pager__link" href="<?php echo $pageDir; ?>">1</a>
      </li>
    <?php endif; ?>
    <!-- /1ページ目 -->
    <!-- リーダー -->
    <?php if ($start > $pageRange): ?>
      <li>
        <span>...</span>
      </li>
    <?php endif; ?>
    <!-- /リーダー -->
    <!-- 1ページ目以降 -->
    <?php foreach ($pagerNums as $pagerNum): ?>
      <?php if($pagerNum !== 1 && $pagerNum !== (int)$totalPage): ?>
        <?php if($pagerNum === $currentPage): ?>
          <li>
            <span class="pager__current">
              <?php echo $pagerNum; ?>
            </span>
          </li>
        <?php else: ?>
          <li>
            <a class="pager__link" href="<?php echo $pagePath . $pagerNum; ?>">
              <?php echo $pagerNum; ?>
            </a>
          </li>
        <?php endif; ?>
      <?php endif; ?>
    <?php endforeach; ?>
    <!-- /1ページ目以降 -->
    <!-- リーダー -->
    <?php if(($totalPage - 1) > $end): ?>
      <li>
        <span>...</span>
      </li>
    <?php endif; ?>
    <!-- /リーダー -->
    <!-- 末尾のページ -->
    <?php if($currentPage === (int)$totalPage): ?>
      <li>
        <span class="pager__current"><?php echo $totalPage; ?></span>
      </li>
    <?php else: ?>
      <li>
        <a class="pager__link" href="<?php echo $pagePath . $totalPage; ?>"><?php echo $totalPage; ?></a>
      </li>
    <?php endif; ?>
    <!-- /末尾のページ -->
  </ul>
  <!-- /ページャー -->
</body>
</html>