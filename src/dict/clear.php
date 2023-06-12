<?php
/*
字典文件二次清洗
*/

// 获取当前目录下的所有指定扩展名的文件路径
$files = glob("*.dict");

// 遍历所有文件
foreach ($files as $file) {
    // 读取文件内容
    $contents = file_get_contents($file);

    // 去重
    $word_list = array_unique(explode(',', $contents));

    // 过滤长度为1的单词和特殊字符或标点符号
    foreach ($word_list as &$word) {
        $word = trim($word); // 去除前后空格
        if (mb_strlen($word, 'utf-8') === 1) { // 去除长度为1的单词
            $word = null;
        } else {
            $word = str_replace(["*",'：','“','”','|','、','】','【','，','。','{','}','%','……','&','！'],'', $word); // 去除特殊字符或标点符号
        }
    }

    // 去除空单词（即上一步中长度为1的单词）
    $word_list = array_filter($word_list);

    // 将单词列表转换为字符串并保存到同一文件中，覆盖原来的内容
    file_put_contents($file, implode(',', $word_list));
}

echo "文件处理完毕。";