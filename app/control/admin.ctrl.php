<?php
class AdminControl extends Control{

	function index(){
		$site_url=site_url();
		echo "1341";
		load_view("admin_head",array("site_url"=>$site_url));
		load_view("admin_main",array("site_url"=>$site_url));
		load_view("admin_foot",array("site_url"=>$site_url));
	}
	

	function idea() {
		$belong_to=isset($_GET["a"])?trim($_GET["a"]):"idea";
		$rs=daocall("admin","get_albulm",array("","belong_to='{$belong_to}'"));
		$pic_rs=daocall("admin","get_cover",array());
		foreach($rs as $k=>$v){
			foreach($pic_rs as $subk=>$subv){
				if($subv["albulm_id"]==$v["albulm_id"]){
				
					$rs[$k]["cover"]=$subv["location"];
				}
			}
		
		}
		load_view("albulm",array("albulms"=>$rs,"belong_to"=>$belong_to));
	}

	function branding() {
		$belong_to=isset($_GET["a"])?trim($_GET["a"]):"idea";
		
		$rs=daocall("admin","get_albulm",array("","belong_to='{$belong_to}'"));
		$pic_rs=daocall("admin","get_cover",array());
		if($rs){
			foreach($rs as $k=>$v){
				foreach($pic_rs as $subk=>$subv){
					if($subv["albulm_id"]==$v["albulm_id"]){
					
						$rs[$k]["cover"]=$subv["location"];
					}
				}
			
			}
		}
		load_view("albulm",array("albulms"=>$rs,"belong_to"=>$belong_to));
	}
	
	
	function signage() {
		$belong_to=isset($_GET["a"])?trim($_GET["a"]):"idea";
		$rs=daocall("admin","get_albulm",array("","belong_to='{$belong_to}'"));
		$pic_rs=daocall("admin","get_cover",array());

		if($rs){
			foreach($rs as $k=>$v){
				foreach($pic_rs as $subk=>$subv){
					if($subv["albulm_id"]==$v["albulm_id"]){
					
						$rs[$k]["cover"]=$subv["location"];
					}
				}
			
			}
		}
		load_view("albulm",array("albulms"=>$rs,"belong_to"=>$belong_to));
	}


	function idea_upload_form() {
		load_view("upload_pic");
	}

	function upload_pic() {
		if(!$_FILES["pic"]["name"]){
			Umsg("没有选择图片！");
		}
		$pic_name=trim($_POST["name"]);
		$pic_desc=trim($_POST["desc"]);
		$albulm_id=trim($_POST["albulm_id"]);
		$other=array("pic_name"=>$pic_name,"pic_desc"=>$pic_desc,"albulm_id"=>$albulm_id);
		$rs=modcall("admin","upload_pic",array($_FILES,$other));
		if(!$rs) Umsg("上传图片失败");
		Umsg("上传图片成功");
	}
	
	function pic_list() {
		$belong_to=isset($_GET["belong_to"])?trim($_GET["belong_to"]):false;
		if(!$belong_to) Umsg("传入参数有误！请确认");
		$rs=daocall("admin","list_pic",array($belong_to));
		$this->out_result($rs);
	}
	
	function show_albulm_pics() {
		$albulm_id=$_GET["albulm_id"]?intval($_GET["albulm_id"]):0;
		if(!$albulm_id) Umsg("传入参数有误请确认");
		$where="albulm_id={$albulm_id}";
		$rs=daocall("admin","get_pics",array($where));
		load_view("albulm_pics",array("pics"=>$rs));
	}

	function delete_pic() {
		$idstr=isset($_GET["ids"])?trim($_GET["ids"]):false;
		if(!$idstr){
			echo 0;
			exit();
		} 
		$rs=daocall("admin","delete_pic",array($idstr));
		if(!$rs){
			echo 0;
			exit();
		}
		echo 1;
		exit();
	}


	function load_albulm_page() {
		$rs=daocall("admin","get_albulm",array("",""));
		$pic_rs=daocall("admin","get_cover",array());
		foreach($rs as $k=>$v){
			foreach($pic_rs as $subk=>$subv){
				if($subv["albulm_id"]==$v["albulm_id"]){
				
					$rs[$k]["cover"]=$subv["location"];
				}
			
			}
		
		}
		load_view("albulm",array("albulms"=>$rs));
	}

	function get_category() {
		$rs=daocall("admin","get_category",array("cat_name,cat_name",""));
		
		echo json_encode($rs);
	}


	function add_albulm() {
		if(!$_POST) Umsg("添加相册失败");
		$data=$_POST;
		$time=time();
		$data["add_time"]=$time;
		$rs=daocall("admin","add_albulm",array($data));
		if(!$rs) Umsg("添加相册失败");
		$pic_data=array();
		$pic_data["albulm_id"]=$rs;
		$pic_data["pic_name"]="albulm".$rs."_cover";
		$pic_data["pic_desc"]="albulm".$rs."_cover";
		$pic_data["belong_to"]=$_POST["belong_to"];
		$pic_data["is_cover"]=1;
		$pic_data["add_time"]=$time;

		$rs=modcall("admin","upload_pic",array($_FILES,$pic_data));
		if($rs) Umsg("添加相册成功");
		Umsg("添加相册失败");
	}


	function albulm_list() {
		$belong_to=$_GET["belong_to"]?trim($_GET["belong_to"]):false;
		$rs=daocall("admin","get_albulm",array("albulm_id,albulm_name","belong_to='{$belong_to}'"));
		if(!$rs){
			echo json_encode(array());
			exit();
		}
		echo json_encode($rs);
	}
}

