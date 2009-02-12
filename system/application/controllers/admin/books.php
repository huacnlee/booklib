<?php

/**
 * @author 
 * @copyright 2007
 */
class Books extends Controller{
	
	function Books(){

		parent::Controller();
		
		$this->load->model("users");
		
		if(! $this->users->CheckIsLogin()){
			redirect("admin/login");
		}
	}
	
	function index(){
	
		$pageSize = 30;
		
		$pageIndex = $this->uri->segment(4,1) - 1;
		$searchText = $this->uri->segment(5,"");		
		
		//加载分类列表
        $this->load->model("bookmodel");
        
		
		
		$bookList = $this->bookmodel->GetAllByPage($pageSize,$pageIndex,$searchText);
		
		$rowCount = $this->bookmodel->GetCount($searchText);
		
		$config['base_url'] = site_url()."/admin/books/index";		
		$config['per_page'] = $pageSize;	
		$config['uri_segment'] = 4;
		$config['num_links'] = 7;
		$config['total_rows'] = $rowCount;
		$config['first_link'] = '首页';
		$config['prev_link'] = '上一页';
		$config['next_link'] = '下一页';
		$config['last_link'] = '尾页';
		
		$this->pagination->initialize($config);	
		$pagebar =  $this->pagination->create_links();
		
		$data = array(
			"css_filename" => "books",
			"title" => "书集列表 - 管理后台",
			"bookList" => $bookList ,
			"pageSize" => $pageSize,
			"pageIndex" => $pageIndex,
			"rowCount" => $rowCount,
			"pagebar" => $pagebar,
			"searchtext" => $searchText
		);
		
		
		$this->load->view("admin/books",$data);		
		
	}
	
		
	/**
     * 添加页面
     */
	function create(){
		
	    //加载分类列表
        $this->load->model("sorts");       
        $sorts = $this->sorts->GetAll();
       
        //加载出版社列表
        $this->load->model("pubs");
        $pubs = $this->pubs->GetAll();
        
        //加载类型列表
        $this->load->model("booktypes");
        $booktypes = $this->booktypes->GetAll();
       
        //书架列表
        $this->load->model("locations");
        $locations = $this->locations->GetAll();
        
        $buytime = date("Y-m-d");
        $data = array(
            "css_filename" => "books",
            "title" => "添加图书 - 书集列表 - 管理后台",
            "sorts" => $sorts,
            "pubs" => $pubs,
        	"booktypes" => $booktypes,
        	"locations" => $locations,
        	"buytime" => $buytime
        );
       
        $this->load->view("admin/books/create",$data);
	}
	
	
	/**
     * 添加图书
     */
	function createpost(){
	
		$now = date("Y-m-d h:i:s");
		
		$bookArray = Array(
			"booklabel" => $_POST["booklabel"],
			"bookname" =>  $_POST["bookname"],
			"bookcontent" => $_POST["bookcontent"],
			"bookkeywords" => $_POST["bookkeywords"],
			"bookauthors" => $_POST["bookauthors"],
			"bookstar" => $_POST["bookstar"],
			"bookisbn" => $_POST["bookisbn"],
			"bookmoney" => $_POST["bookmoney"],
			"bookaddtime" => $now,
			"bookbuytime" => $_POST["bookbuytime"],
			"bookstatus" => $_POST["bookstatus"],
			"typeid" => $_POST["booktype"],
			"pubid" => $_POST["bookpub"],
			"sortid" => $_POST["booksort"],
			"locationid" => $_POST["booklocation"],
			"memberid" => -1
		);
		
		
		//表单验证
		$rules['bookname'] = "required";
		$rules['booktype'] = "required";
		$rules['booksort'] = "required";
		$rules['bookpub']  = "required";
		$rules['bookstar'] = "required";
		$rules['bookmoney'] = "required";
		$rules['bookstatus'] = "required";
		$rules['bookbuytime'] = "required";
		  
		$this->validation->set_rules($rules);
		if (! $this->validation->run())
		{
			$messagetext = "表单填写不完成，请返回后填写完毕再提交。<br />";
			$messagetext .= "<br />请 <a href=\"javascript:history.go(-1);\">点击这里</a> 返回刚才的页面。";
			
			$data = array(
	            "css_filename" => "books",
	            "title" => "提示消息 - 书集列表 - 管理后台",
	            "messagetitle" => "表单还未填写完整",
	            "messagetext" => $messagetext,
				"messageclass" => "error"
	        );
	       
	        $this->load->view("admin/books/message",$data);
	        
	        return ;
		}
		
		//存入数据库
		$this->load->model("bookmodel");
		try
		{
			$bookid = $this->bookmodel->CreateNew($bookArray);
		}
		catch(Exception $ex){
			log_message("错误",$ex);
			//show_error($ex);
			return ;
		}
		
		//保存关键词
		$this->load->model("keywords");		
		$this->keywords->SaveKeywords($bookArray["bookkeywords"]);
		
		//保存作者
		$this->load->model("authors");
		$this->authors->SaveAuthors($bookArray["bookauthors"]);
		
		
		//提示消息		
		$messagetext = "恭喜，新的书集添加成功！";
		$messagetext .= "<br />您现在可以 <a href=\"".site_url()."/admin/books\">返回书集列表</a> 或者 <a href=\"".site_url()."/admin/books/create\">继续添加</a>。";
		$data = array(
            "css_filename" => "books",
            "title" => "添加成功 - 书集列表 - 管理后台",
            "messagetitle" => "添加成功",
            "messagetext" => $messagetext,
			"messageclass" => ""
        );
       
        $this->load->view("admin/books/message",$data);
		
	}
	
