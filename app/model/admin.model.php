<?php
class AdminModel extends Model {
	function upload_pic($file=array(),$other=array()) {
		if(!$file||!$other){
			return false;
		}
		$upload=new upload("pic");
		$upload->out_file_dir="./statics/images/idea";
		$upload->out_file_name="idea".time();
		$upload->upload_process();
		$error_no=$upload->error_no;
		if($error_no>0){
			return flase;
		}
		$other["add_time"]=time();
		$other["location"]=trim($upload->saved_upload_name,".");
		$other["belong_to"]="idea";

		$rs=daocall("admin","insert_pic",array($other));
		if(!$rs) return false;
		return true;
	}
}

?>