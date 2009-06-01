<?=$this->load->view("admin/header")?>
<style type="text/css">
#main .submenu ul li.sorts a{ color:#666; text-decoration: none;  }
</style>
<script type="text/javascript">
	/**
	 * 删除内容分类
	 */
	var deleteSort = function(id){
		if(! confirm("确定要删除这个内容分类么？")){
			return ;
		}
		
		var item = $("#sortitem"+id);
		var msg = $(".message",item);
		
		msg.removeClass("red");
		msg.html("正在删除...");
		$.ajax({
			url:"sortpost",
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
						msg.html("不能删除存有书集的内容分类。");
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
	 * 重命名内容分类
	 */
	var renameSort = function(id){
		
		var item = $("#sortitem"+id);
		var msg = $(".message",item);
		
		var newName = window.prompt("请输入内容分类名称",$(".name",item).text());
		if(newName == null || newName == ""){
			return ;
		}
		
		msg.removeClass("red");
		msg.html("正在提交...");
		$.ajax({
			url:"sortpost",
			dataType:"json",
			data:"action=rename&id="+id+"&name="+newName,
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
	 * 新建内容分类
	 */
	var createSort = function(id){
		var newName = window.prompt("请输入内容分类名称","");
		if(newName == null || newName == ""){
			return ;
		}
		
		var msg = $("#lblCreateMessage");
		
		msg.removeClass("red");
		msg.html("提交中...");
		$.ajax({
			url:"sortpost",
			dataType:"json",
			data:"action=create&name="+newName,
			type:"post",
			success:function(results){
				switch(results.success){
					case 1:
						msg.html("添加成功。");
						msg.removeClass("red");
						appendSortItem(newName,results.value);
						break;
					case -2:
						msg.addClass("red");
						msg.html("已有相同的内容分类名称存在，添加失败。");
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
	 * 内容分类创建成功后，添加HTML到页面
	 */
	var appendSortItem = function(sortname,sortid){
		var html = "<li class=\"item\" id=\"sortitem"+sortid+"\">";
		html += "<span class=\"name\">"+sortname+"</span>";
		html += "<a href=\"javascript:;\" onclick=\"renameSort("+sortid+");\" class=\"rename\">重命名</a> | ";
		html += "<a href=\"javascript:;\" onclick=\"deleteSort("+sortid+");\" class=\"delete\">删除</a> ";
		html += "<span class=\"message\"></span>";
		html += "</li>";
		$("#sortlist ul").append(html);
	}
	
</script>
<div id="main">		
	<?=$this->load->view("admin/config/submenu")?>
	<h2>内容分类列表 <a href="javascript:void(0);" onclick="createSort();" class="create">新建内容分类</a> <span class="message" id="lblCreateMessage"></span></h2>
	<div class="list" id="sortlist">		
		<ul>
<?php						
foreach ($sorts->result() as $row)
{
	echo "<li class=\"item\" id=\"sortitem".$row->sortid."\">";
	echo "<span class=\"name\">".$row->sortname."</span>";
	echo "<a href=\"javascript:;\" onclick=\"renameSort(".$row->sortid.");\" class=\"rename\">重命名</a> | ";
	echo "<a href=\"javascript:;\" onclick=\"deleteSort(".$row->sortid.");\" class=\"delete\">删除</a> ";
	echo "<span class=\"message\"></span>";
	echo "</li>";
}
?>
		</ul>
	</div>
</div>
<?=$this->load->view("admin/footer")?>
