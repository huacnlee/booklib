<?=$this->load->view("admin/header",$data)?>
<style type="text/css">
.submenu ul li.locations a{ background:#465C8A; color:#FFF; }
</style>
<script type="text/javascript">
	/**
	 * 删除书架
	 */
	var deleteLocation = function(id){
		if(! confirm("确定要删除这个书架么？")){
			return ;
		}
		
		var item = $("#locationitem"+id);
		var msg = $(".message",item);
		
		msg.removeClass("red");
		msg.html("正在删除...");
		$.ajax({
			url:"locationpost",
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
						msg.html("不能删除存有书集的书架。");
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
	 * 重命名书架
	 */
	var renameLocation = function(id){
		
		var item = $("#locationitem"+id);
		var msg = $(".message",item);
		
		var newName = window.prompt("请输入书架名称",$(".name",item).text());
		if(newName == null || newName == ""){
			return ;
		}
		
		msg.removeClass("red");
		msg.html("正在提交...");
		$.ajax({
			url:"locationpost",
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
	 * 新建书架
	 */
	var createLocation = function(id){
		var newName = window.prompt("请输入书架名称","");
		if(newName == null || newName == ""){
			return ;
		}
		
		var msg = $("#lblCreateMessage");
		
		msg.removeClass("red");
		msg.html("提交中...");
		$.ajax({
			url:"locationpost",
			dataType:"json",
			data:"action=create&name="+newName,
			type:"post",
			success:function(results){
				switch(results.success){
					case 1:
						msg.html("添加成功。");
						msg.removeClass("red");
						appendLocationItem(newName,results.value);
						break;
					case -2:
						msg.addClass("red");
						msg.html("已有相同的书架名称存在，添加失败。");
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
	 * 书架创建成功后，添加HTML到页面
	 */
	var appendLocationItem = function(locationname,locationid){
		var html = "<li class=\"item\" id=\"locationitem"+locationid+"\">";
		html += "<span class=\"name\">"+locationname+"</span>";
		html += "<a href=\"javascript:;\" onclick=\"renameLocation("+locationid+");\" class=\"rename\">重命名</a> | ";
		html += "<a href=\"javascript:;\" onclick=\"deleteLocation("+locationid+");\" class=\"delete\">删除</a> ";
		html += "<span class=\"message\"></span>";
		html += "</li>";
		$("#locationlist ul").append(html);
	}
	
</script>
<div id="main">		
	<?=$this->load->view("admin/config/submenu")?>
	<h2>书架列表 <a href="javascript:void(0);" onclick="createLocation();" class="create">新建书架</a> <span class="message" id="lblCreateMessage"></span></h2>
	<div class="list" id="locationlist">		
		<ul>
<?php						
foreach ($locations->result() as $row)
{
	echo "<li class=\"item\" id=\"locationitem".$row->locationid."\">";
	echo "<span class=\"name\">".$row->locationname."</span>";
	echo "<a href=\"javascript:;\" onclick=\"renameLocation(".$row->locationid.");\" class=\"rename\">重命名</a> | ";
	echo "<a href=\"javascript:;\" onclick=\"deleteLocation(".$row->locationid.");\" class=\"delete\">删除</a> ";
	echo "<span class=\"message\"></span>";
	echo "</li>";
}
?>
		</ul>
	</div>
</div>
<?=$this->load->view("admin/footer",$data)?>
