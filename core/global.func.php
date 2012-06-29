<?php

/*
 *@自动加载类库
 *@author usual2970
 */
function __auto_load($class){
	$class=strtolower($class);
	$file=UPATH."/library/".$class.".php";
	if(!file_exists($file)){
		Umsg("调用了未定义的类!");
	}
	require_once($file);

}

/*
 *@加载配置
 *@author usual2970
 */
function load_conf($config){
	$config=strtolower($config);	
	$file=UPATH."/data/config/".$config.".php";
	if(!file_exists($file)) return false;
	require_once($file);
}

/*
 *@加载控制器文件
 *@author usual2970
 */
function load_control($control){
	$control=strtolower($control);
	$file=UPATH."/app/control/".$control.".ctrl.php";
	if(!file_exists($file)) Umsg("控制器文件不存在".$file);
	require_once($file);
}

/*
 *@加载模型
 *@author usual2970
 */
function load_model($model){
	$model=strtolower($model);
	$file=UPATH."/app/model/".$model.".model.php";
	if(!file_exists($file)) Umsg("模型不存在");
	require_once($file);
}

/*
 *@调用某个模型的方法
 */
function modcall($model,$func){
	load_model($model);
	$class=ucfirst($model)."."."Model";

	if(!class_exists($class)){
		Umsg("模型无效");
	}
	$instance=new $class;

	if(!method_exists($instance,$func)){
		Umsg("该模型不存在方法");
	}
	
	$instance->$func();

}

/*
 *@加载视图
 */
 function load_view($__file, $__data = null, $__print = true){
        
	$file=UPATH."/app/view/".$__file.".view.php";
	if(!file_exists($file)) Umsg("视图不存在");
	ob_start();
	require_once($file);
	$__ob_content = ob_get_contents();
	ob_end_clean();

	!defined("__OUTVIEW__") && define("__OUTVIEW__", 1);
	if(!is_null($__data))
	{
		if(is_array($__data))
		{
			foreach ($__data as $__key => $__value)
			{
				if (!isset($$__key) )
				{
					$$__key = $__value;
				}
			}
		}
		else if(is_object($__data))		//将类属性转化为变量
		{
			$__data = get_object_vars($__data);
		}
		else
		{
			trigger_error(__FUNCTION__ . ' 函数的第2个参数必须是数组或者类', E_USER_NOTICE);
		}
	}

	if($__print)
	{
		if($GLOBALS["cookie"])
		{
			header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
			//header('P3P: CP="NOI DEV PSA PSD IVA PVD OTP OUR OTR IND OTC"');
			foreach($__core_env["cookie"] as $cn => $cv)
			{
				@setcookie($cn, $cv["value"], $cv["expire"], $cv["path"], $cv["domain"]);
			}
		}
		unset($__core_env["cookie"]);

		header("Content-type:text/html;charset=utf-8");
		echo $__ob_content;
	} else return $__ob_content;
 }

/**
 * @显示系统信息
 *
 * @param string $msg 信息
 * @param string $url 返回地址
 * @param boolean $isAutoGo 是否自动返回 true false
 */
function Umsg($msg, $url='javascript:history.back(-1);', $isAutoGo=false){
	if ($msg == '404') {
		header("HTTP/1.1 404 Not Found");
		$msg = '抱歉，你所请求的页面不存在！';
	}
	echo <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
EOT;
	if($isAutoGo){
		echo "<meta http-equiv=\"refresh\" content=\"2;url=$url\" />";
	}
	echo <<<EOT
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>emlog system message</title>
<style type="text/css">
<!--
body {
	background-color:#F7F7F7;
	font-family: Arial;
	font-size: 12px;
	line-height:150%;
}
.main {
	background-color:#FFFFFF;
	font-size: 12px;
	color: #666666;
	width:650px;
	margin:60px auto 0px;
	border-radius: 10px;
	padding:30px 10px;
	list-style:none;
	border:#DFDFDF 1px solid;
}
.main p {
	line-height: 18px;
	margin: 5px 20px;
}
-->
</style>
</head>
<body>
<div class="main">
<p>$msg</p>
<p><a href="$url">&laquo;点击返回</a></p>
</div>
</body>
</html>
EOT;
	exit;
}