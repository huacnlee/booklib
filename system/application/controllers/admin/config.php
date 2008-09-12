<?php

/**
 * @author 
 * @copyright 2007
 */
class Config extends Controller{
	
	function Config(){

		parent::Controller();
		
		$this->load->model("users");
		
		if(! $this->users->CheckIsLogin()){
			redirect("admin/login");
		}
	}
	
	/**
	 * 参数设定首页
	 */
	function index(){
		
		$data = array(
			"css_filename" => "config",
			"title" => "参数设置 - 管理后台"
		);
		
		$this->load->view("admin/config",$data);
	}
	
	
	/**
	 * 分类页面
	 */
	function sorts(){
		$this->load->model("sorts");
		
		$result = $this->sorts->GetAll();
		
		$data = array(
			"css_filename" => "config",
			"title" => "分类维护 - 管理后台",
			"sorts" => $result
		);
		
		$this->load->view("admin/config/sorts",$data);
	}
	
	/**
	 * Ajax调用创建分类
	 */
	function sortpost(){
		if(! $_POST){
			return ;
		}
		
		$type = $_POST["action"];
		
		$this->load->model("sorts");
		
		
		if($type == "create"){
			//创建分类
			$sortname = $_POST["name"];
			if($sortname == ""){
				echo ("{success:-1}");
				return ;
			}
			$reusltValue = $this->sorts->CreateNew($sortname);
			
			//-2分类名已存在
			if($reusltValue == -2){
				echo ("{success:-2}");
				return ;
			}
			else {
				echo ("{success:1,value:".$reusltValue."}");
			}
		}
		else if($type == "delete"){
			//删除分类
			$sortid = $_POST["id"];
			
			$reusltValue = $this->sorts->Delete($sortid);
			
			if($reusltValue == -2){
				echo ("{success:-2}");
				return ;
			}
			else {
				echo ("{success:1}");
			}
		}else if($type == "rename"){
			//重命名
			$sortid = $_POST["id"];			
			$sortname = $_POST["name"];
			
			$this->sorts->Update($sortid,$sortname,"");
			
			echo ("{success:1}");
		}
	}
	
	
	/**
	 * 作者页面
	 */
	function authors(){
		$this->load->model("authors");
		
		$result = $this->authors->GetAll();
		
		$data = array(
			"css_filename" => "config",
			"title" => "作者列表 - 管理后台",
			"authors" => $result
		);
		
		$this->load->view("admin/config/authors",$data);
	}
	
	/**
	 * Ajax调用创建作者
	 */
	function authorpost(){
		if(! $_POST){
			return ;
		}
		
		$type = $_POST["action"];
		
		$this->load->model("authors");
		
		
		if($type == "create"){
			//创建
			$authorname = $_POST["name"];
			if($authorname == ""){
				echo ("{success:-1}");
				return ;
			}
			$reusltValue = $this->authors->CreateNew($authorname);
			
			//-2作者已存在
			if($reusltValue == -2){
				echo ("{success:-2}");
				return ;
			}
			else {
				echo ("{success:1,value:".$reusltValue."}");
			}
		}
		else if($type == "delete"){
			//删除
			$authorid = $_POST["id"];
			
			$reusltValue = $this->authors->Delete($authorid);
			
			if($reusltValue == -2){
				echo ("{success:-2}");
				return ;
			}
			else {
				echo ("{success:1}");
			}
		}else if($type == "rename"){
			//重命名
			$authorid = $_POST["id"];			
			$authorname = $_POST["name"];
			
			$this->authors->Update($authorid,$authorname,"");
			
			echo ("{success:1}");
		}
	}
	
	function modifypassword(){		
		
		$data = array(
			"css_filename" => "config",
			"title" => "修改密码 - 管理后台",
			"messageclass" => "",
			"messagetext" => ""			
		);
		
		$this->load->view("admin/config/modifypassword",$data);
	}
	
	function modifypasswordpost(){
		
		$messagetext = "";
		$messageclass = "";
		
		$oldpass =$_POST["oldpass"];
		$newpass =$_POST["newpass"];
		$confirmpass =$_POST["confirmpass"];
		
		if($newpass == ""){			
			$messageclass = "red";
			$messagetext = "新密码不能为空。";
		}
		else{				
			if($newpass != $confirmpass){
				$messageclass = "red";
				$messagetext = "两次输入的密码不一至，请重新输入。";
			}
			else{
				//检查旧密码
				$username = get_cookie("username");
				
				$oldpass = dohash($oldpass, 'md5');
				if($this->users->CheckLogin($username,$oldpass) == 0){
					$messageclass = "red";
					$messagetext = "旧密码不正确。";
				}
				else {
					$this->users->UpdatePassword($username,$newpass);
					$messageclass = "";
					$messagetext = "恭喜，您的密码修改成功。";
					set_cookie("password",dohash($newpass, 'md5'),"3600","","/");
				}
			}
		}
		
		$data = array(
			"css_filename" => "config",
			"title" => "修改密码 - 管理后台",
			"messageclass" => $messageclass,
			"messagetext" => $messagetext		
		);
		
		$this->load->view("admin/config/modifypassword",$data);
	}

	/**
	 * 出版社页面
	 */
	function pubs(){
		$this->load->model("pubs");
		
		$result = $this->pubs->GetAll();
		
		$data = array(
			"css_filename" => "config",
			"title" => "出版社列表 - 管理后台",
			"pubs" => $result
		);
		
		$this->load->view("admin/config/pubs",$data);
	}
	
