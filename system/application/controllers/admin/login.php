<?php

/**
 * @author 
 * @copyright 2007
 */

class Login extends Controller {
	
	function Login()
	{
		parent::Controller();	
	}
	
	function index(){
		
		$data = array(
			"css_filename" => "login",
			"title" => "管理后台登录",			
			"message" => "请在下面输入您的用户名和密码。",
			"messageclass" => ""
		);
		
		$this->load->view("admin/Login",$data);
	}
	
	/**
	 * 创建新用户
	 */
	function newuser(){
		$this->load->model("users");
		
		//MD5加密码
		$password = "123123";
		$username = "admin";
		
		$this->users->CreateUser($username,$password,$username);
		
		show_error("User:".$username." create successed!The password is:".$password);
		
	}
	
	function out(){
		delete_cookie("username");
		delete_cookie("password");
		
		redirect('admin/login');
	}

	function submit(){
		
		
		$data = array(
			"css_filename" => "login",
			"title" => "管理后台登录",			
			"message" => "",
			"messageclass" => ""
		);
		
		$this->load->view("admin/Login",$data);
		
		if(! $_POST){
			redirect("cp/login");
		}
		
		$username = $_POST["username"];
		$password = $_POST["password"];
		
		
		if($username == ""){
			$this->_showMessage("您还未输入用户名。",0);
			return;
		}
		
		if($password == ""){
			$this->_showMessage("您的密码还未输入。",0);
			return;
		}
		
		$this->load->model("Users");
		
		//MD5加密码
		$password = dohash($password, 'md5');
		
		$result = $this->Users->CheckLogin($username,$password);
		
		if($result == 0){
			$this->_showMessage("对不起，您的密码不正确，请重新输入。",0);
		}
		else {
			set_cookie("username",$username,"3600","","/");
			set_cookie("password",$password,"3600","","/");
			redirect("admin");
		}
	}
	
	/**
	 * 显示消息提示
	 *
	 * @param unknown_type $msg 消息内容
	 * @param unknown_type $type 1普通 0错误
	 */
	function _showMessage($msg,$type){
		
		$cssClass = "";
		if($type == 0){
			$cssClass = "error";
		}
		
		$data = array(
			"title" => "管理后台登录",
			"message" => $msg,
			"messageclass" => $cssClass
		);
		
		$this->load->view("admin/login",$data);
	}
}

?>