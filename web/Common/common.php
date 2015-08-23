<?php




/**
 * @author mydaigy
 * @version 公共函数库
 */
function toDate($time, $format = 'Y-m-d H:i:s') {
	if (empty ( $time )) {
		return '';
	}
	$format = str_replace ( '#', ':', $format );
	return date ( $format, $time );
}


/**
 * 生成二维码
 */

function erweima($id,$type,$url){
	require APP_PATH.'Class/phpqrcode/phpqrcode.php';


	// 二维码数据

	$data = $url;
	// 生成的文件名

	$imgname= $id.'.png';

	$filename = 'userqrcode/'.$imgname;

	// 纠错级别：L、M、Q、H

	$errorCorrectionLevel = 'L';

	// 点的大小：1到10

	$matrixPointSize = 4;

	//创建一个二维码文件

	QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

	//输入二维码到浏览器

	//QRcode::png($data);

	return $filename;
}



/**
 * 输出用户组
 *
 * @return Ambigous <mixed, string, boolean, NULL, unknown>
 */
function getRoleAll() {
	$role = M ( 'auth_group' );
	$result = $role->select ();
	return $result;
}
/**
 * 获得当前id是否有子节点
 *
 * @param unknown_type $mode        	
 * @param unknown_type $id        	
 * @return boolean
 */
function getChildren($mode, $id) {
	$map ['pid'] = array ('eq',$id);
	$result = $mode->where ( $map )->select ();
	//echo $mode->_sql();
	if ($result) {
		return true;
	} else {
		return false;
	}
}
/**
 * 获取状态文本
 *
 * @param unknown_type $num        	
 * @return string
 */
function getStatusText($num) {
	return $num == 1 ? '开启' : '停用';
}
/**
 * 获取状态输出框
 *
 * @param unknown_type $num        	
 * @return string
 */
function getStatus($num) {
	if ($num == 1) {
		return '<select id="status" name="status"><option value="1" selected="selected">开启</option><option value="0">停用</option></select>';
	} elseif ($num == 0) {
		return '<select id="status" name="status"><option value="0" selected="selected">停用</option><option value="1">开启</option></select>';
	}
}

/**
 * 获取状态输出框
 *
 * @param unknown_type $num
 * @return string
 */
function getClick($num) {
	if ($num == 1) {
		return '<select id="status" name="status"><option value="1" selected="selected">是</option><option value="0">否</option></select>';
	} elseif ($num == 0) {
		return '<select id="status" name="status"><option value="0" selected="selected">否</option><option value="1">是</option></select>';
	}
}


/**
 * 返回性别Select选择框,待废弃.
 *
 * @param unknown_type $num        	
 * @return string
 */
function getXbSelect($num) {
	$m = M ( 'Datalib' );
	$rs1 = $m->where ( 'code="xbm"' )->find ();
	$rs2 = $m->field ( 'code,text' )->where ( 'pid=' . $rs1 ['id'] )->select ();
	/* 初始选择框 */
	$data = $data . '<option value="">--</option>';
	for($i = 0; $i < count ( $rs2 ); $i ++) {
		if ($rs2 [$i] ['code'] == $num) {
			$data = $data . '<option value="' . $rs2 [$i] ['code'] . '" selected="selected">' . $rs2 [$i] ['text'] . '</option>';
		} else {
			$data = $data . '<option value="' . $rs2 [$i] ['code'] . '">' . $rs2 [$i] ['text'] . '</option>';
		}
	}
	return $data;
}
/**
 * 返回所属学院部门Select选择框
 *
 * @param unknown_type $num        	
 * @return string
 */
function getDepSelect($num) {
	$m = M ( 'Datalib' );
	$rs1 = $m->where ( 'code="dep"' )->find ();
	$rs2 = $m->field ( 'code,text' )->where ( 'pid=' . $rs1 ['id'] )->select ();
	// 初始选择框
	$data = $data . '<option value="">--</option>';
	for($i = 0; $i < count ( $rs2 ); $i ++) {
		if ($rs2 [$i] ['code'] == $num) {
			$data = $data . '<option value="' . $rs2 [$i] ['code'] . '" selected="selected">' . $rs2 [$i] ['text'] . '</option>';
		} else {
			$data = $data . '<option value="' . $rs2 [$i] ['code'] . '">' . $rs2 [$i] ['text'] . '</option>';
		}
	}
	return $data;
}
/**
 * 返回民族Select选择框
 *
 * @param unknown_type $num        	
 * @return string
 */
