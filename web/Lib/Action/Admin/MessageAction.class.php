<?php
/**
 * 
 * @author win
 * 设置基本信息
 *
 */
class MessageAction extends CommonAction{
    public function index(){
        $this->sel                                      = M('message')->where(array('ms_id'=>1))->find();
        $this->display();
    }
    
    public function editbaseinfo(){
        if (IS_AJAX && IS_POST){
            $M                                          = M('message');
            $data                                       = $M->create();
            $data['ms_id']                              = 1;
            $change                                     = $M->save($data);
            if ($change !== false){
                $this->ajaxReturn('成功','保存成功',true);
            }else {
                $this->ajaxReturn('失败','保存失败',false);
            }
        }else{
            $this->sel                                      = M('message')->where(array('ms_id'=>1))->find();
            $this->display();
        }
        
    }
    
}

?>