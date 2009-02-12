<?=$this->load->view("admin/header",$data)?>
<style type="text/css">
	.form { margin:20px; border:1px solid #CAD0D5; padding:10px;}
	.form table tr td { padding:5px;}
	.form table tr td.label { width:80px; text-align:right; color:#999;}
	
	#main .submenu ul li.create a{ background:#465C8A; color:#FFF; }
</style>
<div id="main">			
	<?=$this->load->view("admin/members/submenu")?>	
	<h2>添加员工</h2>
	<div id="panelForm" class="form">
	<?=form_open("admin/members/createpost")?>
		<table>
			<tr>
				<td class="label">* 姓名：</td>
				<td>
					<input type="text" name="membername" class="text m" /> 					
				</td>
			</tr>
			<tr>
				<td class="label">* 电话：</td><td><input type="text" name="membertel" value="" class="text m"></td>
			</tr>
			<tr>
				<td class="label">E-mail：</td><td><input type="text" name="memberemail" value="" class="text l"></td>
			</tr>
			<tr>
				<td class="label"></td>
				<td><button type="submit" class="submit">提交</button></td>
			</tr>		
		</table>
	<?=form_close()?>
	</div>
</div>
<?=$this->load->view("admin/footer",$data)?>
