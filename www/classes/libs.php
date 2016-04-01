<?php 

class libs extends Core {
	protected $name;
	protected $type;
	protected $table;

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
		$this->type = $type;
		$lj?$this->table = $this->getdata($curdb, $curflds, false, false, $lj):$this->table = $this->getdata($curdb);
		echo "<div class='formwrapper'>";
		echo "<h4>Справочник '".$this->name[$this->type]."'</h4>";
		echo "<hr />";
		//print_r($table);
		//echo "<p></p>";
		//print_r($curflds);
		// echo "<br>";
		//print_r($thead);
		//echo $this->getest($curdb, false, false, false, $lj);
		//echo $this->leftjoin(Array(), Array());
		echo "<table class=\"table table-striped\" id=\"libtab\">";
		echo "<thead><tr>";
		$virtfields = array_keys(array_values($this->table)[0]);
		foreach ($thead as $th) {				
					echo "<th>".$th."</th>";		
			}
		echo "</tr></thead><tbody>";
		foreach ($this->table as $key => $value) {
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
		// echo "<form action=\"../modules/formshandler.php?go=libs&type=".$type."\" method='post' class='mineforms'>";
		// echo "<label for=\"itemname\">Наименование :</label><input type='text' name='itemname' placeholder='Наименование'>";
		// echo "<input type='submit' value='записать'>";
		// echo "</form>";
		$this->get_forms($curdb);

		$testform = new forms("post", "../modules/formshandler.php?go=libs&type=".$this->type,"test", "mineforms");
		echo $testform->inputs("Test", "For testing something...", $type, "test", "placeholder");
		echo $testform->sbmt();
		echo "</div>";
	}

	protected function get_forms ($dbtable, $fields=false){
		//print_r($this->table);
		echo "<form action=\"../modules/formshandler.php?go=libs&type=".$this->type."\" method='post' class='mineforms'>";
		echo "<label for=\"itemname\">Наименование :</label><input type='text' name='itemname' placeholder='$dbtable'>";
		echo "<input type='submit' value='записать'>";
		echo "</form>";

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
    		$this->libs_get($_GET['go'], 'lib_'.$_GET['go'], Array('#iD', 'Наименование', 'Расположение', 'Описание'), Array('lib_'.$_GET['go'].'.id as id', 'lib_'.$_GET['go'].'.name as name', 'lib_location.name as location', 'lib_'.$_GET['go'].'.description as description'), $this->leftjoin(Array('lib_location'), Array('lib_location.id=lib_department.location')));
    	}
    	if ($_GET['go']=='contragents'){
    		$this->libs_get($_GET['go'], 'lib_'.$_GET['go'], Array('#iD', 'Наименование', 'Должность', 'Подразделение', 'Компания', 'Описание'), Array('lib_'.$_GET['go'].'.id as id', 'lib_'.$_GET['go'].'.name as name', 'lib_'.$_GET['go'].'.position as position', 'lib_department.name as department', 'lib_companies.name as compamy', 'lib_'.$_GET['go'].'.description as description'), $this->leftjoin(Array('lib_department', 'lib_companies'), Array('lib_contragents.dep_id=lib_department.id', 'lib_contragents.company_id=lib_companies.id')));
    	}
    	if ($_GET['go']=='operations'){
    		$this->libs_get($_GET['go'], 'lib_'.$_GET['go'], Array('#iD', 'Наименование', 'Тип оборудования'), Array('lib_'.$_GET['go'].'.id as id', 'lib_'.$_GET['go'].'.name as name', 'lib_typeof_equipment.names as enames'), $this->leftjoin(Array('lib_typeof_equipment'), Array('lib_'.$_GET['go'].'.type_id=lib_typeof_equipment.id')));
    	}
    	if ($_GET['go']=='equipment'){
    		$this->libs_get($_GET['go'], 'lib_'.$_GET['go'], Array('#iD', 'Наименование', 'Номер', 'Тип оборудования', 'Модель'), Array('lib_'.$_GET['go'].'.id as id', 'lib_'.$_GET['go'].'.name as name', 'lib_'.$_GET['go'].'.number as number', 'lib_typeof_equipment.names as enames', 'lib_'.$_GET['go'].'.model as model'), $this->leftjoin(Array('lib_typeof_equipment'), Array('lib_'.$_GET['go'].'.type=lib_typeof_equipment.id')));
    	}
		echo '</div></div>';
	}
}

 ?>