	/**
     * 修改页面
     */
	function edit(){
		
		$bookid = $this->uri->segment(4);

	    //加载分类列表
        $this->load->model("sorts");       
        $sorts = $this->sorts->GetAll();
       
        //加载出版社列表
        $this->load->model("pubs");
        $pubs = $this->pubs->GetAll();
        
        //加载类型列表
        $this->load->model("booktypes");
        $booktypes = $this->booktypes->GetAll();
       
        //书架列表
        $this->load->model("locations");
        $locations = $this->locations->GetAll();
        
       	$this->load->model("BookModel");
        

        $bookquery = $this->BookModel->GetByID($bookid);      	
       
        if ($bookquery->num_rows() > 0)
		{
        	$bookinfo = $bookquery->row();
		}
		else{
			$this->_showMessage("信息不存在","对不起，这本书不存在。<br />请点击这里 <a href=\"".site_url()."/admin/books\">返回书集列表</a>。",true);
			return ;
		}
        
        
        
        $data = array(
            "css_filename" => "books",
            "title" => "修改图书 - 书集列表 - 管理后台",
            "sorts" => $sorts,
            "pubs" => $pubs,
        	"booktypes" => $booktypes,
        	"locations" => $locations,
        	"buytime" =>  $buytime = date("Y-m-d"),
        	"bookinfo" => $bookinfo,
        	"bookid" => $bookid
        );
       
        $this->load->view("admin/books/edit",$data);
	}
	
	/**
     * 修改图书提交
     */
	function editpost(){
		
		$bookid = $this->uri->segment(4);
		
		$bookArray = Array(
			"booklabel" => $_POST["booklabel"],
			"bookname" =>  $_POST["bookname"],
			"bookcontent" => $_POST["bookcontent"],
			"bookkeywords" => $_POST["bookkeywords"],
			"bookauthors" => $_POST["bookauthors"],
			"bookstar" => $_POST["bookstar"],
			"bookisbn" => $_POST["bookisbn"],
			"bookmoney" => $_POST["bookmoney"],
			"bookbuytime" => $_POST["bookbuytime"],
			"bookstatus" => $_POST["bookstatus"],			
			"typeid" => $_POST["booktype"],
			"pubid" => $_POST["bookpub"],
			"sortid" => $_POST["booksort"],
			"locationid" => $_POST["booklocation"],
			"memberid" => -1
		);
		
		
		//表单验证
		$rules['bookname'] = "required";
		$rules['booktype'] = "required";
		$rules['booksort'] = "required";
		$rules['bookpub']  = "required";
		$rules['bookstar'] = "required";
		$rules['bookmoney'] = "required";
		$rules['bookstatus'] = "required";
		$rules['bookbuytime'] = "required";
		  
		$this->validation->set_rules($rules);
		if (! $this->validation->run())
		{
			$messagetext = "表单填写不完成，请返回后填写完毕再提交。<br />";
			$messagetext .= "<br />请 <a href=\"javascript:history.go(-1);\">点击这里</a> 返回刚才的页面。";
			
			$data = array(
	            "css_filename" => "books",
	            "title" => "提示消息 - 书集列表 - 管理后台",
	            "messagetitle" => "表单还未填写完整",
	            "messagetext" => $messagetext,
				"messageclass" => "error"
	        );
	       
	        $this->load->view("admin/books/message",$data);
	        
	        return ;
		}
		
		//存入数据库
		$this->load->model("bookmodel");
		try
		{
			$bookid = $this->bookmodel->Update($bookid,$bookArray);
		}
		catch(Exception $ex){
			log_message("错误",$ex);
			//show_error($ex);
			return ;
		}
		
		//保存关键词
		$this->load->model("keywords");		
		$this->keywords->SaveKeywords($bookArray["bookkeywords"]);
		
		//保存作者
		$this->load->model("authors");
		$this->authors->SaveAuthors($bookArray["bookauthors"]);
		
		//提示消息		
		$messagetext = "恭喜，新的书集添加成功！";
		$messagetext .= "<br />您现在可以 <a href=\"".site_url()."/admin/books\">返回书集列表</a> 或者 <a href=\"".site_url()."/admin/books/create\">继续添加</a>。";
		$data = array(
            "css_filename" => "books",
            "title" => "添加成功 - 书集列表 - 管理后台",
            "messagetitle" => "添加成功",
            "messagetext" => $messagetext,
			"messageclass" => ""
        );
       
        $this->load->view("admin/books/message",$data);
		
	}
	
	
	/**
     * 详细信息页面
     */
	function view(){
		
		$bookid = $this->uri->segment(4);

       	$this->load->model("BookModel");
        $bookquery = $this->BookModel->GetByID($bookid);
    	$bookinfo = $bookquery->row();

    	//取类型
    	$this->load->model("booktypes");    	
    	$typeinfo = $this->booktypes->GetByID($bookinfo->typeID);
    	$typename = $typeinfo->typename;
    	
    	//取内容类型
    	$this->load->model("sorts");    	
    	$sortinfo = $this->sorts->GetByID($bookinfo->sortid);
    	$sortname = $sortinfo->sortname;
    	
    	//取书架
    	$this->load->model("locations");    	
    	$locationinfo = $this->locations->GetByID($bookinfo->locationid);
    	$locationname = $locationinfo->locationname;
    	
    	//取出版社
    	$this->load->model("pubs");    	
    	$pubinfo = $this->pubs->GetByID($bookinfo->pubid);
    	$pubname = $pubinfo->pubname;
    	
        $data = array(
            "css_filename" => "books",
            "title" => "查看图书详细信息 - 书集列表 - 管理后台",
            "sortname" => $sortname,
            "pubname" => $pubname,
        	"typename" => $typename,
        	"locationname" => $locationname,
        	"buytime" =>  $buytime = date("Y-m-d"),
        	"bookinfo" => $bookinfo,
        	"bookid" => $bookid,
        );
       
        $this->load->view("admin/books/view",$data);
	}
	
