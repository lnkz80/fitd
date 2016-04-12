<?php
require_once '../config.php';
require_once '../classes/Core.php';
require_once '../classes/units.php';

$core = new units;

if ($_POST){
	if($_GET['go']=='new'){
		$name = htmlspecialchars($_POST["itemname"]); 
		$number = htmlspecialchars($_POST["itemnumber"]);
		$model = htmlspecialchars($_POST["itemmodel"]);
		$cat = $_POST['type'];
		if (!$name or !$number or !$model) {
			$json['error'] = 'Вы зaпoлнили нe всe пoля! oбмaнуть рeшили? =)';
			echo json_encode($json);
			die();
		}

		if (!is_numeric($number)){
			$json['error'] = 'В поле НОМЕР указано не числовое значение!';
			echo json_encode($json);
			die();
		}
		
		$query = "INSERT INTO lib_equipment (name, number, type, model) VALUES ('$name', '$number', '$cat', '$model')";

		if(mysql_query($query)){
			$data = "Данные успешно внесены";
		}
		else {
			$data = "Ошибка запроса:".mysql_error();
		}
		//$data = "Данные успешно внесены";
		$json['data'] = $data;
		echo json_encode($json);
	}

	if($_GET['go']=='rec'){
		
		$date = $_POST['dateoper'];
		$e_id = $_POST['getunit'];
		$op_id = $_POST['opid'];
		$from = $_POST['from'];
		$to = $_POST['to'];
		$descr = $_POST['description'];
		
		$query = "INSERT INTO jrnl_equipment (date, equipment_id, operation_id, from_contragent_id, to_contragent_id, description) VALUES ('$date', '$e_id', '$op_id', '$from', '$to', '$descr')";

		if(mysql_query($query)){
			$data = "Данные успешно внесены";
		}
		else {
			$data = "Ошибка запроса:".mysql_error();
		}

		$json['data'] = $data;
		//$json['data'] = $date."; ".$e_id."; ".$op_id."; ".$from."; ".$to."; ".$descr;
		echo json_encode($json);
	}

	if($_GET['go']=='libs'){
		if($_GET['type']=='location'){
			$name = $_POST['itemname'];
			$query = "INSERT INTO lib_location (name) VALUES ('$name')";
			$query2 = "select * from lib_location ORDER BY id DESC LIMIT 1";
			if(mysql_query($query)){
			$data = "Данные успешно внесены";
			$res = mysql_query($query2);
			$array = mysql_fetch_array($res, MYSQL_ASSOC);
		}
		else {
			$data = "Ошибка запроса:".mysql_error();
		}
		$json['data'] = $data;
		$json['arr'] = $array;
		echo json_encode($json);
		}
	}
}
else {
	$json['error'] = 'GET LOST!';
	echo json_encode($json);
}

?>