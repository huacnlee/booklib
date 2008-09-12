<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * 用户表数据访问类
 * @author Json Lee
 * @copyright 2007
 */
class Users extends Model{	
	
	function Users(){		
		parent::Model();
	}

	/**
	 * Cookie验证登录
	 * @return unknown
	 */
	function CheckIsLogin(){
		$username = get_cookie("username");
		$password = get_cookie("password");
		
		if($this->CheckLogin($username,$password)){
			return true;
		}
		else {
			return false;
		}
	}	
		
	/**
	 * 检查登录
	 *
	 * @param unknown_type $username 用户名
	 * @param unknown_type $password 密已加密的密码
	 * @return unknown 0用户名或密码错误
	 */
	function CheckLogin($username,$password){
		
		$this->load->database();
		
		$sql = "select * from users where username = '".$username."' and password = '".$password."'";
		
		$result = $this->db->query($sql);
		
		$rowcount = $result->num_rows();
		
		return  $rowcount;
	}
	
	/**
	 * 创建新用户
	 *
	 * @param unknown_type $username 用户名
	 * @param unknown_type $password 未密的密码
	 * @param unknown_type $realname 真实姓名
	 */
	function CreateUser($username,$password,$realname){
		$this->load->database();
		
		$password = dohash($password, 'md5');
		
		$sql = "insert into users (username,password,realname) values('".$username."','".$password."','".$realname."')";
		
		$result = $this->db->query($sql);
	}
	
	/**
	 * 修改密码
	 * @param unknown_type $username
	 * @param unknown_type $password
	 */
	function UpdatePassword($username,$password){
		$this->load->database();
		
		$password = dohash($password, 'md5');
		
		$sql = "update users set password = '".$password."' where username = '".$username."'";
		
		$result = $this->db->query($sql);
	}
}