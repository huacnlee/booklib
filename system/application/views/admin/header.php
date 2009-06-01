<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title ?></title>
<link rel="stylesheet" href="<?=base_url() ?>styles/cp/html.css" media="screen" />
<link rel="stylesheet" href="<?=base_url() ?>styles/cp/<?=$css_filename?>.css" media="screen" />
<script type="text/javascript" src="<?=base_url() ?>scripts/jquery.js"></script>
</head>
<body>
<div id="layout">
	<div id="header">
		<div class="inner">
			<div class="left">
				<h1><a href="<?=base_url() ?>"><span class="book">Book</span>Library</a></h1>
			</div>	
			<?=$this->load->view("admin/menubar")?>					
		</div>
	</div>
