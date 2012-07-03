<?php
class IndexControl extends Control{

	function index(){
		load_view("test",array("test"=>"hello world"));
	}
	function test(){

		echo "you are not along;";
	
	}



}
