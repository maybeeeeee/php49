<?php
namespace Admin\Controller;
#use Think\Controller;
class EmailController extends CommonController
{
	public function _empty()
	{
		$this -> display('Empty/error');
	}
	
	public function send()
	{
		$model = M('User');
		$data = $model -> where('id != ' . session('uid')) -> select();
		$this -> assign('data',$data);
		#dump($data);die;
		$this -> display();
	}

	public function sendOk()
	{
		$post = I('post.');
		if ($_FILES['file']['size'] > 0) {
			$cfg = array(
				'rootPath' => WORKING_PATH . UPLOAD_ROOT_PATH
				);
			$upload = new \Think\Upload($cfg);
			$info = $upload -> uploadOne($_FILES['file']);
			if ($info) {
				$post['hasfile'] = 1;
				$post['filename'] = $info['name'];
				$post['file'] = UPLOAD_ROOT_PATH . $info['savepath'] . $info['savename'];
			}
		}
		$post['from_id'] = session('uid');
		$post['addtime'] = time();
		$model = M('Email');
		$rst = $model -> add($post);
		if ($rst) {
			$this -> success('邮件发送成功。', U('sendBox'), 2);
		} else {
			$this -> error('邮件发送失败。', U('send'), 2);
		}
	}

	public function sendBox()
	{
		#select t1.*,t2.truename as truename from tp_email as t1,tp_user as t2 where t1.to_id = t2.id and from_id = session('uid');
		$model = M();
		$data = $model -> field('t1.*,t2.truename as truename')
					   -> table('tp_email as t1,tp_user as t2')
					   -> where('t1.to_id = t2.id and from_id = ' . session('uid'))
					   -> select();
		$this -> assign('data', $data);
		$this -> display();
	}

	public function download()
	{
		$id = I('get.id');
		$model = M('Email');
		$data = $model -> find($id);
		$file = WORKING_PATH . $data['file'];
		header("Content-type: application/octet-stream");
		header('Content-Disposition: attachment; filename="' . basename($file) . '"');
		header("Content-Length: ". filesize($file));
		readfile($file);
	}

	public function del()
	{
		$id = I('get.id');
		$model = M('Email');
		$rst = $model -> where("id = $id and isread = 0 and from_id = " . session('uid')) -> delete();
		if ($rst) {
			$this -> success('撤回成功。', U('sendBox'), 2);
		} else {
			$this -> error('撤回失败。', U('sendBox'), 2);
		}
	}

	public function getContent()
	{
		$id = I('get.id');
		$model = M('Email');
		$data = $model -> find($id);
		echo $data['content'];
	}
}