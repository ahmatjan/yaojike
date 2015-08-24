<?php
class AuthorityAction extends CommonAction {

    
    /**
     * 
     * 权限规则模版，只有模版
     * 
     */
    public function auth_rule(){
    	$this->display();
    }
    /**
     * 权限规则用json返回
     */
    public function get_auth_rule_json(){
    	$M										= M('auth_rule');
    	$select 								= $M->order('sort asc')->select();
    	for ($i=0; $i<count($select); $i++){
    		if ($select[$i]['pid']!=0) {
    			$select [$i] ['_parentId'] = $select [$i] ['pid'];
    		}
    	}
    	
    	$data ['rows'] = $select;
    	$data ['total'] = count ( $select );
    	$data ['rows'] = intval ( $data ['total'] ) >= 1 ? $data ['rows'] : '';
    	$this->ajaxReturn($data);
    	
    }
    
    
    /**
     * 添加规则
     */
    public function add_auth_rule(){
    	$this->assign ( 'pid', $_GET ['pid'] );
    	$this->assign ( 'level', $_GET ['level'] );
    	$this->display();
    }
    
    /**
     * 添加规则提交操作
     */
    public function add_auth_rule_Submit() {
    	$node = M ( 'auth_rule' );
    	$form = $node->create ();
    	/* 条件:查看当前节点下name是否同名 */
    	$map ['name'] = array (
    			'eq',
    			$form ['name']
    	);
    	$map ['pid'] = array (
    			'eq',
    			$form ['pid']
    	);
    	$map ['_logic'] = 'and';
    
    	$f = $node->where ( $map )->select ();//echo $node->getLastSql();die;
    	if ($f) {
    		$this->ajaxReturn ( $f, '当前层级内已有相同的Action,请更换!', false );
    	} else {
    		if ($form ['name'] && $form ['title']) {
    			$result = $node->add ();
    			if ($result) {
    				writeOperationLog ( APP_NAME, MODULE_NAME, ACTION_NAME, '添加资源信息' );
    				$this->ajaxReturn ( $result, '资源节点添加成功!', true );
    			} else {
    				$this->ajaxReturn ( $result, '资源节点添加失败!', false );
    			}
    		} else {
    			$this->ajaxReturn ( $result, '连接和标题不能为空!', false );
    		}
    	}
    }
    
    
    /**
     * 编辑规则页面
     */
    public function edit_auth_rule() {
    	$node = M ( 'auth_rule' );
    	$result = $node->find ( $_GET ['id'] );
    	$this->assign ( $result );
    	$this->display ();
    }
    
    
    /**
     * 编辑规则提交
     */
    public function edit_auth_rule_Submit() {
    	$node = M ( 'auth_rule' );
    	$form = $node->create ();
    	$form ['updateTime'] = toDate(time());
    	if ($form) {
    		$result = $node->save ( $form );
    		writeOperationLog ( APP_NAME, MODULE_NAME, ACTION_NAME, '编辑资源信息' );
    		$this->ajaxReturn ( $form, '资源节点更新成功!', true );
    	} else {
    		$this->ajaxReturn ( $form, '资源节点更新失败!', false );
    	}
    }
    
    
    /**
     * 删除规则操作
     */
    public function del_auth_rule() {
    	$mapa ['pid'] = $_POST ['id'];
    	$mapb ['id'] = $_POST ['id'];
    	$node = M ( 'auth_rule' );
    	// ==============================================
    	// 查询要删除的节点ID是否有子节点,如果有将停止删除,返回失败提示
    	// ==============================================
    	$resulta = $node->where ( $mapa )->select ();
    	if (! $resulta) {
    		$resultb = $node->where ( $mapb )->delete ();
    		if ($resultb) {
//     			$access = M ( 'Access' );
//     			$node->where ($mapa)->delete ();
    			$this->ajaxReturn ( $resultb, '删除成功！', true );
    		} else {
    			$this->ajaxReturn ( $resultb, '删除失败！', false );
    		}
    	} else {
    		$this->ajaxReturn ( $resulta, '当前所要删除的节点下有子节点,请先将其删除！', false );
    	}
    }
    
    
    /**
     * 权限管理首页
     */
    public function auth_group() {
    	$this->display ();
    }
    
