<?php
// ログアウト
require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Logout();
$app->run();
