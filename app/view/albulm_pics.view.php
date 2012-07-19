<style>
	#add_albulm_form{padding:10px;}
	#add_albulm_form p{padding:15px;border-bottom:1px solid #99bbe8;overflow:hidden;}
	#add_albulm_form p input{width:300px;height:25px;line-height:25px;border:1px solid #99bbe8;}
	#albulm_pic_display ul{margin:0;padding:0;list-style:none;}
	#albulm_pic_display ul li{width:160px; float:left;margin:10px;display:inline;overflow:hidden;cursor:pointer;}
	#albulm_pic_display ul li #name{text-align:center;font-size:14px;font-weight:600;}
</style>
<div style="padding:10px;">
<div id="menubar">
	<a iconCls="icon-add" id="add_pic" onclick="load_upload_form()">添加图片</a>
</div>
<div id="margin10"></div>
<div  id="albulm_pic_display" style="text-align:left;">
	<ul>
		<?php
			$site_url=site_url();
			if(!$pics){
				echo "暂无相册，请添加";
			}
			else{
				foreach($pics as $k=>$v){
					echo "<li><div><img src='{$site_url}/{$v['location']}' border='0' width='160' height='160'/></div><div id='name'>{$v['pic_name']}</div><input type='hidden' id='albulm_id' value='{$v['albulm_id']}'/></li>";
				}
			
			}
		
		?>
	</ul>
</div>
</div>

<script>
$(document).ready(function(){
	$("#add_pic").linkbutton({plain:false});
	

	$("#albulm_pic_display").panel({
		title:"相册图片列表"
	});

});
	
</script>