    /**
     * 返回角色json数据
     */
    public function get_auth_group() {
    	$role = M ( 'auth_group' );
    	$rs = $role->select ();
    	$data ['rows'] = $rs;
    	$data ['total'] = count ( $rs );
    	$data ['rows'] = intval ( $data ['total'] ) >= 1 ? $data ['rows'] : '';
    	$this->ajaxReturn ( $data );
    }
    
    /**
     * 返回所有节点资源json数据
     */
    public function get_auth_rule() {
    	$node = M ( 'auth_rule' );
    	$count = $node->count ();
    	$rs = $node->order ( 'sort asc' )->select ();
    	for($i = 0; $i < count ( $rs ); $i ++) {
    		if (! $rs [$i] ['pid'] == 0) {
    			$rs [$i] ['_parentId'] = $rs [$i] ['pid'];
    		}
    	}
    	$data ['rows'] = $rs;
    	$data ['total'] = $count;
    	$data ['rows'] = intval ( $data ['total'] ) >= 1 ? $data ['rows'] : '';
    	$this->ajaxReturn ( $data );
    }
    
    /**
     * 通过角色ID返回节点资源json数据
     */
    public function get_auth_rule_Id() {
    	$roleId = $_POST ['id'];
    	$m = M ( 'auth_group' );
    	$map ['id'] = $roleId;
    	$r = $m->field ( 'rules' )->where ( $map )->find();
    	if ($r) {
    		$str = explode(',', $r['rules']);
    		
    		$this->ajaxReturn ( $str );
    	}
    }
    
    
    /**
     * 更新资源节点
     * 删除已有的,重新添加现在所选的
     */
    public function update_auth_group() {
    	$data['id'] = $_POST ['rid'];
    	$data['rules'] = $_POST ['nid'];
    	$lv = $_POST ['lv'];
    	$access = M ( 'auth_group' );
    	
    	$res=$access->save($data);
    	if ($res!==false) {
    		$this->ajaxReturn ( '', '更新权限资源节点成功!', true );
    	}else {
    		$this->ajaxReturn ( '', '更新权限资源节点失败!', true );
    	}
    	
    }
    
    
    /**
     * 用户组管理
     * 
     */
    public function auth_group_group() {
    	$this->display ();
    }
    
    /**
     * 返回角色ID对应的用户json数据
     */
    public function get_auth_group_IdUser() {
    	$page = $_POST ['page'];
    	$rows = $_POST ['rows'];
    	$userId = getUserId ( $_GET ['id'] );
    	$map ['id'] = array (
    			'in',
    			$userId
    	);
    	$user = M ( 'user' );
    	$rsCount = $user->where ( $map )->count ();
    	$rs = $user->where ( $map )->limit ( ($page - 1) * $rows, $rows )->order ( 'uid asc' )->select ();
    	// 向rs加入roleName属性
    	for($i = 0; $i < count ( $rs ); $i ++) {
    		$rs [$i] ['groupName'] = getRoleNames ( $rs [$i] ['id'] );
    	}
    	$data ['rows'] = $rs;
    	$data ['total'] = $rsCount;
    	$data ['rows'] = intval ( $data ['total'] ) >= 1 ? $data ['rows'] : '';
    	$this->ajaxReturn ( $data );
    }
    
    
    
    
    
    /**
     * 用户模版
     */
    
    public function user(){
    	$this->display();
    }
    
    /**
     * 返回用户json数据
     * 供用户管理首页调用
     */
    public function getUser() {
    	$uid = $_POST ['uid'];
    	$name = $_POST ['name'];
    	if (! empty ( $uid )) {
    		$map ['uid'] = array (
    				'like',
    				'%' . $uid . '%'
    		);
    	}
    	if (! empty ( $name )) {
    		$map ['name'] = array (
    				'like',
    				'%' . $name . '%'
    		);
    	}
    	$page = $_POST ['page'];
    	$rows = $_POST ['rows'];
    	$user = M ( 'user' );
    	$rsCount = $user->where ( $map )->count ();
    	$rs = $user->where ( $map )->limit ( ($page - 1) * $rows, $rows )->order ( 'uid asc' )->select ();
    	// 向rs加入roleName属性
    	for($i = 0; $i < count ( $rs ); $i ++) {
    		$rs [$i] ['groupName'] = getRoleNames ( $rs [$i] ['id'] );
    		$rs [$i] ['status'] = getStatusText ( $rs [$i] ['status'] );
    	}
    	$data ['rows'] = $rs;
    	$data ['total'] = $rsCount;
    	$data ['rows'] = intval ( $data ['total'] ) >= 1 ? $data ['rows'] : '';
    	$this->ajaxReturn ( $data );
    }
    /**
     * 添加用户首页
     */
    public function addUser() {
    	$role = getRoleAll ();
    	$this->assign ( 'auth_group', $role );
    	$this->display ();
    }
    
