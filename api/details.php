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
//echo $url;
$parts = parse_url($url);
parse_str($parts['query'], $query);
//echo $query['patId'];

$query_update = "SELECT p.id, p.name, p.mobile, p.occupation, p.age, p.gender, p.height, p.weight, p.marital_status,p.zipcode,ci.smoking,ci.fever_pattern,ci.chestpain,ci.alcohol,ci.diabetes,ci.supplement,ci.night_sweat,ci.loss_appetite,ci.excercise,ci.hbac, ci.bp, ci.app_pattern, ci.cough_freq,ci.cough_type,ci.other_cough,ci.travel_freq,ci.current_meditation FROM patient p JOIN clinic_info ci ON p.id = ci.pat_id and p.id =". $query['patId'];

//$query = "SELECT p.id, p.name, p.mobile FROM patient p where p.statusflag='-1' and p.id =". $query['patId'];// where username='$userName' and password='$password'";
//echo $query_update; 

$objSql2 = new SqlClass();

//query_update
$result=$objSql2->executesql($query_update);
//$result=$objSql2->executesql($query);
$resultObj ;
foreach($result as $data)
{
    $resultObj=$data;
}

if(isSet($_POST['txtresutl']) && isSet($_REQUEST['mobileNum']) && $_REQUEST['mobileNum']!= ''){
    $msgBody ='';
    $mobileNumber = '+91'.$_REQUEST['mobileNum'];
    $resutVal = $_POST['txtresutl'];
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
    $updateQuery = "UPDATE patient SET statusflag = ".$resutVal." WHERE id = ".$_REQUEST["patid"];
    //echo $query; 
    //$objSql3 = new SqlClass();
    $objSql2->executesql($updateQuery);

    header("Location: resultUploadPage.php"); 
}

?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.12.3.js"></script>
    <script type="text/javascript"> 
    $(document).ready(function() { 
    $("#btnUpdate").click(function(){
        //alert("button");
       var screeningResult = $('#txtresult').val();
        if(screeningResult===0){ //Negitive case
            var tempURL = "http://158.69.130.136:9091/SMSPANELAPI?username=satish.ksd&pwd=satish.ksd&msisdn=7207635586&msg=Negitive, you dont have TB symptoms&senderid=gvktur";
            $.ajax({  

                         useDefaultXhrHeader: false,

                        cors: true,

                        type:  'GET',

                        url:   tempURL,

                        dataType: 'xml',

                        success: function(xml){

                            alert('aaa');

                        }

                     });
        }
        if(screeningResult===1){ //positive case
            var tempURL = "http://158.69.130.136:9091/SMSPANELAPI?username=satish.ksd&pwd=satish.ksd&msisdn=7207635586&msg=Positive you dont have TB symptoms&senderid=gvktur";

            $.ajax({  

                         useDefaultXhrHeader: false,

                        cors: true,

                        type:  'GET',

                        url:   tempURL,

                        dataType: 'xml',

                        success: function(xml){

                            alert('aaa');

                        }

                     });
        }
    });
    });
    </script>
</head>
<body>
<form action="#" method="POST">

<input type="hidden" name="patid" id="patid" value="<?php echo  $resultObj['id'];?>" />
<input type="hidden" name="mobileNum" id="mobileNum" value="<?php echo $resultObj['mobile'];?>" />
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
<td>Name</td>
<td><?php echo $resultObj['name'];?></td>

<td>Mobile Number</td>
<td><?php echo $resultObj['mobile'];?></td>

</tr>

<tr>
<td>Occupation</td>
<td><?php echo $resultObj['occupation'];?></td>

<td>Age</td>
<td><?php echo $resultObj['age'];?></td>

</tr>

<tr>
<td>Gender</td>
<td><?php echo $resultObj['gender'];?></td>

<td>Height</td>
<td><?php echo $resultObj['height'];?></td>

</tr>


<tr>
<td>Weight</td>
<td><?php echo $resultObj['weight'];?></td>

<td>Marital status</td>
<td><?php echo $resultObj['marital_status'];?></td>

</tr>

<tr>
<td>zipcode</td>
<td><?php echo $resultObj['zipcode'];?></td>

<td>smoking</td>
<td><?php echo $resultObj['smoking'];?></td>

</tr>


<tr>
<td>fever_pattern</td>
<td><?php echo $resultObj['fever_pattern'];?></td>

<td>chestpain</td>
<td><?php echo $resultObj['chestpain'];?></td>

</tr>

<tr>
<td>alcohol</td>
<td><?php echo $resultObj['alcohol'];?></td>

<td>diabetes</td>
<td><?php echo $resultObj['diabetes'];?></td>

</tr>

<tr>
<td>supplement</td>
<td><?php echo $resultObj['supplement'];?></td>

<td>night_sweat</td>
<td><?php echo $resultObj['night_sweat'];?></td>

</tr>

<tr>
<td>loss_appetite</td>
<td><?php echo $resultObj['loss_appetite'];?></td>

<td>excercise</td>
<td><?php echo $resultObj['excercise'];?></td>

</tr>

<tr>
<td>fever_pattern</td>
<td><?php echo $resultObj['fever_pattern'];?></td>