function getMzSelect($num) {
	$m = M ( 'Datalib' );
	$rs1 = $m->where ( 'code="mzm"' )->find ();
	$rs2 = $m->field ( 'code,text' )->where ( 'pid=' . $rs1 ['id'] )->select ();
	// 初始选择框
	$data = $data . '<option value="">--</option>';
	for($i = 0; $i < count ( $rs2 ); $i ++) {
		if ($rs2 [$i] ['code'] == $num) {
			$data = $data . '<option value="' . $rs2 [$i] ['code'] . '" selected="selected">' . $rs2 [$i] ['text'] . '</option>';
		} else {
			$data = $data . '<option value="' . $rs2 [$i] ['code'] . '">' . $rs2 [$i] ['text'] . '</option>';
		}
	}
	return $data;
}
// 返回政治面貌Select选择框
function getZzmmSelect($num) {
	$m = M ( 'Datalib' );
	$rs1 = $m->where ( 'code="zzmm"' )->find ();
	$rs2 = $m->field ( 'code,text' )->where ( 'pid=' . $rs1 ['id'] )->select ();
	// 初始选择框
	$data = $data . '<option value="">--</option>';
	for($i = 0; $i < count ( $rs2 ); $i ++) {
		if ($rs2 [$i] ['code'] == $num) {
			$data = $data . '<option value="' . $rs2 [$i] ['code'] . '" selected="selected">' . $rs2 [$i] ['text'] . '</option>';
		} else {
			$data = $data . '<option value="' . $rs2 [$i] ['code'] . '">' . $rs2 [$i] ['text'] . '</option>';
		}
	}
	return $data;
}
// 返回籍贯码对应的value,此方法需要做成通用函数
function getJgText($key) {
	$m = M ( 'Datalib' );
	$text = $m->field ( 'text' )->where ( 'code="' . $key . '"' )->find ();
	return $text ['text'];
}
// 返回籍贯Select选择框
function getJgSelect($num) {
}
function getTree($num) {
	if ($num == 1) {
		return '<select id="tree" name="tree"><option value="1" selected="selected">显示</option><option value="0">不显</option></select>';
	} elseif ($num == 0) {
		return '<select id="tree" name="tree"><option value="0" selected="selected">不显</option><option value="1">显示</option></select>';
	}
}
// 通过用户ID返回所属组name,仅支持单级.
function getRoleName($id) {
	$m = M ();
	$sql = "SELECT * FROM ip_user a,ip_role_user b,ip_role c WHERE a.id=b.user_id AND b.role_id=c.id and a.id='+$id+'";
	$result = $m->query ( $sql );
	for($i = 0; $i < count ( $result ); $i ++) {
		$str = $str . ' ' . $result [$i] ['name'];
	}
	return $str;
}

// 通过用户ID返回所属组name,仅支持单级.
function getRoleNames($id) {
	$m = M ();
	$sql = "SELECT * FROM `sd_user` a,`sd_auth_group_access` b,`sd_auth_group` c WHERE a.`id`=b.`uid` AND b.`group_id`=c.`id` and a.id='+$id+'";
	$result = $m->query ( $sql );
	for($i = 0; $i < count ( $result ); $i ++) {
		$str = $str . ' ' . $result [$i] ['title'];
	}
	return $str;
}


/**
 * 通过用户ID返回所属的分组角色id
 *
 * @param unknown_type $id
 *        	用户ID
 * @return array
 */
function getRoleid($id) {
	$m = M ();
	$sql = "SELECT `group_id` FROM `sd_auth_group_access` a where a.`uid`='+$id+'";
	$result = $m->query ( $sql );
	for ($i=0;$i<count($result);$i++){
		$str .=$result[$i]['group_id'].',';
	}
	$str=substr($str, 0, -1);
	//$arr=explode(',', $str);
	return $str;
}
// 返回已分组用户id
function getRoleUserId() {
	$ru = M ( 'auth_group_access' );
	$result = $ru->group ( 'uid' )->select ();
	for($i = 0; $i < count ( $result ); $i ++) {
		$str [$i] = $result [$i] ['uid'];
	}
	return $str;
}
/**
 * 通过role_id返回所属组的user_id
 *
 * @param unknown_type $id
 *        	角色id
 * @return array $str
 *         所有组内用户id
 */
function getUserId($id) {
	$ru = M ( 'auth_group_access' );
	$result = $ru->where ( 'group_id=' . $id )->group ( 'uid' )->select ();
	if ($result) {
		for($i = 0; $i < count ( $result ); $i ++) {
			$str [$i] = $result [$i] ['uid'];
		}
	}
	return $str;
}
/**
 * 通过用户的Uid查ip_user表内的ID
 */
