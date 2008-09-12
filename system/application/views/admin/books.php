<?=$this->load->view("admin/header",$data)?>
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

var removeBook = function(bookid){
	if(! confirm("确定要删除这本书吗？")){
		return false;
	}
	
	$.ajax({
		url:"<?=site_url() ?>/admin/books/remove",
		type:"post",
		dataType:"json",
		data:"bookid="+bookid,
		success:function(results){
			if(results.success){
				$("#item"+bookid).fadeOut(500,function(){
					$(this).remove();
				});
			}
		}
	});
}
</script>
<style type="text/css">
	.list {text-align:center;}
	.list table {width:880px;border:1px solid #DDD;padding:2px; margin:10px auto; text-align:left;	}
	.list table tr { height:22px;}
	.list table tr th { background:#F5F5F5;padding:2px;}
	.list table tr td {padding:2px;}
	.list table tr.lending  td{ background:#EAFFEA;}
	.list table tr.close  td{color:#DDD;}
	.list table span.disabled {color:#DDD;}
	
	.listinfo { width:880px; margin:10px auto; background:#FFFDE9; border:1px solid #EEEBA3; padding:2px;}
	.listinfo .title { font-size:14px; font-weight:bold; color:#DFAC00;padding:5px;}
	.listinfo .content {font-size:12px;padding:5px;color:#999;}
	.listinfo .content ol {list-style-position:inside;}
	.listinfo .content ol li { line-height:150%;}
	
	.searchpanel { margin:5px auto; width:880px; text-algin:center; font-size:14px;}
	
	.pager {  margin:5px auto; width:880px; font-size:14px; text-align:right;}
	
</style>
<script type="text/javascript">
	var doSearch = function(){
		var searchText = $("#txtSearch").val();
		
		location.href = "<?=site_url() ?>/admin/books/index/1/"+searchText;
		return false;
	}
</script>
<div id="main">		
	<?=$this->load->view("admin/books/submenu")?>
	<h2>图书列表</h2>	
	<div class="searchpanel form">
		<?=form_open("admin/books/index")?>
		查询书集：<input type="text" id="txtSearch" name="searchtext" class="text m" value="<?=$searchtext?>" /> <button type="submit" onclick="return doSearch();" class="search">搜索</button>
		<?=form_close()?>
	</div>
	<div class="pager">
		<?=$pagebar ?>
	</div>
	<div class="list">	
		<?php
		if($bookList->num_rows() != 0){
		?>
		<table>
			<tr>
				<th width="50">编号</th><th>书名</th><th width="70">标签</th><th  width="70">媒介</th><th  width="70">内容类型</th><th width="50">书架</th><th width="110"></th>
			</tr>
			<?php
			foreach($bookList->result() as $row){
				$rowClass = "";
				switch ($row->bookstatus){
					case 2:
						$rowClass = "lending";
						break;
					case 3:
						$rowClass = "close";
						break;
				}
			?>
			<tr class="row <?=$rowClass?>" id="item<?=$row->bookid ?>">
				<td><?=$row->bookid ?></td>
				<td><?=$row->bookname ?>
				<?php
					if($row->memberid != -1){
						echo "(已借给：".$row->membername.")";
					}
				?>
				</td>
				<td><?= $row->booklabel ?></td>
				<td><?=$row->typename ?></td>
				<td><?=$row->sortname ?></td>
				<td><?=$row->locationname ?></td>
				<td>
					<?php
					if($row->bookstatus == 1){
					?>						
					<a href="<?= site_url("admin/books/lend")."/".$row->bookid ?>" class="view">借出</a> 
					<?php
					}
					else{
					?>
					<span class="disabled">借出</span>
					<?php
					}
					?>
					<a href="<?= site_url("admin/books/view")."/".$row->bookid ?>" class="view">详细</a> 
					<a href="<?= site_url("admin/books/edit")."/".$row->bookid ?>" class="rename">修改</a> 
					<a href="javascript:void(0);" onclick="removeBook(<?=$row->bookid ?>);" class="delete">删除</a>
				</td>
			</tr>
			<?php
			}
		}
		else{
			?>
			<tr>
				<td style="font-size:14px;">没有找到与关键词 “<strong style="color:red;"><?=$searchtext?></strong>” 相关的书集信息。</td>
			</tr>
			<?php
		}
		?>
		</table>	
	</div>	
	<div class="pager">
		<?=$pagebar ?>
	</div>
	<div class="listinfo">
		<div class="title">列表说明</div>
		<div class="content">
			<ol>
				<li>灰色行表示该书<b>已经丢失</b>；</li>
				<li>淡绿色背景的表示<b style="color:#00C688;">已经借出</b>；</li>
			</ol>
		</div>
	</div>
</div>
<?=$this->load->view("admin/footer",$data)?>
