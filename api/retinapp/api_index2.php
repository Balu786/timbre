<?php
//include("api_functions.php");
include("webapi.php");
//header('Content-type: application/json');
$postCheck="Not working...";
if(count($_GET) > 0)
{
       // echo "-->".$_GET['action'];
	$action = $_GET['action'];
}
else if(count($_GET) == 0)
{
	$postCheck="Get with zero args..fine...";
}
else
{
	$postCheck="POST working...fine...";
}
$json = file_get_contents('php://input');
//print_r($json);
//echo "Reached this point";
//exit(0);



$data=null;
$array = json_decode($json, true);
if($array==null || $array =='' )
{
	//print "Array is null";
}
if($array!=null || $array !='' )
{
	$encode_data=json_encode($json,true);
	$rows = '';
	foreach($array as $key=>$value)
	{
		$data= $key; 
	}
}

//$api_class=new Api_function();
$api_class=new model();
switch ($action)
{
	case "regUser":
           //echo $_POST['fname']; exit();
           $firstname=$_POST['fname'];
           $lastname=$_POST['lname'];
	   $mobile=$_POST['mobile'];
	   $gender=$_POST['gender'];
           $age=$_POST['age'];
           $diabeticsince=$_POST['diabeticsince'];
	   $diabetestype=$_POST['diabetestype'];
           $proteinurea=$_POST['proteinurea'];
           $lipids=$_POST['lipids'];
	   $triglycerrides=$_POST['triglycerrides'];
           $eyesight=$_POST['eyesight'];
           $h1bac = $_POST['h1bac'];

           

           $data=null;
           $json='{"regUser":[{"firstname":"'.$firstname.'","gender":"'.$gender.'","mobile":"'.$mobile.'","lastname":"'.$lastname.'","age":"'.$age.'","diabeticsince":"'.$diabeticsince.'","diabetestype":"'.$diabetestype.'","proteinurea":"'.$proteinurea.'","lipids":"'.$lipids.'","triglycerrides":"'.$triglycerrides.'","eyesight":"'.$eyesight.'","h1bac":"'.$h1bac .'"}]}';	

           $array = json_decode($json, true);
           if($array==null || $array =='' ){
           }
	    if($array!=null || $array !='' )
		{
			$encode_data=json_encode($json,true);
			$rows = '';
			foreach($array as $key=>$value)
			 {
				$data= $key; 
			}
		}
		//$data = $api_class->dbRegUser($array, $data);
                $data = $api_class->addUser($array, $data);
//addUser
		break;		
		
    default:
		break;
}

if($data != null){
	//print_r($data);
	$result=$data;
	$status="success";
	$message="";
}else{
	$result=null;
	$status="failure";
	$message="unable process request";
}
$response = ["status"=>$status,"message"=>$message,"result"=>$result,];
print json_encode($data);
?>