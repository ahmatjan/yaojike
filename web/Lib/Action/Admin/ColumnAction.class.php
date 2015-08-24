<?php
/**
 * 
 * @author 之前别人写的，栏目添加的时候是无限极添加，但显示的是只显示了三级，改为只有一级栏目,前端还是传所有的数据，只是在后台全部设为一级
 * 栏目管理模块
 */
class ColumnAction extends CommonAction {
	// 栏目管理模块
	public function index() {
		$this->display (); 
	}
	// 返回栏目列表数据，以treegrid方式层级显示
	public function getColumnJson() {
		$m = M ();
		$sql = 'SELECT a.id,a.pid,a.text,a.state,a.status,a.sort,a.url FROM `dr_column` a where a.pid=0 ORDER BY `sort`';
		$result = $m->query ( $sql );
		//dump($result);
		for($i = 0; $i < count ( $result ); $i ++) {
			if (ifChildren ( $result [$i] ['id'] )) {
				$result [$i] ['children'] = childrenRows ( $result [$i] ['id'] );
				$result [$i] ['state'] = 'closed';
// 				for($j = 0; $j < count ( $result [$i] ['children'] ); $j ++) {
// 					if (ifChildren ( $result [$i] ['children'] [$j] ['id'] )) {
// 						$result [$i] ['children'] [$j] ['children'] = childrenRows ( $result [$i] ['children'] [$j] ['id'] );
// 						$result [$i] ['children'] [$j] ['state'] = 'closed';
// 						for($k = 0; $k < count ( $result [$i] ['children'] [$j] ['children'] ); $k ++) {
// 							if (ifChildren ( $result [$i] ['children'] [$j] ['children'] [$k] ['id'] )) {
// 								$result [$i] ['children'] [$j] ['children'] [$k] ['children'] = childrenRows ( $result [$i] ['children'] [$j] ['children'] [$k] ['id'] );
// 								$result [$i] ['children'] [$j] ['children'] [$k] ['state'] = 'closed';
// 							}
// 						}
// 					}
// 				}
			}
		}
		$this->ajaxReturn ( $result );
	}
	// 新增栏目页面
	public function addColumnPanel() {
		$this->display ();
	}
	// 新增栏目提交
	public function addColumnSubmit() {
		$data ['text'] = $_POST ['text'];
		$data ['url'] = $_POST ['url'];
		$data ['pid'] = 0;
		$data ['createTime'] = toDate ( time () );
		if ($data ['text'] == '') {
			$this->ajaxReturn ( '提示', '栏目名称不能为空！', false );
		} elseif ($data ['url'] == '') {
			$this->ajaxReturn ( '提示', '链接地址不能为空！', false );
		} else {
			$m = M ( 'column' );
			$result = $m->add ( $data );
			if ($result) {
				$this->ajaxReturn ( '成功', '栏目新增成功！', true );
			} else {
				$this->ajaxReturn ( '失败', '数据库操作失败！', false );
			}
		}
	}
	// 编辑栏目面板
	public function editColumnPanel() {
		$id = $_GET ['id'];
		$m = M ( 'column' );
		$result = $m->find ( $id );
		if ($result ['status'] == 1) {
			$result ['status'] = '<option value="1"	selected="selected">显示</option><option value="0">不显</option>';
		} else {
			$result ['status'] = '<option value="1">显示</option><option value="0"selected="selected">不显</option>';
		}
		$this->assign ( 'vo', $result );
		$this->display ();
	}
	// 编辑栏目提交
	public function editColumnSubmit() {
		$data ['text'] = $_POST ['text'];
		$data ['url'] = $_POST ['url'];
		$data ['status'] = $_POST ['status'];
		$data ['sort'] = $_POST ['sort'];
		$data ['id'] = $_POST ['id'];
		$data ['updateTime'] = toDate ( time () );
		
		$m = M ( 'column' );
		$result = $m->save ( $data );
		
		if ($result) {
			$this->ajaxReturn ( '成功', '更新栏目成功！', true );
		} else {
			$this->ajaxReturn ( '失败', '更新栏目失败！', false );
		}
	}
	// 删除栏目提交
	public function delColumnSubmit() {
		$id = $_POST ['id'];
		$m = M ( 'column' );
		if (ifChildren ( $id )) {
			$this->ajaxReturn ( '失败', '该栏目有子栏目，请先删除子栏目！', false );
		} else {
			$result = $m->delete ( $id );
			if ($result) {
				$this->ajaxReturn ( '成功', '删除栏目成功！', true );
			} else {
				$this->ajaxReturn ( '失败', '删除栏目失败！', false );
			}
		}
	}
}