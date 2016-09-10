<?php
namespace Admin\Controller;
#use Think\Controller;
class DeptController extends CommonController
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
		$model = M('Dept');
		$model -> create();
		//判断数据对象的返回结果
		if (!$rst) {
			$this -> error($model -> getError(), U('add'), 2);exit;
		}
		$rst = $model -> add();
		if($rst){
			$this -> success('添加成功',U('showList'),3);
		}else{
			$this -> error('添加失败',U('add'),3);
		}
	}

	public function showList()
	{
		$model = M('Dept');
		$data = $model -> select();
		foreach ($data as $key => $value) {
			if ($value['pid'] > 0) {
				$info = $model -> find($value['pid']);
				$data[$key]['parentName'] = $info['name'];
			}
		}
		load('@/tree');
		$data = getTree($data);
		$this -> assign('data', $data);
		$this->display();
	}

	public function del()
	{
		$ids = I('get.ids');
		$model = M('Dept');
		$rst = $model -> delete($ids);
		if ($rst) {
			$this -> success('删除成功。', U('showList'), 2);
		} else {
			$this -> error('删除失败。', U('showList'), 2);
		}
	}

	public function edit()
	{
		$id = I('get.id');
		$model = M('Dept');
		$data = $model -> find($id);
		$info = $model -> select();
		$this -> assign('data', $data);
		$this -> assign('info', $info);
		$this -> display();
	}

	public function editOk()
	{
		$post = I('post.');
		$model = M('Dept');
		$rst = $model -> save($post);
		if ($rst !== false) {
			$this -> success('修改成功。', U('showList'), 2);
		} else {
			$this -> error('修改失败。', U('edit',array('id' => $post['id'])), 2);
		}
	}
}