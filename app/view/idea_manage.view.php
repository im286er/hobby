<div  id="uploadpic" style="text-align:left;">
	<div id="menubar">
		<a id="idea_manage">idea管理</a>&nbsp;&nbsp;&nbsp;&nbsp;<a id="idea_albulm_manage" onclick="albulm_manage()">idea相册管理</a>&nbsp;&nbsp;&nbsp;&nbsp;<a id="idea_upload" onclick="load_upload_form()">idea图片添加</a>
	</div>
	<div id="margin10"></div>
	<div id="panel" style="text-align:left;">
		
	</div>
</div>

<script>
var fields=[[
	{field:"pic_name",title:"图片名称",width:"180"},
	{field:"pic_desc",title:"图片说明",width:"280"},
	{field:"belong_to",title:"归属于",width:"180"},
	{field:"add_time",title:"添加时间",width:"180"}
]];

$(document).ready(function(){
	$("#idea_manage").linkbutton({
		iconCls:"icon-edit",
		plain:false
	});
	
	$("#idea_upload").linkbutton({
		iconCls:"icon-add",
		plain:false
	
	});

	$("#idea_albulm_manage").linkbutton({
		iconCls:"icon-add",
		plain:false
	
	});

	$("#panel").datagrid({
		title:"图片列表",
		columns:fields,
		rownumbers:true,
		url:"index.php?c=admin&a=pic_list&belong_to=idea",
		toolbar:[
			{
				text:"删除",
				iconCls:"icon-remove",
				handler:delete_row
	
			
			}	
		]
	});




});
	
</script>