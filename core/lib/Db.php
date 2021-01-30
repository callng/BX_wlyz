<?php
namespace core\lib;
class Db {
	private $server;
	private $pre;
	private static $instance;
	public static function getInstance() {
		if(empty(self::$instance)) {
			self::$instance=new self();
		}
		return self::$instance;
	}
	private function __clone() {
	}
	private function __construct() {
		try {
			$this -> server = new \PDO('mysql:host=' . Config::get('db.host') . ';port=' . Config::get('db.port') . ';dbname=' . Config::get('db.name'), Config::get('db.user'), Config::get('db.pw'));
			$this -> server -> setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$this -> server -> exec("set names utf8");
			$this -> pre = Config::get('db.tablepre');
		}
		catch(\PDOException $e) {
			exit($e -> getMessage());
		}
	}
	public function sql($query) {
		try {
			$Model = $this -> server -> prepare($query);
			$Model -> execute();
			$m_data = $Model -> fetchAll(\PDO::FETCH_ASSOC);
			return $m_data;
		}
		catch(\PDOException $e) {
			exit($e -> getMessage());
		}
	}
	public function insert($table, $array,$is_lastInsertId=FALSE) {
		try {
			$into = "";
			$val = array();
			$insert_num = 0;
			$create_method = '';
			foreach ($array as $key => $value) {
				$into .= "{$key},";
				$val[] = $value;
				$insert_num++;
			}
			for ($i = 0; $i < $insert_num; $i++) {
				$create_method .= '?,';
			}
			$create_method = rtrim($create_method, ",");
			$into = rtrim($into, ",");
			$Model = $this -> server -> prepare("insert into {$this -> pre}{$table} ({$into}) values ({$create_method})");
			$exe = $Model -> execute($val);
			if (!$is_lastInsertId) {
				return $exe;
			} else {
				$method_id = $this -> server -> lastInsertId();
				return $method_id;
			}
		}
		catch (\PDOException $e) {
			exit($e -> getMessage());
		}
	}
	public function select($table,$where = '', $join = '', $desc = '', $limit = '',$field = '') {
		try {
			$ifwhere = '';
			$order = '';
			$desc_limit = '';
			if (! empty($where)) {
				$ifwhere = "where {$where}";
			}
			if (! empty($desc)) {
				$order = "order by {$desc} desc";
			}
			if (! empty($limit)) {
				$desc_limit = "limit {$limit}";
			}
			empty($field) ? $field = "*" : FALSE;
			$sql = "SELECT {$field} FROM {$this -> pre}{$table} {$join} {$ifwhere} {$order} {$desc_limit}";
			$sql = str_replace('pre_',$this -> pre, $sql);
			$Model = $this->server->prepare($sql);
			$Model->execute();
			$m_data = $Model->fetchAll(\PDO::FETCH_ASSOC);
			return $m_data;
		}
		catch (\PDOException $e) {
			exit($e -> getMessage());
		}
	}
	public function update($table,$array, $where = '') {
		try {
			$data = "";
			$update_data = array();
			$ifwhere = '';
			foreach ($array as $key => $value) {
				$data .= "{$key}=?,";
				$update_data[] = $value;
			}
			$data = rtrim($data, ",");
			if (! empty($where)) {
				$ifwhere = "where {$where}";
			}
			$Model = $this->server->prepare("update {$this -> pre}{$table} set {$data} {$ifwhere}");
			$exe = $Model->execute($update_data);
			return $exe;
		}
		catch (\PDOException $e) {
			exit($e -> getMessage());
		}
	}
	public function delete($table,$where = '') {
		try {
			if (! empty($where)) {
				$ifwhere = "where {$where}";
			}
			$Model = $this->server->prepare("DELETE FROM {$this -> pre}{$table} {$ifwhere}");
			$del = $Model->execute();
			return $del;
		}
		catch (\PDOException $e) {
			exit($e -> getMessage());
		}
	}
	public function openTransaction() {
		$this->server->beginTransaction();
	}
	public function commit() {
		$this->server->commit();
	}
	public function rollBack() {
		$this->server->rollBack();
	}
	public function __destruct() {
		$this -> server = null;
	}
}
?>