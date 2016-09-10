<?php
namespace Admin\Controller;
use Think\Controller;
class EmptyController extends Controller
{
	public function _empty()
	{
		#展示错误模版
		$this -> display('Empty/error');
	}
} 