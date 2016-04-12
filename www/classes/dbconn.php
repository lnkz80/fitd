<?php 

class dbconn {


private $_connection;
private static $_instance;

public static function getInstance (){
	if (!self::$_instance){
		self::$_instance = new self();
	}
	return self::$_instance;
}

public function __construct (){
	$this->_connection = new mysqli (HOST, USER, PASS, DB);
	$this->_connection->set_charset("utf8");
	if(mysqli_connect_error()){
		trigger_error('Ошибка при подключении к базе данных: '.mysqli_connect_error(), E_USER_ERROR);
	}
}

private function __clone(){}

public function getConnection(){
	return $this->_connection;
}

static function leftjoin ($tarr, $farr){			
			foreach ($tarr as $key => $value) {
				$ljoinout.=" LEFT JOIN ".$value." ON ".$farr[$key];
			}
			return $ljoinout;
		}

public function getdata($table, $fields=false, $param=false, $sort=false, $lj=false){

	if(!$fields){
		$sql="SELECT * FROM ".$table;
	}
	else {
		if(is_array($fields)){
			$fld = implode(", ", $fields);
			$sql = "SELECT ".$fld." FROM ".$table;
		}
		else {
			$sql = "SELECT ".$fields." FROM ".$table;
		}
	}
	
	if ($lj){
		$sql.=$lj;
	}
	
	if($param){
		$sql.=" WHERE ".$param;
	}
	if($sort){
			$sql.=" ORDER BY ".$sort;
		}
	$db = dbconn::getInstance();
	$mysqli = $db->getConnection();
	$res=mysqli_query($mysqli, $sql);
	
	if (!$res){
		return FALSE;
	}
		
		for ($i=0; $i < mysqli_num_rows($res); $i++){
			$row[]=mysqli_fetch_assoc($res);
		}

	return $row;
}



		// protected $db;
		// function __construct(){
		// 	$this->db=mysql_connect(HOST, USER, PASS);
		// 	if (!$this->db){			 
		// 	exit("No connection with database!");
		// 	}
		// 	if(!mysql_select_db(DB, $this->db)){
		// 		exit("No table!");
		// 	}
		// 	mysql_query("SET NAMES utf8");
		// }

		// protected function leftjoin ($tarr, $farr){			
		// 	foreach ($tarr as $key => $value) {
		// 		$ljoinout.=" LEFT JOIN ".$value." ON ".$farr[$key];
		// 	}
		// 	return $ljoinout;
		// }

		// public function getdata($table, $fields=false, $param=false, $sort=false, $lj=false){

		// if(!$fields){
		// 	$sql="SELECT * FROM ".$table;
		// }
		// else {
		// 	if(is_array($fields)){
		// 		$fld = implode(", ", $fields);
		// 		$sql = "SELECT ".$fld." FROM ".$table;
		// 	}
		// 	else {
		// 		$sql = "SELECT ".$fields." FROM ".$table;
		// 	}
		// }
		
		// if ($lj){
		// 	$sql.=$lj;
		// }
		
		// if($param){
		// 	$sql.=" WHERE ".$param;
		// }
		// if($sort){
		// 		$sql.=" ORDER BY ".$sort;
		// 	}
		
		// $res=mysql_query($sql);
		
		// if (!$res){
		// 	return FALSE;
		// }
			
		// 	for ($i=0; $i < mysql_num_rows($res); $i++){
		// 		$row[]=mysql_fetch_array($res, MYSQL_ASSOC);
		// 	}

		// 	return $row;
		// }

		// public function getest($table, $fields=false, $param=false, $sort=false, $lj=false){
		
		// if(!$fields){
		// 	$sql="SELECT * FROM ".$table;
		// }

		// else {
		// 	if(is_array($fields)){
		// 		$fld = implode(", ", $fields);
		// 		$sql = "SELECT ".$fld." FROM ".$table;
		// 	}
		// 	else {
		// 		$sql = "SELECT ".$fields." FROM ".$table;
		// 	}
		// }
		
		// if ($lj){
		// 	$sql.=$lj;			
		// }
		
		// if($param){
		// 	$sql.=" WHERE ".$param;
		// }

		// if($sort){
		// 		$sql.=" ORDER BY ".$sort;
		// 	}		
		
		// 	return $sql;
		// }

}

 ?>