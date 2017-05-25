<?php 
include("dc.php");
require 'twilio-php-master/Twilio/autoload.php';

$_h = curl_init();
curl_setopt($_h, CURLOPT_HEADER, 1);
curl_setopt($_h, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($_h, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($_h, CURLOPT_HTTPGET, 1);
curl_setopt($_h, CURLOPT_URL, 'https://api.twilio.com' );
curl_setopt($_h, CURLOPT_PROXY, "192.168.0.102");

//CURLOPT_SSL_VERIFYPEER => FALSE
curl_setopt($_h, CURLOPT_DNS_USE_GLOBAL_CACHE, false );
curl_setopt($_h, CURLOPT_DNS_CACHE_TIMEOUT, 2 );

curl_exec($_h);


use Twilio\Rest\Client;

$url = $_SERVER['REQUEST_URI'];
$parts = parse_url($url);
parse_str($parts['query'], $query);


$query_update = "SELECT * FROM personalinfo per where per.patid=".$query['patId'];


$objSql2 = new SqlClass();

//query_update
$result=$objSql2->executesql($query_update);

$resultObj ;
foreach($result as $data)
{
    $resultObj=$data;
}

if(isSet($_POST['txtresutl']) && isSet($_REQUEST['mobileNum']) && $_REQUEST['mobileNum']!= ''){
    $msgBody ='';
    $mobileNumber = '+91'.$_REQUEST['mobileNum'];
    $resutVal = $_POST['txtresutl'];

 $msgBody="Retinopathy Grade for ".$_POST['firstname']."".$_POST['lastname']."is :".$_POST['txtresutl'];

    if($resutVal==1){//positive case
        $msgBody="You may have TB, Please visit the nearest diagnostic center to get further tests done for confirmation";
    }else if($resutVal==0){
        $msgBody="Hurray! you don't have TB. Take Medications, Persistent condition? visit Physician";
    }
    $sid = 'AC863d8b499c7e972953733bedcc28497e';
    $token = 'd13d76433b3c06cb05c17ca744fe9adc';
    //$sid = 'ACf9fa8f30f553b95e00ef6416c8839cb7'; //Test
    //$token = '50c05a17a4d86988c5458d07e577a8ff'; //Test
    
    $client = new Client($sid, $token);

    $client->messages->create(
    $mobileNumber,
    array(
        'from' => '+15129942875',// 15017250604',
        'body' => $msgBody
        )
    );
    $updateQuery = "UPDATE personalinfo per SET per.statusflag=".$resutVal." WHERE per.id = ".$query['patId'];
    //echo $query; 
    $objSql2->executesql($updateQuery);

    header("Location: resultUploadPage.php"); 
}

?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.12.3.js"></script>
    
</head>
<body>
<form action="#" method="POST">

<input type="hidden" name="patid" id="patid" value="<?php echo  $resultObj['id'];?>" />
<input type="hidden" name="mobileNum" id="mobileNum" value="<?php echo $resultObj['mobile'];?>" />
<input type="hindden" name="firstname" value=" <?php echo  $resultObj['firstname'];?> "/>
<input type="hindden" name="lastname" value=" <?php echo  $resultObj['lastname'];?> "/>
<table cellspacing="0" width="70%" align="center" border="1">
<tr>
        <th>Name</th>
        <th>Mobile</th>
        <th>Response</th>
        <th>Action</th>
</tr>
<tr>
    <td><?php echo $resultObj['name'];?></td>
    <td><?php echo $resultObj['mobile'];?></td>
    <td><input type="text" name="txtresutl" id="txtresult" /></td>
    <td><input type="submit" name="updated" value="Update Result" id="btnUpdate"></td>
</tr>
</table>
</form>
<br/>
<br/>

<hr/>
<table align='center' border='1'>
<tr>
<td>First name</td>
<td><?php echo $resultObj['firstname'];?></td>

<td>Last Name</td>
<td><?php echo $resultObj['lastname'];?></td>

</tr>

<tr>
<td>Mobile</td>
<td><?php echo $resultObj['mobile'];?></td>

<td>Gender</td>
<td><?php echo $resultObj['gender']==0? 'Male': 'Female';?></td>

</tr>

</table>
</body>
</html>