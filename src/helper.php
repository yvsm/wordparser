<?php
/**
 * 中文分词
 * ============================================================================
 * 版权所有 (C) 西安尊云信息科技有限公司，并保留所有权利。
 * 网站地址:   http://www.zunyunkeji.com
 * 源码下载:   http://www.wdphp.com
 * ----------------------------------------------------------------------------
 * 许可声明：遵循GPL2.0开源协议
 * 基于基础词库并结合自定义词库进行分词的系统，也可进行敏感词检测。
  * 训练并添加词组:$this->add
 * ============================================================================
 * Author: 缘境 (yvsm@zunyunkeji.com) QQ:316430983 
*/

use zunyunkeji\wordparser\splits;


if (!function_exists('splits_get')) {
	/**
	 * 分隔并计算关键词
	 * @demo splits_get($content,$title)
	 * @param content $str 需要分隔计算的内容
	 * @param title $str 需要分隔计算的标题
	 * @return array[
	 *		t_tags	//标题关键词组
	 *		c_tags	//全文关键词组
	 *		n_tags	//与标题关键词组相关段落的关键词组
	 *		tags_count	//关键词出现次数
	 *	]
	 */
    function splits_get($content,$title='')
    {
        return (new splits())->get($content,$title);
    }
}


if (!function_exists('splits_top')) {
	/**
	 * 分隔并计算关键词
	 * @demo splits_get($content,$title)
	 * @param content $str 需要分隔计算的内容
	 * @param title $str 需要分隔计算的标题
	 * @return array
	 */
    function splits_top($content,$title='',$top=5)
    {
        return (new splits())->splits_top($content,$title,$top);
    }
}

if (!function_exists('get_splits')) {
	/**
	 * 分隔并计算关键词
	 * @demo splits_get($content,$title)
	 * @param content $str 需要分隔计算的内容
	 * @param title $str 需要分隔计算的标题
	 * @return array
	 */
    function get_splits($content,$limt=20)
    {
        return (new splits())->get_splits($content,$limt);
    }
}