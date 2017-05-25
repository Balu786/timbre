<?php
include("api_functions.php");

//header('Content-type: application/json');
$postCheck="Not working...";
if(count($_GET) > 0)
{
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

//$json='{"regUser":[{"fname":"vimal","lname":"kumar","gender":"male","phno":"759712811","email":"teja@gmail.com","password":"12354","cnf_password":"12354","yof_study":"1","yof_grad":"2017","spec":"1","college_name":"1","university":"1","state":"1","district":"1","city":"1","image_path":"","college_type":"1"}]}';

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

$api_class=new Api_function();
switch ($action)
{
	case "regUser":				
		
           $name=$_POST['getName'];
           $mobile=$_POST['getmobile'];
           $gender=$_POST['getsex'];
          $age=$_POST['getage'];
           $pinzipcode=$_POST['getzipcode1'];
           $married_status=$_POST['getmarried_status'];
           $getheight=$_POST['getheight'];
           $weight=$_POST['getwiedth'];
$getsmoke=$_POST['getsmoke'];

$getsuger=$_POST['getsuger'];
$getbp=$_POST['getbp'];
$getheadache=$_POST['getheadache'];
$gettravellingMode=$_POST['gettravellingMode'];
$getcough=$_POST['getcough'];
$getnight=$_POST['getnight'];
$getioss=$_POST['getioss'];

$getpromiscuity=$_POST['getpromiscuity'];
$getalcohol=$_POST['getalcohol'];
$getsubstanceUsage=$_POST['getsubstanceUsage'];
$gettravellingFrequncy=$_POST['gettravellingFrequncy'];
$getbronchitis=$_POST['getbronchitis'];
$gettemparature=$_POST['gettemparature'];



           $data=null;
           $json='{"regUser":[{"name":"'.$name.'","gender":"'.$gender.'","mobile":"'.$mobile.'","married_status":"'.$married_status.'","getheight":"'.$getheight.'","weight":"'.$weight.'","age":"'.$age.'","pinzipcode":"'.$pinzipcode.'","getsmoke":"'.$getsmoke.'","getsuger":"'.$getsuger.'","getbp":"'.$getbp.'","getheadache":"'.$getheadache.'","gettravellingMode":"'.$gettravellingMode.'","getcough":"'.$getcough.'","getnight":"'.$getnight.'","getioss":"'.$getioss.'","getpromiscuity":"'.$getpromiscuity.'","getalcohol":"'.$getalcohol.'","getsubstanceUsage":"'.$getsubstanceUsage.'","gettravellingFrequncy":"'.$gettravellingFrequncy.'","getbronchitis":"'.$getbronchitis.'","gettemparature":"'.$gettemparature.'"}]}';	

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
		$data = $api_class->dbRegUser($array, $data);
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