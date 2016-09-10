<?php
namespace Admin\Controller;

#use Think\Controller;

class UserController extends CommonController
{
	public function _empty()
	{
		$this -> display('Empty/error');
	}
	
	public function add()
	{
		$model = M('Dept');
		$data = $model -> select();
		$this -> assign('data', $data);
		$this -> display();
	}

	public function addOk()
	{
		$post = I('post.');
		$post['addtime'] = time();
		$model = M('User');
		$model -> create($post);
		$rst = $model -> add();
		if ($rst) {
			$this -> success('添加成功。', U('showList'), 2);
		} else {
			$this -> error('添加失败。', U('add'), 2);
		}
	}

	public function showList()
	{
		$model = M('User');
		$count = $model -> count();
		$page = new \Think\Page($count,1);
		$page -> rollPage = 3;
		$page -> lastStuffix = false;
		$page -> setConfig('prev', '上一页');
		$page -> setConfig('next', '下一页');
		$page -> setConfig('first', '首页');
		$page -> setConfig('last', '末页');
		$show = $page -> show();
		
		$data = $model -> limit($page -> firstRow, $page -> listRows) -> select();
		$this -> assign('show', $show);
		$this -> assign('data', $data);
		$this -> display();
	}

	public function charts()
	{
		$model = M();
		$data = $model -> field('t2.name as deptname, count(*) as count')
				-> table('tp_user as t1, tp_dept as t2')
				-> where('t1.dept_id = t2.id')
				-> group('deptname')
				-> select();
		$str = '[';
		foreach ($data as $key => $value) {
			$str .= "['" . $value['deptname'] . "'," . $value['count'] . "],";
		}
		$str = rtrim($str,',');
		$str .= ']';
		$this -> assign('str', $str);
		$this ->display();
	}
}