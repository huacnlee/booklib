<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * 类型表数据访问类
 * @author Json Lee
 * @copyright 2007
 */
class BookTypes extends Model{	
	
	function BookTypes(){		
		parent::Model();
	}
	
	/**
	 * 取得所有类型列表
	 * @return unknown
	 */
	function GetAll(){
		$this->load->database();
		
		$sql = "select typeid,typename from booktypes order by typeid asc";
		
		$result = $this->db->query($sql);
		
		return  $result;
	}
	
	/**
	 * 根据typeid取信息
	 *
	 * @param unknown_type $typeid
	 * @return unknown row
	 */
	function GetByID($typeid){
		$this->db->select("typeid,typename");
		$this->db->from("booktypes");
		$this->db->where("typeid",$typeid);
		$query = $this->db->get();
		return $query->row();
	}
	
	/**
	 * 创建一个新类型
	 *
	 * @param unknown_type $typename 类型名称
	 * @return  -2已存在 >0成功后的编号
	 */
	function CreateNew($typename = ""){
		
		$this->load->database();
		
		//检查是否存在
		$sqlSelect = "select typeid,typename from booktypes where typename = '".$typename."'";
		
		$query = $this->db->query($sqlSelect);
		if($query->num_rows() > 0){
			return -2;
		}
		
		$sqlCreate = "insert into booktypes (typename) values('".$typename."')";
		
		$this->db->query($sqlCreate);		
		
		//取编号
		$query2 = $this->db->query($sqlSelect);
		$row = $query2->row();
		
		return $row->typeid;
		
	}
	
	/**
	 * 删除内容类型,并会检查下面有否有书集
	 * @param unknown_type $typeid 内容类型编号
	 * @return  -2还有书存在 1成功
	 */
	function Delete($typeid = -1){
		$this->load->database();
		
		//检查是否存在
		$sqlCheck = "select count(*) as itemcount from books where typeid = ".$typeid."";
		
		$queryCheck = $this->db->query($sqlCheck);
		
		$row = $queryCheck->row();
		if($row->itemcount > 0){
			return -2;
		}
		
		//删除
		$sqlDelete = "delete from booktypes where typeid = ".$typeid."";
		
		$this->db->query($sqlDelete);
		
		return 1;
	}
	
	/**
	 * 修改内容类型
	 * @param unknown_type $typeid
	 * @param unknown_type $typeName
	 * @param unknown_type $typedesc
	 */
	function Update($typeid = -1,$typeName = ""){
		$this->load->database();
		
		$sqlText = "update booktypes set typename = '".$typeName."' where typeid = ".$typeid."";
		
		$this->db->query($sqlText);
		
	}
}
?>