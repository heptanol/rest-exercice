<?php

use App\Managers\ArticleManager;
use App\Models\Article;

require "vendor/autoload.php";


$am = new ArticleManager();
$article = new Article();
$article->setId(1);
$article->setLibelle('voiture');
$article->setPrix(5.4);
$article->setQuantite(5);


$res = $am->findAll();
var_dump($res);

