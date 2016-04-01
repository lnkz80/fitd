<?php 

class forms {

    function __construct($method, $action, $name=false, $class=false) {
        $name?$name='name='.$name:$name="";
        $class?$class='class='.$class:$class="";
        echo  "<form $name method='$method' action='$action' $class>";
    }

    protected function label($for, $text){            
            return "<label for='$for'>$text</label>";
        }
     
    public function inputs($for, $text, $type, $name, $placeholder){           
            return $this->label($for, $text)."<input type='$type' name='$name' placeholder='$placeholder'/>";
        }   

    public function sbmt(){
        return "<input type='submit' value='записать'>";
    }


      function __destruct() {
            echo "</form>";
        } 
    }

// class forms {
//     //put your code here
    
//     function __construct($name,$id,$method,$action) {
//         echo  "<form id='$id' name='id' method='$method' action='$action'>";
//     }
    
//     static private function attr($param)    {
//         if ($param) {
//             foreach ($param as $nam_attr => $val_attr) {
//                 $attribs.=$nam_attr."='".$val_attr."'";
//             }
//             return $attribs; 
//         }
//     }

//     static private function label($id,$text,$attr)    {
//         $key = array_search('regue', $attr, true);
//         if ($key = 1) $text.="<font color='red'>*</font>";
//         return "<label for='$id'>$text</label>";
//     }
 
//     static public function inputs($text,$type,$name,$id,$value=false,$class=false, $attr=false)    {
       
//         return self::label($id,$text,$attr)."<input type='$type' name='$name' id='$id' value='$value' class='$class' ".self::attr($attr)."/>";
//     }    
    
//     static public function inputs_chek($text,$type,$name,$id,$value=false,$class=false, $attr=false)    {
//         return  self::label($id,$text,$attr)."<input type='$type' name='$name' id='$id' class='$class' ".self::attr($attr)."/>$value";
//     }   
    
//     static public function area($text,$name,$id,$value=false,$class=false, $attr=false)    {
//         return  self::label($id,$text,$attr)."<TEXTAREA NAME='$name' id='$id' WRAP='virtual' COLS='40' ROWS='3' ".self::attr($attr).">$value</TEXTAREA>";
//     } 
    
//     static public function select($text,$name,$id,$value=false,$class=false, $attr=false)    {
//         $select="<select name='$name' id='$id' ".self::attr($attr).">";
//         foreach($value as $value => $val_text)  {
//             $select.="<option value='$value'>$val_text</option>";
//         }
//        $select.="</select>";
//        return  self::label($id,$text,$attr).$select;
//     } 
    
//     function __destruct() {
//         echo "<input type='submit'/><input type='reset' value='Очистить'></form>";
//     }   
// }

?>