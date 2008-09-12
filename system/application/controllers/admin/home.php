<?php

/**
 * @author 
 * @copyright 2007
 */
class Home extends Controller{
	
	function Home(){
		
		
		
		parent::Controller();
		
	}
	
	function index(){
		
		$this->load->model("users");
		
		$this->load->model("bookmodel");
		$this->load->model("membermodel");
		
		$bookcount = $this->bookmodel->GetCount("");
		$membercount = $this->membermodel->GetCount();
		
		if(! $this->users->CheckIsLogin()){
			redirect("admin/login");
		}
		
		$data = array(
			"css_filename" => "home",
			"title" => "首页 - 管理后台",
			"db_platform" => $this->db->platform(),
			"db_version" => $this->db->version(),
			"bookcount" => $bookcount,
			"membercount" => $membercount
		);
		
		$this->load->view("admin/Home",$data);
	}
	
	/**
	 * 登出
	 */
	function logout(){
		set_cookie("username","");
		set_cookie("password","");
	}
}

?>