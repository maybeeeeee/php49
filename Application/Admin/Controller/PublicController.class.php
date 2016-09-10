<?php
namespace Admin\Controller;

use Think\Controller;
use Think\Verify;

class PublicController extends Controller
{

	public function login()
	{
		$this -> display();
	}

	public function captcha()
	{
		$cfg = array(
			'fontSize'  =>  10,              // 验证码字体大小(px)
	        'useCurve'  =>  false,           // 是否画混淆曲线
	        'useNoise'  =>  false,           // 是否添加杂点	
	        'imageH'    =>  40,               // 验证码图片高度
	        'imageW'    =>  70,               // 验证码图片宽度
	        'length'    =>  4,               // 验证码位数
	        'fontttf'   =>  '4.ttf',         // 验证码字体，不设置随机获取)
        );
		$verify = new Verify($cfg);
		$verify -> entry();
	}

	public function check()
	{
		$post = I('post.');
		$verify = new Verify();
		$rst = $verify -> check($post['captcha']);
		if ($rst) {
			$model = M('User');
			unset($post['captcha']);
			$data = $model -> where($post) -> find();
			if ($data) {
				session('uid',$data['id']);
				session('uname',$data['username']);
				session('role_id',$data['role_id']);
				$this -> success('登陆成功。', U('Index/index'), 2);
			} else {
				$this -> error('登录失败。', U('login'), 2);
			}
		} else {
			$this -> error('验证码错误。', U('login'), 2);
		}
	}

	public function logout()
	{
		session(null);
		if (!session('?uid')) {
			$this -> success('退出成功。', U('login'), 2);
		}
	}
}