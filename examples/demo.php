<?php
require_once __DIR__ . '/../src/splits.php';
require_once __DIR__ . '/../src/helper.php';

$title = "13800138000 029-88888888 眉县猕猴桃之乡 -  眉县猕猴桃  猕猴桃原生态原产地 眉县猕猴桃之乡 -  眉县猕猴桃  猕猴桃原生态原产地";
$content="眉县猕猴桃之乡,眉县田家寨,徐香猕猴桃,猕猴桃,奇异果,猕猴桃原生态原产地。代办批发,团购,代理,快递代发,价格优惠。陕西&middot;眉县 全国优质猕猴桃生产基地县、猕猴桃标准化生产示范区、猕猴桃生产质量工作先进单位、中国猕猴桃无公害科技示范县";
$splitword = new \zunyunkeji\wordparser\splits();

/* 分词*/
print_r($splitword->get($content,$title));


/* 获取前5个分词 */
print_r(splits_top($content,$title,5));

//$splitword->add("眉县猕猴桃");
//$splitword->add("徐香猕猴桃"); 