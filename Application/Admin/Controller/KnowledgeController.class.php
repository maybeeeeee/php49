<?php
namespace Admin\Controller;
#use Think\Controller;
class KnowledgeController extends CommonController
{
	public function _empty()
	{
		$this -> display('Empty/error');
	}
	
	public function add()
	{
		$this -> display();
	}

	public function addOk()
	{
		$post = I('post.');
		if ($_FILES['thumb']['size'] > 0) {
			$cfg = array(
				'rootPath' => WORKING_PATH . UPLOAD_ROOT_PATH
				);
			$upload = new \Think\Upload($cfg);
			$info = $upload -> uploadOne($_FILES['thumb']);
			if ($info) {
				$post['picture'] = UPLOAD_ROOT_PATH . $info['savepath'] . $info['savename'];
				$image = new \Think\Image();
				$image -> open(WORKING_PATH . $post['picture']);
				$image -> thumb(100,100);
				$image -> save(WORKING_PATH . UPLOAD_ROOT_PATH .$info['savepath'] . 'thumb' .$info['savename']);
			}
		}
		$post['addtime'] = time();
		$model = M('Knowledge');
		$rst = $model -> add($post);
		if ($rst) {
			$this -> success('添加成功。', U('showList'), 2);
		} else {
			$this -> error('你人品有问题。', U('add'), 2);
		}
	}

	public function showList()
	{
		$model = M('Knowledge');
		$data = $model -> select();
		$this -> assign('data',$data);
		$this -> display();
	}

	public function edit()
	{
		$id = I('get.id');
		$model = M('Knowledge');
		$data = $model -> find($id);
		$this -> assign('data',$data);
		$this -> display();
	}

	public function editOk()
	{
		$post = I('post.');
		if ($_FILES['thumb']['size'] > 0) {
			$cfg = array(
				'rootPath' => WORKING_PATH . UPLOAD_ROOT_PATH
				);
			$upload = new \Think\Upload($cfg);
			$inof = $upload -> uploadOne($_FILES['file']);
			if ($info) {
				$post['picture'] = UPLOAD_ROOT_PATH . $info['savepath'] . $info['savename'];
				$image = new \Think\Image();
				$image -> open(WORKING_PATH . $post['picture']);
				$image -> thumb(100,100);
				$image -> save(WORKING_PATH , UPLOAD_ROOT_PATH . $info['savepath'] . 'thumb_' . $info['savename']);
				$post['thumb'] = UPLOAD_ROOT_PATH . $info['savepath'] . 'thumb_' . $info['savename'];
			}
		}
		$model = M('Knowledge');
		$rst = $model -> save($post);
		if ($rst) {
		 	$this -> success('编辑成功。', U('showList'), 2);
		 } else {
		 	$this -> error('编辑失败。', U('edit', array('id' => $post['id'])), 2);
		 }
	}
}