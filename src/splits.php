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

namespace zunyunkeji\wordparser;


class splits{
	//定义自定义词库路径
	public $dict_dir = __DIR__.'/dict/train';

	//定义基本词库位置
	public $word_dict = __DIR__.'/dict/split.dict';
	
	//定义自定义词库位置
	public $train_dict = __DIR__.'/dict/split.train.dict';
	
	public $dict = [];
	
    /**
     * 插件构造函数
     * Addons constructor.
     * @param \think\App $app
     */
    public function __construct($train_dict=''){
		if($train_dict){
			$this->train_dict = $train_dict;
		}
    }

    /* 设置词库目录 */
	public function set_dict_dir($dict_dir){
		if(!empty($dict_dir)){
			$this->dict_dir = $dict_dir;
		}
	}
	
	public function set_dict($dict=[]){
		if(!empty($dict)){
			$this->dict = $dict;
		}
	}
	
	/**
	 * 分隔并计算关键词
	 * @demo $this->get($content,$title)
	 * @param content $str 需要分隔计算的内容
	 * @param title $str 需要分隔计算的标题
	 * @return array[
	 *		t_tags	//标题关键词组
	 *		c_tags	//全文关键词组
	 *		n_tags	//与标题关键词组相关段落的关键词组
	 *		tags_count	//关键词出现次数
	 *	]
	 */
 
    public function get($content,$title=''){
		// 获取目录下所有扩展名为 .dict 的文本文件
		$files = glob($this->dict_dir . '/*.dict');
		
		// 循环读取每个文本文件的内容
		$tags_array = array();
		foreach ($files as $file) {
		    $word = file_get_contents($file);
			$tags_array = array_merge($tags_array,explode(',', $word));
		}

		if($this->train_dict && file_exists($this->train_dict)){
			$word = file_get_contents($this->train_dict);
			$tags_array = array_merge($tags_array,explode(',', $word));
		}

		if($this->word_dict && file_exists($this->word_dict)){
			$word = file_get_contents($this->word_dict);
			$tags_array = array_merge($tags_array,explode(',', $word));
		}

		if(is_array($this->dict) && !empty($this->dict)){
			$tags_array = array_merge($tags_array,$this->dict);
		}

		$tags_array = array_unique($tags_array);

        $t_tags = array();
        $c_tags = array();
        $n_tags = array();
        $n_content = array();
        $content=$this->clearhtml($content);
        if(!empty($title)){
            $title=$this->clearhtml($title);
            foreach($tags_array as $t_tag) {
                if(strpos($title, $t_tag) !== false){
                    $t_tags[] = $t_tag;
                }
            }
            foreach($t_tags as $key) {
                $n_content[]=$this->findword($key,$content);
            }
            $n_content=implode("|->|",array_unique($n_content));
            foreach($tags_array as $n_tag) {
                if(strpos($n_content, $n_tag) !== false){
                    $n_tags[] = $n_tag;
                }
            }
        }
        foreach($tags_array as $c_tag) {
            if(strpos($content, $c_tag) !== false){
                $c_tags[] = $c_tag;
            }
        }
        if(!empty($title)){
			$_tags = array_merge($t_tags,$c_tags);
            $tags=array("t_tags"=>array_unique($t_tags),"n_tags"=>array_unique($n_tags),"c_tags"=>array_unique($c_tags),'tags_count'=>array_count_values($_tags));
        }else{
            $tags=array("c_tags"=>array_unique($c_tags),'tags_count'=>array_count_values($c_tags));
        }
        return $tags;
    }
	
	/*
	 * 获取排列前几位关键词
	 * @param content $str 需要分隔计算的内容
	 * @param title $str 需要分隔计算的标题
	 * @return string
	*/
	public function splits_top($content,$title='',$top=5){
		$splits = $this->get($content,$title);
		$tags_count = array_slice($splits['tags_count'], 0, $top);
		return array_keys($tags_count);
	}


	/**
	 * 查询关键词在文本中出现的位置并重新组成一个新的文本
	 * @param string $keyword 关键词
	 * @param string $content 文本
	 * @return string
	 */
    public function findword($keyword,$content){
        $n_content=array();
        $content=$this->scontent($content);
        foreach($content as $value) {
           if(strpos($value,$keyword)!==false){
               $n_content[] =$value;
           }
        }
        return implode("|->|",$n_content);
    }


	/**
	 * 分隔文本段落
	 * @param string $content 文本
	 * @return string
	 */
    public function scontent($content){
        $symbol=array("，","。","？","！","……",",",".","!","?");
        $content=str_replace($symbol,"|->|",$content);
        $content=explode("|->|",$content);
        return $content;
    }


	/**
	 * 清除文本中的HTML代码
	 * @param string $content 文本
	 * @return string
	 */
    public function clearhtml($content){
        $content = strip_tags($content,"");
        $content = str_replace(array("\r\n", "\r", "\n"), "", $content);   
        $content = str_replace("　","",$content);
        $content = str_replace("&nbsp;","",$content);
        $content = str_replace(" ","",$content);
        return ltrim(trim($content));
    }


	/**
	 * 向自定义词库增加词组
	 * @param string $keyword 文本
	 * @return bool
	 */
    public function add($keyword){
		if(is_array($keyword)){
			foreach($keyword as $key){
				$this->add($key);
			}
			return true;
		}
		
		$keyword = $this->clearhtml($keyword);
		if(empty($keyword)) return false;
		
		$word = file_get_contents($this->train_dict);
		$words = $word.",".file_get_contents($this->word_dict);
		
        if(strpos($words,",{$keyword},") !== false){
            return false;
        }else{
            $word = str_replace("--END--","".$keyword.",--END--",$word);
            file_put_contents($this->train_dict,$word);
            return true;
        }
    }
}