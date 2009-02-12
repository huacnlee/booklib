<?=$this->load->view("admin/header",$data)?>
<style type="text/css">
	#main .submenu ul li.config a{ background:#465C8A; color:#FFF; }
</style>
<div id="main">		
	<?=$this->load->view("admin/config/submenu")?>	
	<h2>参数设定</h2>
</div>
<?=$this->load->view("admin/footer",$data)?>
