<div id="uploadpic">
	<form action="index.php?c=admin&a=upload_pic" method="post" enctype="multipart/form-data" id="upload_form">
		<div id="menubar">
			<input type="button" id="idea_submit" value="提交" class="icon-save" onclick="check_data()"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" id="idea_reset" style="cursor:pointer;"  value="重置" class="icon-cancel"/>
		</div>
		<div id="margin10" style="height:10px;"></div>
		<div id="picform">
			<p><label>选择图片:</label><input type="file" name="pic"/></p>
			<p><label>图片名称:</label><input type="text" name="name" id="pic_name"/></p>
			<p><label>相册选择</label><select name="albulm_id" id="albulm_ids"></select></p>
			<p><span id="desclabel">图片说明:</span><textarea name="desc" id="pic_desc"></textarea></p>
		</div>
	</form>
</div>

<script>
$(document).ready(function(){
	$("#albulm_ids").combobox({
		url:"index.php?c=admin&a=albulm_list&belong_to=idea",
		valueField:"albulm_id",
		textField:"albulm_name"
	});



});
	
	
</script>