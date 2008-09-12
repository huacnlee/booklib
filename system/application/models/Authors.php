<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * 用户表数据访问类
 * @author Json Lee
 * @copyright 2007
 */
class Authors extends Model{	
	
	function Authors(){		
		parent::Model();
		
		
	}
	
	/**
	 * 取得所有作者列表
	 * @return unknown
	 */
	function GetAll(){
		$this->load->database();
		
		$sql = "select * from authors order by authorid asc";
		
		$result = $this->db->query($sql);
		
		return  $result;
	}
	
	/**
	 * 创建一个新作者
	 *
	 * @param unknown_type $authorname 作者名称
	 * @return  -2已存在 >0成功后的编号
	 */
	function CreateNew($authorname = ""){
		
		$this->load->database();
		
		//检查是否存在
		if($this->CheckExist($authorname)){
			return -2;
		}
		
		$sqlCreate = "insert into authors (authorname) values('".$authorname."')";
		
		$this->db->query($sqlCreate);		
		
		//取编号
		$sqlSelect = "select * from authors where authorname = '".$authorname."'";
		$query2 = $this->db->query($sqlSelect);
		$row = $query2->row();
		
		return $row->authorid;
		
	}
	
	/**
	 * 检查关键词是否存在
	 *
	 * @param unknown_type $authorname
	 * @return  true存在 false不存在
	 */
	function CheckExist($authorname = ""){
		$this->db->select("*");
		$this->db->where("authorname",$authorname);
		$this->db->from("authors");
		$result = $this->db->get();
		
		if($result->num_rows() > 0){
			return true;
		}
		
		return false;
	}
	
	/**
	 * 删除作者,并会检查下面有否有书集
	 * @param unknown_type $authorid 作者编号
	 * @return  -2还有书存在 1成功
	 */
	function Delete($authorid = -1){
		$this->load->database();		
			
		//删除
		$sqlDelete = "delete from authors where authorid = ".$authorid."";
		
		$this->db->query($sqlDelete);
		
		return 1;
	}
	
	/**
	 * 修改作者
	 * @param unknown_type $authorid
	 * @param unknown_type $authorName
	 */
	function Update($authorid = -1,$authorName = ""){
		$this->load->database();
		
		$sqlText = "update authors set authorname = '".$authorName."' where authorid = ".$authorid."";
		
		$this->db->query($sqlText);
		
	}
	
	/**
	 * 保存作者组，以逗号分隔的
	 *
	 * @param unknown_type $authors
	 */
	function SaveAuthors($authors = ""){
		$authorArray = split(",",$authors);
		foreach ($authorArray as $author){
			if($author != ""){
				$this->CreateNew($author);
			}
		}
	}
}
?>