<?php
namespace Admin\Controller;
#use Think\Controller;
class DocController extends CommonController
{
	public function _empty()
	{
		$this -> display('Empty/error');
	}

	public function add(){
		$this -> display();
	}

	public function addOk(){
		$post = I('post.');
		#获取文件的数据
		$file = $_FILES['file'];
		#配置上传信息
		$cfg = array(
			//保存根路径
			'rootPath'      =>  WORKING_PATH . UPLOAD_ROOT_PATH,
		);
		#实例化上传类
		$uplaod = new \Think\Upload($cfg);
		#上传操作
		if($file['size'] > 0){
			$info = $uplaod -> uploadOne($file);//一维数组
			#判断返回结果
			if($info){
				#hasfile字段
				$post['hasfile'] = 1;
				#filename字段
				$post['filename'] = $info['savename'];
				#filepath字段
				$post['filepath'] = UPLOAD_ROOT_PATH . $info['savepath'] . $info['savename'];
			}
		}
		#添加addtime字段
		$post['addtime'] = time();
		#写入数据表
		$model = M('Doc');
		$rst = $model -> add($post);
		if($rst){
			$this -> success('添加公文成功',U('showList'),3);
		}else{
			$this -> error('添加公文失败',U('add'),3);
		}
	}

	public function showList(){
		$model = M('Doc');
		$data = $model -> select();
		$this -> assign('data',$data);
		$this -> display();
	}

	public function download(){
		$id = I('get.id');
		$model = M('Doc');
		$data = $model -> find($id);
		$file = WORKING_PATH . $data['filepath'];
		header("Content-type: application/octet-stream");
		header('Content-Disposition: attachment; filename="' . basename($file) . '"');
		header("Content-Length: ". filesize($file));
		readfile($file);
	}

	public function getContent(){
		$id = I('get.id');
		$model = M('Doc');
		$data = $model -> find($id);
		echo htmlspecialchars_decode($data['content']);
	}

	public function edit()
	{
		$id = I('get.id');
		$model = M('Doc');
		$data = $model -> find($id);
		$this -> assign('data', $data);
		$this -> display();
	}

	public function editOk()
	{
		$post = I('post.');
		if ($_FILES['file']['size'] > 0) {
			$cfg = array(
				'rootPath' => WORKING_PATH . UPLOAD_ROOT_PATH
				);
			$upload = new \Think\Upload($cfg);
			$info = $upload -> uploadOne($_FILES['file']);
			if ($info) {
				$post['filepath'] = UPLOAD_ROOT_PATH . $info['savepath'] . $info['savename'];
				$post['filename'] = $info['savename'];
				$post['hasfile'] = 1;
			}
		}
		$model = M('Doc');
		$rst = $model -> save($post);
		if ($rst) {
			$this -> success('编辑成功。', U('showList'), 2);
		} else {
			$this -> error('编辑失败。', U('edit', array('id' => $post['id'])), 2);
		}
	}
}