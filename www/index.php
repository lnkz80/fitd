<?php 
require_once 'config.php';
require_once 'classes/dbconn.php';
require_once 'classes/Core.php';
require_once 'classes/forms.php';
//include 'classes/ContentPage.php';
// include 'tpl/head.php';
// include 'tpl/main.php';
// include 'tpl/foot.php';
if($_GET['m']){
	$class=trim($_GET['m']);
}
else {
	$class="main";
}
if(file_exists("classes/".$class.".php")){
	include ("classes/".$class.".php");
	if (class_exists($class)){
		$obj = new $class;
		$obj->get_body();
	}
	else {
		exit("Нет данных для входа");
	}
}
else {
	exit("Неверный адрес!");
}
 ?>