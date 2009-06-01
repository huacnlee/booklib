<?=$this->load->view("admin/header")?>
<style type="text/css">
#main .submenu ul li.authors a{  color:#666; text-decoration: none;  }
span.name {font-size:14px; padding:8px;}
.list { line-height:24px;}
</style>
<script type="text/javascript">
	/**
	 * 删除作者
	 */
	var deleteAuthor = function(id){
		if(! confirm("确定要删除这个作者么？")){
			return ;
		}
		
		var item = $("#authoritem"+id);
		var msg = $(".message",item);
		
		msg.removeClass("red");
		msg.html("正在删除...");
		$.ajax({
			url:"authorpost",
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
						msg.html("不能删除存有书集的作者。");
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
	 * 重命名作者
	 */
	var renameAuthor = function(id){
		
		var item = $("#authoritem"+id);
		var msg = $(".message",item);
		
		var newName = window.prompt("请输入作者姓名",$(".name",item).text());
		if(newName == null || newName == ""){
			return ;
		}
		
		msg.removeClass("red");
		msg.html("正在提交...");
		$.ajax({
			url:"authorpost",
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
	 * 新建作者
	 */
	var createAuthor = function(id){
		var newName = window.prompt("请输入作者姓名","");
		if(newName == null || newName == ""){
			return ;
		}
		
		var msg = $("#lblCreateMessage");
		
		msg.removeClass("red");
		msg.html("提交中...");
		$.ajax({
			url:"authorpost",
			dataType:"json",
			data:"action=create&name="+newName,
			type:"post",
			success:function(results){
				switch(results.success){
					case 1:
						msg.html("添加成功。");
						msg.removeClass("red");
						appendAuthorItem(newName,results.value);
						break;
					case -2:
						msg.addClass("red");
						msg.html("已有相同的作者姓名存在，添加失败。");
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
	 * 作者创建成功后，添加HTML到页面
	 */
	var appendAuthorItem = function(authorname,authorid){
		html += "<span class=\"name\">"+authorname+"</span>";
		$("#authorlist ul").append(html);
	}
</script>
<div id="main">		
	<?=$this->load->view("admin/config/submenu")?>
	<h2>作者列表 <a href="javascript:void(0);" onclick="createAuthor();" class="create">添加作者</a> <span class="message" id="lblCreateMessage"></span></h2>
	<div class="list" id="authorlist">		
		<ul>
<?php						
foreach ($authors->result() as $row)
{
	echo "<span class=\"name\">".$row->authorname."</span>";
}
?>
		</ul>
	</div>
</div>
<?=$this->load->view("admin/footer")?>