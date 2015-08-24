<?php
/**
 * 
 * @author 
 * 前台栏目显示
 *
 */

class ArticleAction extends CommonAction{
    public function index(){
        $this->select                               = M('article')->where(array('column'=>$this->_get('id')))->order('id desc')->select();
        $this->columnname                           = M('column')->where(array('id'=>$this->_get('id')))->getField('text');
        $this->display();
    }
    
    public function content() {
        $this->find                                 = M('article')->where(array('id'=>$this->_get('id')))->find();
        $this->display();
    }
}

?>