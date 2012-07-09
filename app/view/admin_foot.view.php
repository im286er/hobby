	<script src="<?php echo $site_url;?>/statics/js/jquery-1.7.1.min.js"></script>
	<script src="<?php echo $site_url;?>/statics/js/jqueryeasyui/jquery.easyui.min.js"></script>
	<script>
		var SITE_URL="<?php echo $site_url?>";
		$(document).ready(function(){
			$("#nav").tree({
				onClick:function(node){
					$("#main_content").tabs("add",{
						title:node.text,
						href:node.id,
						closable:true
					});
				}
			});
		
			$("#main_content").tabs({
				
			});
		});
		
	
	</script>
</body>
</html>