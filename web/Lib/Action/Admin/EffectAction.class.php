<?php
/**
 * 
 * @author win
 * @desc 不良反应
 * 
 */

class EffectAction extends CommonAction {
	
	/**
	 * 不良反应列表
	 */
	public function index(){
		if (isset($_GET['getdatajson']) && !empty($_GET['getdatajson'])) {
		    $db                                                   = M('report');
		    $page							                      = I('page');
		    $rows							                      = I('rows');
		    $p								                      = ($page - 1) * $rows;
		    $result                                                  = $db->limit($p,$rows)->where(array('hz_isdel'=>1))->select();
		    
		    $data ['rows']                                        = $result!=null?$result:[];
		    $data ['total']                                       = $db->where(array('hz_isdel'=>1))->count('hz_id');
			$this->ajaxReturn($data);
		}else {
				$this->display();
		}
	}
	
	
	
	/**
	 * 不良反应添加
	 */
	public function effectadd(){
		if (isset($_GET['doit']) && !empty($_GET['doit']) && IS_AJAX) {
		    
			$mreport                                             = M('report');
			$myaopin                                             = M('yaopin');
			
			if(!$mreport->create()){//错误返回信息
			    $this->ajaxReturn($mreport->getError(),false,false);exit();
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
		            $this->ajaxReturn('保存成功',true,true);
		        }else{
		            $this->ajaxReturn('失败，请刷新重试',false,false);
		        }
		    }else {
		        $this->ajaxReturn('失败，请刷新重试',false,false);
		    }
    		
    	    
		}else {//如果不是提交保存数据，则显示页面
		    $this->minzu                          = M('datalibminzu')->where(array('isdel'=>1))->select();
			$this->display();
		}
	}
}

?>