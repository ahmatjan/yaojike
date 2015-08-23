<?php
/**
 * 
 * @author kaifeng
 * 信息管理系统框架模块
 *
 */
class MainAction extends CommonAction {
	// 主框架首页
	public function index() {
		$this->assign ( 'site_title', C ( 'SITE_TITLE' ) );
		$this->display ();
	}
	
	
	// 菜单树json数据
	public function menuData() {
		//authcheck($url);
		/* 列出所有节点 */
		$ids								= isset($_POST['id']) ? $this->_post('id'):$this->_get('id');
		$id									= isset ( $_POST ['id'] )|| isset( $_GET['id'] ) ? intval ( $ids ) : 0;
		
		$map ['pid']						= array ('eq',$id );
		$map ['tree']						= array ('eq',1);
		$db									= M('auth_rule');
		/* 如果是超级用户，所有列表 */
		if (session('id')==C('SUPER_ADMIN')) {
			$result							= $db->field('iconCls,id,level,name,action,pid,sort,tree,title text,whetherclick')->where($map)->order ( 'sort asc' )->select();
		}else {//否则通过权限查看
			$accessList						= getAccessNodeList ( session ( 'id' ) );
			
			$map ['id']						= array ('in',$accessList);
			
			$result							= $db->field('iconCls,id,level,name,action,pid,sort,tree,title text,whetherclick')->where ( $map )->order ( 'sort asc' )->select ();
			//dump($result);die;
		}
		
		for($i = 0; $i < count ( $result ); $i ++) {
			/* 加入result[i][attributes][url] 节点 */
			$result [$i] ['attributes'] ['name'] = $result [$i] ['name'];
			$result[$i]['attributes']['whetherclick']= $result[$i]['whetherclick'];
			/* 加入state节点 */
			if (getChildren ( $db, $result [$i] ['id'] )) {
				$result [$i] ['state']		= 'closed';
			} else {
				$result [$i] ['state']		= 'open';
			}
		}
		
		$this->ajaxReturn ( $result );
	}
	// 上 Banner面板
	public function north() {
		//$auth ['id'] = session ( C ( 'USER_AUTH_KEY' ) );
		$auth ['uid'] = session ( 'uid' );
		$auth ['name'] = session ( 'name' );
		$auth ['lastIp'] = session ( 'lastIp' );
		$auth ['lastTime'] = session ( 'lastTime' );
		$auth ['count'] = session ( 'count' ) + 1;
		$this->assign ( 'auth', $auth );
		$this->display ();
	}
	// 下 版权信息面板
	public function south() {
		$this->assign ( 'site_copyright', C ( 'SITE_COPYRIGHT' ) );
		$this->display ();
	}
	// 左 导航面板
	public function west() {
		$M								= M('auth_rule');
		$sel							= $M->field('iconCls,id,level,name,action,pid,sort,tree,title text,whetherclick')->where(array('pid'=>0,'tree'=>1))->select();
		$this->assign(array('menu'=>$sel))->display ();
	}
	// 内容面板
	public function center() {
		$this->display ();
	}
	/**
	 * 初始密码检查页
	 */
	public function pwdChange() {
		$this->display ();
	}
	/**
	 * 初始密码检查修改提交
	 */
	public function pwdChangeSubmit() {
		$data ['newPwd'] = $this->_post ('newPwd');
		$data ['rePwd'] =  $this->_post ('rePwd');
		$data ['newdelPwd']=$this->_post ('newdelPwd');
		$data ['redelPwd']=$this->_post ('redelPwd');
		if (empty ( $data ['newPwd'] ) || empty ( $data ['rePwd'] ) || empty($data['newdelPwd']) || empty($data['redelPwd'])) {
			$this->ajaxReturn ( $data, '密码字段不能为空!', false );
		} elseif ($data ['newPwd'] == C ( 'ADD_PASSWORD' ) || $data ['newdelPwd'] == C ( 'ADD_DEL_PASSWORD' )) {
			$this->ajaxReturn ( $data, '密码不能与初始密码相同!', false );
		} else if ($data ['newPwd'] != $data ['rePwd'] || $data ['newdelPwd'] != $data ['redelPwd']) {
			$this->ajaxReturn ( $data, '密码必须和重复密码相同!', false );
		}else{
			$udata ['pwd'] = md5 ( $data ['newPwd'] );
			$udata ['delpwd']=md5($data['newdelPwd']);
			$udata ['updateTime'] = toDate(time());
			$m = M ( 'user' );
			$r = $m->where ( 'id=' . session ( 'id' ) )->save ( $udata );
			if ($r) {
				$this->ajaxReturn ( '成功', '密码修改成功!', true );
			} else {
				$this->ajaxReturn ( '失败', '密码修改失败!', false );
			}
			
		}
	}
	// 验证是否密码初始状态
	public function checkPwd() {
		$m = M ( 'user' );
		$result = $m->field ( 'pwd,delpwd' )->find ( session ( 'id' ) );
		if (md5 ( C ( 'ADD_PASSWORD' ) ) == $result ['pwd'] || md5(C('ADD_DEL_PASSWORD')) == $result['delpwd']) {
			$this->ajaxReturn ( true );
		} else {
			$this->ajaxReturn ( false );
		}
	}
	
	
	
	
}