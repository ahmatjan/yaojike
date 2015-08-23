<?php
/**
 * @author kf
 * 数据字典模块
 * 所有字典的增删改查全部都用统一的方法，用ACTION_NAME来区别是哪一个字典，需要注意数据库命名和模版文件里面的字段和js函数名的命名
 * 数据表命名：前缀_datalib+方法名字，
 * 文件名命名：方法名.html和方法名+add.html
 * 文件模版里面的id、js函数等必须一致。
 * 暂时先这样写，后期所有的字典共用同一个模版，只加数据表
 */
class DatalibAction extends CommonAction {
	// 数据字典首页
	public function index() {
		$this->display ();
	}
	
	/**
	 * 列表页json数据
	 * 因为所有的列表用的统一的格式，所以需要把每一个字典的列表的id设置为不同，为了方便，后面加ACTION_NAME
	 */
	public function getdatalibjson(){
		$name							= $this->_get('action');
		
		
		$M								= M('datalib'.$name);
		$page							= I('page');
		$rows							= I('rows');
		//echo $page;echo $rows;
		$p								= ($page - 1) * $rows;
		$result							= $M->limit($p,$rows)->where(array('isdel'=>1))->order($name.'_sort asc')->select();
		
		//echo $M->getLastSql();
//         echo $M->where(array('isdel'=>1))->count($name.'_id');
//         echo $M->getLastSql();
        
		$data ['rows'] = $result!=null?$result:[];
		$data ['total'] =  $M->where(array('isdel'=>1))->count($name.'_id');
		
		$this->ajaxReturn ( $data );
	}
	
	
	
	/**
	 * 字典添加
	 * 列表页模版的js函数命名需要加上ACTION_NAME用来判断是哪一个字典，否则js函数会重复，表单名要按字典名判断
	 */
	public function adddatalib(){
		if ($_FILES) {
			
			$arr						= array_keys($_FILES);
			import('ORG.Net.UploadFile');
			$upload						= new UploadFile();// 实例化上传类
			$upload->maxSize			= 3145728 ;// 设置附件上传大小
			$upload->allowExts			= array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			$upload->savePath			=  './Public/ybimg/';// 设置附件上传目录
			
			if(!$upload->upload()) {// 上传错误提示错误信息
				$this->ajaxReturn('错误',$upload->getErrorMsg(),false);
			}else{// 上传成功 获取上传文件信息
				$info					=  $upload->getUploadFileInfo();
				$upfile					= $info[0]['savepath'].$info[0]['savename'];
				$upfile					= substr($upfile,1);
				session('upfile',$upfile);
				session('typename',$arr[0]);
				$this->ajaxReturn('成功','图片上传成功',true);
			}
		}
		
		
		$name							= $this->_get('action');
		$M								= M('datalib'.$name);
		
		$create							= $M->create();
		//是否上传过图片信息
		$sessionupfile                  = session('upfile');
		if (!empty($sessionupfile)) {
			$create[session('typename')]= session('upfile');
		}
		$pinyin							= pinyin($create[$name.'_name'],UTF8);
		
		$create[$name.'_pinyin']		= $pinyin;
		
		$add							= $M->add($create);
		
		if ($add) {
			$this->ajaxReturn('添加成功','添加成功',true);
		}else {
			$this->ajaxReturn('添加失败','添加失败',false);
		}
	}
	
	
	/**
	 * 字典修改读取
	 * ajax全部用id传值，方法里面获取数据库的主键，用主键做查询条件,
	 */
	public function editDatalib(){
		$name							= $this->_get('action');
		$id								= $this->_get('id');
		$M								= M('datalib'.$name);
		$pk								= $M->getPk();
		$this->sel						= $M->where(array($pk=>$id))->find();
		$this->display($name.'add');
	}
	
	/**
	 * 字典修改保存
	 * 和添加基本上差不多
	 */
	public function editDatalibSubmit(){
		if ($_FILES) {
				
			$arr						= array_keys($_FILES);
			import('ORG.Net.UploadFile');
			$upload						= new UploadFile();// 实例化上传类
			$upload->maxSize			= 3145728 ;// 设置附件上传大小
			$upload->allowExts			= array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			$upload->savePath			=  './Public/ybimg/';// 设置附件上传目录
				
			if(!$upload->upload()) {// 上传错误提示错误信息
				$this->ajaxReturn('错误',$upload->getErrorMsg(),false);
			}else{// 上传成功 获取上传文件信息
				$info					=  $upload->getUploadFileInfo();
				$upfile					= $info[0]['savepath'].$info[0]['savename'];
				$upfile					= substr($upfile,1);
				session('upfile',$upfile);
				session('typename',$arr[0]);
				$this->ajaxReturn('成功','图片上传成功',true);
			}
		}
		$name							= $this->_get('action');
		$M								= M('datalib'.$name);
		$data							= $M->create();
		//是否上传过图片信息
		$sessionupfile                  = session('upfile');
		if (!empty($sessionupfile)) {
			$data[session('typename')]	= session('upfile');
		}
		$pinyin							= pinyin($data[$name.'_name'],UTF8);
		
		$data[$name.'_pinyin']			= $pinyin;
		
		$save							= $M->save($data);
		
		if (false!==$save) {
			$this->ajaxReturn('修改成功','修改成功',true);
		}else {
			$this->ajaxReturn('修改失败','修改失败',false);
		}
	}
	
