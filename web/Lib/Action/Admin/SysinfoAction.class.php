<?php
/**
 * 
 * @author Mydaigy
 * 系统信息模板
 */
class SysinfoAction extends CommonAction {
	// 版本信息首页
	public function updateLog() {
		writeOperationLog ( APP_NAME, MODULE_NAME, ACTION_NAME, '查看更新日志' );
		$this->display ();
	}
	// 版本更新json数据
	public function getUpdateLog() {
		$page = $_POST ['page'];
		$rows = $_POST ['rows'];
		$m = M ( 'Updatelog' );
		$p = ($page - 1) * $rows;
		$c = $m->count ();
		$result = $m->limit ( $p, $rows )->order ( 'createTime desc' )->select ();
		$data ['rows'] = $result;
		$data ['total'] = $c;
		$data ['rows'] = intval ( $data ['total'] ) >= 1 ? $data ['rows'] : '';
		$this->ajaxReturn ( $data );
	}
	// 添加版本信息
	public function addUpdateLog() {
		$this->display ();
	}
	// 添加版本信息提交
	public function addUpdateLogSubmit() {
		$m = M ( 'Updatelog' );
		$data ['content'] = $_POST ['content'];
		$data ['copyright'] = $_POST ['copyright'];
		$data ['createTime'] = toDate(time());
		$data ['uid'] = session ( 'uid' );
		$result = $m->add ( $data );
		if ($result) {
			writeOperationLog ( APP_NAME, MODULE_NAME, ACTION_NAME, '添加更新日志' );
			$this->ajaxReturn ( $data, '添加升级日志成功!', true );
		} else {
			$this->ajaxReturn ( $data, '添加升级日志失败!', false );
		}
	}
	// 版本信息单页显示
	public function updateLogDisplay() {
		$m = M ( 'Updatelog' );
		$result = $m->find ( $_GET ['id'] );
		$this->assign ( 'log', $result );
		$this->display ();
	}
	// 删除版本信息操作
	public function delUpdateLog() {
		$rows = $_POST ['id'];
		
		for($i = 0; $i < count ( $rows ); $i ++) {
			$id [$i] = $rows [$i] ['id'];
		}
		$id = implode ( ',', $id );
		$m = M ( 'Updatelog' );
		$result = $m->delete ( $id );
		if ($result) {
			writeOperationLog ( APP_NAME, MODULE_NAME, ACTION_NAME, '删除更新日志' );
			$this->ajaxReturn ( $result, '删除日志成功!', true );
		} else {
			$this->ajaxReturn ( $result, '删除日志失败!', false );
		}
	}
	// 操作日志首页
	public function operationLog() {
		$this->display ();
	}
	// 删除操作日志
	public function delOperationLog() {
		$id = $_POST ['id'];
		$m = M ( 'Operationlog' );
		for($i = 0; $i < count ( $id ); $i ++) {
			$m->delete ( $id [$i] );
		}
		$this->ajaxReturn ( '', '删除操作日志成功!', true );
	}
	// 操作日志json数据
	public function getOperationLog() {
		$page = $_POST ['page'];
		$rows = $_POST ['rows'];
		$p = ($page - 1) * $rows;
		$m = M ( 'Operationlog' );
		$c = $m->count ();
		$result = $m->limit ( $p, $rows )->order ( 'createTime desc' )->select ();
		$data ['rows'] = $result;
		$data ['total'] = $c;
		$data ['rows'] = intval ( $data ['total'] ) >= 1 ? $data ['rows'] : '';
		$this->ajaxReturn ( $data );
	}
	/**
	 * 文本编辑器
	 */
	public function editor() {
		$this->assign ( 'appName', APP_NAME );
		$this->display ();
	}
}