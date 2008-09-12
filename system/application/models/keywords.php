<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * 用户表数据访问类
 * @author Json Lee
 * @copyright 2007
 */
class Keywords extends Model{	
	
	function Keywords(){		
		parent::Model();
		
		
	}
	
	/**
	 * 取得所有关键词列表
	 * @return unknown
	 */
	function GetAll(){
		$this->load->database();
		
		$sql = "select * from keywords order by keywordid asc";
		
		$result = $this->db->query($sql);
		
		return  $result;
	}
	
	/**
	 * 创建一个新关键词
	 *
	 * @param unknown_type $keywordname 关键词名称
	 * @return  -2已存在 >0成功后的编号
	 */
	function CreateNew($keywordname = ""){
		
		$this->load->database();
		
		//检查是否存在
		
		if($this->CheckExist($keywordname)){
			return -2;
		}
		
		$sqlCreate = "insert into keywords (keywordname) values('".$keywordname."')";
		
		$this->db->query($sqlCreate);		
		
		//取编号
		$sqlSelect = "select * from keywords where keywordname = '".$keywordname."'";		
		$query2 = $this->db->query($sqlSelect);
		$row = $query2->row();
		
		return $row->keywordid;
		
	}
	
	/**
	 * 检查关键词是否存在
	 *
	 * @param unknown_type $keywordname
	 * @return  true存在 false不存在
	 */
	function CheckExist($keywordname = ""){
		$this->db->select("*");
		$this->db->where("keywordname",$keywordname);
		$this->db->from("keywords");
		$result = $this->db->get();
		
		if($result->num_rows() > 0){
			return true;
		}
		
		return false;
	}
	
	/**
	 * 删除关键词
	 * @param unknown_type $keywordid 关键词编号
	 */
	function Delete($keywordid = -1){
		$this->load->database();		
				
		//删除
		$sqlDelete = "delete from keywords where keywordid = ".$keywordid."";
		
		$this->db->query($sqlDelete);
		
	}
	
	/**
	 * 修改关键词
	 * @param unknown_type $keywordid
	 * @param unknown_type $keywordName
	 */
	function Update($keywordid = -1,$keywordName = ""){
		$this->load->database();
		
		$sqlText = "update keywords set keywordname = '".$keywordName."' where keywordid = ".$keywordid."";
		
		$this->db->query($sqlText);
		
	}
	
	/**
	 * 保存关键词组，以逗号分隔的
	 *
	 * @param unknown_type $keywords
	 */
	function SaveKeywords($keywords = ""){
		$keywordArray = split(",",$keywords);
		foreach ($keywordArray as $word){
			if($word != ""){
				$this->CreateNew($word);
			}
		}
	}
}
?>