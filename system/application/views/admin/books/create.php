<?=$this->load->view("admin/header")?>
<style type="text/css">
	.form { margin:20px; border:1px solid #CAD0D5; padding:10px;}
	.form table tr td { padding:5px;}
	.form table tr td.label { width:80px; text-align:right; color:#999;}
	
	#main .submenu ul li.create a{ color:#666; text-decoration: none;  }
</style>
<div id="main">			
	<?=$this->load->view("admin/books/submenu")?>
	<div id="panelForm" class="form">
	<?=form_open("admin/books/createpost/")?>
		<table>
			<tr>
				<td class="label">* 书名：</td>
				<td>
					<input type="text" name="bookname" value="" class="text m" /> 					
				</td>
			</tr>
			<tr>
				<td class="label">* 类型：</td>
				<td>	
					<select name="booktype" class="text">							
					<?php
					foreach($booktypes->result() as $row){									
						echo "<option value=\"".$row->typeid."\">".$row->typename."</option>";
					}
					?>
					</select>
					内容分类：
					<select name="booksort" class="text">							
					<?php
					foreach($sorts->result() as $row){					
						echo "<option value=\"".$row->sortid."\">".$row->sortname."</option>";
					}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="label">书架：</td><td>
				<select name="booklocation" class="text">							
					<?php
					foreach($locations->result() as $row){						
						echo "<option value=\"".$row->locationid."\" >".$row->locationname."</option>";
					}
					?>
					</select>
				标签：<input type="text" name="booklabel" value="" class="text s" /> <samp>如：N41251</samp></td>
			</tr>	
			<tr>
				<td class="label">* 出版社：</td>
				<td>
					<select name="bookpub" class="text">	
					<?php
					foreach($pubs->result() as $row){						
						echo "<option value=\"".$row->pubid."\" >".$row->pubname."</option>";
					}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="label">* 评分(1-5)：</td><td><input type="text" name="bookstar" value="1" class="text s"></td>
			</tr>
			<tr>
				<td class="label">ISBN：</td><td><input type="text" name="bookisbn" value="" class="text m"></td>
			</tr>
			<tr>
				<td class="label">* 价格：</td><td><input type="text" name="bookmoney" value="0.00" class="text s"> 元</td>
			</tr>			
			<tr>
				<td class="label">* 购买时间：</td><td><input type="text" name="bookbuytime" value="<?=$buytime ?>" class="text m"></td>
			</tr>
			<tr>
				<td class="label">* 状态：</td>
				<td>
					<select name="bookstatus" class="text">
						<option value="1">普通</option>
						<option value="2">已借出</option>
						<option value="3">已丢失</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="label">简介：</td><td><textarea class="text" name="bookcontent" cols="90" rows="5"></textarea></td>
			</tr>
			<tr>
				<td class="label"></td><td class="tip">以下的多关键词、作者之间请用“,”分隔，如：美食,人物</td>
			</tr>
			<tr>
				<td class="label">关键词：</td><td><input type="text" name="bookkeywords" value="" class="text l" /></td>				
			</tr>					
			<tr>
				<td class="label">作者：</td><td><input type="text" name="bookauthors" value="" class="text l"></td>
			</tr>	
			<tr>
				<td class="label"></td>
				<td><button type="submit" class="submit">提交</button></td>
			</tr>		
		</table>
	<?=form_close()?>
	</div>	
</div>
<?=$this->load->view("admin/footer")?>
