<?php
/**
 * 
 * @author win
 * 药物不良反应
 *
 */
class DrugAdverseReactionAction extends CommonAction{
    
    public function index(){
        $this->minzu                                = M('datalibminzu')->select();
        $this->display();
    }

    
    
    
    /**
     * 不良反应添加
     */
    public function effectadd(){
        if (IS_POST && IS_AJAX) {
    
            $mreport                                             = M('report');
            $myaopin                                             = M('yaopin');
            	
            if(!$mreport->create()){//错误返回信息
                $this->ajaxReturn('错误',$mreport->getError(),false);exit();
            }
            $data                                                = $mreport->data();
            $id                                                  = $mreport->getPk();
            $data['hz_baogaotype']                               = implode(',', $this->_post('hz_baogaotype'));
            $data['hz_zhongyaoxinxi']                            = implode(',', $this->_post('hz_zhongyaoxinxi'));
            $data['hz_age']                                      = date('Y-m-d')-$this->_post('hz_chushengtime');
            $data['hz_uid']                                      = session('id');
    
            $result                                              = $mreport->add($data);
    
    
            //echo $mreport->_sql();
            //添加药品,因为可能每次有多个药品，所以单独放另一个的表
            if ($result) {
                $hynum                                       = count($this->_post('yp_hypzwh'));
                $bynum                                       = count($this->_post('yp_bypzwh'));
                //echo $hynum.$bynum;die;
                for ($i=0;$i<$hynum;$i++){
                    $hydata[$i]['yp_pzwh']                       = $_POST['yp_hypzwh'][$i];
                    $hydata[$i]['yp_spmc']                       = $_POST['yp_hyspmc'][$i];
                    $hydata[$i]['yp_tymc']                       = $_POST['yp_hytymc'][$i];
                    $hydata[$i]['yp_sccj']                       = $_POST['yp_hysccj'][$i];
                    $hydata[$i]['yp_yaopinpihao']                = $_POST['yp_hyyaopinpihao'][$i];
                    $hydata[$i]['yp_yaopinyongfaliang']          = $_POST['yp_hyyaopinyongfaliang'][$i];
                    $hydata[$i]['yp_yyqzsj']                     = $_POST['yp_hyyyqzsj'][$i];
                    $hydata[$i]['yp_yyyuanyin']                  = $_POST['yp_hyyyyuanyin'][$i];
                    $hydata[$i]['yp_uid']                        = session('id');
                    $hydata[$i]['yp_type']                       = 1;//1是怀疑药品
                    $hydata[$i]['yp_hzid']                       = $result;//是哪一个不良反应
    
    
                }
                $hyyaopin                                        = $myaopin->addAll($hydata);
                for ($i=0;$i<$bynum;$i++){
                    $bydata[$i]['yp_pzwh']                       = $_POST['yp_bypzwh'][$i];
                    $bydata[$i]['yp_spmc']                       = $_POST['yp_byspmc'][$i];
                    $bydata[$i]['yp_tymc']                       = $_POST['yp_bytymc'][$i];
                    $bydata[$i]['yp_sccj']                       = $_POST['yp_bysccj'][$i];
                    $bydata[$i]['yp_yaopinpihao']                = $_POST['yp_byyaopinpihao'][$i];
                    $bydata[$i]['yp_yaopinyongfaliang']          = $_POST['yp_byyaopinyongfaliang'][$i];
                    $bydata[$i]['yp_yyqzsj']                     = $_POST['yp_byyyqzsj'][$i];
                    $bydata[$i]['yp_yyyuanyin']                  = $_POST['yp_byyyyuanyin'][$i];
                    $bydata[$i]['yp_uid']                        = session('id');
                    $bydata[$i]['yp_type']                       = 2;//2是并用药品
                    $bydata[$i]['yp_hzid']                       = $result;//是哪一个不良反应
                }
                $byyaopin                                        = $myaopin->addAll($bydata);
    
                if ($result!==false && $hyyaopin!==false && $byyaopin!==false) {
                    $this->ajaxReturn('保存成功','保存成功，3秒后自动跳转.',true);
                }else{
                    $this->ajaxReturn('失败','失败，请刷新重试。02',false);
                }
            }else {
                $this->ajaxReturn('失败','失败，请稍候再试，某些数据可能为空，请填写完整后重试。01',false);
            }
    
            	
        }else {//如果不是提交保存数据，则返回false
            return false;
        }
    }
    
}

?>