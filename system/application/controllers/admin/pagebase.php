<?php

/**
 * Controller基类
 * @author  Json Lee
 * @copyright 2007
 */
class MY_PageBase extends Controller{
	
	function MY_PageBase(){
		
		parent::Controller();
				
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
	 * 验证登录，未登录会转向登录页面
	 */
	function CheckLogin(){
		if(! $this->CheckIsLogin()){
			redirect("admin/login");
		}
	}
}
?>