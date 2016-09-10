<?php
namespace Admin\Model;
use Think\Model;
class DeptModel extends Model
{
	//开启批量验证
	protected $patchValidate = true;

	#自动验证规则
	// protected $_validate = array(
	// 		//验证字段,验证规则,错误提示,验证条件,附加规则,验证时间
	// 		#部门名称字段的验证
	// 		array('name','require','部门名称不能为空！'),
	// 		array('name','','部门名称已经存在！',0,'unique'),
	// 		#排序字段的验证，要求必须是数字
	// 		#array('sort','number','排序必须是数字！')
	// 		array('sort','is_numeric','排序必须是一个数字!',0,'function')
	// 	);
	
	protected $_map = array(
		'bumenmingcheng' => 'name',
		'paixu'			 => 'sort',
		'beizhu'		 => 'remark'
		);

	//测试自定义方法
	public function diy()
	{
		echo "this is model";
	}
}