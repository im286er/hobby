<style>
	#add_albulm_form{padding:10px;}
	#add_albulm_form p{padding:15px;border-bottom:1px solid #99bbe8;overflow:hidden;}
	#add_albulm_form p input{width:300px;height:25px;line-height:25px;border:1px solid #99bbe8;}
	#pic_display ul{margin:0;padding:0;list-style:none;}
	#pic_display ul li{width:160px; float:left;margin:10px;display:inline;overflow:hidden;cursor:pointer;}
	#pic_display ul li #name{text-align:center;font-size:14px;font-weight:600;}
</style>
<div style="padding:10px;">
<div id="menubar">
	<a iconCls="icon-add" id="add_albulm" onclick="add_albulm()">添加相册</a>
</div>
<div id="margin10"></div>
<div  id="pic_display" style="text-align:left;">
	<ul>
		<?php
			$site_url=site_url();
			if(!$albulms){
				echo "暂无相册，请添加";
			}
			else{
				foreach($albulms as $k=>$v){
					echo "<li><div><img src='{$site_url}/{$v['cover']}' border='0' width='160' height='160'/></div><div id='name'>{$v['albulm_name']}</div><input type='hidden' id='albulm_id' value='{$v['albulm_id']}'/></li>";
				}
			
			}
		
		?>
	</ul>
</div>
</div>



<div id="add_albulm_form" style="display:none;">
<form id="albulm_form" enctype="multipart/form-data" method="post" action="index.php?c=admin&a=add_albulm">
	<p><label>相册名称:</label><input type="text" name="albulm_name" id="albulm_name"/></p>
	<p><label>相册说明:</label><input type="text" name="albulm_desc" id="albulm_desc"/></p>
	<p><label>相册封面</label><input type="file" name="pic" id="albulm_cover"/></p>

	<p><label>所属类目:</label><select name="belong_to" id="belong_to"></select></p>
</form>
</div>
<script>
var fields=[[
	{field:"albulm_name",title:"相册名称",width:"180",editor:{type:"text"}},
	{field:"albulm_desc",title:"相册说明",width:"280"},
	{field:"belong_to",title:"归属于",width:"180"},
	{field:"add_time",title:"添加时间",width:"180"}
]];

$(document).ready(function(){
	$("#add_albulm").linkbutton({plain:false});
	

	$("#pic_display").panel({
		title:"相册列表"
	});

	$("#albulm_name").validatebox({
		required:true
	});

	$("#albulm_desc").validatebox({
		required:true
	});
	
	$("#belong_to").combobox({
		url:"index.php?c=admin&a=get_category",
		valueField:"cat_name",
		textField:"cat_name"
	
	});
	$("#belong_to").combobox("select","idea");

});
	
</script>