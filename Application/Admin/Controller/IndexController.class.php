<?php
namespace Admin\Controller;

#use Think\Controller;

class IndexController extends CommonController
{
	public function _empty()
	{
		$this -> display('Empty/error');
	}
	
    public function index()
    {
        $this->display();
    }

    public function home()
    {
    	$this->display();
    }
}