	/**
	 * 删除数据字典操作
	 */ 
	public function delDatalib() {
		$name							= $this->_get('action');
		$M								= M('datalib'.$name);
		$id								= $this->_post('id');
		
		$map [$name.'_pid'] = array ('eq',	$id );
		$map['isdel']=array('eq',1);
		$r								= $M->where ( $map )->select ();
		if (count($r)>0) {
			$this->ajaxReturn ( false, '当前要删除的栏目有子节点,请先清空子节点!', false );
		} else {
			$mapb [$name.'_id']			= $id;
			$mapb['isdel']				= 0;
			
			$result						= $M->save ($mapb);
			//echo $M->getLastSql();
			if (false!==$result) {
				$this->ajaxReturn ( $r, '数据字典删除成功!', true );
			} else {
				$this->ajaxReturn ( $r, '数据字典删除失败!', false );
			}
		}
	}
	
	
	
	
	
	

	
	
	
	// 数据字典json数据,列表显示用.
// 	public function getDataLibJson() {
// 		$pid = $_POST ['id'];
// 		$pid = empty ( $pid ) ? 0 : $pid;
// 		$m = M ( 'Datalib' );
// 		$rs = $m->where ( 'pid=' . $pid )->order ( 'code asc' )->select ();
// 		/*
// 		 * for($i = 0; $i < count ( $rs ); $i ++) { if (! $rs [$i] ['pid'] == 0)
// 		 * { $rs [$i] ['_parentId'] = $rs [$i] ['pid']; } } $data ['total'] =
// 		 * count ( $rs ); $data ['rows'] = $rs;
// 		 */
// 		for($i = 0; $i < count ( $rs ); $i ++) {
// 			if (! $rs [$i] ['pid'] == 0) {
// 				$rs [$i] ['_parentId'] = $rs [$i] ['pid'];
// 			}
// 			$rs2 = $m->where ( 'pid=' . $rs [$i] ['id'] )->find ();
// 			$rs [$i] ['state'] = $rs2 ? 'closed' : 'open';
// 		}
		
// 		$data ['rows'] = $rs;
		
// 		$this->ajaxReturn ( $data );
// 	}
	// 添加数据字典窗口
// 	public function addDatalib() {
// 		$this->assign ( 'pid', $_GET ['pid'] );
// 		$this->display ();
// 	}
	// 添加数据字典动作
	public function addDatalibSubmit() {
		$m = M ( 'Datalib' );
		$form = $m->create ();
		$form ['createTime'] = toDate(time());
		if ($form ['text'] == '') {
			$this->ajaxReturn ( null, '名称不能为空!', false );
		} else if ($form ['code'] == '') {
			$this->ajaxReturn ( null, '编码不能为空!', false );
		} else {
			/* 检查是否在所要添加级内有同text和code */
			$mapa ['pid'] = array (
					'eq',
					$form ['pid'] 
			);
			$mapa ['text'] = array (
					'eq',
					$form ['text'] 
			);
			$mapb ['pid'] = array (
					'eq',
					$form ['pid'] 
			);
			$mapb ['code'] = array (
					'eq',
					$form ['code'] 
			);
			
			$rsa = $m->where ( $mapa )->select ();
			$rsb = $m->where ( $mapb )->select ();
			if ($rsa) {
				$this->ajaxReturn ( $rsa, '当前级下面名称已存在!', false );
			} else if ($rsb) {
				$this->ajaxReturn ( $rsb, '当前级下面编码已存在!', false );
			} else {
				$result = $m->data ( $form )->add ();
				if ($result) {
					$this->ajaxReturn ( $form, '数据字典添加成功!', true );
				} else {
					$this->ajaxReturn ( $form, '数据字典添加失败!', false );
				}
			}
		}
	}
// 	// 删除数据字典操作
// 	public function delDatalib() {
// 		$id = $_POST ['id'];
// 		$m = M ( 'Datalib' );
// 		$map ['pid'] = array (
// 				'eq',
// 				$id 
// 		);
// 		$r = $m->where ( $map )->select ();
// 		if ($r) {
// 			$this->ajaxReturn ( $r, '当前要删除的栏目有子节点,请先清空子节点!', false );
// 		} else {
// 			$mapb ['id'] = array (
// 					'eq',
// 					$id 
// 			);
// 			$result = $m->where ( $mapb )->delete ();
// 			if ($result) {
// 				writeOperationLog ( APP_NAME, MODULE_NAME, ACTION_NAME, '删除数据字典信息' );
// 				$this->ajaxReturn ( $r, '数据字典删除成功!', true );
// 			} else {
// 				$this->ajaxReturn ( $r, '数据字典删除失败!', false );
// 			}
// 		}
// 	}
	// 编辑数据字典窗口
// 	public function editDatalib() {
// 		$id = $_GET ['id'];
// 		$m = M ( 'Datalib' );
// 		$r = $m->find ( $id );
// 		if ($r) {
// 			$this->assign ( 'vo', $r );
// 		}
// 		$this->display ();
// 	}
// 	// 编辑数据字典操作
// 	public function editDatalibSubmit() {
// 		$m = M ( 'Datalib' );
// 		$form = $m->create ();
// 		$form ['updateTime'] = toDate(time());
// 		$result = $m->save ( $form );
// 		if ($result) {
// 			writeOperationLog ( APP_NAME, MODULE_NAME, ACTION_NAME, '编辑数据字典信息' );
// 			$this->ajaxReturn ( $result, '数据字典更新成功!', true );
// 		} else {
// 			$this->ajaxReturn ( $result, '数据字典更新失败!', false );
// 		}
// 	}

}