    /**
     * 返回角色json数据
     * 供前台combotree选择调用
     */
    public function get_auth_group_Json() {
    	$role = M ( 'auth_group' );
    	$r = $role->select ();
    	for($i = 0; $i < count ( $r ); $i ++) {
    		$result [$i] ['id'] = $r [$i] ['id'];
    		$result [$i] ['text'] = $r [$i] ['title'];
    	}
    	$this->ajaxReturn ( $result );
    }
    /**
     * 添加用户提交
     */
    public function addUserSubmit() {
    	$user								= M ( 'user' );
    	$data								= $user->create ();
    	$data ['pwd']						= md5 ( C ( 'ADD_PASSWORD' ) );
    	
    	$data ['createTime']				= date('Y-m-d H:i:s');//toDate(time());
    	$uid								= trim ( $data ['uid'] );
    	if ($uid == null) {
    		$this->ajaxReturn ( false, '用户ID为必填项!', false );
    	} else {
    		$map ['uid']					= $uid;
    		$rs								= $user->where ( $map )->select ();
    		if ($rs) {
    			$this->ajaxReturn ( false, '用户ID已存在,请更换!', false );
    		} else {
    			$result						= $user->add ( $data );
    			if ($result) {
    				// 添加用户与组的对应关系
    				$auth_group_access		= M ( 'auth_group_access' );
    				$auth_group_access->where ( 'uid=' . $result )->delete ();
    				$roleId					= $_POST ['auth_group'];
    				$agc['uid']				= $result;
    				for ($i=0;$i<count($roleId);$i++){
    					$agc['group_id']	= $roleId[$i];
    					$auth_group_accessadd	= $auth_group_access->add($agc);
    				}
    				
    				
    				if ($auth_group_accessadd) {
    					$this->ajaxReturn ( true, '添加用户成功!', true );
    				}else 
    					$this->ajaxReturn ( true, '添加用户权限失败!', true );
    			} else {
    				$this->ajaxReturn ( $result, '添加用户失败!', false );
    			}
    		}
    	}
    }
    
    /**
     * 编辑用户首页
     */
    public function editUser() {
    	$user = M ( 'user' );
    	$result = $user->find ( I('id') );
    	// 通过用户id获得所属组的id
    	$roleId = getRoleid ( I('id') );
    	// 向当前用户信息集中加入所属组
    	$role = M ( 'auth_group' );
    	$roler = $role->select ();
    	for($i = 0; $i < count ( $roler ); $i ++) {
    		if (in_array($roler [$i] ['id'] , $roleId)) {
    			$str = $str . '<option value="' . $roler [$i] ['id'] . '" selected="selected">' . $roler [$i] ['title'] . '</option>';
    		} else {
    			$str = $str . '<option value="' . $roler [$i] ['id'] . '">' . $roler [$i] ['title'] . '</option>';
    		}
    	}
    	$result ['role'] = '<select id="role" class="easyui-combo" name="role">' . $str . '</select>';
    	// 模板赋值
    	$this->assign ( 'time', toDate(time()) );
    	$this->assign ( 'user', $result );
    	$this->display ();
    }
    
