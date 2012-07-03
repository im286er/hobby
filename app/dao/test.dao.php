<?php
class TestDao extends Dao{
	function test(){
		return $this->read("*","emlog_blog");
	
	}
	
}
