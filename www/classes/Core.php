<?php 
	abstract class Core {
		protected $db;
		function __construct(){
			$this->db=mysql_connect(HOST, USER, PASS);
			if (!$this->db){			 
			exit("No connection with database!");
			}
			if(!mysql_select_db(DB, $this->db)){
				exit("No table!");
			}
			mysql_query("SET NAMES utf8");
		}

		protected function leftjoin ($tarr, $farr){
			//SELECT lib_contragents.name,  lib_contragents.position, lib_contragents.dep_id, lib_department.name, lib_contragents.company_id, lib_companies.name FROM lib_contragents LEFT JOIN lib_department ON lib_contragents.dep_id=lib_department.id LEFT JOIN lib_companies ON lib_contragents.company_id=lib_companies.id
			
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
		
		$res=mysql_query($sql);
		
		if (!$res){
			return FALSE;
		}
			
			for ($i=0; $i < mysql_num_rows($res); $i++){
				$row[]=mysql_fetch_array($res, MYSQL_ASSOC);
			}

			return $row;
		}

		public function getest($table, $fields=false, $param=false, $sort=false, $lj=false){
		
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
		
			return $sql;
		}

		public function insertdata($q){
			$result = mysql_query($q) or die("Invalid query: " . mysql_error());
			// for ($i=0; $i < mysql_num_rows($result); $i++){
			// 	$row[] = mysql_fetch_array($result, MYSQL_ASSOC);
			// }
			// return $row;
		}

		protected function get_head(){
			include "tpl/head.php";
		}

		protected function get_menu(){
			echo '<div class="row navig">
  			<div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12">
		  	<nav class="hor">
		  		<ul class="nav nav-pills">
		  			<li><a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Оборудование <span class="caret"></span></a>
		        <ul class="dropdown-menu">';
		    $ttt = $this->getdata('lib_typeof_equipment');
		    foreach ($ttt as $key=>$value){
		    	echo "<li><a href='index.php?m=units&cat=".$value['id']."'>".$value['names']."</a></li>";
		          }		     
		    echo '</ul>
		        </li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Документы <span class="caret"></span>
					</a>
					    <ul class="dropdown-menu">
				    		<li><a href="#">Option 1</a></li>
							<li><a href="#">Option 2</a></li>
							<li><a href="#">Option 3</a></li>  
					    </ul>
				<!-- <a href="#"></a> -->

				</li>';
					// <li><a href="#">Основные средства</a></li>
					// <li><a href="#">Малоценка</a></li>
				echo '<li><a href="index.php?m=libs">Справочники</a></li>
		  		</ul>

		  	</nav>
  </div>  
</div>';
		}

		protected function lmenu ($section, $mnu, $cat, $page){
		$menu_output="<div class='lside_mnu'><h4>".$section."</h4>";
		if (isset($mnu)){
			$menu_output.="<ul>";
			foreach ($mnu as $keym=>$value) {
				if (is_array($value)) {
					$menu_output.="<ul>";
					foreach ($value as $key=>$value2) {
						$menu_output.= "<li><a href=\"index.php?m=".$page."&cat=".$cat."&go=".$key."\">".$value2." -</a></li>";
					}
					$menu_output.="</ul>";
				}
				else{
					$menu_output.= "<li>";
					if($keym!="nolink"){
					$menu_output.="<a href=\"index.php?m=".$page."&cat=".$cat."&go=".$keym."\">".$value."</a>";
					}
					else{
						$menu_output.=$value;
					}
					$menu_output.= "</li>";
				}
			}
			$menu_output.= "</ul>";
		}
		// echo "<h4>".$section."</h4>";
		// echo "<ul class=\"nav\"><li><a href=''>".$var1."</a></li>";
		// echo "<li><a href=''>".$var2."</a></li></ul>";
		return $menu_output.'</div>';
	}

	protected function get_lmenu(){
	
	}

	

		protected function get_foot(){
			include "tpl/foot.php";
		}

		public function get_body(){
			$this->get_head();
			$this->get_menu();
			$this->get_lmenu();
			//echo '';
			$this->get_content();
			$this->get_foot();
		}

	abstract function get_content();

	}
 ?>