// 通过uid返回所拥有的资源节点
function getAccessNodeList($uid) {
	// 通过uid查出所属组
	$roleId								= getRoleid ( $uid );
	// 根据所有的组ID查出所有的节点ID
	$access								= M ( 'auth_group' );
	$map ['id']							= array ('in',$roleId );
	$r									= $access->field ( 'rules' )->where ( $map )->select ();
	//echo $access->getLastSql();
	//dump($r);
	$r									= explode(',',$r[0]['rules']);
	return $r;
}
/**
 * 操作日志记录
 *
 * @param unknown_type $app
 *        	APP_NAME
 * @param unknown_type $mod
 *        	MODULE_NAME
 * @param unknown_type $act
 *        	ACTION_NAME
 * @param unknown_type $str
 *        	Msg
 */
// function writeOperationLog($app, $mod, $act, $str) {
// 	$operation = M ( 'Operationlog' );
// 	$data ['action'] = $app . ' -> ' . $mod . ' -> ' . $act;
// 	$data ['uid'] = session ( 'uid' );
// 	$data ['ipadd'] = get_client_ip ();
// 	$data ['remark'] = $str;
// 	$data ['createTime'] = toDate ( time () );
// 	$operation->data ( $data )->add ();
// }
/**
 * 根据数据字典的ID,返回对应的Code值
 *
 * @param unknown_type $id        	
 */
function getDatalibCode($id) {
	if ($id != '') {
		$m = M ( 'Datalib' );
		$result = $m->field ( 'code' )->find ( intval ( $id ) );
		return $result ['code'];
	} else {
		return '';
	}
}
/**
 * 通过数据字典编码返回所属文本值
 *
 * @param unknown_type $value        	
 * @return unknown
 */
function getDatalibText($value) {
	$datalib = M ( 'Datalib' );
	$rs = $datalib->field ( 'text' )->where ( 'code="' . $value . '"' )->find ();
	// $rs = $datalib->where ( 'code="' . $value . '"' )->find ();
	return $rs ['text'];
}
/**
 * 根据数据字典的编码值,返回对应记录的id
 *
 * @param string $code        	
 * @return int
 */
function getDatalibIdfCode($code) {
	$m = M ( 'Datalib' );
	$rs = $m->where ( 'code="' . $code . '"' )->find ();
	return $rs ['id'];
}
/**
 * 通过用户表id返回用户uid
 *
 * @param int $id        	
 */
function getUidfId($id) {
	$m = M ( 'User' );
	$result = $m->field ( 'uid' )->where ( 'id=' . $id )->find ();
	return $result ['uid'];
}

/**
 * 通过用户的uid返回用户名称name
 *
 * @param string $uid        	
 * @return string <>
 */
function getNamefUid($uid) {
	$m = M ( 'User' );
	$result = $m->field ( 'name' )->where ( 'uid="' . $uid . '"' )->find ();
	return $result ['name'];
}
// 是否博导
function getSfbd($key) {
	return $key == 1 ? '是' : '否';
}
// 是否博导select输出框
function getSfbdSelect($key) {
	if ($key == 1) {
		$str = '<option value="1" selected="selected">是</option><option value="0">否</option>';
	} else {
		$str = '<option value="1">是</option><option value="0" selected="selected">否</option>';
	}
	return $str;
}
// 返回反馈信息阅读状态类型文本
function getFeedbackStatusText($key) {
	return $key == 1 ? '已读' : '未读';
}
/**
 * 通过uid返回icon
 *
 * @param unknown_type $uid        	
 * @return Ambigous <>
 */
function getIconfUid($uid) {
	$m = M ( 'UserBaseinfo' );
	$result = $m->field ( 'icon' )->find ( $uid );
	return $result ['icon'];
}
/**
 * 通过uid得到所在部门
 *
 * @param unknown_type $uid        	
 * @return string
 */
function getDepfUid($uid) {
	$m = M ( 'UserBaseinfo' );
	$result = $m->field ( 'depCode' )->find ( $uid );
	return getDataLibText ( $result ['depCode'], 'dep' );
}
/**
 * 通过用户uid返回所属部门depCode的编码
 *
 * @param string $uid        	
 * @return string
 */
function getDepCodefUid($uid) {
	$m = M ( 'UserBaseinfo' );
	$result = $m->field ( 'depCode' )->find ( $uid );
	$depCode = $result ['depCode'];
	return $depCode;
}
/**
 * 通过用户uid返回用户基本表内学科归属学院xkgsxyCode的编码
 *
 * @param string $uid        	
 * @return string
 */
