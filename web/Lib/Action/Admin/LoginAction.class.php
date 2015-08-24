<?php

class LoginAction extends Action {
	function _initialize() {
		header ( "Content-Type:text/html;charset=utf-8" );
		if (true == session('id') || true == session('uid')) {
		    $this->redirect(GROUP_NAME.'/Main/index');exit;
		}
	}
	
	public function index(){
		$this->display('login');
	}
	
	public function login(){
		$this->display();
	}
	
	
	//用户登录判断
	public function checkLogin() {
		// 用户权限检查
		if (session ( 'verify' ) != md5 ( $_POST ['verify'] )) {
			$this->ajaxReturn ( '验证失败', "验证码错误，请重试！", false );
		}
		$map ['uid']								= $this->_post('uid');
		$map ['pwd']								= md5 ( $this->_post('pwd') );
		$map ["status"]								= array ('eq',1);
		
		$db											= M('user');
		$authInfo									= $db->where($map)->select();
		
		if (1<count($authInfo)) {
			$this->ajaxReturn('错误','登录信息重复',false);
		}elseif (1==count($authInfo)) {
			if ($authInfo [0]['uid'] == 'admin') {
				//session('USER_AUTH_KEY',true);
			}
			
			session ('id',(int)$authInfo[0]['id']);//用户id,强制转换成int,其实本来就是int，但从数据库读出来就成字符型了，权限要用int类型判断，字符型的数字则没有权限
			session ( 'name', $authInfo [0]['name'] );//别名
			session ( 'uid', $authInfo [0]['uid'] );//登录名
			session ( 'lastIp', $authInfo [0]['lastIp'] );
			session ( 'lastTime', $authInfo [0]['lastTime'] );
			session ( 'count', $authInfo [0]['count'] );
			session ( 'tishiyu',$authInfo[0]['tishiyu']);
			session ( 'language',$authInfo[0]['tishiyu']);
			
			// 保存登录信息
			$User = M ( 'User' );
			$data = array ();
			$data ['id'] = $authInfo [0]['id'];
			$data ['lastTime'] = toDate(time());
			$data ['count'] = array ('exp','count+1');
			$data ['lastIp'] = get_client_ip ();
			$User->save ( $data );
			$this->ajaxReturn ( '成功', "登录成功！", true );
		}elseif (1>count($authInfo)){
			$this->ajaxReturn('登录失败',"登录失败，请联系管理员处理！", false );
		}
	}
	
	//用户退出
	public function logout() {
		session(null);
		$this->success ( '退出系统成功！', __APP__.'/'.GROUP_NAME );
	}
	//验证码
	public function verify() {
		import ( '@.ORG.Util.Image' );
		Image::buildImageVerify ( 4, 1, 'png', 50, 25, 'verify' );
	}
	public function checkVerify() {
		if (session ( 'verify' ) != md5 ( $_POST ['verify'] )) {
			echo false;
		} else {
			echo true;
		}
	}
	
	
}

?>