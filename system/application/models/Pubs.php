<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * 出版社表数据访问类
 * @author Json Lee
 * @copyright 2007
 */
class Pubs extends Model{	
	
	function Pubs(){
		parent::Model();
	}
	
	/**
	 * 取得所有出版社列表
	 * @return unknown
	 */
	function GetAll(){
		$this->load->database();
		
		$sql = "select * from pubs order by pubid asc";
		
		$result = $this->db->query($sql);
		
		return  $result;
	}
	
	/**
	 * 根据pubid取信息
	 *
	 * @param unknown_type $typeid
	 * @return unknown row
	 */
	function GetByID($pubid){
		$this->db->select("pubid,pubname");
		$this->db->from("pubs");
		$this->db->where("pubid",$pubid);
		$query = $this->db->get();
		return $query->row();
	}
	
	/**
	 * 创建一个新出版社
	 *
	 * @param unknown_type $pubname 出版社名称
	 * @return  -2已存在 >0成功后的编号
	 */
	function CreateNew($pubname = ""){
		
		$this->load->database();
		
		//检查是否存在
		$sqlSelect = "select * from pubs where pubname = '".$pubname."'";
		
		$query = $this->db->query($sqlSelect);
		if($query->num_rows() > 0){
			return -2;
		}
		
		$sqlCreate = "insert into pubs (pubname) values('".$pubname."')";
		
		$this->db->query($sqlCreate);		
		
		//取编号
		$query2 = $this->db->query($sqlSelect);
		$row = $query2->row();
		
		return $row->pubid;
		
	}
	
	/**
	 * 删除出版社
	 * @param unknown_type $pubid 出版社编号
	 */
	function Delete($pubid = -1){
		$this->load->database();
		
		//删除
		$sqlDelete = "delete from pubs where pubid = ".$pubid."";
		
		$this->db->query($sqlDelete);
		
	}
	
	/**
	 * 修改出版社
	 * @param unknown_type $pubid
	 * @param unknown_type $pubName
	 */
	function Update($pubid = -1,$pubName = ""){
		$this->load->database();
		
		$sqlText = "update pubs set pubname = '".$pubName."' where pubid = ".$pubid."";
		
		$this->db->query($sqlText);
		
	}
}

?>