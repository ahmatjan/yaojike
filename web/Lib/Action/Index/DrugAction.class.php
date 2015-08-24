<?php
/**
 * 
 * @author win
 *显示药物信息
 *
 */
class DrugAction extends CommonAction{
    public function index(){
        
        require_once APP_PATH.'Class/Page/Page.class.php';
        $count                                                = M('medicine')->count('md_id');
        $page							                      = I('p')?I('p'):1;
        $rows							                      = 20;
        $p								                      = ($page - 1) * $rows;
        $sel                                                  = M('medicine')->limit($p,$rows)->where(array('md_isdelete'=>1))->order('md_sort asc , md_id asc')->select();//查询药品数据
        //echo M('medicine')->_sql();
        $Page                                                 = new Page($count, $rows);
        $this->page                                           = $Page->show();
        $this->prePage                                        = $Page->prePage;
        $this->nextPage                                       = $Page->nextPage;
        $this->rows                                           = $rows;
        $this->pageinfo                                       = $Page->nowPage.'/'.$Page->totalPages;
        
        
        
        
        //dump($sel);
        $this->assign(array('sel'=>$sel,'count'=>$count,'rowstart'=>$p+1,'rowend'=>$p+$rows))->display();
    }
    
    public function drugcontent() {
        $find                                                  = M('medicine')->field('md_id,md_isdelete,md_type,md_datetime,md_sort',true)->where(array('md_id'=>$this->_get('id')))->find();
        //dump($find);
        $this->assign(array('sel'=>$find))->display();
    }
}

?>