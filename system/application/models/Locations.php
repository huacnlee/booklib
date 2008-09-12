<?php

?><?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * 书架表数据访问类
 * @author Json Lee
 * @copyright 2007
 */
class Locations extends Model{	
	
	function Locations(){
		parent::Model();
	}
	
	/**
	 * 取得所有书架列表
	 * @return unknown
	 */
	function GetAll(){
		$this->load->database();
		
		$sql = "select * from locations order by locationid asc";
		
		$result = $this->db->query($sql);
		
		return  $result;
	}
	
	/**
	 * 根据locationid取信息
	 *
	 * @param unknown_type $typeid
	 * @return unknown row
	 */
	function GetByID($locationid){
		$this->db->select("locationid,locationname");
		$this->db->from("locations");
		$this->db->where("locationid",$locationid);
		$query = $this->db->get();
		return $query->row();
	}
	
	/**
	 * 创建一个新书架
	 *
	 * @param unknown_type $locationname 书架名称
	 * @return  -2已存在 >0成功后的编号
	 */
	function CreateNew($locationname = ""){
		
		$this->load->database();
		
		//检查是否存在
		$sqlSelect = "select * from locations where locationname = '".$locationname."'";
		
		$query = $this->db->query($sqlSelect);
		if($query->num_rows() > 0){
			return -2;
		}
		
		$sqlCreate = "insert into locations (locationname) values('".$locationname."')";
		
		$this->db->query($sqlCreate);		
		
		//取编号
		$query2 = $this->db->query($sqlSelect);
		$row = $query2->row();
		
		return $row->locationid;
		
	}
	
	/**
	 * 删除书架
	 * @param unknown_type $locationid 书架编号
	 */
	function Delete($locationid = -1){
		$this->load->database();
		
		//删除
		$sqlDelete = "delete from locations where locationid = ".$locationid."";
		
		$this->db->query($sqlDelete);
		
	}
	
	/**
	 * 修改书架
	 * @param unknown_type $locationid
	 * @param unknown_type $locationName
	 */
	function Update($locationid = -1,$locationName = ""){
		$this->load->database();
		
		$sqlText = "update locations set locationname = '".$locationName."' where locationid = ".$locationid."";
		
		$this->db->query($sqlText);
		
	}
}

?>