	/**
     * 借书
     */
	function lend(){
		
		$bookid = $this->uri->segment(4);

       	$this->load->model("BookModel");
        $bookquery = $this->BookModel->GetByID($bookid);
    	$bookinfo = $bookquery->row();

   		//取员工
   		$this->load->model("MemberModel");
   		$members = $this->MemberModel->GetAll();
    	
        $data = array(
            "css_filename" => "books",
            "title" => "借书 - 管理后台",
            "bookname" => $bookinfo->bookname,
        	"members" => $members,
        	"bookid" => $bookid,
        );
       
        $this->load->view("admin/books/lend",$data);
	}
	
	/**
	 * 借书提交
	 */
	function lendpost(){
		$bookid = $this->uri->segment(4);
		
		$memberid = $_POST["member"];
		
		if($memberid == -1){
			$messagetext = "您还未选择借书人。<br />";
			$messagetext .= "<br />请 <a href=\"javascript:history.go(-1);\">点击这里</a> 返回刚才的页面。";
			
			$data = array(
	            "css_filename" => "books",
	            "title" => "提示消息 - 书集列表 - 管理后台",
	            "messagetitle" => "表单还未填写完整",
	            "messagetext" => $messagetext,
				"messageclass" => "error"
	        );
	       
	        $this->load->view("admin/books/message",$data);
	        
	        return ;
		}
		
		
		//存入数据库
		$this->load->model("bookmodel");
		$this->bookmodel->setLend($bookid,$memberid,1);

		
		//提示消息		
		$messagetext = "书集借出信息已经保存成功！";
		$messagetext .= "<br />您现在可以 <a href=\"".site_url()."/admin/books\">返回书集列表</a> 。";
		$data = array(
            "css_filename" => "books",
            "title" => "保存成功 - 借书 - 管理后台",
            "messagetitle" => "保存成功",
            "messagetext" => $messagetext,
			"messageclass" => ""
        );
       
        $this->load->view("admin/books/message",$data);
		
	}
	
	/**
	 * Ajax删除书
	 */
	function remove(){
		$bookid = $_POST["bookid"];
		
		$this->load->model("bookmodel");
		$this->bookmodel->Delete($bookid);
		
		echo "{success:1}";
	}
	
	/**
     * 显示消息提示
     */
	function _showMessage($messagetitle,$messagetext,$iserror){
		$messageclass = "";
		if($iserror){
			$messageclass = "error";
		}
		
		$data = array(
            "css_filename" => "books",
            "title" => $messagetitle." - 书集列表 - 管理后台",
            "messagetitle" => $messagetitle,
            "messagetext" => $messagetext,
			"messageclass" => $messageclass
        );
       
        $this->load->view("admin/books/message",$data);
	}
}

?>