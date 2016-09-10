<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>测试6</title>
</head>
<body>
	/Public：指静态资源文件夹路径（Public）<br/>
	/index.php/Admin：从域名后面开始寻找，一直找到分组名为止<br/>
	/index.php/Admin/Test：从域名后面开始寻找，一直找到控制器名为止<br/>
	/index.php/Admin/Test/test6：从域名后面开始寻找，一直找到方法名为止<br/>
	/index.php/Admin/Test/test6：从域名后面开始寻找，一直找到最后<br/>
</body>
</html>