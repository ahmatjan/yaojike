<?php
/**
 * @author Mydaigy
 * 个人面板模块
 */
class SelfPanelAction extends CommonAction {
	// 登录信息页
	public function loginInfo() {
		$m = M ( 'User' );
		$rs = $m->find ( session ( C ( 'USER_AUTH_KEY' ) ) );
		$this->assign ( 'vo', $rs );
		$this->display ();
	}
	// 基本信息页
	public function baseInfo() {
		$uid = session ( 'uid' );
		$m = M ( 'UserBaseinfo' );
		$rs = $m->find ( $uid );
		$rs ['icon'] = $rs ['icon'] == null ? '__PUBLIC__/Uploads/icons/icon.jpg' : '__PUBLIC__/Uploads/icons/thumb_' . $rs ['icon'];
		$this->assign ( 'vo', $rs );
		$this->display ();
	}
	// 编辑基本信息窗口
	public function editBaseInfo() {
		$uid = $_GET ['uid'];
		$m = M ( 'UserBaseinfo' );
		$rs = $m->where ( 'uid="' . $uid . '"' )->find ();
		$this->assign ( 'vo', $rs );
		$this->display ();
	}
	// 编辑基本信息提交
	public function editBaseInfoSubmit() {
		$user = M ( 'UserBaseinfo' );
		$form = $user->create ();
		$form ['xbCode'] = getDatalibCode ( $form ['xbCode'] );
		$form ['zzmmCode'] = getDatalibCode ( $form ['zzmmCode'] );
		$form ['mzCode'] = getDatalibCode ( $form ['mzCode'] );
		$form ['jgCode'] = getDatalibCode ( $form ['jgCode'] );
		$form ['depCode'] = getDatalibCode ( $form ['depCode'] );
		$form ['xkgsxyCode'] = getDatalibCode ( $form ['xkgsxyCode'] );
		$form ['updateTime'] = toDate(time());
		$result = $user->save ( $form );
		if ($result) {
			writeOperationLog ( APP_NAME, MODULE_NAME, ACTION_NAME, '编辑基本信息' );
			$this->ajaxReturn ( $form, '基本信息更新成功!', true );
		} else {
			$this->ajaxReturn ( $form, '基本信息更新失败!', false );
		}
	}
	// 更新个人头像窗口
	public function updataIcon() {
		$this->assign ( 'size', C ( 'UPLOAD_ICON_SIZE' ) / 1024 );
		$this->assign ( 'uid', $_GET ['uid'] );
		$this->display ();
	}
	// 更新个人头像提交
	public function updataIconSubmit() {
		$upload = new UploadFile ();
		/* 文件大小单位以字节为单位 */
		$upload->maxSize = C ( 'UPLOAD_ICON_SIZE' );
		$upload->allowExts = array (
				'jpg' 
		);
		$upload->thumb = true;
		$upload->thumbMaxWidth = '200';
		$upload->thumbMaxHeight = '270';
		$upload->savePath = '../Public/Uploads/icons/';
		if (! $upload->upload ()) {
			$info = $upload->getErrorMsg ();
			echo '{"data":"' . $info . '","info":"' . $info . '","status":false}';
			/* $this->ajaxReturn ( $info, '更新失败', false ); */
		} else {
			$info = $upload->getUploadFileInfo ();
			$m = M ( 'UserBaseinfo' );
			$data ['icon'] = $info [0] ['savename'];
			$result = $m->where ( 'uid="' . $_POST ['uid'] . '"' )->save ( $data );
			if ($result) {
				writeOperationLog ( APP_NAME, MODULE_NAME, ACTION_NAME, '更新头像' );
				echo '{"data":"' . $result . '","info":"Profile updated!","status":true}';
				/* $this->ajaxReturn ( $result, '更新成功', true ); */
			} else {
				echo '{"data":"' . $result . '","info":"Profile update failed!","status":false}';
				/* $this->ajaxReturn ( $result, '更新失败', false ); */
			}
		}
	}
	// 密码修改
	public function pwdChange() {
		$this->display ();
	}
	// 密码修改提交
	public function pwdChangeSubmit() {
		$oldPwd = $_POST ['oldPwd'];
		$newPwd = $_POST ['newPwd'];
		$rePwd = $_POST ['rePwd'];
		if (empty ( $oldPwd ) or empty ( $newPwd ) or empty ( $rePwd )) {
			$this->ajaxReturn ( null, '表单信息填写不完整,请重试!', false );
		} else if ($newPwd == $rePwd) {
			$m = M ( 'User' );
			$result = $m->field ( 'pwd' )->find ( session ( C ( 'USER_AUTH_KEY' ) ) );
			if (md5 ( $oldPwd ) == $result ['pwd']) {
				$data ['id'] = session ( C ( 'USER_AUTH_KEY' ) );
				$data ['pwd'] = md5 ( $newPwd );
				$data ['update_time'] = toDate(time());
				$r = $m->save ( $data );
				if ($r) {
					writeOperationLog ( APP_NAME, MODULE_NAME, ACTION_NAME, '密码修改' );
					$this->ajaxReturn ( $result, '密码更新成功!', true );
				} else {
					$this->ajaxReturn ( $result, '密码更新失败!', false );
				}
			} else {
				$this->ajaxReturn ( $result, '原始密码错误,请重试!', false );
			}
		} else {
			$this->ajaxReturn ( null, '两次密码不一致,请重试!', false );
		}
	}
	/**
	 * 异步加载数据字典
	 * code:字典名称的代码
	 */
	public function asyncDatalibTree() {
		$m = M ( 'Datalib' );
		$code = $m->where ( 'code="' . $_GET ['code'] . '"' )->find ();
		// 字典的ID
		$id = $code ['id'];
		$id = isset ( $_POST ['id'] ) ? intval ( $_POST ['id'] ) : $id;
		$rs = $m->where ( 'pid=' . $id )->select ();
		for($i = 0; $i < count ( $rs ); $i ++) {
			$data [$i] ['id'] = $rs [$i] ['id'];
			$data [$i] ['text'] = $rs [$i] ['text'];
			// 判断是否有子节点
			if ($m->where ( 'pid=' . $rs [$i] ['id'] )->find ()) {
				$data [$i] ['state'] = 'closed';
			}
		}
		$this->ajaxReturn ( $data );
	}
	/**
	 * 数据字典选择页面
	 */
	public function datalibSelect() {
		$this->assign ( 'code', $_GET ['code'] );
		$this->display ();
	}
	/**
	 * 数据字典选择页面的数据字典json数据
	 */
	public function getDatalibSelectJson() {
		$m = M ( 'Datalib' );
		$codeId = getDatalibIdfCode ( $_GET ['code'] );
		$page = $_POST ['page'];
		$rows = $_POST ['rows'];
		$map ['pid'] = array (
				'eq',
				$codeId 
		);
		$map ['code'] = array (
				'like',
				'%' . $_POST ['codeValue'] . '%' 
		);
		$map ['text'] = array (
				'like',
				'%' . $_POST ['textValue'] . '%' 
		);
		$p = ($page - 1) * $rows;
		$result = $m->limit ( $p, $rows )->field ( 'id,code,text' )->where ( $map )->order ( 'code asc' )->select ();
		$count = $m->where ( $map )->count ();
		$data ['rows'] = $result;
		$data ['total'] = $count;
		$this->ajaxReturn ( $data );
	}
	/**
	 * 学院选择面板
	 */
	public function xySelectPanel() {
		$this->display ();
	}
	/**
	 * 学院选择面板
	 * 获取学院数据
	 */
	public function getXyJson() {
		$m = M ();
		$sql = 'SELECT * FROM ip_datalib WHERE pid=1 ORDER BY code';
		$result = $m->query ( $sql );
		$data ['rows'] = $result;
		$data ['total'] = count ( $result );
		$this->ajaxReturn ( $data );
	}
}