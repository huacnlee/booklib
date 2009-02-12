<?=$this->load->view("admin/header",$data)?>
<style type="text/css">
	.form { margin:20px; border:1px solid #CAD0D5; padding:10px;}
	.form table tr td { padding:5px;}
	.form table tr td.label { width:80px; text-align:right; color:#999;}
	#main .submenu ul li.list a{ background:#465C8A; color:#FFF; }
	.list {text-align:center;}
	.list table {width:880px;border:1px solid #DDD;padding:2px; margin:10px auto; text-align:left;	}
	.list table tr { height:22px;}
	.list table tr th { background:#F5F5F5;padding:2px;}
	.list table tr td {padding:2px;}
</style>
<script type="text/javascript">
$("#main .list").ready(function(){
	var list = $(this);
	$("tr.row",$(this)).mouseover(function(){
		rowHover($(this));
	});
	
	$("tr.row",$(this)).mouseout(function(){
		rowBlur($(this));
	});
});

var rowHover = function(el){
	el.css("background:#F5F5F5");
}

var rowBlur = function(el){
	el.css("background:#FFF");
}	

var removeMember = function(id){
	if(! confirm("确定要删除这个员工吗？")){
		return false;
	}
	
}
</script>

<div id="main">		
	<?=$this->load->view("admin/members/submenu")?>	
	<h2>员工列表</h2>
	<?=form_open("admin/members/removepost")?>
	<div class="list">
		<table>
			<tr>
				<th width="50">编号</th><th>姓名</th><th width="190">电话</th><th  width="270">E-mail</th><th width="110"></th>
			</tr>
		
		<?php
		foreach($members->result() as $row){
			?>
			<tr class="row" id="item<?=$row->memberid ?>">
				<td><?=$row->memberid ?></td>
				<td><?=$row->membername ?></td>
				<td><?=$row->membertel ?></td>
				<td><a href="mailto:<?=$row->memberemail ?>"><?=$row->memberemail ?></a></td>
				<td>
					<a href="" class="view">借书记录</a> 
					<a href="<?= site_url("admin/members/edit")."/".$row->memberid ?>" class="rename">修改</a> 					
					<a href="javascript:void(0);" onclick="removeMember(<?=$row->memberid ?>);" class="delete">删除</a>
				</td>
			</tr>
			<?php
		}
		?>
		</table>
		<?php echo $this->pagination->create_links(); ?>
	</div>	
	<?=form_close()?>
</div>
<?=$this->load->view("admin/footer",$data)?>
