<?php
//header('Content-type: application/json');
include("webapi.php");
$json = file_get_contents('php://input');

$action="";
if(isset($_GET['action']) && $json=='')
{
	$action=$_GET['action'];
}
$jsonKey=null;
$posted_data = json_decode($json, true);
if(!isset($_GET['action']) && $json!='')
{
if($posted_data!=null || $posted_data !='' )
{
	$encode_data=json_encode($json,true);
	
	$rows = '';
	foreach($posted_data as $key=>$value)
	{
		$jsonKey= $key; 
	}
}
$action=$jsonKey;
}
$api_class=new model();
if($action!='')
{
	switch ($action)
	{
			case "personalDetails";
                            $str=$api_class->addUser($posted_data,$jsonKey);
                            $data=(object)array("status"=>"1","lastId"=>$str);
                            $json_response=json_encode($data);
                            	echo $json_response;
                            
                            
			break;

			case "MoreClinicalDetails";
                       $str=$api_class->addClinic($posted_data,$jsonKey);
                       $data=(object)array("status"=>"1","lastId"=>$str);
                       $json_response=json_encode($data);
	               echo $json_response;
                      
			break;
                       case "UserImage";
                       $str=$api_class->addImage($posted_data,$jsonKey);
                       $data=(object)array("status"=>"1");
                       $json_response=json_encode($data);
	               echo $json_response;
                      
			break;

                default:
			break;
	}
	/*$json_response=json_encode($data);
	echo $json_response;*/
}

?>