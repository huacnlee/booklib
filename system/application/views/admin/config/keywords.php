<?=$this->load->view("admin/header")?>
<style type="text/css">
#main .submenu ul li.keywords a{ color:#666; text-decoration: none;  }
span.name {font-size:14px; padding:6px;}
.list { line-height:24px;}
</style>
<script type="text/javascript">
	/**
	 * 删除关键词
	 */
	var deleteKeyword = function(id){
		if(! confirm("确定要删除这个关键词么？")){
			return ;
		}
		
		var item = $("#keyworditem"+id);
		var msg = $(".message",item);
		
		msg.removeClass("red");
		msg.html("正在删除...");
		$.ajax({
			url:"keywordpost",
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
	 * 重命名关键词
	 */
	var renameKeyword = function(id){
		
		var item = $("#keyworditem"+id);
		var msg = $(".message",item);
		
		var newName = window.prompt("请输入关键词名称",$(".name",item).text());
		if(newName == null || newName == ""){
			return ;
		}
		
		msg.removeClass("red");
		msg.html("正在提交...");
		$.ajax({
			url:"keywordpost",
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
	 * 新建关键词
	 */
	var createKeyword = function(id){
		var newName = window.prompt("请输入关键词名称","");
		if(newName == null || newName == ""){
			return ;
		}
		
		var msg = $("#lblCreateMessage");
		
		msg.removeClass("red");
		msg.html("提交中...");
		$.ajax({
			url:"keywordpost",
			dataType:"json",
			data:"action=create&name="+newName,
			type:"post",
			success:function(results){
				switch(results.success){
					case 1:
						msg.html("添加成功。");
						msg.removeClass("red");
						appendKeywordItem(newName,results.value);
						break;
					case -2:
						msg.addClass("red");
						msg.html("已有相同的关键词名称存在，添加失败。");
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
	 * 关键词创建成功后，添加HTML到页面
	 */
	var appendKeywordItem = function(keywordname,keywordid){
		html += "<span class=\"name\">"+keywordname+"</span>";
		$("#keywordlist ul").append(html);
	}
	
</script>
<div id="main">		
	<?=$this->load->view("admin/config/submenu")?>
	<h2>关键词列表 <a href="javascript:void(0);" onclick="createKeyword();" class="create">新建关键词</a> <span class="message" id="lblCreateMessage"></span></h2>
	<div class="list" id="keywordlist">		
		<ul>
<?php						
foreach ($keywords->result() as $row)
{
	echo "<span class=\"name\">".$row->keywordname."</span>";
}
?>
		</ul>
	</div>
</div>
<?=$this->load->view("admin/footer")?>