    /**
     * 向编辑用户表单内加入combotree
     */
    public function getauth_groupEditJson() {
    	// 通过用户id获取所属组的id
    	$roleId = getRoleid ( $_POST ['id'] );
    	// 列出所有用户组
    	$role = M ( 'auth_group' );
    	$r = $role->select ();
    	for($i = 0; $i < count ( $r ); $i ++) {
    		$result [$i] ['id'] = $r [$i] ['id'];
    		$result [$i] ['text'] = $r [$i] ['title'];
    		// 判断当前组是否被选中
    		for($j = 0; $j < count ( $roleId ); $j ++) {
    			if ($result [$i] ['id'] == $roleId [$j]) {
    				$result [$i] ['checked'] = true;
    			}
    		}
    	}
    	// 返回给combotree
    	$this->ajaxReturn ( $result );
    }
    /**
     * 编辑用户提交
     */
    public function editUserSubmit() {
    	$user = M ( 'user' );
    	$form = $user->create ();
    	$form ['updateTime'] = date('Y-m-d H:i:s');//toDate(time());
    	$result = $user->save ( $form );
    	if ($result) {
    		// 重新添加用户与组的对应关系
    		$role_user = M ( 'auth_group_access' );
    		$role_user->where ( 'uid=' . $form ['id'] )->delete ();
    		$roleId = $_POST ['role'];
    		$rdata ['uid'] = $form ['id'];
    		for($i = 0; $i < count ( $roleId ); $i ++) {
    			$rdata ['group_id'] = $roleId [$i];
    			$role_user->add ( $rdata );
    		}
    		$this->ajaxReturn ( true, '更新用户成功!', true );
    	} else {
    		$this->ajaxReturn ( false, '更新用户失败!', false );
    	}
    }
    /**
     * 删除用户操作
     */
    public function delUser() {
    	$rudata = explode ( ",", $_POST ['id'] );
    	for($i = 0; $i < count ( $rudata ); $i ++) {
    		$return = clearUserInfo ( $rudata [$i] );
    	}
    	if (true == $return) {
    		$this->ajaxReturn ( 'success', '用户信息删除成功!', true );
    	}else $this->ajaxReturn ( 'error', '用户信息删除失败!', false );
    	
    }
    
    
    
    
    /**
     * 重置用户密码
     */
    public function resetPwd() {
    	$result = reSetPassword ( I('id') );
    	if ($result) {
    		$this->ajaxReturn ( true, '用户密码已重置为:' . C ( 'ADD_PASSWORD' ), true );
    	} else {
    		$this->ajaxReturn ( false, '用户密码重置失败!', false );
    	}
    }
    
    
    
    public function edit(){
    	$id										= I('id');
    	if (!empty($id)) {
    		$M									= M('auth_rule');
    		$this->data							= $M->where(array('id'=>$id))->find();
    		$this->display();
    	}
    }
    
    
    
	/*
	 * 删除方法
	 */
	public function delete(){
		layout(!$this->isAjax());
		$ids								= $this->_param('id');
		$M									= D('auth_rule');
		$id									= $M->getPk();
		$result								= $M->where($id.' in('.$ids.')')->delete();//逻辑删除
		//echo $M->getLastSql();
		//$result								= $M->where($id.' in('.$ids.')')->delete();
		//echo $M->getlastSql();
		if($this->isAjax())
			$this->ajaxReturn($result?'删除成功':'删除失败');
		else if($result){
			$this->success('删除成功');
		}
		else{
			$this->error('删除失败');
		}
	}
    
	
	
	/**
	 * 
	 * 用户组（角色管理）
	 * 
	 */
	/**
	 * 添加角色首页
	 */
	public function add_auth_group() {
		$this->display ();
	}
	
	/**
	 * 添加角色提交
	 */
	public function add_auth_group_Submit() {
		$role = M ( 'auth_group' );
		$form = $role->create ();
		$map ['title'] = array (
				'eq',
				$form ['title']
		);
		$f = $role->where ( $map )->select ();
		if ($f) {
			$this->ajaxReturn ( false, '角色已存在,请改换角色名!', false );
		} else {
			$result = $role->add ();
			if ($result) {
				
				$this->ajaxReturn ( true, '角色添加成功!', true );
			} else {
				$this->ajaxReturn ( false, '角色添加失败!', false );
			}
		}
	}
	
	
	
	/**
	 * 编辑角色首页
	 */
	public function edit_auth_group() {
		$role = M ( 'auth_group' );
		$result = $role->find ( I('id') );
		$this->assign ( 'role', $result );
		$this->display ();
	}
	/**
	 * 编辑角色提交
	 */
	public function edit_auth_group_Submit() {
		$role = M ( 'auth_group' );
		$form = $role->create ();
		if ($form) {
			$result = $role->save ( $form );
			if ($result) {
				$this->ajaxReturn ( true, '角色编辑成功!', true );
			} else {
				$this->ajaxReturn ( false, '角色编辑失败!', false );
			}
		}
	}
	
