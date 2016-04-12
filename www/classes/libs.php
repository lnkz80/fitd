<?php 

class libs extends Core {
	protected $name;
	protected $type;
	protected $table;
	protected $fflds;
	protected $t;


	protected function get_lmenu(){
			echo '<div class="row"><div class="col-lg-2 col-md-4 col-sm-4 col-xs-4 mnucol">';
		//if (isset($_GET["cat"])){
		$section = dbconn::getdata('lib_typeof_equipment', 'names', 'id='.$_GET["cat"]);
	 	$text = $this->lmenu('Справочники', $this->name = array("location"=>"Локации", "companies"=>"Компании", "department"=>"Отделы", "contragents"=>"МОЛ", "operations"=>"Операции", "equipment"=>"Оборудование"), $_GET["cat"], "libs");
	  	//$sqltxt = $page->getdata();
		echo $text;
		//} 
  		echo '</div><div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 middlecol"></div>';
	}

	protected function libs_get($type, $curdb, $thead, $curflds, $lj=false) {
		$this->type = $type;
		$lj?$this->table = dbconn::getdata($curdb, $curflds, false, false, $lj):$this->table = dbconn::getdata($curdb);
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
		
		$testform = new forms("post", "../modules/formshandler.php?go=libs&type=".$this->type, "form_".$this->type, "mineforms");
		$i=0;
		foreach ($this->fflds as $key => $value) {
			if ($value['fftype'] == "input"){				
				$fieldsprn .= $testform->inputs($value['label_for'], $value['label_text'], $value['type'], $value['name'], $value['placeholder']);
			}
			if ($value['fftype'] == "tarea"){
				$fieldsprn .= $testform->tarea($value['label_for'], $value['label_text'], $value['name'], $value['placeholder']);
			}
			if ($value['fftype'] == "select"){
				$fieldsprn .= $testform->select($value['selectname'], $value['dbtable']);
			}

		}	
		echo $fieldsprn;	
		//echo $testform->tarea("description", "Дополнительно", "description", "Дополнительные заметки");
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
    		$this->fflds = Array(Array("fftype"=>"input", "label_for"=>"itemname", "label_text"=>"Наименование", "type"=>"text", "name"=>"itemname", "placeholder"=>"Наименование"));

    		$this->libs_get('location', 'lib_location', Array('#iD', 'Наименование'), Array('id', 'name'));
    	}
    	if ($_GET['go']=='companies'){
    		$f_name = Array("fftype"=>"input", "label_for"=>"itemname", "label_text"=>"Наименование", "type"=>"text", "name"=>"itemname", "placeholder"=>"Наименование");
    		$f_fname = Array("fftype"=>"input","label_for"=>"fullitemname", "label_text"=>"Полное наименование", "type"=>"text", "name"=>"fullitemname", "placeholder"=>"Полное наименование");
    		$f_addr = Array("fftype"=>"input","label_for"=>"address", "label_text"=>"Адрес компании", "type"=>"text", "name"=>"address", "placeholder"=>"Укажите адрес");
    		$f_req = Array("fftype"=>"input","label_for"=>"req", "label_text"=>"Реквизиты компании", "type"=>"text", "name"=>"req", "placeholder"=>"Укажите реквизиты");
    		$f_descr = Array("fftype"=>"tarea","label_for"=>"description", "label_text"=>"Дополнительная информация", "name"=>"description", "placeholder"=>"Описание");
    		$this->fflds = Array($f_name, $f_fname, $f_addr, $f_req, $f_descr);
    		$this->libs_get($_GET['go'], 'lib_'.$_GET['go'], Array('#iD', 'Наименование', 'Полное наименование', 'Адрес', 'Реквизиты', 'Описание'), Array('id', 'name', 'fullname', 'address', 'requisites', 'description'));
    	}
    	if ($_GET['go']=='department'){
    		$f_name = Array("fftype"=>"input", "label_for"=>"itemname", "label_text"=>"Наименование", "type"=>"text", "name"=>"itemname", "placeholder"=>"Наименование");
    		$f_loc = Array("fftype"=>"select","selectname"=>"sel_loc", "dbtable"=>"location");
    		$this->fflds = Array($f_name, $f_loc);
    		$this->libs_get($_GET['go'], 'lib_'.$_GET['go'], Array('#iD', 'Наименование', 'Расположение', 'Описание'), Array('lib_'.$_GET['go'].'.id as id', 'lib_'.$_GET['go'].'.name as name', 'lib_location.name as location', 'lib_'.$_GET['go'].'.description as description'), dbconn::leftjoin(Array('lib_location'), Array('lib_location.id=lib_department.location')));
    	}
    	if ($_GET['go']=='contragents'){
    		$this->libs_get($_GET['go'], 'lib_'.$_GET['go'], Array('#iD', 'Наименование', 'Должность', 'Подразделение', 'Компания', 'Описание'), Array('lib_'.$_GET['go'].'.id as id', 'lib_'.$_GET['go'].'.name as name', 'lib_'.$_GET['go'].'.position as position', 'lib_department.name as department', 'lib_companies.name as compamy', 'lib_'.$_GET['go'].'.description as description'), dbconn::leftjoin(Array('lib_department', 'lib_companies'), Array('lib_contragents.dep_id=lib_department.id', 'lib_contragents.company_id=lib_companies.id')));
    	}
    	if ($_GET['go']=='operations'){
    		$this->libs_get($_GET['go'], 'lib_'.$_GET['go'], Array('#iD', 'Наименование', 'Тип оборудования'), Array('lib_'.$_GET['go'].'.id as id', 'lib_'.$_GET['go'].'.name as name', 'lib_typeof_equipment.names as enames'), dbconn::leftjoin(Array('lib_typeof_equipment'), Array('lib_'.$_GET['go'].'.type_id=lib_typeof_equipment.id')));
    	}
    	if ($_GET['go']=='equipment'){
    		$this->libs_get($_GET['go'], 'lib_'.$_GET['go'], Array('#iD', 'Наименование', 'Номер', 'Тип оборудования', 'Модель'), Array('lib_'.$_GET['go'].'.id as id', 'lib_'.$_GET['go'].'.name as name', 'lib_'.$_GET['go'].'.number as number', 'lib_typeof_equipment.names as enames', 'lib_'.$_GET['go'].'.model as model'), dbconn::leftjoin(Array('lib_typeof_equipment'), Array('lib_'.$_GET['go'].'.type=lib_typeof_equipment.id')));
    	}
		echo '</div></div>';
	}
}

 ?>