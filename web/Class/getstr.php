<?php

class get_c_str {
    var $str=null;
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
        $this->str                                      = preg_replace("/(.*)($start_str.*)/", "\\2", $str);//echo $this->str;
        $this->start_str                                = $start_str;
        $this->end_str                                  = $end_str;
        $start_str_length                               = strlen($this->start_str);//开始的字符有多少个字符
        $this->start_pos                                = 0;//strpos($this->str,$this->start_str)+$start_str_length;//从哪个位置开始搜索,返回开始字符串所在位置，strpos从第0位开始搜索,strlen返回长度
        $this->end_pos                                  = stripos($this->str,$this->end_str,5);//在哪个位置结束搜索，返回结束位置,第一次出现的位置，因为str第一个字符就是要搜索的结束字符，所以不从第一个搜索，随便写个从第二个开始搜
        $this->c_str_l                                  = ceil(($this->end_pos - $this->start_pos));//要截取多少个字符
        mb_internal_encoding("utf-8");
        if ($this->end_pos<=0){//为最后一个判断
            $this->contents                             = mb_substr($this->str,$this->start_pos);
        }else {
            $this->contents                             = mb_substr($this->str,$this->start_pos,$this->c_str_l,'utf-8');
        }
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
    
    
    /**
     * $mubiaostr---------目标字符串
     * $ksstr---------截取开始字符串，支持通配符(*)
     * $jsstr---------截取结束字符串，支持通配符(*)
     * */
    function jiequstr($mubiaostr,$ksstr,$jsstr)  {
        
        if($mubiaostr==''){
            //echo '目标字符串为空<br/>';
            return false;
        }
        if($ksstr==''){
            $jiequks=0;
            return false;
        }else{
            $chucuo1=0;
            $arr1=explode('(*)',$ksstr);
            $len1=count($arr1);
            $chaxunwz=0;
            $feikongnum1=0;
            for($i=0;$i<$len1;$i++){
                if($arr1[$i]==''){
                    continue;
                }
                $feikongnum1++;
                if(($wz=strpos($mubiaostr,$arr1[$i],$chaxunwz))!==false){
                    $chaxunwz=$wz+strlen($arr1[$i]);
                }else{
                    $chucuo1=1;
                    return '无';
                    break;
                }
            }
            if($chucuo1==1){
                $jiequks=0;
            }else{
                $jiequks=$chaxunwz;
            }
        }
        if($jsstr==''){//字符串为空
            $jiequjs=strlen($mubiaostr);
            return false;
        }else{
            $chucuo2=0;
            $arr2=explode('(*)',$jsstr);
            $len2=count($arr2);
            $chaxunwz=$jiequks;
            $feikongnum2=0;
            for($i=0;$i<$len2;$i++){
                if($arr2[$i]==''){
                    continue;
                }
                $feikongnum2++;
                if(($wz=strpos($mubiaostr,$arr2[$i],$chaxunwz))!==false){
                    $chaxunwz=$wz+strlen($arr2[$i]);
                    if($feikongnum2==1){
                        $enddian=$wz;
                    }
                }else{
                    $chucuo2=1;
                    return false;
                    break;
                }
            }
            if($chucuo2==1){
                $jiequjs=strlen($mubiaostr);
            }else{
                $jiequjs=$enddian;
            }
        }
        $jiequstr=substr($mubiaostr,$jiequks,$jiequjs-$jiequks);
        return $jiequstr;
    }
    
}

?>