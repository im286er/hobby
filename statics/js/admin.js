$(document).ready(function(){
	$("#pic_display li").live("click",function(){
		var albulm_id=$(this).find("#albulm_id").val();
		$("#main_content").tabs("add",{
			title:"相册图片",
			href:"index.php?c=admin&a=show_albulm_pics&albulm_id="+albulm_id,
			closable:true
		
		});
	});


});

function check_data(){
	var name=$("#pic_name").val();
	var desc=$("#pic_desc").val();
	if(!!name==false||!!desc==false){
		__alert("所有内容均不能为空！");
		return false;
	}
	$("#upload_form").submit();
}

function load_upload_form(){
	$("#main_content").tabs("add",{
		title:"idea图片上传",
		href:"index.php?c=admin&a=idea_upload_form",
		closable:true
	});



}

function delete_row(){
	var rs=$("#panel").datagrid("getSelections");
	if(rs.length==0){ __alert("没有选中任何数据");return;}
	var ids="";
	$.each(rs,function(k,v){
		ids+=","+v.id;
	});

	ids=ids.substring(1);
	var data={};
	data.ids=ids;
	$.get("index.php?c=admin&a=delete_pic",data,function(rs){
		if(!!rs){
			__alert("删除成功");
			$("#panel").datagrid("reload");
			return;
		}
		__alert("删除失败");
		return false;
	
	});
}


function albulm_manage(){
	var flag=$("#main_content").tabs("exists","IDEA相册管理");
	if(!flag){
	$("#main_content").tabs("add",{
		title:"IDEA相册管理",
		href:"index.php?c=admin&a=load_albulm_page",
		closable:true,
		padding:10
	
	});
	}
	else{
		$("#main_content").tabs("select","IDEA相册管理");
	}
}

function add_albulm(){
	$("#add_albulm_form").css("display","block");
	$("#add_albulm_form").dialog({
		title:"添加相册",
		width:500,
		height:350,
		modal:true,
		buttons:[
			{
				text:"保存",
				handler:add_albulm_submit
			},
			{
				text:"取消",
				handler:add_albulm_reset
			}
		]
	});

}

function add_albulm_submit(){
		$("#albulm_form").submit();
}
function add_albulm_reset(){


}
function __alert(content,title){
	if(!!title){
		$.messager.alert(title,content);
		return false;
	}
	$.messager.alert("提示",content);
	return false;
};
