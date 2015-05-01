<?php

require_once 'filesAutoload.php';
ini_set("session.cookie_lifetime", 3 * 30 * 24 * 60 * 60);

$fileLoader = new Filesystem\FileSystem();
$app = new App($fileLoader);

$app->bindPaths(require_once 'paths.php');

$app->start();
