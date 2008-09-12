<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * 书集表数据访问类
 * @author Json Lee
 * @copyright 2007
 */
class BookModel extends Model{	
	
	function Books_model(){		
		parent::Model();		
		
	}
	
	/**
	 * 取书本总数
	 */
	function GetCount($searchText){
		$this->db->select("bookid");
		$this->db->from("books");
		$this->db->like("bookname",$searchText);
		$this->db->orlike("bookkeywords",$searchText);
		$this->db->orlike("bookauthors",$searchText);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	/**
	 * 分页取得所有书集列表
	 * @return unknown
	 */
	function GetAllByPage($num,$index,$searchText){

		$this->db->select('books.bookid,books.bookname,books.booklabel,books.bookstatus,books.memberid,booktypes.typename,locations.locationname,pubs.pubname,sorts.sortname,members.membername');
		$this->db->from('books');
		$this->db->join('booktypes', 'booktypes.typeid = books.typeid');
		$this->db->join('locations', 'locations.locationid = books.locationid');
		$this->db->join('pubs', 'pubs.pubid = books.pubid');
		$this->db->join('sorts', 'sorts.sortid = books.sortid');
		$this->db->join('members', 'books.memberid = members.memberid', 'left');
		$this->db->orderby("books.bookaddtime", "desc"); 
		$this->db->like("bookname",$searchText);	
		$this->db->orlike("bookkeywords",$searchText);
		$this->db->orlike("bookauthors",$searchText);
		$this->db->limit($num,$index);
		$query = $this->db->get();      
				
		return  $query;
	}
	
	/**
     * 根据编号取信息
     */
	function GetByID($bookid){
		$this->load->database();
		
		$this->db->select("*");
		$this->db->from('books');
		$this->db->where('bookid', $bookid);
		
		$query = $this->db->get();
		return $query;
	}
	
	/**
	 * 创建一个新书集
	 *
	 * @param Array 书集数组
	 * @return  -2已存在 >0成功后的编号
	 */
	function CreateNew($book = Array()){
		
		$this->load->database();

		$sqlCreate = "INSERT INTO ";
		$sqlCreate .= "books (booklabel,bookname,bookcontent,bookkeywords,bookauthors,bookstar,bookisbn";
		$sqlCreate .= ",bookmoney,bookaddtime,bookbuytime,bookstatus,typeid,pubid,sortid,locationid,memberid) ";
		$sqlCreate .= "values(".$this->db->escape($book["booklabel"]).",".$this->db->escape($book["bookname"]).",".$this->db->escape($book["bookcontent"]).",".$this->db->escape($book["bookkeywords"]).",".$this->db->escape($book["bookauthors"])."";
		$sqlCreate .= ",".$book["bookstar"].",".$this->db->escape($book["bookisbn"]).",".$book["bookmoney"].",'".$book["bookaddtime"]."','".$book["bookbuytime"]."',".$book["bookstatus"]."";
		$sqlCreate .= ",".$book["typeid"].",".$book["pubid"].",".$book["sortid"].",".$book["locationid"].",".$book["memberid"].")";		
			
		$this->db->query($sqlCreate);		
		
		$sqlSelect = "select bookid from books where bookaddtime = '".$book["bookaddtime"]."' and bookname = '".$book["bookname"]."'";
		//取编号
		$query2 = $this->db->query($sqlSelect);
		$row = $query2->row();
		
		return $row->bookid;

	}
	
	/**
	 * 修改书集
	 *
	 * @param unknown_type $book
	 */
	function Update($bookid = -1,$book = Array()){
		$this->db->where('bookid', $bookid);
		$this->db->update('books', $book);
	}
	
	/**
	 * 更改书的借出状态
	 *
	 * @param unknown_type $bookid
	 * @param unknown_type $IsLend
	 */
	function setLend($bookid,$memberid,$IsLend){
		$status = 1;
		if($IsLend){
			$status = 2;
		}
		$data = array('bookstatus' => $status,"memberid" => $memberid);

		$where = "bookid = ".$bookid;
		
		$sqlCommand = $this->db->update_string('books', $data, $where);
		
		$this->db->query($sqlCommand);
	}
	
	/**
	 * 删除书集,并会检查下面有否有书集
	 * @param unknown_type $authorid 书集编号
	 */
	function Delete($bookid = -1){
		$this->load->database();
		
		//删除
		$sqlDelete = "delete from books where bookid = ".$bookid."";
		
		$this->db->query($sqlDelete);

	}
	
	
}
?>