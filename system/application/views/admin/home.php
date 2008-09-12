<?=$this->load->view("admin/header",$data)?>
<?php
$yes = "<span style=\"color:green;\">是</span>";
$no = "<span style=\"color:green;\">否</span>";
?>
<div id="main">	
	<h2 style="margin-top:15px;">管理后台首页</h2>
	<div class="tip totalinfo">
		<h3>系统信息</h3>
		<ul>
			<li>当前共有 <?=$bookcount ?> 本图书</li>
			<li>员工 <?=$membercount ?> 人</li>
		</ul>
	</div>
	<div class="tip database">
		<h3>数据库信息</h3>
		<ul>			
			<li>平台：<?=$db_platform ?></li>			
			<li>版本号：<?=$db_version ?></li>
			<li>持续连接：<?php echo @get_cfg_var("mysql.allow_persistent") ? $yes : $no;?></li>
			<li>最大连接数：<?php echo @get_cfg_var("mysql.max_links")==-1 ? "不限" : @get_cfg_var("mysql.max_links");?></li>
		</ul>
	</div>
	<div class="tip database">
		<h3>服务器信息</h3>
		<ul>
			<li>域名：<?php echo @getenv("SERVER_NAME");?></li>
			<li>IP地址：<?php echo @getenv("SERVER_ADDR");?></li>
			<li>端口：<?php echo @getenv("SERVER_PORT");?></li>
			<li>服务器时间：<?php echo date("Y年m月d日 h:i:s",time());?></li>
			<li>操作系统：<?php echo PHP_OS;?></li>
			<li>空间大小：<?php echo intval(diskfreespace(".") / (1024 * 1024)).'Mb';?></li>
			<li>管理员：<?php echo @get_current_user();?></li>
			<li>网站存放目录：<?php echo @getenv("SCRIPT_FILENAME");?></li>
		</ul>
	</div>
	<div class="tip phpinfo">
		<h3>PHP信息</h3>
		<ul>
			<li>版本号：<?=phpversion() ?></li>
			<li>运行方式：<?php echo strtoupper(php_sapi_name());?></li>
			<li>解译引擎：<?php echo @getenv("SERVER_SOFTWARE");?></li>	
			<li>Zend版本：<?php echo zend_version();?></li>		
			<li>通信协议：<?php echo @getenv("server_protocol");?></li>		
			<li>自动定义全局变量：<?php echo @get_cfg_var("register_globals") ? '允许' : '不允许';?></li>
			<li>运行于安全模式：<?php echo @get_cfg_var("safe_mode") ? $yes :$no;?></li>
			<li>显示错误信息：<?php echo @get_cfg_var("display_errors") ? $yes :$no;?></li>	
			<li>动态加载连接库支持：<?php echo @get_cfg_var("enable_dl") ? $yes :$no;?></li>
			<li>使用URL打开文件：<?php echo @get_cfg_var("allow_url_fopen") ? $yes :$no;?></li>
			<li>内存允许量：<?php echo @get_cfg_var("memory_limit");?></li>
			<li>POST最大字节数：<?php echo @get_cfg_var("post_max_size");?></li>
			<li>允许最大上传文件：<?php echo @get_cfg_var("file_uploads") ?  @get_cfg_var("upload_max_filesize") : $error;?></li>
			<li>程序超时限制：<?php echo @get_cfg_var("max_execution_time")."秒";?></li>
			<li>被禁用的函数：<?php echo @get_cfg_var("disable_functions") ? @get_cfg_var("disable_functions") : "没有";?></li>
			<li>短标记&lt;? ?&gt;支持：<?php echo @get_cfg_var("short_open_tag") ? $yes : $no;?></li>
			<li>标记&lt;% %&gt;支持：<?php echo @get_cfg_var("asp_tags") ? $yes : $no;?></li>
			<li>Cookie支持：<?php echo isset($HTTP_COOKIE_VARS) ? $yes : $no;?></li>
			<li>SMTP支持：<?php echo @get_cfg_var("SMTP") ? $yes : $no;?></li>
			<li>SMTP地址：<?php echo @get_cfg_var("SMTP");?></li>
		</ul>
	</div>	
</div>
<?=$this->load->view("admin/footer",$data)?>
