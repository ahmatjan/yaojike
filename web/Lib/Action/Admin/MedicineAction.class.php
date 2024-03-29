<?php
/**
 * 药品部分
 * @author win
 *
 */

class MedicineAction extends CommonAction {
	
	/**
	 * 药品列表
	 */
	public function index(){
		
		if (isset($_GET['getdatajson']) && !empty($_GET['getdatajson'])) {
		    $db                                                   = M('medicine');
		    $page							                      = I('page');
		    $rows							                      = I('rows');
		    $p								                      = ($page - 1) * $rows;
		    $result                                               = $db->field('md_id,md_name,md_sort')->limit($p,$rows)->where(array('md_isdelete'=>1))->order('md_sort asc,md_id asc')->select();
		    //echo $db->getLastSql();
		    $data ['rows']                                        = $result!=null?$result:array();
		    $data ['total']                                       = $db->where(array('md_isdelete'=>1))->count('md_id');
		    $this->ajaxReturn($data);
		}else {
			$this->display();
		}
		
	}
	
	/**
	 * 导入药品word文档,兼容Linux，Windows。
	 */
	public function medicineaddword() {
	    if ($_FILES) {
            import('ORG.Net.UploadFile');
            $upload                                                 = new UploadFile();// 实例化上传类
            $upload->maxSize                                        = 3145728 ;// 设置附件上传大小
            $upload->allowExts                                      = array('docx');// 设置附件上传类型
            $upload->savePath                                       = './Public/Uploadsword/';// 设置附件上传目录
            //dump($upload);
            if(!$upload->upload()) {// 上传错误提示错误信息
                $this->ajaxReturn('错误',$upload->getErrorMsg(),false);
            }else{// 上传成功 获取上传文件信息
                $info                                               = $upload->getUploadFileInfo();
                $document                                           = readword($info[0]['savepath'].$info[0]['savename']);
                $str                                                = strip_tags($document);
                //$str                                                = str_replace('【','[',$str);
                //$str                                                = str_replace('】',']',$str);
                
                $db                                                 = M('medicine');
                //将字符串分割
                require_once APP_PATH.'Class/getstr.php';
                $get_c_str = new get_c_str();
                $data['md_name']                                    = $get_c_str->get_str_char($str,'[',']');//药品名
                //查询数据库有没有此药品
                $find                                               = $db->where(array('md_name'=>$data['md_name']))->find();
				
				//echo $get_c_str->get_str($str,'【组成成分】', '【');die;
                if (count($find)>0){
                    $this->ajaxReturn('失败','药品已经存在',false);exit();
                }else {
                    $data['md_jingshi']                                 = $get_c_str->jiequstr($str,'【特别警示】', '【');
                    $data['md_chengfen']                                = $get_c_str->jiequstr($str,'【组成成分】', '【');
                    $data['md_yaolifenllei']                            = $get_c_str->jiequstr($str,'【药理分类】', '【');
                    $data['md_lcyingyong']                              = $get_c_str->jiequstr($str, '【临床应用】', '【');
                    $data['md_yfyl']                                    = $get_c_str->jiequstr($str, '【用法与用量】', '【');
                    $data['md_guowaiylck']                              = $get_c_str->jiequstr($str, '【国外用法用量参考】', '【');
                    $data['md_geiyaoshuoming']                          = $get_c_str->jiequstr($str, '【给药说明】', '【');
                    $data['md_jinjizheng']                              = $get_c_str->jiequstr($str, '【禁忌症】', '【');
                    $data['md_shenyong']                                = $get_c_str->jiequstr($str, '【慎用】', '【');
                    $data['md_tsrenqun']                                = $get_c_str->jiequstr($str, '【特殊人群】', '【');
                    $data['md_blfanying']                               = $get_c_str->jiequstr($str, '【不良反应】', '【');
                    $data['md_ywxhzuoyong']                             = $get_c_str->jiequstr($str, '【药物相互作用】', '【');
                    $data['md_zhuyishixiang']                           = $get_c_str->jiequstr($str, '【注意事项】', '【');
                    $data['md_guowaizkyyxxck']                          = $get_c_str->jiequstr($str, '【国外专科用药信息参考】', '【');
                    $data['md_ywguoliang']                              = $get_c_str->jiequstr($str, '【药物过量】', '【');
                    $data['md_yaoli']                                   = $get_c_str->jiequstr($str, '【药理】', '【');
                    $data['md_zjgg']                                    = $get_c_str->jiequstr($str, '【制剂与规格】', '【');
                    $data['md_chucang']                                 = $get_c_str->jiequstr($str, '【贮藏】', '【');
                    //操作字符串数组，将其插入到数据库
//                     dump($data);
//                     die;
                    $add                                                = $db->add($data);
                    if ($add){
                        $this->ajaxReturn('成功','药品上传成功',true);
                    }else {
                        $this->ajaxReturn('失败','药品上传失败',false);
                    }
                }
            }
	    }else {
			$this->display();
		}
	}
	
	/**
	 * 查看药品详细,和修改
	 */
	public function get_medicine_content(){
	    $id                                                                = $this->_get('id');
	    if (!empty($id)){
	        $db                                                            = M('medicine');
	        $select                                                        = $db->where(array('md_id'=>$id))->find();
	        $this->assign(array('data'=>$select,'url'=>'http://'.$_SERVER['HTTP_HOST']))->display('editmedicine');
	        
	    }else {
	        $this->ajaxReturn('错误','没有获取到药品id',false);
	    }
	}
	

	/**
	 * 手动填写药品
	 */
	public function medicineadd(){
	    
	}
	
	
	/**
	 * 药品修改
	 */
	public function editmedicine(){
	    if (IS_AJAX && IS_POST){
	        //dump($_POST);
	        $M                                                                 = M('medicine');
	        $M->create();
	        $add                                                               = $M->save();
	        //echo $M->_sql();die;
	        if ($add!==false){
	            $this->ajaxReturn('成功','药品修改成功',true);
	        }else 
	            $this->ajaxReturn('失败','药品修改失败',false);
	    }else {
	        $this->ajaxReturn('错误','服务器获取到信息，但信息异常',false);
	    }
	}
	
	
	/**
	 * 药品删除
	 */
	public function delmedicine(){
	    if (IS_POST && IS_AJAX){
	        if (isset($_POST['id']) && !empty($_POST['id'])){
	            $del                                                           = M('medicine')->where(array('md_id'=>$this->_post('id')))->delete();
	            if ($del){
	            $this->ajaxReturn('成功','药品删除成功',true);
	        }else 
	            $this->ajaxReturn('失败','药品删除失败',false);
	        }else {//既然都错了，肯定不是从正规入口进来的
	            return false;
	        }
	    }
	}
	

	
	

	
	
}

?>