	/**
	 * Ajax调用创建出版社
	 */
	function pubpost(){
		if(! $_POST){
			return ;
		}
		
		$type = $_POST["action"];
		
		$this->load->model("pubs");
		
		
		if($type == "create"){
			//创建
			$pubname = $_POST["name"];
			if($pubname == ""){
				echo ("{success:-1}");
				return ;
			}
			$reusltValue = $this->pubs->CreateNew($pubname);
			
			//-2出版社已存在
			if($reusltValue == -2){
				echo ("{success:-2}");
				return ;
			}
			else {
				echo ("{success:1,value:".$reusltValue."}");
			}
		}
		else if($type == "delete"){
			//删除
			$pubid = $_POST["id"];
			
			$this->pubs->Delete($pubid);
			
			echo ("{success:1}");
			
		}else if($type == "rename"){
			//重命名
			$pubid = $_POST["id"];			
			$pubname = $_POST["name"];
			
			$this->pubs->Update($pubid,$pubname,"");
			
			echo ("{success:1}");
		}
	}
	
	/**
	 * 关键词页面
	 */
	function keywords(){
		$this->load->model("keywords");
		
		$result = $this->keywords->GetAll();
		
		$data = array(
			"css_filename" => "config",
			"title" => "关键词列表 - 管理后台",
			"keywords" => $result
		);
		
		$this->load->view("admin/config/keywords",$data);
	}
	
	/**
	 * Ajax调用创建关键词
	 */
	function keywordpost(){
		if(! $_POST){
			return ;
		}
		
		$type = $_POST["action"];
		
		$this->load->model("keywords");
		
		
		if($type == "create"){
			//创建
			$keywordname = $_POST["name"];
			if($keywordname == ""){
				echo ("{success:-1}");
				return ;
			}
			$reusltValue = $this->keywords->CreateNew($keywordname);
			
			//-2关键词已存在
			if($reusltValue == -2){
				echo ("{success:-2}");
				return ;
			}
			else {
				echo ("{success:1,value:".$reusltValue."}");
			}
		}
		else if($type == "delete"){
			//删除
			$keywordid = $_POST["id"];
			
			$this->keywords->Delete($keywordid);
			
			echo ("{success:1}");
			
		}else if($type == "rename"){
			//重命名
			$keywordid = $_POST["id"];			
			$keywordname = $_POST["name"];
			
			$this->keywords->Update($keywordid,$keywordname,"");
			
			echo ("{success:1}");
		}
	}
	
	/**
	 * 类型页面
	 */
	function booktypes(){
		$this->load->model("booktypes");
		
		$result = $this->booktypes->GetAll();
		
		$data = array(
			"css_filename" => "config",
			"title" => "类型列表 - 管理后台",
			"booktypes" => $result
		);
		
		$this->load->view("admin/config/booktypes",$data);
	}
	
	/**
	 * Ajax调用创建类型
	 */
	function booktypepost(){
		if(! $_POST){
			return ;
		}
		
		$type = $_POST["action"];
		
		$this->load->model("booktypes");
		
		
		if($type == "create"){
			//创建
			$typename = $_POST["name"];
			if($typename == ""){
				echo ("{success:-1}");
				return ;
			}
			$reusltValue = $this->booktypes->CreateNew($typename);
			
			//-2类型已存在
			if($reusltValue == -2){
				echo ("{success:-2}");
				return ;
			}
			else {
				echo ("{success:1,value:".$reusltValue."}");
			}
		}
		else if($type == "delete"){
			//删除
			$typeid = $_POST["id"];
			
			$this->booktypes->Delete($typeid);
			
			echo ("{success:1}");
			
		}else if($type == "rename"){
			//重命名
			$typeid = $_POST["id"];			
			$typename = $_POST["name"];
			
			$this->booktypes->Update($typeid,$typename,"");
			
			echo ("{success:1}");
		}
	}
	
	
	/**
	 * 书架页面
	 */
	function locations(){
		$this->load->model("locations");
		
		$result = $this->locations->GetAll();
		
		$data = array(
			"css_filename" => "config",
			"title" => "书架列表 - 管理后台",
			"locations" => $result
		);
		
		$this->load->view("admin/config/locations",$data);
	}
	
	/**
	 * Ajax调用创建书架
	 */
	function locationpost(){
		if(! $_POST){
			return ;
		}
		
		$type = $_POST["action"];
		
		$this->load->model("locations");
		
		
		if($type == "create"){
			//创建
			$locationname = $_POST["name"];
			if($locationname == ""){
				echo ("{success:-1}");
				return ;
			}
			$reusltValue = $this->locations->CreateNew($locationname);
			
			//-2书架已存在
			if($reusltValue == -2){
				echo ("{success:-2}");
				return ;
			}
			else {
				echo ("{success:1,value:".$reusltValue."}");
			}
		}
		else if($type == "delete"){
			//删除
			$locationid = $_POST["id"];
			
			$this->locations->Delete($locationid);
			
			echo ("{success:1}");
			
		}else if($type == "rename"){
			//重命名
			$locationid = $_POST["id"];			
			$locationname = $_POST["name"];
			
			$this->locations->Update($locationid,$locationname,"");
			
			echo ("{success:1}");
		}
	}
}
?>