<?php
class AdminControl extends Control{

	function index(){
		$site_url=site_url();
		load_view("admin_head",array("site_url"=>$site_url));
		load_view("admin_main",array("site_url"=>$site_url));
		load_view("admin_foot",array("site_url"=>$site_url));
	}
	function test(){

		echo "you are not along;";
	
	}



}
