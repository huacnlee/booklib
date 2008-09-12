<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * 书集表数据访问类
 * @author Json Lee
 * @copyright 2007
 */
class MemberModel extends Model{	

	function MemberModel(){
		parent::Model();
	}
	
	/**
	 * 取员工总数
	 */
	function GetCount(){
		return $this->db->count_all("members");
	}
	
	/**
	 * 分页取得所有员工列表
	 * @return unknown
	 */
	function GetAllByPage($num,$index){
	
		$this->db->select('*');
		$this->db->from('members');
		$this->db->orderby("members.memberid", "desc"); 
		$this->db->limit($num, $index);

		$query = $this->db->get();      
				
		return  $query;
	}
	
	/**
	 * 创建一个新书集
	 *
	 * @param Array 书集数组
	 * @return  -2已存在 >0成功后的编号
	 */
	function CreateNew($member = Array()){
		
		$this->load->database();
		
		//检查是否存在
		$this->db->select("*");
		$this->db->from("members");
		$this->db->where("membername",$member["membername"]);
		
		if($this->db->count_all() > 0){
			return -2;
		}

		$sqlCreate = "INSERT INTO ";
		$sqlCreate .= "members (membername,membertel,memberemail) ";
		$sqlCreate .= "values(".$this->db->escape($member["membername"]).",".$this->db->escape($member["membertel"]).",".$this->db->escape($member["memberemail"]).")";		
			
		$this->db->query($sqlCreate);		
		
		$sqlSelect = "select memberid from members where membername = ".$this->db->escape($member["membername"])." ";
		//取编号
		$query2 = $this->db->query($sqlSelect);
		$row = $query2->row();
		
		return $row->memberid;

	}
	
	/**
	 * 取得员工列表
	 * @return unknown
	 */
	function GetAll(){
		$this->load->database();
		$this->db->select("*");
		$this->db->from("members");	
		$this->db->orderby("membername");
		$query = $this->db->get();
		return  $query;
	}
	
	/**
     * 根据编号取信息
     */
	function GetByID($memberid){
		$this->load->database();
		
		$this->db->select("*");
		$this->db->from('members');
		$this->db->where('memberid', $memberid);
		
		$query = $this->db->get();
		return $query;
	}
	
	/**
	 * 修改员工
	 *
	 * @param unknown_type $book
	 */
	function Update($memberid = -1,$member = Array()){
		$this->db->where('memberid', $memberid);
		$this->db->update('members', $member);
	}
	
	/**
	 * 删除书集,并会检查下面有否有书集
	 * @param unknown_type $authorid 书集编号
	 */
	function Delete($memberid = -1){
		$this->load->database();
		
		//删除
		$sqlDelete = "delete from members where memberid = ".$memberid."";
		
		$this->db->query($sqlDelete);

	}
}
?>