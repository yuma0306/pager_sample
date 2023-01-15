<?php
Class Helper
{
  // jsonファイルのdecode
  public function getData($json) {
    $data = file_get_contents($json);
    return json_decode($data, true);
  }

  // 末尾のURLを取得
  public function getEndUri() {
    $uri = rtrim($_SERVER['REQUEST_URI'], '/');
    $uri = substr($uri, strrpos($uri, '/') + 1);
    return $uri;
  }

  // デバック用（var_dumpのデバッグを見やすく）
  public function d() {
    echo '<pre style="background:#fff;color:#333;border:1px solid lightgray;margin:5px; padding:5px;font-size:12px;line-height:2;">';
    foreach(func_get_args() as $v) {
      var_dump($v);
    }
    echo '</pre>';
  }
}
?>