<?php
Class Pager
{
  // 1ページに表示するデータ件数
  private $dataLimit;
  // 現在のページから前後に表示するページャーの数
  public $pageRange;
  // パラメータ名
  public $param;
  // 現在のページパス
  public $pagePath;

  // プロパティ定義
  function __construct($dataLimit, $pageRange, $param)	{
		$this->dataLimit = $dataLimit;
    $this->pageRange = $pageRange;
    $this->param = $param;
    $this->pagePath = $this->getPagePath();
  }

  // パラメータを除いた現在のページパスを取得
  private function getPagePath() {
    $uri = $_SERVER['REQUEST_URI'];
    if(isset($_GET[$this->param])) {
      $uri = strtok($uri, '?');
    }
    return $uri;
  }

  // 現在のページ数を取得
  public function getCurrentPage() {
    if(isset($_GET[$this->param])) {
      return (int)$_GET[$this->param];
    } else {
      return 1;
    }
  }

  //ページ及びページャーの総数を取得
  public function getTotalPage($data) {
    return ceil(count($data) / $this->dataLimit);
  }

  // パラメータのチェック
  public function checkParam($totalPage, $url) {
    if(isset($_GET[$this->param]) && (int)$_GET[$this->param] === 1) {
      header("Location:" . $url, true, 301);
      exit;
    } elseif(isset($_GET[$this->param]) && (int)$_GET[$this->param] > (int)$totalPage) {
      $this->redirectNotfound();
    }
  }

  // 現在のページに表示するデータの取得
  public function getShowData($data, $currentPage) {
    // データの開始位置
    $dataStart = ($currentPage - 1) * $this->dataLimit;
    // 全データ,記事データの開始位置,切り取り件数,取得した配列のキーを0からの連番に
    return array_slice($data, $dataStart, $this->dataLimit, true);
  }

  // ページャーに表示する最初のページ番号（先頭以外）
  public function getStartPagerNum($currentPage) {
    return max($currentPage - $this->pageRange, 1);
  }

  // ページャーに表示する最後のページ番号（末尾以外）
  public function getEndPagerNum($currentPage, $totalPage) {
    return min($currentPage + $this->pageRange, $totalPage);
  }

  // ページャーに表示する番号一覧を取得
  public function getPagerNums($start,$end) {
    $pagerNums = [];
    for ($i = $start; $i <= $end; $i++) {
      $pagerNums[] = $i;
    }
    return $pagerNums;
  }

  // 戻るボタンのリンク取得
  public function createPrevLink($currentPage) {
    $prevNum =  max($currentPage - 1, 1);
    echo $this->pagePath . '?' . $this->param . '=' . $prevNum;
  }

  // 次へボタンのリンク取得
  public function createNextLink($currentPage, $totalPage) {
    $nextNum = min($currentPage + 1, $totalPage);
    echo $this->pagePath . '?' . $this->param . '=' . $nextNum;
  }

  // ページャーのリンク作成
  public function createPagerLink($pagerNum) {
    $pagerLink = $this->pagePath . '?' . $this->param . '=' . $pagerNum;
    echo $pagerLink;
  }

  // 404リダイレクト
  private function redirectNotfound() {
    header("HTTP/1.1 404 Not Found");
    include $_SERVER['DOCUMENT_ROOT'] . '/404.html';
    exit;
  }
}
// ページ番号でデータにフィルタかける
// function getShowData($currentPage, $dataLimit, $data) {
//   return array_filter($data, function($i) use ($currentPage, $dataLimit) {
//     // 論理積
//     return $i >= ($currentPage - 1) * $dataLimit && $i < $currentPage * $dataLimit;
//   }, ARRAY_FILTER_USE_KEY);
// }
// $showData = getShowData($currentPage, $dataLimit, $data);
?>