<?php
	define('DB_SERVER','localhost');
	define('DB_USER','abhinavt_abhinav');
	define('DB_PASSWD','Abh1n@v123');
	define('DB_NAME','abhinavt_adhinav');

        
 $con = mysql_connect(DB_SERVER,DB_USER,DB_PASSWD) or die('unable to connect to db');
 //mysql_select_db(DB_NAME,con) or die ("Could not select DatabaseClass");
 mysql_select_db(DB_NAME, $con) or die(mysql_error());
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$file_name = $_FILES['myFile']['name'];
		$file_size = $_FILES['myFile']['size'];
		$file_type = $_FILES['myFile']['type'];
		$temp_name = $_FILES['myFile']['tmp_name'];
               // $idarra=explode("^",$file_name);
                //echo $latest_id=$idarra[0];


				
		$location = "uploads/";
		$name=$location.$file_name;
		move_uploaded_file($temp_name, $location.$file_name);

                $temp = split('_',$file_name)[0];

              //echo $temp;
             $query="UPDATE personalinfo per SET per.imagepath='".$name."' WHERE per.patid='".$temp."'";
		//echo $query;

		if(mysql_query($query)){
			echo "Successfully Uploaded";
		}
		
		mysql_close($con);
	}else{
		echo "Error";
	}
?>