function getXkgsxyCodefUid($uid) {
	$m = M ( 'UserBaseinfo' );
	$result = $m->field ( 'xkgsxyCode' )->find ( $uid );
	$xkgsxyCode = $result ['xkgsxyCode'];
	return $xkgsxyCode;
}
/**
 * 通过用户uid返回用户基本表内学科归属学院xkgsxyCode的编码
 *
 * @param string $uid        	
 * @return string
 */
function getXkgsxyCode($uid) {
	$m = M ();
	$sql = 'SELECT * from ip_user_baseinfo where uid="' . $uid . '"';
	$result = $m->query ( $sql );
	return $result [0] ['xkgsxyCode'];
}
/**
 * 通过角色id返回当前角色用户的个数
 *
 * @param unknown_type $roleId        	
 */
function getCountfRoleUser($roleId) {
	/*
	 * $m = M ( 'RoleUser' ); $map ['role_id'] = array ( 'eq', $roleId ); $count = $m->where ( $map )->count ();
	 */
	$m = M ();
	$sql = 'select * from ip_role_user a , ip_user b where a.user_id=b.id AND a.role_id=' . $roleId . '';
	$count = $m->query ( $sql );
	return count ( $count );
}
/**
 * 重置用户密码为配置文件中的值,默认为:111111
 *
 * @param int $id
 *        	用户ID
 * @return boolean
 */
function reSetPassword($id) {
	$data ['id'] = $id;
	$data ['pwd'] = md5 ( C ( 'ADD_PASSWORD' ) );
	$data ['updateTime'] = date('Y-m-d H:i:s');//toDate ( time () );
	$m = M ( 'user' );
	$result = $m->save ( $data );
	return $result;
}
/**
 * 添加用户时,向相关初始数据表中加入基础数据(ip_user_baseinfo,ip_user_classinfo,ip_user_eduinfo,ip_user_jobinfo,ip_user_tutorinfo)
 *
 * @param unknown_type $mode        	
 * @param unknown_type $data
 *        	(uid,[xkgsxyCode])
 */
function addUserInfo($mode, $data) {
	$m = M ( $mode );
	$rs = $m->find ( $data ['uid'] );
	if (! $rs) {
		$m->add ( $data );
	}
}

/**
 * 返回当前学生Uid的导师Uid数组
 *
 * @param unknown_type $classUid        	
 * @return array $data
 */
function getTutorUid($classUid) {
	$sUid = $classUid;
	$m = M ( 'UserTeacherStudent' );
	$result = $m->field ( 'tUid' )->where ( 'sUid="' . $sUid . '"' )->select ();
	for($i = 0; $i < count ( $result ); $i ++) {
		$data [$i] = $result [$i] ['tUid'];
	}
	return $data;
}
/**
 * 返回学科归属学院code下的所有用户的uid
 *
 * @param unknown_type $xkgsxyCode        	
 * @return unknown
 */
function getUserUidArray($xkgsxyCode) {
	$m = M ( 'UserBaseinfo' );
	$result = $m->field ( 'uid' )->where ( 'xkgsxyCode="' . $xkgsxyCode . '"' )->select ();
	for($i = 0; $i < count ( $result ); $i ++) {
		$data [$i] = $result [$i] ['uid'];
	}
	return $data;
}
/**
 * 返回用户Uid对应的用户认证表的id
 *
 * @param string $userUid
 *        	用户帐号uid
 * @return integer
 */
function getId($userUid) {
	$m = M ( 'User' );
	$r = $m->field ( 'id' )->where ( 'uid="' . $userUid . '"' )->find ();
	return $r ['id'];
}
/**
 * 删除用户uid的所有相关数据
 *
 * @param string $uid        	
 */
function clearUserInfo($uid) {
	$map1 ['uid'] = array (
			'eq',
			$uid 
	);
	$map2 ['id'] = array (
			'eq',
			$uid
	);
	$m1 = M ( 'auth_group_access' ); // 权限表
	$m2 = M ( 'user' ); // 用户认证表
	
	
	$rem1=$m1->where ( $map1 )->delete ();
	$rem2=$m2->where ( $map2 )->delete ();
	if (false!==$rem1 && false!=$rem2) {
		return true;
	}else {
		return $rem1.$rem2;
	}
}
/**
 * 判断栏目ID是否有子栏目
 */
