<?php
/**
 * 
 * @author kf
 *
 */
class CommonAction extends Action {
	
	function _initialize() {
	    header ( "Content-Type:text/html;charset=utf-8" );
		
		writeOperationLogadmin(get_url(),GROUP_NAME);
		
		if (false == session('id') || false == session('uid')){
			
			$this->redirect(GROUP_NAME.'/Login/index');exit;
			
		}
		
		if(!authcheck(MODULE_NAME.'/'.ACTION_NAME)){
			if (IS_AJAX) {
				$this->ajaxReturn('您没有权限',false,false);
			}else
				$this->error('你没有权限',U('Index/index'));
		}else return true;
			
		
			
			
			
		
		
	}
	
}