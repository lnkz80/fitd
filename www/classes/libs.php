<?php 

class libs extends Core {
	protected $name;


	protected function get_lmenu(){
			echo '<div class="row"><div class="col-lg-2 col-md-4 col-sm-4 col-xs-4 mnucol">';
		//if (isset($_GET["cat"])){
		$section = $this->getdata('lib_typeof_equipment', 'names', 'id='.$_GET["cat"]);
	 	$text = $this->lmenu('Справочники', $this->name = array("location"=>"Локации", "companies"=>"Компании", "department"=>"Отделы", "contragents"=>"МОЛ", "operations"=>"Операции", "equipment"=>"Оборудование"), $_GET["cat"], "libs");
	  	//$sqltxt = $page->getdata();
		echo $text;
		//} 
  		echo '</div><div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 middlecol"></div>';
	}

	protected function libs_get($type, $curdb, $thead, $curflds, $lj=false) {
		$lj?$table = $this->getdata($curdb, $curflds, false, false, $lj):$table = $this->getdata($curdb);
		echo "<div class='formwrapper'>";
		echo "<h4>Справочник '".$this->name[$type]."'</h4>";
		echo "<hr />";
		//print_r($table);
		//echo "<p></p>";
		//print_r($curflds);
		// echo "<br>";
		//print_r($thead);
		//echo $this->getest($curdb, false, false, false, $lj);

		echo "<table class=\"table table-striped\" id=\"libtab\">";
		echo "<thead><tr>";
		$virtfields = array_keys(array_values($table)[0]);
		foreach ($thead as $th) {				
					echo "<th>".$th."</th>";		
			}
		echo "</tr></thead><tbody>";
		foreach ($table as $key => $value) {
			echo "<tr>";
			foreach ($virtfields as $fieldname) {				
					echo "<td>".$value[$fieldname]."</td>";		
			}
			echo "</tr>";
			
		}
		echo "</tbody><tfoot><td colspan='".count($curflds)."'></td></tfoot>";
		echo "</table>";

		echo "<h5>Добавить данные в справочник '".$this->name[$type]."'</h5>";
		echo "<hr />";
		echo "<span class=\"itemstatus\"></span>";
		echo "<form action=\"../modules/formshandler.php?go=libs&type=".$type."\" method='post' class='mineforms'>";
		echo "<label for=\"itemname\">Наименование :</label><input type='text' name='itemname' placeholder='Наименование'>";
		echo "<input type='submit' value='записать'>";
		echo "</form>";

		echo "</div>";
	}

	

	public function get_content (){
		
		echo '<div class="col-lg-9 col-md-7 col-sm-7 col-xs-7 contentcol">';
    	if ($_GET['go']=='location'){
    		$this->libs_get('location', 'lib_location', Array('#iD', 'Наименование'), Array('id', 'name'));
    	}
    	if ($_GET['go']=='companies'){
    		$this->libs_get($_GET['go'], 'lib_'.$_GET['go'], Array('#iD', 'Наименование', 'Полное наименование', 'Адрес', 'Реквизиты', 'Описание'), Array('id', 'name', 'fullname', 'address', 'requisites', 'description'));
    	}
    	if ($_GET['go']=='department'){
    		 //$this->libs_get($_GET['go'], 'lib_'.$_GET['go'], Array('#iD', 'Наименование', 'Расположение', 'Описание'), Array('lib_'.$_GET['go'].'.id', 'lib_'.$_GET['go'].'.name', 'lib_location.name', 'lib_'.$_GET['go'].'.description'), Array('lib_location', 'lib_location.id=lib_department.location'));
    		$this->libs_get($_GET['go'], 'lib_'.$_GET['go'], Array('#iD', 'Наименование', 'Расположение', 'Описание'), Array('lib_'.$_GET['go'].'.id as id', 'lib_'.$_GET['go'].'.name as name', 'lib_location.name as location', 'lib_'.$_GET['go'].'.description as description'), Array('lib_location', 'lib_location.id=lib_department.location'));
    	}
    	if ($_GET['go']=='contragents'){
    		$this->mol();
    	}
    	if ($_GET['go']=='operations'){
    		$this->operations();
    	}
    	if ($_GET['go']=='equipment'){
    		$this->equipments();
    	}
		echo '</div></div>';
	}
}

 ?>