function ifChildren($id) {
	$m = M ();
	$sql = 'SELECT * FROM ip_web_column a WHERE a.pid=' . $id . ' ORDER BY sort';
	$result = $m->query ( $sql );
	return count ( $result ) == 0 ? false : true;
}
/**
 * 返回栏目ID子栏目集
 */
function childrenRows($id) {
	$m = M ();
	$sql = 'SELECT a.id,a.pid,a.text,a.state,a.sort,a.url 
			FROM ip_web_column a WHERE a.pid=' . $id . ' ORDER BY sort';
	$result = $m->query ( $sql );
	return $result;
}
/**
 * 返回客户的帐号名称，通过客户表Id
 */
function getCustomerUid($id) {
	$m = M ();
	$sql = 'SELECT uid FROM `ip_web_coustomer_data` WHERE id=' . $id . '';
	$result = $m->query ( $sql );
	return $result [0] ['uid'];
}




/*
 * 前台日志
*/
function writeOperationLog($str,$path,$destination='',$extra='') {
	//$operation = M ( 'indexlog' );
	$data ['fl_time'] = date('Y-m-d H:i:s');
	$data ['fl_loginidcard'] = cookie('uidcard')?cookie('uidcard'):'null';
	$data ['fl_ip'] = get_client_ip ();

	$data ['fl_loginname'] = cookie('uname')?cookie('uname'):'null';
	$data ['fl_do'] = $str;
	$data['jieshoutype']	= IS_GET?'GET':'POST';
	$data['visibletype']	= $_SERVER['HTTP_USER_AGENT'];

	$type=3;
	if(empty($destination))
		$destination = LOG_PATH_SELF.$path.'_'.date('y_m_d').'.log';//echo $destination;
	//检测日志文件大小，超过配置大小则备份日志文件重新生成
	if(is_file($destination) && 10485760 <= filesize($destination) )
		rename($destination,dirname($destination).'/'.time().'-'.basename($destination));


	$logstr=null;
	foreach ($data as $k=>$v){
		$logstr.=$v.'     ';
	}
	error_log($logstr."\r\n", $type,$destination ,$extra);

	$logstr=null;

	//$add = $operation->add ($data);
}

/*
 * 后台日志
*/
function writeOperationLogadmin($str,$path,$destination='',$extra='') {
	$operation = M ( 'indexlog' );
	$data ['fl_time'] = date('Y-m-d H:i:s');
	$data ['fl_ip'] = get_client_ip ();

	$data ['fl_loginname'] = session('username')?session('username'):'null';
	$data ['fl_do'] = $str;
	$data['jieshoutype']	= IS_GET?'GET':'POST';
	$data['visibletype']	= $_SERVER['HTTP_USER_AGENT'];
	$type=3;
	if(empty($destination))
		$destination = LOG_PATH_SELF.$path.date('Y-m-d').'.log';//echo $destination;
	//检测日志文件大小，超过配置大小则备份日志文件重新生成
	if(is_file($destination) && 10485760 <= filesize($destination) )
		rename($destination,dirname($destination).'/'.time().'-'.basename($destination));


	$logstr=null;
	foreach ($data as $k=>$v){
		$logstr.=$v.'     ';
	}
	error_log($logstr."\r\n", $type,$destination ,$extra);

	$logstr=null;

	//$add = $operation->add ($data);
}


/**
 * 获取当前页面完整URL地址
 */
function get_url() {
	$sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
	$php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
	$path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
	$relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
	return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
}

/**
 * 
 * @param 权限判断
 * @param string $relation
 * @return void|boolean
 */
function authcheck($url,$relation='or'){
	if (C('SUPER_ADMIN')!==session('id')){//如果当前登录的id不等于设置的超级管理员的id,强制类型判断,session(id)已经是int型，SUPER_ADMIN的id也是int型
		$linkArr										= explode('/',$url);//将
		if(!(count($linkArr)==2||count($linkArr)==3))return;
		if(count($linkArr)==2){
			$CUR_MODULE_NAME							= $linkArr[0];
			$CUR_ACTION_NAME							= $linkArr[1];
		}else{
			$CUR_MODULE_NAME							= $linkArr[1];
			$CUR_ACTION_NAME							= $linkArr[2];
		}
		//dump($linkArr);
		$notAuth										= in_array($CUR_MODULE_NAME, explode(",", C("NOT_AUTH_MODULE"))) || in_array($CUR_ACTION_NAME, explode(",", C("NOT_AUTH_ACTION")));
		
		//dump($notAuth);exit;
		$AUTH_CONFIG									= C('AUTH_CONFIG');
		
		if(!$AUTH_CONFIG['AUTH_ON'] || $notAuth)return true;
		else{
			if(!session("?id"))return false;
			if(in_array(session('id'),C('SUPER_ADMIN')))return true;
			else{
				import('ORG.Util.Auth');
				$auth									= new Auth();
				if($auth->check($CUR_MODULE_NAME.'/'.$CUR_ACTION_NAME,session('id'),$relation))return true;
				else return false;
			}
		}
	}else return true;
}


