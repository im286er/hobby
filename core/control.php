<?php
/*
 *@控制器基类
 */

class Control{
	protected function out_result($data=array()) {
		if(!$data){
			$data=array();
			echo json_encode($data);
		}
		echo json_encode($data);
		exit();
	}
	protected function out_error($data) {
		echo json_encode($data);
		exit();
	}
}


?>