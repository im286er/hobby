	<script src="<?php echo $site_url;?>/statics/js/jquery-1.7.1.min.js"></script>
	<script src="<?php echo $site_url;?>/statics/js/jqueryeasyui/jquery.easyui.min.js"></script>
	<script src="<?php echo $site_url;?>/statics/js/admin.js"></script>

	<script>
		var SITE_URL="<?php echo $site_url?>";
		$(document).ready(function(){
			$("#nav").tree({
				onClick:function(node){
					if(!!node.id){
						var flag=$("#main_content").tabs("exists",node.text);
						if(!flag){
							$("#main_content").tabs("add",{
								title:node.text,
								href:node.id,
								closable:true
							});
						}
						else{
							$("#main_content").tabs("select",node.text);
						
						}
					}
				}
			});
		
			$("#main_content").tabs({
				title:"idea管理",
				content:"index.php?c=admin&a=idea",
				closable:true,
				height:600
			});

			
		});
		
	
	</script>
</body>
</html>