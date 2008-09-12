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
		redirect('admin/login');
	}
}