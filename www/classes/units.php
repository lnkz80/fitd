<?php 

class units extends Core {

	protected function get_lmenu(){
			echo '<div class="row"><div class="col-lg-2 col-md-4 col-sm-4 col-xs-4 mnucol">';
		//if (isset($_GET["cat"])){
		$section = dbconn::getdata('lib_typeof_equipment', 'names', 'id='.$_GET["cat"]);
	 	$text = $this->lmenu($section[0]['names'], array("new"=>"Новый", "nolink"=>"Журнал", "journ_sub"=>array("rec"=>"запись", "view"=>"просмотр")), $_GET["cat"], "units");
	  	//$sqltxt = $page->getdata();
		echo $text;
		//} 
  		echo '</div><div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 middlecol"></div>';
	}

	protected function newunits (){
		
	}

	private $name;

	protected function newitem() {
		$name = dbconn::getdata('lib_typeof_equipment', 'name', 'id='.$_GET["cat"]);
		$name = mb_strtolower($name[0]['name'], 'UTF-8');
		echo "<div class='formwrapper'>";
		echo "<h4>Новый $name</h4>";		
		echo "<hr />";
		echo "<span class=\"itemstatus\"></span>";
		echo "<form action=\"../modules/formshandler.php?go=new\" method='post' class='mineforms'>";
		echo "<label for=\"itemname\">Наименование :</label><input type='text' name='itemname' placeholder='Наименование'>";
		echo "<label for=\"itemnumber\">Номер:</label><input type='text' name='itemnumber' placeholder='Номер'>";
		echo "<label for=\"itemmodel\">Модель:</label><input type='text' name='itemmodel' placeholder='Модель'>";
		echo "<input type='submit' value='записать'>";
		echo "</form>";
		echo "</div>";
	}

	private function viewjournal() {
		echo "<h3>VIEW</h3>";
	}

	private function recitem() {
		$name = dbconn::getdata('lib_typeof_equipment', 'name', 'id='.$_GET["cat"]);
		$name = mb_strtolower($name[0]['name'], 'UTF-8');
		echo "<div class='formwrapper'>";
		echo "<h4>Добавить запись в журнал</h4>";		
		echo "<hr />";
		echo "<span class=\"itemstatus\"></span>";
		echo "<form action=\"../modules/formshandler.php?go=rec\" method='post' class='mineforms'>";

		echo "<label for=\"itemname\">Дата:</label><input type='text' id=\"datepicker\" name='dateoper' value='".date('Y-m-d')."'>";
		echo "<label for=\"itemselect\">Выбрать $name: </label><br /><select name=\"getunit\" id=\"\">";
			$arr = dbconn::getdata('lib_equipment', false, 'type='.$_GET["cat"], 'number');
			//print_r ($arr);
			foreach ($arr as $key => $value) {
				echo "<option value=".$value['id'].">".$value['number']." - ".$value['name']." ".$value['model']."</option>";
			}

		// $query4 = "SELECT * FROM lib_equipment ORDER BY number asc";
		// $result4 = mysql_query($query4);
		// while ($arr4 = mysql_fetch_array($result4)){
		// 	echo "<option value=".$arr4['id'].">".$arr4['name']." (".$arr4['number'].")</option>";
		// }

		echo "</select>";
		$db = dbconn::getInstance();
$mysqli = $db->getConnection();

		echo "<label for=\"itemselect\">Выбрать действие с $name: </label><br /><select id=\"test\" name='opid'>";
		$query = "SELECT lib_operations.id as opid, lib_operations.name as opname, lib_typeof_equipment.name as unitname FROM lib_typeof_equipment LEFT JOIN lib_operations ON lib_operations.type_id=lib_typeof_equipment.id WHERE lib_typeof_equipment.id=".$_GET["cat"];
		$result = mysqli_query($mysqli, $query);
		while ($arr = mysqli_fetch_array($result)){
			echo "<option value=".$arr['opid'].">".$arr['opname']."</option>";
		}		

		// while ($arr=mysql_fetch_array(mysql_query($query))){
		// 	echo "<option>".$arr['opname']."</option>";
		// }

		echo "</select>";
		// echo "<label for=\"itemselect\">От: </label><br /><select name='from'>";
		// $query2 = "SELECT * FROM lib_contragents";
		// $result2 = mysqli_query($mysqli, $query2);
		// while ($arr2 = mysqli_fetch_array($result2)){
		// 	echo "<option value=".$arr2['id'].">".$arr2['name']." (".$arr2['position'].")</option>";
		// }
		// echo "</select>";

		$arr = dbconn::getdata('lib_contragents');
		echo "<label for=\"itemselect\">От: </label><br /><select name='from'>";
		foreach ($arr as $key => $value) {
			echo "<option value=".$value['id'].">".$value['name']." (".$value['position'].")</option>";
		}
		echo "</select>";

		
		echo "<label for=\"itemselect\">Кому: </label><br /><select name='to'>";
		foreach ($arr as $key => $value) {
			echo "<option value=".$value['id'].">".$value['name']." (".$value['position'].")</option>";
		}
		echo "</select>";

		echo "<label>Пометки:</label><textarea rows='7' name='description'></textarea>";

		//echo "<label for=\"itemnumber\">Номер:</label><input type='text' name='itemnumber' placeholder='Номер'>";
		//echo "<label for=\"itemmodel\">Модель:</label><input type='text' name='itemmodel' placeholder='Модель'>";
		echo "<input type='submit' value='записать'>";
		echo "</form>";
		echo "</div>";
	}

	public function get_content (){
		//$this->newunits();
		echo '<div class="col-lg-9 col-md-7 col-sm-7 col-xs-7 contentcol">';
    	if ($_GET['go']=='new'){
    		$this->newitem();
    	}
    	if ($_GET['go']=='view'){
    		$this->viewjournal();
    	}
    	if ($_GET['go']=='rec'){
    		$this->recitem();
    	}
		echo '</div></div>';
	}
}

 ?>