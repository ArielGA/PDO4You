<?php
namespace Model;
require_once dirname(__FILE__).'/src/PDO4You/PDO4You.php';

use \PDO4You\PDO4You as BPDO4You;

class PDO4You extends BPDO4You{   
 	
	protected static $table;
	protected static $columns;

 	function __construct(){
		$this->getInstance();
	}

	static function select($where = ""){
		return parent::selectObj("SELECT ".self::$columns." FROM ".self::$table. " " .$where);
	}

	static function find($id){
		return parent::selectObj("SELECT ".self::$columns." FROM ".self::$table." WHERE id =".$id);
	}

	static function last($where = ""){
		return parent::selectObj("SELECT ".self::$columns." FROM ".self::$table." ".$where." order by id desc limit 1");
	}

   static function update($arr_values, $id='', $multi=''){
		if($arr_values){
			if($multi){
				foreach($arr as $i => $a){
					$update[] = array("table"=>self::$table, "values"=>$a,"where"=>array("id"=>$i));
				}
			}else{
				$update[] = array("table"=>self::$table, "values"=>$arr_values, "where"=>array("id"=>$id));
			}
			$json_update = json_encode($update);
			return parent::execute("update:".$json_update);
		}
	}	

	static function insert($arr_values, $multi = ''){
		if($arr_values){
			if($multi){
				foreach ($arr_values as $i => $a) {
					$insert[] = array("table" => self::$table, "values" => $a);	
				}
			}else{
				$insert[] = array("table" => self::$table, "values" => $arr_values);	
			}
			$json_insert = json_encode($insert);
			return parent::execute('insert:'.$json_insert);
		}
	}

	static function delete($arr, $multi = ''){
		if($arr){
			if($multi){
				foreach ($arr as $i => $a) {
					$delete[] = array("table" => self::$table, "where"=>array("id"=>$i));	
				}
			}else{	
				$delete[] = array("table" => self::$table, "where"=>array("id"=>$arr));	
			}
			$json_delete = json_encode($delete);
			return parent::execute('delete:'.$json_delete);
		}
	}
}