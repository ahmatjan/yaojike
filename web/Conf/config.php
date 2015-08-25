<?php
return array (
		/**
		 * 权限部分
		 */
		//authority权限认证
		'AUTH_CONFIG' => array(
				'AUTH_ON' => true, //认证开关
				'AUTH_TYPE' => 1, // 认证方式，1为时时认证；2为登录认证。
				'AUTH_GROUP' => 'dr_auth_group', //用户组数据表名
				'AUTH_GROUP_ACCESS' => 'dr_auth_group_access', //用户组明细表
				'AUTH_RULE' => 'dr_auth_rule', //权限规则表
				'AUTH_USER' => 'dr_user'//用户信息表
		),
		//不用判断的分组、模块等
		
		'NOT_AUTH_MODULE'=>'Index,Main',
		'NOT_AUTH_ACTION'=>'checkPwd,center,west,south,north,menuData,pwdChangeSubmit',
		'SUPER_ADMIN'=> 1,
        'TITLE'=>'药剂科',
        
		
		/**
		 * session、cookie部分
		 */
		'SESSION_PREFIX'			=> 'yaojike',
			
		'COOKIE_PREFIX'				=> 'yaojike',

		//'SHOW_PAGE_TRACE' => true,//显示信息
		// 站点配置
		'URL_MODEL' => 2,
		'ADD_PASSWORD' => '111111', // 添加用户初始密码
		'ADD_DEL_PASSWORD'=>'abcdef',
		'UPLOAD_ICON_SIZE' => 500 * 1024, // 个人头像上传大小限制
		//'SHOW_PAGE_TRACE' => 0
		'USER_ENCRYPT'=>'beijingtianqihaohunzhuoa',//用户加密字符串，不可删除，不可更改，否则用户会登录失败



		'URL_HTML_SUFFIX'	=>	'',//url伪静态后缀为空
		'APP_GROUP_LIST'			=> 'Admin,Index', //项目分组设定
		'DEFAULT_GROUP'				=> 'Index', //默认分组
		'DB_TYPE' => 'mysql',
		'DB_NAME' => 'yaojike',
		'DB_HOST' => 'localhost',
		'DB_USER' => 'root',
		'DB_PWD' => 'xingqiyi223',
		'DB_PORT' => 3306,
		'DB_PREFIX' => 'dr_',
        'LIMIT_ROBOT_VISIT'=>true,/*禁止机器人访问*/
		'LOAD_EXT_CONFIG' => 'tishiyu,zh-cn,en-us',
		
		'SITE_TITLE' => '后台管理',/* */
		'SITE_COPYRIGHT' => 'Copyright &copy 2015 儿童医院药剂科  技术支持-- 北京儿童医童缘网络科技发展有限公司' 
);

?>