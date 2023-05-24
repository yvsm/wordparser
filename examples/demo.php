<?php
require_once __DIR__ . '/../src/splits.php';
require_once __DIR__ . '/../src/helper.php';

$title = "HTTP缓存实际表现探究-使用node.js和chrome";
$content="前言， http缓存作为前端面试中经常被提问的一环，相信很多人或多或少都会有基本概念，本文基于此，使用node和chrome就浏览器对HTTP各种缓存的表现做一探究。";
$splitword = new \zunyunkeji\wordparser\splits();

/* 分词*/
print_r($splitword->get($content,$title));


/* 获取前5个分词 */
print_r(splits_top($content,$title,5));

//$splitword->add("眉县猕猴桃", __DIR__.'/dict/other.dict');
//$splitword->add("HTTP缓存", __DIR__.'/dict/it.dict'); 