<td>chestpain</td>
<td><?php echo $resultObj['chestpain'];?></td>

</tr>

<tr>
<td>alcohol</td>
<td><?php echo $resultObj['alcohol'];?></td>

<td>diabetes</td>
<td><?php echo $resultObj['diabetes'];?></td>

</tr>

<tr>
<td>supplement</td>
<td><?php echo $resultObj['supplement'];?></td>

<td>night_sweat</td>
<td><?php echo $resultObj['night_sweat'];?></td>

</tr>

<tr>
<td>loss of appetite</td>
<td><?php echo $resultObj['loss_appetite'];?></td>

<td>excercise</td>
<td><?php echo $resultObj['excercise'];?></td>

</tr>

<tr>
<td>hbac</td>
<td><?php echo $resultObj['hbac'];?></td>

<td>bp</td>
<td><?php echo $resultObj['bp'];?></td>

</tr>

<tr>
<td>app_pattern</td>
<td><?php echo $resultObj['app_pattern'];?></td>

<td>cough_freq</td>
<td><?php echo $resultObj['cough_freq'];?></td>

</tr>

<tr>
<td>cough_type</td>
<td><?php echo $resultObj['cough_type'];?></td>

<td>other_cough</td>
<td><?php echo $resultObj['other_cough'];?></td>

</tr>

<tr>
<td>travel_freq</td>
<td><?php echo $resultObj['travel_freq'];?></td>

<td>current_meditation</td>
<td><?php echo $resultObj['current_meditation'];?></td>

</tr>




</table>
<a href="#" id ="export" role='button'>Export CSV File</a>

<div id="dvData">
<table style="display:none">
<tr>
<th>Name</th>
<th>Gender</th>
<th>Age</th>
<th>Height</th>
<th>Weight</th>
<th>BMI</th>
<th>Smoking</th>
<th>Marital Status</th>
<th>Pre-Existing conditions (HIV, Diabetes, Other Auto immune)</th>
<th>Surgeris in recent past-Boolean</th>
</tr>

<tr>

<td><?php echo $resultObj['name'];?></td>
<td><?php echo $resultObj['gender'];?></td>
<td><?php echo $resultObj['age'];?></td>
<td><?php echo $resultObj['height'];?></td>
<td><?php echo $resultObj['weight'];?></td>
<td>null</td>
<td><?php echo $resultObj['smoking'];?></td>
<td><?php echo $resultObj['marital_status'];?></td>
<td><?php echo $resultObj['hiv'] ==''?'null':$resultObj['hiv'];?>,<?php echo $resultObj['diabetes'] == ''?'null':$resultObj['diabetes'];?>,<?php echo $resultObj['immunity'] == ''?'null':$resultObj['immunity'];?></td>
<td>null</td>
</tr>
</table>

<script type='text/javascript'>
        $(document).ready(function () {

            console.log("HELLO")
            function exportTableToCSV($table, filename) {
                var $headers = $table.find('tr:has(th)')
                    ,$rows = $table.find('tr:has(td)')

                    // Temporary delimiter characters unlikely to be typed by keyboard
                    // This is to avoid accidentally splitting the actual contents
                    ,tmpColDelim = String.fromCharCode(11) // vertical tab character
                    ,tmpRowDelim = String.fromCharCode(0) // null character

                    // actual delimiter characters for CSV format
                    ,colDelim = '","'
                    ,rowDelim = '"\r\n"';

                    // Grab text from table into CSV formatted string
                    var csv = '"';
                    csv += formatRows($headers.map(grabRow));
                    csv += rowDelim;
                    csv += formatRows($rows.map(grabRow)) + '"';

                    // Data URI
                    var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

                $(this)
                    .attr({
                    'download': filename
                        ,'href': csvData
                        //,'target' : '_blank' //if you want it to open in a new window
                });

                //------------------------------------------------------------
                // Helper Functions 
                //------------------------------------------------------------
                // Format the output so it has the appropriate delimiters
                function formatRows(rows){
                    return rows.get().join(tmpRowDelim)
                        .split(tmpRowDelim).join(rowDelim)
                        .split(tmpColDelim).join(colDelim);
                }
                // Grab and format a row from the table
                function grabRow(i,row){
                     
                    var $row = $(row);
                    //for some reason $cols = $row.find('td') || $row.find('th') won't work...
                    var $cols = $row.find('td'); 
                    if(!$cols.length) $cols = $row.find('th');  

                    return $cols.map(grabCol)
                                .get().join(tmpColDelim);
                }
                // Grab and format a column from the table 
                function grabCol(j,col){
                    var $col = $(col),
                        $text = $col.text();

                    return $text.replace('"', '""'); // escape double quotes

                }
            }


            // This must be a hyperlink
            $("#export").click(function (event) {
                // var outputFile = 'export'
                var outputFile = window.prompt("What do you want to name your output file (Note: This won't have any effect on Safari)") || 'export';
                outputFile = outputFile.replace('.csv','') + '.csv'
                 
                // CSV
                exportTableToCSV.apply(this, [$('#dvData>table'), outputFile]);
                
                // IF CSV, don't do event.preventDefault() or return false
                // We actually need this to be a typical hyperlink
            });
        });
    </script
</div>
</body>
</html>