	/**
	 * 删除角色操作
	 */
	public function del_auth_group() {
		$role = M ( 'auth_group' );
		$result = $role->where(array('id'=>I('id')))->delete ();
		if ($result) {
			$this->ajaxReturn ( true, '角色删除成功!', true );
		} else {
			$this->ajaxReturn ( false, '角色删除失败!', false );
		}
	}
	
	
	/**
	 * 返回未分组用户json数据
	 */
	public function getUn_auth_group_access_User() {
		$page = $_POST ['page'];
		$rows = $_POST ['rows'];
		$userid=getRoleUserId ();
		if (null != $userid) {
			$map ['id'] = array ('not in',getRoleUserId ());
		}
		
		$user = M ( 'user' );
		$rsCount = $user->where ( $map )->count ();
		$rs = $user->where ( $map )->limit ( ($page - 1) * $rows, $rows )->order ( 'id asc' )->select ();
		// 向rs加入roleName属性
		for($i = 0; $i < count ( $rs ); $i ++) {
			$rs [$i] ['groupName'] = getRoleNames ( $rs [$i] ['id'] );
		}
		$data ['rows'] = $rs;
		$data ['total'] = $rsCount;
		$data ['rows'] = intval ( $data ['total'] ) >= 1 ? $data ['rows'] : '';
		$this->ajaxReturn ( $data );
	}

	/**
	 * 返回所有用户json数据
	 */
	public function getAllUser() {
		$page = $_POST ['page'];
		$rows = $_POST ['rows'];
		$user = M ( 'user' );
		$rsCount = $user->count ();
		$rs = $user->limit ( ($page - 1) * $rows, $rows )->order ( 'id asc' )->select ();
		// 向rs加入roleName属性
		for($i = 0; $i < count ( $rs ); $i ++) {
			$rs [$i] ['groupName'] = getRoleName ( $rs [$i] ['id'] );
		}
		$data ['rows'] = $rs;
		$data ['total'] = $rsCount;
		$data ['rows'] = intval ( $data ['total'] ) >= 1 ? $data ['rows'] : '';
		$this->ajaxReturn ( $data );
	}
	
