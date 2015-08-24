<?php

class IndexAction extends CommonAction{
    
    
    public function index() {
        $this->sel                                      = M('message')->where(array('ms_id'=>1))->find();
        $this->find                                     = M('medicine')->field('md_id,md_isdelete,md_type,md_datetime,md_sort',true)->order('RAND()')->find();//随机查询一个
        $this->display();
    }
}

?>