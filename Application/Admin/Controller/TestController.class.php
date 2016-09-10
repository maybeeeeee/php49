<?php
namespace Admin\Controller;

use Think\Controller;
use Think\Verify;

class TestController extends Controller
{
	public function _empty()
	{
		$this -> display('Empty/error');
	}
	
	public function index()
	{
		$this -> display();
	}

	public function test1()
	{
		echo time();
	}

	public function test2()
	{
		echo U('index')."<br/>";
		echo U('Index/index')."<br/>";
		echo U('index', array('id' => 1));
	}

	public function test3()
	{
		$this -> success('执行成功！', U('test2'), 2);
	}

	public function test4()
	{
		$this -> error('执行失败！', U('test2'), 2);
	}

	public function test5()
	{
		$date = date('Y-m-d H:i:s', time());
		$this -> assign('date', $date);
		$this -> display();
	}

	public function test6()
	{
		$this -> display();
	}

	public function test42()
	{
		$model = M('Dept');
		$data = $model -> fetchSql(true) -> where('id > 1') -> limit(2) ->select();
		dump($data);
	}

	public function test45()
	{
		gbk2utf8();
	}

	public function test46()
	{
		test_fun();
	}

	public function test47()
	{
		load('@/info');
		getInfo();
	}

	public function test48()
	{
		$cfg = array(
			'fontSize'  =>  14,              // 验证码字体大小(px)
	        'useCurve'  =>  false,           // 是否画混淆曲线
	        'useNoise'  =>  false,           // 是否添加杂点	
	        'imageH'    =>  0,               // 验证码图片高度
	        'imageW'    =>  0,               // 验证码图片宽度
	        'length'    =>  4,               // 验证码位数
	        'fontttf'   =>  '6.ttf',         // 验证码字体，不设置随机获取)
        );
		$verify = new Verify($cfg);
		$verify -> entry();
	}

	public function test49()
	{
		$cfg = array(
			'useZh'     =>  true,           // 使用中文验证码
			'useImgBg'  =>  false,           // 使用背景图片
			'fontSize'  =>  25,              // 验证码字体大小(px)
	        'useCurve'  =>  false,           // 是否画混淆曲线
	        'useNoise'  =>  false,           // 是否添加杂点
	        'length'    =>  4,               // 验证码位数
        );
		$verify = new Verify($cfg);
		$verify -> entry();
	}

	public function test50()
	{
		$model = M();
		$data = $model -> field('t1.*,t2.name as deptname') -> table('tp_user as t1,tp_dept as t2') -> where('t1.dept_id = t2.id') -> select();
		dump($data);
	}

	public function test51()
	{
		$model =M('Dept');
		$data = $model -> field('t1.*,t2.name as deptname') -> alias('t1') -> join('left join tp_dept as t2 on t1.pid = t2.id') -> select();
		dump($data);
	}

	public function test53()
	{
		$i = I('get.id');
		$ip = new \Org\Net\IpLocation('qqwry.dat');
		$data = $ip -> getlocation($i);
		dump($data);
	}
}