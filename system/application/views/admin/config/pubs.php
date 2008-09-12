<?=$this->load->view("admin/header",$data)?>
<style type="text/css">
.submenu ul li.pubs a{ background:#465C8A; color:#FFF; }
</style>
<script type="text/javascript">
	/**
	 * 删除出版社
	 */
	var deletePub = function(id){
		if(! confirm("确定要删除这个出版社么？")){
			return ;
		}
		
		var item = $("#pubitem"+id);
		var msg = $(".message",item);
		
		msg.removeClass("red");
		msg.html("正在删除...");
		$.ajax({
			url:"pubpost",
			dataType:"json",
			data:"action=delete&id="+id,
			type:"post",
			success:function(results){
				switch(results.success){
					case 1:
						item.fadeOut(200,function(){
							$(this).remove();
						});
						break;
					case -2:
						msg.addClass("red");
						msg.html("不能删除存有书集的出版社。");
						break;
					default:
						msg.addClass("red");
						msg.html("程序异常，提交失败。");
						break;
				}
			}
		});
	}
	
	/**
	 * 重命名出版社
	 */
	var renamePub = function(id){
		
		var item = $("#pubitem"+id);
		var msg = $(".message",item);
		
		var newName = window.prompt("请输入出版社名称",$(".name",item).text());
		if(newName == null || newName == ""){
			return ;
		}
		
		msg.removeClass("red");
		msg.html("正在提交...");
		$.ajax({
			url:"pubpost",
			dataType:"json",
			data:"action=rename&id="+id+"&name="+ newName,
			type:"post",
			success:function(results){
				switch(results.success){
					case 1:
						msg.removeClass("red");
						msg.html("修改成功。");
						$(".name",item).text(newName);
						break;
					default:
						msg.addClass("red");
						msg.html("程序异常，提交失败。");
						break;
				}
			}
		});
	}
	
	/**
	 * 新建出版社
	 */
	var createPub = function(id){
		var newName = window.prompt("请输入出版社名称","");
		if(newName == null || newName == ""){
			return ;
		}
		
		var msg = $("#lblCreateMessage");
		
		msg.removeClass("red");
		msg.html("提交中...");
		$.ajax({
			url:"pubpost",
			dataType:"json",
			data:"action=create&name="+newName,
			type:"post",
			success:function(results){
				switch(results.success){
					case 1:
						msg.html("添加成功。");
						msg.removeClass("red");
						appendPubItem(newName,results.value);
						break;
					case -2:
						msg.addClass("red");
						msg.html("已有相同的出版社名称存在，添加失败。");
						break;
					default:
						msg.addClass("red");
						msg.html("程序异常，提交失败。");
						break;
				}
			}
		});
	}
	
	/**
	 * 出版社创建成功后，添加HTML到页面
	 */
	var appendPubItem = function(pubname,pubid){
		var html = "<li class=\"item\" id=\"pubitem"+pubid+"\">";
		html += "<span class=\"name\">"+pubname+"</span>";
		html += "<a href=\"javascript:;\" onclick=\"renamePub("+pubid+");\" class=\"rename\">重命名</a> | ";
		html += "<a href=\"javascript:;\" onclick=\"deletePub("+pubid+");\" class=\"delete\">删除</a> ";
		html += "<span class=\"message\"></span>";
		html += "</li>";
		$("#publist ul").append(html);
	}
	
</script>
<div id="main">		
	<?=$this->load->view("admin/config/submenu")?>
	<h2>出版社列表 <a href="javascript:void(0);" onclick="createPub();" class="create">新建出版社</a> <span class="message" id="lblCreateMessage"></span></h2>
	<div class="list" id="publist">		
		<ul>
<?php						
foreach ($pubs->result() as $row)
{
	echo "<li class=\"item\" id=\"pubitem".$row->pubid."\">";
	echo "<span class=\"name\">".$row->pubname."</span>";
	echo "<a href=\"javascript:;\" onclick=\"renamePub(".$row->pubid.");\" class=\"rename\">重命名</a> | ";
	echo "<a href=\"javascript:;\" onclick=\"deletePub(".$row->pubid.");\" class=\"delete\">删除</a> ";
	echo "<span class=\"message\"></span>";
	echo "</li>";
}
?>
		</ul>
	</div>
</div>
<?=$this->load->view("admin/footer",$data)?>