/**
 * 汉字转拼音部分
 *
 */
function pinyin($_String, $_Code='gb2312'){

	$_DataKey = "a|ai|an|ang|ao|ba|bai|ban|bang|bao|bei|ben|beng|bi|bian|biao|bie|bin|bing|bo|bu|ca|cai|can|cang|cao|ce|ceng|cha".
			"|chai|chan|chang|chao|che|chen|cheng|chi|chong|chou|chu|chuai|chuan|chuang|chui|chun|chuo|ci|cong|cou|cu|".
			"cuan|cui|cun|cuo|da|dai|dan|dang|dao|de|deng|di|dian|diao|die|ding|diu|dong|dou|du|duan|dui|dun|duo|e|en|er".
			"|fa|fan|fang|fei|fen|feng|fo|fou|fu|ga|gai|gan|gang|gao|ge|gei|gen|geng|gong|gou|gu|gua|guai|guan|guang|gui".
			"|gun|guo|ha|hai|han|hang|hao|he|hei|hen|heng|hong|hou|hu|hua|huai|huan|huang|hui|hun|huo|ji|jia|jian|jiang".
			"|jiao|jie|jin|jing|jiong|jiu|ju|juan|jue|jun|ka|kai|kan|kang|kao|ke|ken|keng|kong|kou|ku|kua|kuai|kuan|kuang".
			"|kui|kun|kuo|la|lai|lan|lang|lao|le|lei|leng|li|lia|lian|liang|liao|lie|lin|ling|liu|long|lou|lu|lv|luan|lue".
			"|lun|luo|ma|mai|man|mang|mao|me|mei|men|meng|mi|mian|miao|mie|min|ming|miu|mo|mou|mu|na|nai|nan|nang|nao|ne".
			"|nei|nen|neng|ni|nian|niang|niao|nie|nin|ning|niu|nong|nu|nv|nuan|nue|nuo|o|ou|pa|pai|pan|pang|pao|pei|pen".
			"|peng|pi|pian|piao|pie|pin|ping|po|pu|qi|qia|qian|qiang|qiao|qie|qin|qing|qiong|qiu|qu|quan|que|qun|ran|rang".
			"|rao|re|ren|reng|ri|rong|rou|ru|ruan|rui|run|ruo|sa|sai|san|sang|sao|se|sen|seng|sha|shai|shan|shang|shao|".
			"she|shen|sheng|shi|shou|shu|shua|shuai|shuan|shuang|shui|shun|shuo|si|song|sou|su|suan|sui|sun|suo|ta|tai|".
			"tan|tang|tao|te|teng|ti|tian|tiao|tie|ting|tong|tou|tu|tuan|tui|tun|tuo|wa|wai|wan|wang|wei|wen|weng|wo|wu".
			"|xi|xia|xian|xiang|xiao|xie|xin|xing|xiong|xiu|xu|xuan|xue|xun|ya|yan|yang|yao|ye|yi|yin|ying|yo|yong|you".
			"|yu|yuan|yue|yun|za|zai|zan|zang|zao|ze|zei|zen|zeng|zha|zhai|zhan|zhang|zhao|zhe|zhen|zheng|zhi|zhong|".
			"zhou|zhu|zhua|zhuai|zhuan|zhuang|zhui|zhun|zhuo|zi|zong|zou|zu|zuan|zui|zun|zuo";

	$_DataValue = "-20319|-20317|-20304|-20295|-20292|-20283|-20265|-20257|-20242|-20230|-20051|-20036|-20032|-20026|-20002|-19990".
			"|-19986|-19982|-19976|-19805|-19784|-19775|-19774|-19763|-19756|-19751|-19746|-19741|-19739|-19728|-19725".
			"|-19715|-19540|-19531|-19525|-19515|-19500|-19484|-19479|-19467|-19289|-19288|-19281|-19275|-19270|-19263".
			"|-19261|-19249|-19243|-19242|-19238|-19235|-19227|-19224|-19218|-19212|-19038|-19023|-19018|-19006|-19003".
			"|-18996|-18977|-18961|-18952|-18783|-18774|-18773|-18763|-18756|-18741|-18735|-18731|-18722|-18710|-18697".
			"|-18696|-18526|-18518|-18501|-18490|-18478|-18463|-18448|-18447|-18446|-18239|-18237|-18231|-18220|-18211".
			"|-18201|-18184|-18183|-18181|-18012|-17997|-17988|-17970|-17964|-17961|-17950|-17947|-17931|-17928|-17922".
			"|-17759|-17752|-17733|-17730|-17721|-17703|-17701|-17697|-17692|-17683|-17676|-17496|-17487|-17482|-17468".
			"|-17454|-17433|-17427|-17417|-17202|-17185|-16983|-16970|-16942|-16915|-16733|-16708|-16706|-16689|-16664".
			"|-16657|-16647|-16474|-16470|-16465|-16459|-16452|-16448|-16433|-16429|-16427|-16423|-16419|-16412|-16407".
			"|-16403|-16401|-16393|-16220|-16216|-16212|-16205|-16202|-16187|-16180|-16171|-16169|-16158|-16155|-15959".
			"|-15958|-15944|-15933|-15920|-15915|-15903|-15889|-15878|-15707|-15701|-15681|-15667|-15661|-15659|-15652".
			"|-15640|-15631|-15625|-15454|-15448|-15436|-15435|-15419|-15416|-15408|-15394|-15385|-15377|-15375|-15369".
			"|-15363|-15362|-15183|-15180|-15165|-15158|-15153|-15150|-15149|-15144|-15143|-15141|-15140|-15139|-15128".
			"|-15121|-15119|-15117|-15110|-15109|-14941|-14937|-14933|-14930|-14929|-14928|-14926|-14922|-14921|-14914".
			"|-14908|-14902|-14894|-14889|-14882|-14873|-14871|-14857|-14678|-14674|-14670|-14668|-14663|-14654|-14645".
			"|-14630|-14594|-14429|-14407|-14399|-14384|-14379|-14368|-14355|-14353|-14345|-14170|-14159|-14151|-14149".
			"|-14145|-14140|-14137|-14135|-14125|-14123|-14122|-14112|-14109|-14099|-14097|-14094|-14092|-14090|-14087".
			"|-14083|-13917|-13914|-13910|-13907|-13906|-13905|-13896|-13894|-13878|-13870|-13859|-13847|-13831|-13658".
			"|-13611|-13601|-13406|-13404|-13400|-13398|-13395|-13391|-13387|-13383|-13367|-13359|-13356|-13343|-13340".
			"|-13329|-13326|-13318|-13147|-13138|-13120|-13107|-13096|-13095|-13091|-13076|-13068|-13063|-13060|-12888".
			"|-12875|-12871|-12860|-12858|-12852|-12849|-12838|-12831|-12829|-12812|-12802|-12607|-12597|-12594|-12585".
			"|-12556|-12359|-12346|-12320|-12300|-12120|-12099|-12089|-12074|-12067|-12058|-12039|-11867|-11861|-11847".
			"|-11831|-11798|-11781|-11604|-11589|-11536|-11358|-11340|-11339|-11324|-11303|-11097|-11077|-11067|-11055".
			"|-11052|-11045|-11041|-11038|-11024|-11020|-11019|-11018|-11014|-10838|-10832|-10815|-10800|-10790|-10780".
			"|-10764|-10587|-10544|-10533|-10519|-10331|-10329|-10328|-10322|-10315|-10309|-10307|-10296|-10281|-10274".
			"|-10270|-10262|-10260|-10256|-10254";

	$_TDataKey = explode('|', $_DataKey);
	$_TDataValue = explode('|', $_DataValue);
	$_Data = (PHP_VERSION>='5.0') ? array_combine($_TDataKey, $_TDataValue) : Arr_Combine($_TDataKey, $_TDataValue);
	arsort($_Data);
	reset($_Data);
	if($_Code != 'gb2312') $_String = U2_Utf8_Gb($_String);
	$_Res = '';
	for($i=0; $i<strlen($_String); $i++){
		$_P = ord(substr($_String, $i, 1));
		if($_P>160) { $_Q = ord(substr($_String, ++$i, 1)); $_P = $_P*256 + $_Q - 65536; }
		$_Res .= Pinyins($_P, $_Data);
	}
	return $_Res;
	//return preg_replace("/[^a-z0-9]*/", '', $_Res);
}

