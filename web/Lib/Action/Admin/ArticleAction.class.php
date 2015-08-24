<?php
/**
 * 
 * @author kaifeng(添加了修改方法)
 * 文章管理模块,把之前别人写的拿过来改了改
 */
class ArticleAction extends CommonAction {
	// 文章管理首页
	public function index() {
		$this->display ();
	}
	// 返回文章列表
	public function getArticleJson() {
		$columnId = $_POST ['columnId'];
		$page = $_POST ['page'];
		$rows = $_POST ['rows'];
		$p = ($page - 1) * $rows;
		$m = M ();
		if ($columnId == '') {
			$sql = 'SELECT * FROM `dr_article` a order by createTime desc';
		} else {
			$sql = 'SELECT * FROM `dr_article` a where a.column=' . $columnId . ' order by createTime desc';
		}
		$sqlLimit = $sql . ' limit ' . $p . ',' . $rows . '';
		$result = $m->query ( $sqlLimit );
		$data ['rows'] = $result;
		$data ['total'] = count ( $m->query ( $sql ) );
		$this->ajaxReturn ( $data );
	}
	// 起草文章面板
	public function qcArticleDialog() {
		$this->display ();
	}
	// 文章添加操作
	public function addArticleSubmit() {
		$data ['title'] = $_POST ['title'];
		$data ['column'] = $_POST ['cid'];
		$data ['source'] = $_POST ['source'];
		$data ['content'] = $_POST ['content'];
		$data ['createTime'] = toDate ( time () );
		
		$m = M ( 'article' );
		$result = $m->add ( $data );
		if ($result) {
			$this->ajaxReturn ( '成功', '文章发布成功!', true );
		} else {
			$this->ajaxReturn ( '失败', '文章发布失败!', false );
		}
	}
	
	
	
	// 文章修改操作
	public function changeArticleSubmit() {
		$data ['title'] = $_POST ['title'];
		$data ['source'] = $_POST ['source'];
		$data ['content'] = $_POST ['content'];
	
		$m = M ( 'article' );
		$result = $m->where(array('id'=>$this->_post('id')))->save( $data );
// 		/echo $m->getLastSql();
		if ($result) {
			$this->ajaxReturn ( '成功', '文章修改成功!', true );
		} else {
			$this->ajaxReturn ( '失败', '文章修改失败!', false );
		}
	}
	
	
	
	

	
	
	public function change(){
		$db								= M('article');
		$sel							= $db->where(array('id'=>$this->_get('id')))->field(array('id','title','source','content'))->select();
		$this->assign(array('sel'=>$sel,'id'=>$this->_get('id')))->dispArticle();
	}
	
	// 删除文章操作
	public function delArticleSubmit() {
		$rows = $_POST ['rows'];
		for($i = 0; $i < count ( $rows ); $i ++) {
			$id [$i] = $rows [$i] ['id'];
		}
		$id = implode ( ',', $id );
		$m = M ( 'article' );
		$result = $m->delete ( $id );
		if ($result) {
			$this->ajaxReturn ( '成功', '文章删除成功!', true );
		} else {
			$this->ajaxReturn ( '失败', '文章删除失败!', false );
		}
	}
	// 文本编辑器页
	public function editor() {
		$db								= M('article');
		$sel							= $db->where(array('id'=>$this->_get('con')))->select();
		$this->assign('con',$sel[0]['content'])->display ();
	}
	// 查看文章页
	public function dispArticle() {
		$id = $_GET ['id'];
		$m = M ();
		$sql = 'SELECT * FROM `dr_article` WHERE id=' . $id . '';
		$result = $m->query ( $sql );
		$this->assign ( 'vo', $result[0] ); 
		$this->display();
	}
}