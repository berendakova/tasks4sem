<?php
require_once 'Article.php';

$article = new Article();
$article->attributes->description = "1";
$article->upsert();