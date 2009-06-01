<?=$this->load->view("admin/header")?>
<style type="text/css">
#main .submenu ul li.password a {color:#666; text-decoration: none;  }
#password { margin:10px;}
#password table tr { height:25px;}
</style>
<div id="main">		
	<?=$this->load->view("admin/config/submenu")?>
	<h2>修改密码</h2>
	<div class="form" id="password">
		<?= form_open("admin/config/modifypasswordpost")?>
		<table>
			<tr>
				<td class="label"></td><td><span class="message <?=$messageclass?>"><?=$messagetext?></span></td>
			</tr>
			<tr>
				<td class="label">旧密码：</td><td><input type="password" class="text m" name="oldpass" /></td>
			</tr>
			<tr>
				<td class="label">新密码：</td><td><input type="password" class="text m" name="newpass" /></td>
			</tr>
			<tr>
				<td class="label">密码确定：</td><td><input type="password" class="text m" name="confirmpass" /></td>
			</tr>
			<tr>
				<td class="label"></td><td><button type="submit" class="submit">提交修改密码</td>
			</tr>
		</table>
		<?= form_close() ?>
	</div>
</div>
<?=$this->load->view("admin/footer")?>
