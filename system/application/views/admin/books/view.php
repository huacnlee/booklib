<?=$this->load->view("admin/header")?>
<style type="text/css">
	.form { margin:20px; border:1px solid #CAD0D5; padding:10px;}
	.form table tr td { padding:5px;}
	.form table tr td.label { width:80px; text-align:right; color:#999;}
	.booktitle {font-size:16px; font-weight:bold;}
</style>
<div id="main">			
	<?=$this->load->view("admin/books/submenu")?>
	<div id="panelForm" class="form">
		<table>
			<tr>
				<td class="label">书名：</td>
				<td class="booktitle"><?=$bookinfo->bookname ?>				
					<a href="<?= site_url("admin/books/edit")."/".$bookid ?>" class="delete">修改</a> 
				</td>
			</tr>
			<tr>
				<td class="label">类型：</td>
				<td><?=$typename?></td>
			</tr>
			<tr>
				<td class="label">内容分类：</td>
				<td><?=$sortname?></td>
			</tr>
			<tr>
				<td class="label">书架：</td>
				<td><?=$locationname?></td>				
			</tr>
			<tr>
				<td class="label">标签：</td>
				<td><?=$bookinfo->booklabel ?></td>
			</tr>
			<tr>
				<td class="label">* 出版社：</td>
				<td><?=$pubname?></td>
			</tr>
			<tr>
				<td class="label">评分：</td><td><?=$bookinfo->bookstar ?></td>
			</tr>
			<tr>
				<td class="label">ISBN：</td><td><?=$bookinfo->bookisbn ?></td>
			</tr>
			<tr>
				<td class="label">价格：</td><td><?=$bookinfo->bookmoney ?> 元</td>
			</tr>			
			<tr>
				<td class="label">购买时间：</td><td><?=$buytime ?></td>
			</tr>
			<tr>
				<td class="label">状态：</td>
				<td>
					<?php
						switch ($bookinfo->bookstatus){
							case 1:
								echo "普通";
								break;
							case 2:
								echo "已借出";
								break;
							case 3:
								echo "丢失";
								break;
						}
					?>
				</td>
			</tr>
			<tr>
				<td class="label" valign="top">简介：</td>
				<td valign="top"><?=$bookinfo->bookcontent ?></td>
			</tr>
			<tr>
				<td class="label" valign="top">关键词：</td>
				<td valign="top"><?=$bookinfo->bookkeywords ?></td>				
			</tr>					
			<tr>
				<td class="label" valign="top">作者：</td>
				<td valign="top"><?=$bookinfo->bookauthors ?></td>
			</tr>
		</table>
	</div>	
</div>
<?=$this->load->view("admin/footer")?>
