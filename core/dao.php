<?php
/*
 *@dao基类
 */
class Dao{
	var $config;
	var $connect;

	function __construct() {
		$this->config=load_conf("db");
		$this->_dbconnect($this->host,$this->username,$this->password);
	}

	//CURD中的READ
	function read($data, $table, $where = '', $limit = '', $order = ''){
		$where = $where == '' ? '' : ' WHERE '.$where;
		$order = $order == '' ? '' : ' ORDER BY '.$order;
		$group = $group == '' ? '' : ' GROUP BY '.$group;
		$limit = $limit == '' ? '' : ' LIMIT '.$limit;
		$field = explode(',', $data);
		array_walk($field, array($this, 'add_special_char'));
		$data = implode(',', $field);

		$sql = 'SELECT '.$data.' FROM `'.$this->config['database'].'`.`'.$table.'`'.$where.$group.$order.$limit;
		$rs=$this->_execute($sql);
		if(!is_resource($rs)) return $rs;

		$datalist = array();
		while(($rs = $this->_fetch_next()) != false) {
			if($key) {
				$datalist[$rs[$key]] = $rs;
			} else {
				$datalist[] = $rs;
			}
		}
		$this->_free_result($rs);
		return $datalist;

	}
	//CURD中的UPDATE
	public function update($data, $table, $where = '') {
		if($table == '' or $where == '') {
			return false;
		}

		$where = ' WHERE '.$where;
		$field = '';
		if(is_string($data) && $data != '') {
			$field = $data;
		} elseif (is_array($data) && count($data) > 0) {
			$fields = array();
			foreach($data as $k=>$v) {
				switch (substr($v, 0, 2)) {
					case '+=':
						$v = substr($v,2);
						if (is_numeric($v)) {
							$fields[] = $this->_add_special_char($k).'='.$this->_add_special_char($k).'+'.$this->_escape_string($v, '', false);
						} else {
							continue;
						}
						
						break;
					case '-=':
						$v = substr($v,2);
						if (is_numeric($v)) {
							$fields[] = $this->_add_special_char($k).'='.$this->_add_special_char($k).'-'.$this->_escape_string($v, '', false);
						} else {
							continue;
						}
						break;
					default:
						$fields[] = $this->_add_special_char($k).'='.$this->_escape_string($v);
				}
			}
			$field = implode(',', $fields);
		} else {
			return false;
		}

		$sql = 'UPDATE `'.$this->config['database'].'`.`'.$table.'` SET '.$field.$where;
		return $this->_execute($sql);
	}
	//CURD 中的DELETE
	public function delete($table, $where) {
		if ($table == '' || $where == '') {
			return false;
		}
		$where = ' WHERE '.$where;
		$sql = 'DELETE FROM `'.$this->config['database'].'`.`'.$table.'`'.$where;
		return $this->_execute($sql);
	}

	//insert应该也属于UPDATE
	function insert($data, $table, $return_insert_id = false, $replace = false) {
		if(!is_array( $data ) || $table == '' || count($data) == 0) {
			return false;
		}
		
		$fielddata = array_keys($data);
		$valuedata = array_values($data);
		array_walk($fielddata, array($this, 'add_special_char'));
		array_walk($valuedata, array($this, 'escape_string'));
		
		$field = implode (',', $fielddata);
		$value = implode (',', $valuedata);

		$cmd = $replace ? 'REPLACE INTO' : 'INSERT INTO';
		$sql = $cmd.' `'.$this->config['database'].'`.`'.$table.'`('.$field.') VALUES ('.$value.')';
		$return = $this->_execute($sql);
		return $return_insert_id ? $this->_last_insert_id() : $return;
	}

	/**
	 * 遍历查询结果集
	 * @param $type		返回结果集类型	
	 * 					MYSQL_ASSOC，MYSQL_NUM 和 MYSQL_BOTH
	 * @return array
	 */
	function _fetch_next($type=MYSQL_ASSOC) {
		$res = mysql_fetch_array($this->lastqueryid, $type);
		if(!$res) {
			$this->free_result();
		}
		return $res;
	}
	
	/**
	 * 释放查询资源
	 * @return void
	 */
	function _free_result($rs) {
		if(is_resource($rs)) {
			mysql_free_result($rs);
		}
	}

	//建立数据库连接
	function _dbconnect($host="",$username="",$password="") {
		if(!$this->connect=@mysql_connect($this->config["host"],$this->config["username"],$this->config["password"]),1){
			return false;
		}

		@mysql_query("set names 'utf8'");

		if($this->config["database"] && !@mysql_select_db($this->config["database"],$this->connect)){
			return false;
		}
		return $this->connect();
	}
	
	//执行SQL语句
	function _execute($sql){
		if(!is_resource($this->connect)){
			$this->dbconnect();
		}
	
		return @mysql_query($sql,$this->connect);
	}

	//返回上一次执行的SQL影响的行数
	function _affected_rows(){
		if(!is_resource($this->connect)){
			$this->dbconnect();
		}
		return @mysql_affected_rows($this->connect);
	
	}

	//返回上一次执行INSERT产生的ID
	function _last_insert_id(){
		if(!is_resource($this->connect)){
			$this->dbconnect();
		}
		return @mysql_insert_id($this->connect);
	
	
	}



	/**
	 * 对字段两边加反引号，以保证数据库安全
	 * @param $value 数组值
	 */
	function _add_special_char(&$value) {
		if('*' == $value || false !== strpos($value, '(') || false !== strpos($value, '.') || false !== strpos ( $value, '`')) {
			//不处理包含* 或者 使用了sql方法。
		} else {
			$value = '`'.trim($value).'`';
		}
		return $value;
	}
	
	/**
	 * 对字段值两边加引号或空格，以保证数据库安全
	 * @param $value 数组值
	 * @param $key 数组key
	 * @param $quotation 
	 */
     function _escape_string(&$value, $key='', $quotation = 1) {
		if ($quotation) {
			$q = '\'';
		} else {
			$q = '';
		}
		$value = $q.$value.$q;
		return $value;
	}
}