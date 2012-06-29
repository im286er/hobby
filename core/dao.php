<?php
/*
 *@dao基类
 */
class Dao{
	var $config;
	var $connect;

	function __construct() {
		$this->config=load_conf("db");
		$this->dbconnect($this->host,$this->username,$this->password);
	}

	function dbconnect($host="",$username="",$password="") {
		if(!$this->connect=@mysql_connect($this->config["host"],$this->config["username"],$this->config["password"]),1){
			return false;
		}

		@mysql_query("set names 'utf8'");
		
	}
	
}