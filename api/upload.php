<?php
	/*define('DB_SERVER','localhost');
	define('DB_USER','baluiny7_adhinav');
	define('DB_PASSWD','abhinav');
	define('DB_NAME','baluiny7_tuber');*/

        define('DB_SERVER','localhost');
	define('DB_USER','abhinavt_abhinav');
	define('DB_PASSWD','Abh1n@v123');
	define('DB_NAME','abhinavt_adhinav');
 
 //$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASSWD,DB_NAME) or die('unable to connect to db');
        $con = mysql_connect(DB_SERVER,DB_USER,DB_PASSWD) or die('unable to connect to db');
        mysql_select_db(DB_NAME, $con) or die(mysql_error());

	if($_SERVER['REQUEST_METHOD']=='POST'){
		$file_name = $_FILES['myFile']['name'];
		$file_size = $_FILES['myFile']['size'];
		$file_type = $_FILES['myFile']['type'];
		$temp_name = $_FILES['myFile']['tmp_name'];
     $idarra=explode("^",$file_name);
     $latest_id=$idarra[0];


				
		$location = "uploads/";
		//$name=$location."/".$file_name);//.".".$file_type;
                $name=$location.$file_name;//.".".$file_type;
		move_uploaded_file($temp_name, $location.$file_name);
		//$sql = "INSERT INTO api (file_name) VALUES ('$name')";
             $query="UPDATE `clinic_info` SET audio_file ='".$name."' WHERE pat_id='".$latest_id."'";
		
		if(mysql_query($query)){ //mysqli_query($con,$query) 
			//file_put_contents($path,base64_decode($image));
			echo "Successfully Uploaded";
		}
		
		mysqli_close($con);
	}else{
		echo "Error";
	}
?>