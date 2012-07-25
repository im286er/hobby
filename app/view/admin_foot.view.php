	<script src="<?php echo $site_url;?>/statics/js/jquery-1.7.1.min.js"></script>
	<script src="<?php echo $site_url;?>/statics/js/jqueryeasyui/jquery.easyui.min.js"></script>
	<script src="<?php echo $site_url;?>/statics/js/admin.js"></script>

	<script>
		var SITE_URL="<?php echo $site_url?>";
		$(document).ready(function(){
			$("#main_content").tabs();
			$("#main_content").tabs("add",{
				title:"相册管理",
				href:"index.php?c=admin&a=idea",
				closable:true,
				height:600
			});


			$("#nav").tree({
				onClick:function(node){
					if(!!node.id){
						var url=node.id;
						var flag=$("#main_content").tabs("exists","相册管理");
						if(!flag){
							$("#main_content").tabs("add",{
								title:"相册管理",
								href:node.id,
								closable:true
							});
						}
						else{
							$("#main_content").tabs("select","相册管理");
							var jtab = $("#main_content").tabs("getSelected"); 
							$.get(url,function(rs){
								$("#main_content").tabs("update",{
								tab:jtab,
								options:{
									content:rs
								}
							
							});
							
							});
							
						
						}
					}
				}
			});
			
			
		});
		
	
	</script>
</body>
</html>