<?php
	$usename = "";
	$password = "";
	if($_POST){
		$usename = $_POST["username"];
		$password = $_POST["password"];
	}
?>
<?=$this->load->view("admin/header")?>
<div id="main">		
	<div class="form login" id="panelLogin">	
		<?=form_open("admin/login/submit")?>
		<table>
			<tr>
				<td></td><td><div class="message <?=$messageclass?>"><?=$message?></div></td>
			</tr>
			<tr>
				<td class="label">用户名：</td><td><input type="text" value="<?=$usename?>" name="username" class="text m" /></td>
			</tr>
			<tr>
				<td class="label">密码：</td><td><input type="password" value="<?=$password?>"  name="password" class="text m" /></td>
			</tr>
			<tr>
				<td></td><td><button type="submit" class="submit">登录</button></td>
			</tr>
		</table>
		<?=form_close()?>
	</div>
</div>
<?=$this->load->view("admin/footer")?>