	/**
	 * 将用户加入角色操作
	 */
	public function addSelect_auth_gorup_access() {
		$rid = I('rid'); // 1
		$uid = I('uid'); // 1,2
		$ru = M ( 'auth_group_access' );
		$map ['uid'] = array (
				'eq',
				$uid
		);
		$map ['group_id'] = array (
				'in',
				$rid
		);
		// 如果已存在要加入的角色内,则先将期删除然后再与不在内的用户一并加入
		$ru->where ( $map )->delete ();
		$userId = (explode ( ",", $uid ));
		// 将选择的用户加入角色组内
		for($i = 0; $i < count ( $userId ); $i ++) {
			$data [$i] ['uid'] = $userId [$i];
			$data [$i] ['group_id'] = $rid;
			$add=$ru->add ( $data [$i] );
		}
		if ($add) {
			$this->ajaxReturn ( null, '角色更新成功!', true );
		}else $this->ajaxReturn ( null, '角色更新失败!', true );
	}
	/**
	 * 从角色内移出选择用户
	 */
	public function removeSelectAuth_group_access() {
		$rid = I('rid'); // 1
		$uid = I('uid'); // 1,2
		$ru = M ( 'auth_group_access' );
		$map ['group_id'] = array (
				'eq',
				$rid
		);
		$map ['uid'] = array (
				'in',
				$uid
		);
		// 如果已存在要加入的角色内,则先将期删除然后再与不在内的用户一并加入
		$result = $ru->where ( $map )->delete ();
		if ($result) {
			$this->ajaxReturn ( $result, '角色更新成功!', true );
		} else {
			$this->ajaxReturn ( $result, '角色更新成功!', false );
		}
	}
	
// 	//显示右侧全部规则
// 	public function auth_rules(){
// 		$M										= M('auth_rule');
// 		$sel									= $M->select();
// 		$i=0;
// 		foreach ($sel as $key =>$v){
// 			$result[$i]							= $v['id'];
// 		}
// 		$this->ajaxReturn($sel,'JSON');
// 	}
	
// 	//选中用户组以后显示其权限
// 	public function u_auth_groups(){
// 		$M										= M("auth_group");
// 		$authgroup								= $M->field('rules')->where('id in ('.$this->_post('ids').')')->select();
// 		foreach ($authgroup as $key => $v){
// 			if (0 != $key) {
// 				$ids							.= ','.$v['rules'];
// 			}else{
// 				$ids							.= $v['rules'];
// 			}
// 		}
// 		$M2										= M('auth_rule');
// 		$sel									= $M2->where('id in ('.$ids.')')->select();
// 		$this->ajaxReturn($sel,'JSON');
// 		//dump($sel);
// 	}
	
// 	//保存当前选中的用户组权限
// 	public function auth_group_save(){
// 		if (IS_AJAX) {
// 			$M									= M('auth_group');
// 			$rids								= $this->_post('rids');//用户组id
// 			if (empty($rids)) {
// 				$this->ajaxReturn('请选择一项。');
// 			}
// 			$rules['rules']						= $this->_post('aids');//权限id
// // 			if (empty($rules['rules'])) {
// // 				$this->ajaxReturn('修改成功');//如果权限为空，则直接成功，不进行下面的数据库操作,此处不能有这个判断，如果确实想删除其所有权限，此处判断后者错误
// // 			}
			
// 			$change								= $M->where('id in ('.$rids.')')->save($rules);
// 			if (false !==$change) {
// 				$this->ajaxReturn('修改成功');
// 			}else $this->ajaxReturn('修改失败');
// 		}else return ;
// 	}
	
	
	
// 	/**
// 	 * 用户和用户权限管理
// 	 */
// 	//用户组权限管理
// 	public function user_auth_group_access_save(){
// 		if (IS_AJAX) {
// 			$M									= M('adminuser');
			
// 			$data['user_name']					= $this->_post('user_name');
// 			$user_password						= $this->_post('user_password');
// 			$data['user_state']					= $this->_post('user_state');
// 			$access['group_id']					= $this->_post('user_auth_group');
// 			$data['user_hospital']				= $this->_post('user_hospital');
			
// 			$sel								= $M->where(array('user_name'=>$data['user_name']))->select();
// 			if (''!=$data['user_name'] && ''!=$data['user_state'] && ''!=$access['group_id'] && ''!=$data['user_hospital']) {
// 				$data['user_id']				= $this->_post('user_id');
// 				if (''==$data['user_id']) {
// 					if (''!=$user_password ) {
// 						if (0<count($sel)) {
// 							$this->ajaxReturn('用户名已存在');
// 						}else{
// 							$data['user_password']  = md5($user_password);
// 							$data['user_isdeleted']	= 0;
// 							$data['user_registtime']= date('Y-m-d H:i:s');
// 							$result					= $M->add($data);
// 						}
// 					}else 
// 						$this->ajaxReturn('密码不能为空');
// 				}else {
// 					if (''!=$user_password) {
// 						$data['user_password']	= md5($user_password);;
// 					}
					
// 					$result						= $M->save($data);//echo $M->getLastSql();
// 				}
				
// 				if (false !== $result) {
// 					$Maccess					= M('auth_group_access');
// 					if ('' == $data['user_id']) {
// 						$access['uid']			= $result;
// 						$save					= $Maccess->add($access);
// 					}else {
// 						$access['uid']			= $data['user_id'];
// 						$save					= $Maccess->where(array('uid'=>$access['uid']))->save($access);
// 					}
// 					if (false !== $save) {
// 						$this->ajaxReturn('保存成功');
// 					}else $this->ajaxReturn('保存失败');
// 				}else 
// 					$this->ajaxReturn('用户保存失败，中断执行。');
// 			}else {
// 				$this->ajaxReturn('请填写完整');
// 			}
// 		}else return ;
// 	}
	
	
// 	//用户组管理
// 	public function auth_group_add(){
		
// 		if (IS_GET) {
// 			$this->display();
// 		}else if (IS_POST && IS_AJAX) {
// 			$M										= M('auth_group');
// 			$data['title']							= $this->_post('title');
// 			if (''!=$data['title']) {
// 				$data['rules']						= '';
// 				$result								= $M->add($data);
// 				if ($result) {
// 					$this->ajaxReturn('添加成功');
// 				}else $this->ajaxReturn('添加失败');
// 			}else $this->ajaxReturn('请填写完整');
// 		}
		
// 	}
	
	
	
	
	
	
	
	
    
    
    
// //     public function user(){
// //         $M=M("User");
// //         $this->data=$M->select();
// //         $this->columns=C("columns.User");
// //         $this->display("role");
// //     }
//     public function tree(){
//         $this->display("Index:tree1");
//     }
//     public function edittree(){
//         $this->display("Index:treeedit");
//     }
//     public function role_authority(){
//         if(!$this->isAjax())return;
//         $ids=htmlentities($_POST['ids']);
//         $M=M();
//         $result=$M->table('dr_menu a')->field("a.id,name,pid,case isParent when 1 then 'true' else 'false' end isParent")->join('inner join dr_role_authority ra on ra.aid=a.id and rid in'."($ids)")->where()->select();
//         //echo $M->getLastSql();
//         $this->ajaxReturn($result,'JSON');
//     }
//     public function user_authority(){
//         if(!$this->isAjax())return;
//         $ids=htmlentities($_POST['ids']);
//         $M=M();
//         $result=$M->table(MODULE_NAME.' a')->field("a.id,name,pid,case isParent when 1 then 'true' else 'false' end isParent")->join('inner join user_authority ua on ua.aid=a.id and uid in'."($ids)")->where()->select();
//         $this->ajaxReturn($result,'JSON');
//     }
//     public function allnodes($ids=null){
//         if(!empty($ids)){
//             $M= M();
//             $n=count(explode(',', $ids));
//             $result=$M->query("
//             SELECT a.id,name,parent,case is_node when 1 then 'true' else 'false' end as isParent
//             ,ra.rid,case when ra.rid is null then 'false' else 'true' end as checked
//             FROM dr_authority a
//             inner join role_authority ra on a.id=ra.aid and ra.rid in($ids)
//             group by aid having count(*)>=$n
//             ");
//         }
//         else{
//             $M= M('menu');
//             $result=$M->field("id,name,pId,case isParent when 1 then 'true' else 'false' end isParent")->select();
//         }
//         //echo $M->getLastSql();
//         $this->ajaxReturn($result,'JSON');
//      }
//     public function nodes(){
//         if(!$this->isAjax()){
//             //return;
//         }
//         $id=htmlentities($_POST['id']);
//         $type=htmlentities($_POST['type']);
//         $data['name']=htmlentities($_POST['name']);
//         $data['pid']=htmlentities($_POST['pid']);
//         $data['level']=htmlentities($_POST['level']);
//         $M=M('authority');
//         if(empty($type)){
//             if(empty($id))$id=0;
//             $result=$M->field("id,name,pid,case isParent when 1 then 'true' else 'false' end isParent")->where('pid='.$id)->select();
//         }else if($type=="all"){
//             $result=$M->field("id,name,pid,case isParent when 1 then 'true' else 'false' end isParent")->select();
//         }else if($type=="edit"){
//             $result=$M->where('id='.$id)->save($data);
//         }else if($type=='add'){
//             $data['isnode']=($data['pid']==0?'0':'1');
//             $result=$M->add($data);
//         }else if($type=='del'){
//             $result=$M->where('id='.$id)->delete();
//         }
//         $this->ajaxReturn($result,'JSON');
        
//     }
//     public function update(){
//         if(!$this->isAjax())return;
//             $M =M("role_authority");
            
//             $rids=$this->_post('rids');
//             if(empty($rids)){
//                 $this->ajaxReturn('error');
//             }
//             $aids=$this->_post('aids');
//             $M->where('rid in'."($rids)")->delete();//把要修改的角色id删除,以免重复
//             if(empty($aids))
//                  $this->ajaxReturn('Success');//如果权限为空，则直接成功，不进行下面的数据库操作
//             $aids=explode(',',$aids);
//             $roles=explode(',',$rids);
            
//             $n=0;
//             foreach ($roles as $rid) {
//                 foreach ($aids as $aid) {
//                         $data[$n]['rid']=$rid;
//                         $data[$n]['aid']=$aid;
//                         ++$n;
//                 }
//             }
            
//             $result=$M->addAll($data);
//             $result=$result>0?'更新成功':'更新失败';
//             $this->ajaxReturn($result);
//     }
    
//     public function save(){
//     	//if($this->isAjax()){
//             $M =M(MODULE_NAME);
//             if(!$M->create()){
//                 $this->ajaxReturn(1,'Save Failed.',1);
//             }
//             $autoNumb=$this->_post('auto_numb');
//             if(empty($autoNumb)){
//                 $this->numb=$M->numb;
//             }
//             else{
//                 $this->numb=uuid();  
//             }
//             R('Comm/Table/save',array($M));
//             $M->query();
// 		//}
//     }

}