<?php
/**
 * 
 * @author Mydaigy
 *
 */
class IndexAction extends CommonAction {
	public function index() {
// 		$site_title = C ( 'SITE_TITLE' );
// 		$this->assign ( 'site_title', $site_title );
// 		if (! isset ( session(C ( 'USER_AUTH_KEY' )) )) {
// 			$this->display ();
// 		} else {
 			$this->redirect ( 'Main/index' );
// 		}
	}
	
// 	public function checkLogin() {
// 		if (session ( 'verify' ) != md5 ( $_POST ['verify'] )) {
// 			$this->ajaxReturn ( '验证失败', "验证码错误，请重试！", false );
// 		}
// 		$map ['uid'] = $_POST ['uid'];
// 		$map ['pwd'] = md5 ( $_POST ['pwd'] );
// 		$map ["status"] = array (
// 				'eq',
// 				1 
// 		);
// 		$authInfo = RBAC::authenticate ( $map );
// 		if ($authInfo) {
// 			if ($authInfo ['uid'] == 'admin') {
// 				$_SESSION [C ( 'ADMIN_AUTH_KEY' )] = true;
// 			}
// 			$_SESSION [C ( 'USER_AUTH_KEY' )] = $authInfo ['id'];
// 			session ( 'name', $authInfo ['name'] );
// 			session ( 'uid', $authInfo ['uid'] );
// 			session ( 'lastIp', $authInfo ['lastIp'] );
// 			session ( 'lastTime', $authInfo ['lastTime'] );
// 			session ( 'count', $authInfo ['count'] );
// 			session ( 'tishiyu',$authInfo['tishiyu']);
// 			RBAC::saveAccessList ();
// 			// 保存登录信息
// 			$User = M ( 'User' );
// 			$data = array ();
// 			$data ['id'] = $authInfo ['id'];
// 			$data ['lastTime'] = toDate(time());
// 			$data ['count'] = array (
// 					'exp',
// 					'count+1' 
// 			);
// 			//dump($_SESSION);die;
// 			$data ['lastIp'] = get_client_ip ();
// 			$User->save ( $data );
// 			$this->ajaxReturn ( '成功', "登录成功！", true );
// 		} else {
// 			$m = M ();
// 			$sql = 'select * from sd_user where uid="' . $map ['uid'] . '"';
// 			$result = $m->query ( $sql );
// 			if (count ( $result ) == 0) {
// 				$this->ajaxReturn ( '帐号不存在', "登录失败，用户<span style='color:red;'>帐号不存在</span>，请联系管理员处理！", false );
// 			} else {
// 				$this->ajaxReturn ( '密码错误', "登录失败，用户<span style='color:red;'>密码不正确</span>，请重试或请联系管理员重置密码！", false );
// 			}
// 		}
// 	}

// 	public function verify() {
// 		import ( '@.ORG.Util.Image' );
// 		Image::buildImageVerify ( 4, 1, 'png', 50, 25, 'verify' );
// 	}
// 	public function checkVerify() {
// 		if (session ( 'verify' ) != md5 ( $_POST ['verify'] )) {
// 			echo false;
// 		} else {
// 			echo true;
// 		}
// 	}
}