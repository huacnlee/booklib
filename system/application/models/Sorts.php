<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * 用户表数据访问类
 * @author Json Lee
 * @copyright 2007
 */
class Sorts extends Model{	
	
	function Sorts(){		
		parent::Model();
	}
	
	/**
	 * 取得所有分类列表
	 * @return unknown
	 */
	function GetAll(){
		$this->load->database();
		
		$sql = "select * from sorts order by sortid asc";
		
		$result = $this->db->query($sql);
		
		return  $result;
	}
	
	/**
	 * 根据sortid取信息
	 *
	 * @param unknown_type $typeid
	 * @return unknown row
	 */
	function GetByID($sortid){
		$this->db->select("sortid,sortname");
		$this->db->from("sorts");
		$this->db->where("sortid",$sortid);
		$query = $this->db->get();
		return $query->row();
	}
	
	/**
	 * 创建一个新分类
	 *
	 * @param unknown_type $sortname 分类名称
	 * @return  -2已存在 >0成功后的编号
	 */
	function CreateNew($sortname = ""){
		
		$this->load->database();
		
		//检查是否存在
		$sqlSelect = "select * from sorts where sortname = '".$sortname."'";
		
		$query = $this->db->query($sqlSelect);
		if($query->num_rows() > 0){
			return -2;
		}
		
		$sqlCreate = "insert into sorts (sortname,sortdesc) values('".$sortname."','')";
		
		$this->db->query($sqlCreate);		
		
		//取编号
		$query2 = $this->db->query($sqlSelect);
		$row = $query2->row();
		
		return $row->sortid;
		
	}
	
	/**
	 * 删除内容分类,并会检查下面有否有书集
	 * @param unknown_type $sortid 内容分类编号
	 * @return  -2还有书存在 1成功
	 */
	function Delete($sortid = -1){
		$this->load->database();
		
		//检查是否存在
		$sqlCheck = "select count(*) as itemcount from books where sortid = ".$sortid."";
		
		$queryCheck = $this->db->query($sqlCheck);
		
		$row = $queryCheck->row();
		if($row->itemcount > 0){
			return -2;
		}
		
		//删除
		$sqlDelete = "delete from sorts where sortid = ".$sortid."";
		
		$this->db->query($sqlDelete);
		
		return 1;
	}
	
	/**
	 * 修改内容分类
	 * @param unknown_type $sortid
	 * @param unknown_type $sortName
	 * @param unknown_type $sortdesc
	 */
	function Update($sortid = -1,$sortName = "",$sortdesc = ""){
		$this->load->database();
		
		$sqlText = "update sorts set sortname = '".$sortName."',sortdesc = '".$sortdesc."' where sortid = ".$sortid."";
		
		$this->db->query($sqlText);
		
	}
}
?>