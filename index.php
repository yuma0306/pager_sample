<?php
  ini_set('display_errors', 'On');
  include $_SERVER['DOCUMENT_ROOT'] . '/assets/php/pager.php';
  $pager = new Pager(3, 2, 'page');
  $json = $_SERVER['DOCUMENT_ROOT'] . '/assets/data/test.json';
  // ----- 記事データの処理 -----
  $currentPage = $pager->getCurrentPage();
  $data = $pager->getData($json);
  $totalPage = $pager->getTotalPage($data);
  $pager->checkParam($totalPage, './index.php');
  // ----- ページャーの処理 -----
  $pagerStart = $pager->getStartPagerNum($currentPage);
  $pagerEnd = $pager->getEndPagerNum($currentPage, $totalPage);
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
    <?php foreach($pager->getShowData($data, $currentPage) as $showItem): ?>
      <li class="article__item">
        <a href="<?php echo $showItem['path']; ?>">
          <p class="article__ttl"><?php echo $showItem['ttl']; ?></p>
          <p class="article__txt"><?php echo $showItem['txt']; ?></p>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
  <!-- /記事一覧 -->
  <!-- ボタン -->
  <div class="btn">
    <?php if($currentPage !== 1): ?>
      <a href="<?php $pager->createPrevLink($currentPage); ?>">前へ</a>
    <?php endif; ?>
    <?php if($currentPage < $totalPage): ?>
      <a href="<?php $pager->createNextLink($currentPage, $totalPage); ?>">次へ</a>
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
        <a class="pager__link" href="<?php echo $pager->pagePath; ?>">1</a>
      </li>
    <?php endif; ?>
    <!-- /1ページ目 -->
    <!-- リーダー -->
    <?php if ($pagerStart > $pager->pageRange): ?>
      <li>
        <span>...</span>
      </li>
    <?php endif; ?>
    <!-- /リーダー -->
    <!-- 1ページ目以降 -->
    <?php foreach ($pager->getPagerNums($pagerStart, $pagerEnd) as $pagerNum): ?>
      <?php if($pagerNum !== 1 && $pagerNum !== (int)$totalPage): ?>
        <?php if($pagerNum === $currentPage): ?>
          <li>
            <span class="pager__current">
              <?php echo $pagerNum; ?>
            </span>
          </li>
        <?php else: ?>
          <li>
            <a class="pager__link" href="<?php $pager->createPagerLink($pagerNum); ?>">
              <?php echo $pagerNum; ?>
            </a>
          </li>
        <?php endif; ?>
      <?php endif; ?>
    <?php endforeach; ?>
    <!-- /1ページ目以降 -->
    <!-- リーダー -->
    <?php if(($totalPage - 1) > $pagerEnd): ?>
      <li>
        <span>...</span>
      </li>
    <?php endif; ?>
    <!-- /リーダー -->
    <!-- 末尾のページ -->
    <?php if($currentPage === (int)$totalPage): ?>
      <li>
        <span class="pager__current">
          <?php echo $totalPage; ?>
        </span>
      </li>
    <?php else: ?>
      <li>
        <a class="pager__link" href="<?php $pager->createPagerLink($totalPage); ?>">
          <?php echo $totalPage; ?>
        </a>
      </li>
    <?php endif; ?>
    <!-- /末尾のページ -->
  </ul>
  <!-- /ページャー -->
</body>
</html>