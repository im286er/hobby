<?php
class IndexControl extends Control{
	function __construct(){
		parent::__construct();
	}

	function index(){
		$this->assign("test","hello world");
		$this->display("index.tpl");

	}
	function test(){

		echo "you are not along;";
	
	}



}
