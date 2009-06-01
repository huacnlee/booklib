<?=$this->load->view("admin/header")?>
<style type="text/css">
	.form { margin:20px; border:1px solid #CAD0D5; padding:10px;}
	.form table tr td { padding:5px;}
	.form table tr td.label { width:80px; text-align:right; color:#999;}
</style>
<div id="main">		
	<?=$this->load->view("admin/books/submenu")?>
	<h3>借书</h3>
	<div id="panelForm" class="form">
	<?=form_open("admin/books/lendpost/".$bookid)?>
		<table>
			<tr>
				<td class="label">书名：</td>
				<td><?=$bookname?></td>			
			</tr>
			<tr>
				<td class="label">借书人：</td>
				<td>
					<select name="member">
						<option value="-1">-- 请选择借书人 --</option>
					<?php
					foreach($members->result() as $row){
						echo "<option value=\"".$row->memberid."\">".$row->membername."(".$row->memberemail.")"."</option>";						
					}
					?>
					</select>
				</td>	
			</tr>
			<tr>
				<td class="label"></td>
				<td><button class="submit">提交</button></td>
			</tr>
		</table>		
	<?=form_close()?>
	</div>
</div>
<?=$this->load->view("admin/footer")?>