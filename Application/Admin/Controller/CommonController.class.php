<?php
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$uid = session('uid');
		if (empty($uid)) {
			$url = U('Public/login');
			$script = "<script>top.location.href='$url';</script>";
			echo $script;die;
		}
	}
}