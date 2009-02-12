<?=$this->load->view("admin/header",$data)?>
<style type="text/css">
#main .submenu ul li.booktypes a{ background:#465C8A; color:#FFF; }
</style>
<script type="text/javascript">
	/**
	 * 删除类型
	 */
	var deleteBookTypes = function(id){
		if(! confirm("确定要删除这个类型么？")){
			return ;
		}
		
		var item = $("#booktypeitem"+id);
		var msg = $(".message",item);
		
		msg.removeClass("red");
		msg.html("正在删除...");
		$.ajax({
			url:"booktypepost",
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
					default:
						msg.addClass("red");
						msg.html("程序异常，提交失败。");
						break;
				}
			}
		});
	}
	
	/**
	 * 重命名类型
	 */
	var renameBookTypes = function(id){
		
		var item = $("#booktypeitem"+id);
		var msg = $(".message",item);
		
		var newName = window.prompt("请输入类型名称",$(".name",item).text());
		if(newName == null || newName == ""){
			return ;
		}
		
		msg.removeClass("red");
		msg.html("正在提交...");
		$.ajax({
			url:"booktypepost",
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
	 * 新建类型
	 */
	var createBookTypes = function(id){
		var newName = window.prompt("请输入类型名称","");
		if(newName == null || newName == ""){
			return ;
		}
		
		var msg = $("#lblCreateMessage");
		
		msg.removeClass("red");
		msg.html("提交中...");
		$.ajax({
			url:"booktypepost",
			dataType:"json",
			data:"action=create&name="+newName,
			type:"post",
			success:function(results){
				switch(results.success){
					case 1:
						msg.html("添加成功。");
						msg.removeClass("red");
						appendBookTypesItem(newName,results.value);
						break;
					case -2:
						msg.addClass("red");
						msg.html("已有相同的类型名称存在，添加失败。");
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
	 * 类型创建成功后，添加HTML到页面
	 */
	var appendBookTypesItem = function(booktypename,booktypeid){
		var html = "<li class=\"item\" id=\"booktypeitem"+booktypeid+"\">";
		html += "<span class=\"name\">"+booktypename+"</span>";
		html += "<a href=\"javascript:;\" onclick=\"renameBookTypes("+booktypeid+");\" class=\"rename\">重命名</a> | ";
		html += "<a href=\"javascript:;\" onclick=\"deleteBookTypes("+booktypeid+");\" class=\"delete\">删除</a> ";
		html += "<span class=\"message\"></span>";
		html += "</li>";
		$("#booktypelist ul").append(html);
	}
	
</script>
<div id="main">		
	<?=$this->load->view("admin/config/submenu")?>
	<h2>类型列表 <a href="javascript:void(0);" onclick="createBookTypes();" class="create">新建类型</a> <span class="message" id="lblCreateMessage"></span></h2>
	<div class="list" id="booktypelist">		
		<ul>
<?php						
foreach ($booktypes->result() as $row)
{
	echo "<li class=\"item\" id=\"booktypeitem".$row->typeid."\">";
	echo "<span class=\"name\">".$row->typename."</span>";
	echo "<a href=\"javascript:;\" onclick=\"renameBookTypes(".$row->typeid.");\" class=\"rename\">重命名</a> | ";
	echo "<a href=\"javascript:;\" onclick=\"deleteBookTypes(".$row->typeid.");\" class=\"delete\">删除</a> ";
	echo "<span class=\"message\"></span>";
	echo "</li>";
}
?>
		</ul>
	</div>
</div>
<?=$this->load->view("admin/footer",$data)?>