function Pinyins($_Num, $_Data){
	if ($_Num>0 && $_Num<160 ) return chr($_Num);
	elseif($_Num<-20319 || $_Num>-10247) return '';
	else {
		foreach($_Data as $k=>$v){ if($v<=$_Num) break; }
		return $k;
	}
}
function U2_Utf8_Gb($_C){
	$_String = '';
	if($_C < 0x80){
		$_String .= $_C;
	}elseif($_C < 0x800){
		$_String .= chr(0xC0 | $_C>>6);
		$_String .= chr(0x80 | $_C & 0x3F);
	}elseif($_C < 0x10000){
		$_String .= chr(0xE0 | $_C>>12);
		$_String .= chr(0x80 | $_C>>6 & 0x3F);
		$_String .= chr(0x80 | $_C & 0x3F);
	}elseif($_C < 0x200000) {
		$_String .= chr(0xF0 | $_C>>18);
		$_String .= chr(0x80 | $_C>>12 & 0x3F);
		$_String .= chr(0x80 | $_C>>6 & 0x3F);
		$_String .= chr(0x80 | $_C & 0x3F);
	}
	return iconv('UTF-8', 'GB2312', $_String);
}
function Arr_Combine($_Arr1, $_Arr2){
	for($i=0; $i<count($_Arr1); $i++) $_Res[$_Arr1[$i]] = $_Arr2[$i];
	return $_Res;
}
/*汉字转拼音结束*/




