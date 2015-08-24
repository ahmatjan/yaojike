<?php

class get_c_str {
    var $str;
    var $start_str;
    var $end_str;
    var $start_pos;
    var $end_pos;
    var $c_str_l;
    var $contents;
    
    /**
     *
     * desc 截取字符串，中文和英文混合
     * @author win
     *
     */
    function get_str($str,$start_str,$end_str){
        $this->str                                      = preg_replace("/(.*)($start_str.*)/", "\\2", $str);
        $this->start_str                                = $start_str;
        $this->end_str                                  = $end_str;
        $this->start_pos                                = strpos($this->str,$this->start_str)+strlen($this->start_str,'utf-8');//从哪个位置开始搜索,返回开始字符串所在位置，strpos从第0位开始搜索,strlen返回长度
        $this->end_pos                                  = strpos($this->str,$this->end_str,5);//在哪个位置结束搜索，返回结束位置,第一次出现的位置，因为str第一个字符就是要搜索的结束字符，所以不从第一个搜索，随便写个从第二个开始搜
        $this->c_str_l                                  = ($this->end_pos - $this->start_pos)/3;//要截取多少个字符
        if ($this->end_pos<=0){//为最后一个判断
            $this->contents                             = mb_substr($this->str,$this->start_pos);
        }else {
            $this->contents                             = mb_substr($this->str,$this->start_pos,$this->c_str_l,'utf-8');
        }
        
        //echo $this->start_str.'开始位置'.$this->start_pos.'结束位置'.$this->end_pos.'要截取多少字符'.$this->c_str_l.'<br>';
        return $this->contents;
    }
    
    
    function get_str_char($str,$start_str,$end_str){
        //$this->str = preg_replace("/(.*)($start_str.*)/", "\\2", $str);
        $this->str                                      =$str;
        $this->start_str                                = $start_str;
        $this->end_str                                  = $end_str;
        $this->start_pos                                = strpos($this->str,$this->start_str)+strlen($this->start_str);//从哪个位置开始搜索,返回开始字符串所在位置，strpos从第0位开始搜索,strlen返回长度
        $this->end_pos                                  = strpos($this->str,$this->end_str);//在哪个位置结束搜索，返回结束位置,第一次出现的位置，因为str第一个字符就是要搜索的结束字符，所以不从第一个搜索，随便写个从第二个开始搜
        $this->c_str_l                                  = $this->end_pos - $this->start_pos;//要截取多少个字符
        $this->contents                                 = mb_substr($this->str,$this->start_pos,$this->c_str_l);
        //echo $this->start_str.'开始位置'.$this->start_pos.'结束位置'.$this->end_pos.'要截取多少字符'.$this->c_str_l.'<br>';
        return $this->contents;
    }
    
    
    
    
}

?>