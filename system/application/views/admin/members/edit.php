<?=$this->load->view("admin/header")?>
<style type="text/css">
	.form { margin:20px; border:1px solid #CAD0D5; padding:10px;}
	.form table tr td { padding:5px;}
	.form table tr td.label { width:80px; text-align:right; color:#999;}
	
	#main .submenu ul li.create a{ color:#666; text-decoration: none;  }
</style>
<div id="main">			
	<?=$this->load->view("admin/members/submenu")?>
	<div id="panelForm" class="form">
	<?=form_open("admin/members/editpost/".$memberid)?>
		<table>
			<tr>
				<td class="label">* 姓名：</td>
				<td>
					<input type="text" name="membername" value="<?=$member->membername ?>" class="text m" /> 					
				</td>
			</tr>
			<tr>
				<td class="label">* 电话：</td><td><input type="text" name="membertel" value="<?=$member->membertel ?>" class="text m"></td>
			</tr>
			<tr>
				<td class="label">E-mail：</td><td><input type="text" name="memberemail" value="<?=$member->memberemail ?>" class="text l"></td>
			</tr>
			<tr>
				<td class="label"></td>
				<td><button type="submit" class="submit">提交</button></td>
			</tr>		
		</table>
	<?=form_close()?>
	</div>	
</div>
<?=$this->load->view("admin/footer")?>