//获取汉字首字母


function getfirstchar($s0){
	$fchar = ord($s0{0});
	if($fchar >= ord("A") and $fchar <= ord("z") )return strtoupper($s0{0});
	$s1 = iconv("UTF-8","gb2312", $s0);
	$s2 = iconv("gb2312","UTF-8", $s1);
	if($s2 == $s0){$s = $s1;}else{$s = $s0;}
	$asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
	if($asc >= -20319 and $asc <= -20284) return "A";
	if($asc >= -20283 and $asc <= -19776) return "B";
	if($asc >= -19775 and $asc <= -19219) return "C";
	if($asc >= -19218 and $asc <= -18711) return "D";
	if($asc >= -18710 and $asc <= -18527) return "E";
	if($asc >= -18526 and $asc <= -18240) return "F";
	if($asc >= -18239 and $asc <= -17760) return "G";
	if($asc >= -17759 and $asc <= -17248) return "H";
	if($asc >= -17247 and $asc <= -17418) return "I";
	if($asc >= -17417 and $asc <= -16475) return "J";
	if($asc >= -16474 and $asc <= -16213) return "K";
	if($asc >= -16212 and $asc <= -15641) return "L";
	if($asc >= -15640 and $asc <= -15166) return "M";
	if($asc >= -15165 and $asc <= -14923) return "N";
	if($asc >= -14922 and $asc <= -14915) return "O";
	if($asc >= -14914 and $asc <= -14631) return "P";
	if($asc >= -14630 and $asc <= -14150) return "Q";
	if($asc >= -14149 and $asc <= -14091) return "R";
	if($asc >= -14090 and $asc <= -13319) return "S";
	if($asc >= -13318 and $asc <= -12839) return "T";
	if($asc >= -12838 and $asc <= -12557) return "W";
	if($asc >= -12556 and $asc <= -11848) return "X";
	if($asc >= -11847 and $asc <= -11056) return "Y";
	if($asc >= -11055 and $asc <= -10247) return "Z";
	return null;
}


function firstword($zh){
	$ret = "";
	$s1 = iconv("UTF-8","gb2312", $zh);
	$s2 = iconv("gb2312","UTF-8", $s1);
	if($s2 == $zh){$zh = $s1;}
	for($i = 0; $i < strlen($zh); $i++){
		$s1 = substr($zh,$i,1);
		$p = ord($s1);
		if($p > 160){
			$s2 = substr($zh,$i++,2);
			$ret .= getfirstchar($s2);
		}else{
			$ret .= $s1;
		}
	}
	return $ret;
}


/**
 * 
 * 读取word
 * 
 */
function readword($path){
    require_once APP_PATH.'Class/PHPword/PHPWord.php';
    $PHPWord = new PHPWord();
    $document = $PHPWord->loadTemplate($path);
    
    //只返回文档内容
    return $document->get_documentXML();
    
    
}

/**
 * 
 * @param 对象转换为数组
 * @return array
 */
function object_array($array) {
    if(is_object($array)) {
        $array = (array)$array;
    } if(is_array($array)) {
        foreach($array as $key=>$value) {
            $array[$key] = object_array($value);
        }
    }
    return $array;
}



?>