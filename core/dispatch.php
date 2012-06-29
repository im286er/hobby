<?php
/*
 *@框架路由类
 *@author usual2970
 */
class Dispatch{
	//初始化控制器，方法
	static function init(){
		if(get_magic_quotes_gpc()){
			$_REQUEST=self::deep_stripslashes($_REQUEST);
		}
		if(isset($_REQUEST["c"]) && !$_REQUEST["c"]=="") $GLOBALS["control"]=$_REQUEST["c"];
		else $GLOBALS["control"]="index";

		if (false === preg_match('/^[a-z0-9_-]+$/i', $GLOBALS['control'])) {
			Umsg("无效的控制器".$GLOBALS["control"]);
		}
		
		if(isset($_REQUEST["a"]) && !$_REQUEST["a"]=="") $GLOBALS["action"]=$_REQUEST["a"];
		else $GLOBALS["action"]="index";

		if (false === preg_match('/^[a-z0-9_-]+$/i', $GLOBALS['action'])) {
			Umsg("无效的ACTION".$GLOBALS["action"]);
		}


	}
	//执行控制器，方法
	static function start(){
		load_control($GLOBALS["control"]);
		$control=ucfirst($GLOBALS["control"])."Control";
		if(!class_exists($control)){
			Umsg("控制器类不存在".$control);
		}
		$instance=new $control;
		$action=$GLOBALS["action"];
		if(!method_exists($instance,$action)){
			Umsg("ACTION不存在".$action);
		}
		$instance->$action();
	}

	//去除转义符
	static function deep_stripslashes($query){
		$result=is_array($query)?array_map("deep_stripslashes",$query):stripslashes($query);
		return $result;
	}




}