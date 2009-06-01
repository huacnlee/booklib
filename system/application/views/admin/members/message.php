<?=$this->load->view("admin/header")?>
<style type="text/css">
	.message { margin:50px auto; border:4px solid #465C6B;width:500px; text-align:left;}
	.error {border:4px solid #C85848;}
	.message .text { margin:10px 8px; font-size:14px; }
	.message h3 {margin:4px; padding:4px; font-size:16px; color:#FFF;background:#465C6B;}
	.error h3 { background:#C85848;}
</style>
<div id="main">		
	<?=$this->load->view("admin/members/submenu")?>
	<div style="text-align:center;">
		<div class="message <?=$messageclass ?>">		
			<h3><?=$messagetitle ?></h3>
			<div class="text">
				<p><?=$messagetext ?><p>
			</div>			
		</div>
	</div>
</div>
<?=$this->load->view("admin/footer")?>