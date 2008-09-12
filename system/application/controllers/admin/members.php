<?php

/**
 * @author 
 * @copyright 2007
 */
class Members extends Controller{
	function Members(){
		parent::Controller();
	}
	
	function index(){
		
		$pageSize = 20;
		$pageIndex = $this->uri->segment(3);
		
		//加载分类列表
        $this->load->model("membermodel");
        
		$config['base_url'] = site_url()."/admin/members";
		
		$config['per_page'] = $pageSize;
		
		
		$memberlist = $this->membermodel->GetAllByPage($pageSize,$pageIndex);
		
		$rowCount = $memberlist->num_rows();
		
		$this->pagination->initialize($config);
		
		$this->table->set_heading("编号","姓名","电话", 'E-mail');
		
		
		$data = array(
			"css_filename" => "members",
			"title" => "员工列表 - 管理后台",
			"members" => $memberlist
		);
		
		$this->load->view("admin/members",$data);
	}
	
	/**
     * 添加页面
     */
	function create(){
		
        $data = array(
            "css_filename" => "members",
            "title" => "添加员工 - 员工管理 - 管理后台"
        );
       
        $this->load->view("admin/members/create",$data);
	}
	
	/**
     * 添加员工
     */
	function createpost(){
	
	
		$memberArray = Array(
			"membername" => $_POST["membername"],
			"membertel" =>  $_POST["membertel"],
			"memberemail" => $_POST["memberemail"]
		);
		
		
		//表单验证
		$rules['membername'] = "required";
		$rules['membertel'] = "required";
		$rules['memberemail'] = "required";
		  
		$this->validation->set_rules($rules);
		if (! $this->validation->run())
		{
			$messagetext = "表单填写不完成，请返回后填写完毕再提交。<br />";
			$messagetext .= "<br />请 <a href=\"javascript:history.go(-1);\">点击这里</a> 返回刚才的页面。";
			
			$data = array(
	            "css_filename" => "members",
	            "title" => "提示消息 - 员工列表 - 管理后台",
	            "messagetitle" => "表单还未填写完整",
	            "messagetext" => $messagetext,
				"messageclass" => "error"
	        );
	       
	        $this->load->view("admin/members/message",$data);
	        
	        return ;
		}
		
		//存入数据库
		$this->load->model("membermodel");
		try
		{
			$memberid = $this->membermodel->CreateNew($memberArray);
		}
		catch(Exception $ex){
			log_message("错误",$ex);
			//show_error($ex);
			return ;
		}
			
		//提示消息		
		$messagetext = "恭喜，员工添加成功！";
		$messagetext .= "<br />您现在可以 <a href=\"".site_url()."/admin/members\">返回员工列表</a></a>。";
		$data = array(
            "css_filename" => "members",
            "title" => "添加成功 - 员工列表 - 管理后台",
            "messagetitle" => "添加成功",
            "messagetext" => $messagetext,
			"messageclass" => ""
        );
       
        $this->load->view("admin/members/message",$data);
		
	}
	
	/**
     * 修改页面
     */
	function edit(){
		
		$memberid = $this->uri->segment(4);

	  
       	$this->load->model("membermodel");        

        $memberquery = $this->membermodel->GetByID($memberid);      	
       
        if ($memberquery->num_rows() > 0)
		{
        	$memberinfo = $memberquery->row();
		}
		else{
			$this->_showMessage("信息不存在","对不起，这个员工不存在。<br />请点击这里 <a href=\"".site_url()."/admin/members\">返回员工列表</a>。",true);
			return ;
		}
        
        
        
        $data = array(
            "css_filename" => "members",
            "title" => "修改员工 - 员工列表 - 管理后台",
        	"member" => $memberinfo,
        	"memberid" => $memberid
        );
       
        $this->load->view("admin/members/edit",$data);
	}
	
	/**
     * 修改员工
     */
	function editpost(){
	
		$memberid = $this->uri->segment(4);
		
		$memberArray = Array(
			"membername" => $_POST["membername"],
			"membertel" =>  $_POST["membertel"],
			"memberemail" => $_POST["memberemail"]
		);
		
		
		//表单验证
		$rules['membername'] = "required";
		$rules['membertel'] = "required";
		$rules['memberemail'] = "required";
		  
		$this->validation->set_rules($rules);
		if (! $this->validation->run())
		{
			$messagetext = "表单填写不完成，请返回后填写完毕再提交。<br />";
			$messagetext .= "<br />请 <a href=\"javascript:history.go(-1);\">点击这里</a> 返回刚才的页面。";
			
			$data = array(
	            "css_filename" => "members",
	            "title" => "提示消息 - 员工列表 - 管理后台",
	            "messagetitle" => "表单还未填写完整",
	            "messagetext" => $messagetext,
				"messageclass" => "error"
	        );
	       
	        $this->load->view("admin/members/message",$data);
	        
	        return ;
		}
		
		//存入数据库
		$this->load->model("membermodel");
		try
		{
			$memberid = $this->membermodel->Update($memberid,$memberArray);
		}
		catch(Exception $ex){
			log_message("错误",$ex);
			//show_error($ex);
			return ;
		}
			
		//提示消息		
		$messagetext = "恭喜，员工信息修改成功！";
		$messagetext .= "<br />您现在可以 <a href=\"".site_url()."/admin/members\">返回员工列表</a></a>。";
		$data = array(
            "css_filename" => "members",
            "title" => "修改成功 - 员工列表 - 管理后台",
            "messagetitle" => "修改成功",
            "messagetext" => $messagetext,
			"messageclass" => ""
        );
       
        $this->load->view("admin/members/message",$data);
		
	}
	
	
	function removepost(){
		$memberid = $this->uri->segment(4);
		
		$this->load->model("membermodel");
		
		$result = $this->membermodel->Delete($memberid);
		
		//提示消息		
		$messagetext = "恭喜，员工信息删除成功！";
		$messagetext .= "<br />您现在可以 <a href=\"".site_url()."/admin/members\">返回员工列表</a></a>。";
		$data = array(
            "css_filename" => "members",
            "title" => "删除成功 - 员工列表 - 管理后台",
            "messagetitle" => "删除成功",
            "messagetext" => $messagetext,
			"messageclass" => ""
        );
	}
	
}
?>