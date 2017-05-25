	<?php 
	include("dc.php");
	class model
	{
	        public function __construct()
	 	{ 		
			$json = file_get_contents('php://input');			
	 	}

		function addUser($data,$key1)
		{
		foreach ($data[$key1] as $key)
							{
						    $firstname=$key['firstname'];
                                                    $lastname=$key['lastname'];
					            $mobile=$key['mobile'];
					            $gender=$key['gender'];
                                                    $age=$key['age'];
                                                    $diabeticsince=$key['diabeticsince'];
					            $diabetestype=$key['diabetestype'];
                                                    $proteinurea=$key['proteinurea'];
                                                    $lipids=$key['lipids'];
					            $triglycerrides=$key['triglycerrides'];
                                                    $eyesight=$key['eyesight'];
                                                    $h1bac = $key['h1bac'];

$query = 'INSERT INTO `personalinfo`(`firstname`, `lastname`, `diabeticsince`, `diabetestype`, `proteinurea`, `lipids`, `triglycerrides`, `eyesight`, `gender`, `mobile`,`h1bac`) VALUES ("'.$firstname.'","'.$lastname.'","'.$diabeticsince.'","'.$diabetestype.'","'.$proteinurea.'","'.$lipids.'","'.$triglycerrides.'","'.$eyesight.'","'.$gender.'","'.$mobile.'","'.$h1bac.'")';

	$objSql2 = new SqlClass();
			return $result=$objSql2->getLstInserted($query);
	              
	             
							}   	
		}

	              function addImage($data,$key1){

	                                              foreach ($data[$key1] as $key)
							{
						    $pid=$key['pid'];				            
	                                            $image_string=$key['image'];
	if($image_string!="null"){
	            $today = date("Ymdhis");
	            $rand = strtoupper(substr(uniqid(sha1(time())),0,4));
	            $image = $today . $rand.".png";
	            $path="images/".$image ;
	            if($details['imageurl']=='null')
	            {
	     			$image="-text.png";
	            }else{
	                   file_put_contents($path,base64_decode($image_string));
	            }
	            $query='update patient set  image= "'.$path.'" where id= "'.$pid.'"';
	            $objSql2 = new SqlClass();
		     return $result=$objSql2->getLstInserted($query);
	}else{
	           $query='update patient set  image= "Epmty" where id= "'.$pid.'"';
	            $objSql2 = new SqlClass();
		     return $result=$objSql2->getLstInserted($query);
	}

	}
	}

	function addClinic($data,$key1)
		{
		foreach ($data[$key1] as $key)
		{
							   $pid=$key['pid'];
			                  $Smoking=$key['Smoking'];
					           $Alcohol=$key['Alcohol'];
					            $FHTB=$key['FHTB'];
					           $LWTB=$key['LWTB'];
					           $PCi=$key['PCi'];
					           $HIV=$key['HIV'];
					           $Diabetes=$key['Diabetes'];
					           $Supplement=$key['Supplement'];
					            $NSW=$key['NSW'];
					            $LOA=$key['LOA'];
					            $Exe=$key['Exe'];
					            $HBA=$key['HBA'];
					            $BP=$key['BP'];
					            $AP=$key['AP'];
					            $CFQ=$key['CFQ'];
					            $CT=$key['CT'];
					            $OC=$key['OC'];
					           $TFQ=$key['TFQ'];
					            $CMS=$key['CMS'];
					            $OSE=$key['OSE'];
					            $ccc="null";
$fever_pattern=$key['fever_pattern'];

$chestPain=$key['chestPain'];

	$cdate=date("m/d/Y");

	        $query='INSERT INTO `clinic_info`(`pat_id`, `smoking`,`fever_pattern`,`chestpain`, `alcohol`, `fh_tb`, `lw_tb`, `par_cough_indicator`, `hiv`, `diabetes`, `supplement`, `night_sweat`, `loss_appetite`, `excercise`, `hbac`, `bp`, `app_pattern`, `cough_freq`, `cough_type`, `other_cough`, `travel_freq`, `current_meditation`, `immunity`, `audio_file`, `created_on`, `updated_on`) VALUES ("'.$pid.'","'.$Smoking.'","'.$fever_pattern.'","'.$chestPain.'","'.$Alcohol.'","'.$FHTB.'","'.$LWTB.'","'.$PCi.'","'.$HIV.'","'.$Diabetes.'","'.$Supplement.'","'.$NSW.'","'.$LOA.'","'.$Exe.'","'.$HBA.'","'.$BP.'","'.$AP.'","'.$CFQ.'","'.$CT.'","'.$OC.'","'.$TFQ.'","'.$CMS.'","'.$OSE.'","'.$ccc.'","'.$cdate.'","'.$cdate.'")';
	        $objSql2 = new SqlClass();
	       return $result=$objSql2->getLstInserted($query);
	    

		}   	
	}
	}
	?>