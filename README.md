# wordparser
基于基础词库并结合自定义词库进行分词的系统，也可进行敏感词检测。

## 安装
> composer require zunyunkeji/wordparser "dev-main"

## 示例

### 分词
```php
	//分词
	print_r($splitword->get($content,$title));
	
	//分词快捷方法
	print_r(splits_get($content,$title));
	
	//获取排列前几位分词
	print_r($splitword->get($content,$title));
	
	//分词快捷方法
	print_r(splits_top($content,$title,5));
```


### 添加分词
```php
	$splitword->add("眉县猕猴桃");
```