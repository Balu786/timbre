<?php
include("dc.php");
//include("model/reuseMethods.php");
//header('Content-type: application/json');
class Api_function
{
	public function __construct()
 	{ 		
		$json = file_get_contents('php://input');
		print_r($json);		
 	}
 	
 	public function signin($data)
 	{
 	  	$get_data=explode(",",$data);
 	  	$query="select * from master_state";
		$objSql2 = new SqlClass();
		$result=$objSql2->executesql($query);
		$status="fail";
		$message="invalid username or passowrd";
		if($result == 'no rows')
		{
			return $obj = (object)array("status"=>$status,"message"=>$message,"data"=>"null");
		}
		else
		{
		    foreach($result as $data)
			{  							
				$row_array['id'] = $data['id'];
				$row_array['name'] = $data['state_name'];
				$row_array['date'] = $data['created_on'];			
		        if(count($row_array) > 0){
					$status="success";
					$message="";
				}
				$obj = (object)array("status"=>$status,"message"=>$message,"data"=>$row_array);
				return $obj;
			}
		}
 	}
 	public function dbChangePwd($data, $key)
 	{
 		foreach ($data[$key] as $details)
 		{
 			$mobile_no = $details['phno'];
 			$old_password = $details['old_password'];
			$new_password = $details['new_password'];
			$cnf_password = $details['cnf_password'];
			$date="";
			$passCheck=strcmp($new_password,$cnf_password);
			$result='';
			if($passCheck==0)
			{				
				$queryCheck="select * from users where phno='".$mobile_no."' and password='".$old_password."'";
				$objSql2 = new SqlClass();
				$resultCheck=$objSql2->executesql($queryCheck);
				
				$query="UPDATE `users` SET `password`='".$new_password."',`password_salt`='".$new_password."', `updated_on`='".$date."' WHERE phno='".$mobile_no."' and password='".$old_password."'";
				$objSql2 = new SqlClass();
				$result=$objSql2->executesql($query);
			}
			if($resultCheck!='no rows' && $resultCheck!='')
			{
				$status="success";
				$message="Updated Successfully";
				$obj = (object)array("status"=>$status,"message"=>$message,"data"=>"");
				return $obj;
			}
			else
			{
				$status="fail";
				$message="Failed to Update";
				return $obj = (object)array("status"=>$status,"message"=>$message,"data"=>"");		
			}			
		}	
 	}
 	public function dbGetFests($key)
 	{
 		if($key=='fByDateAdded')
 		{
 			$query="select m_col.college_name, f.* from master_college_map m_col join fest_details f on f.college_map_id=m_col.id order by f.created_on";
 		}
		else if($key=='fByDate')
		{
			$query="select m_col.college_name, f.* from master_college_map m_col join fest_details f on f.college_map_id=m_col.id order by f.start_date";
		}
		else if($key=='fByLoc')
		{
			$query="select m_col.college_name, f.* from master_college_map m_col join fest_details f on f.college_map_id=m_col.id order by m.city_id";
		}
		else if($key=='fByType')
		{
			$query="select m_col.college_name,ft_map.fests_type_id, f.* from master_college_map m_col join fest_details f join festtype_fest_map ft_map on f.college_map_id=m_col.id and f.id=ft_map.fest_id order by ft_map.fests_type_id";
		} 		
 		/*$query="select m_col.college_name, f.* from master_college_map m_col join fest_details f on f.college_map_id=m_col.id";*/
		$objSql2 = new SqlClass();
		$result=$objSql2->executesql($query);
		$status="fail";
		$message="no data found";
		if($result == 'no rows')
		{
			return $obj = (object)array("status"=>$status,"message"=>$message,"data"=>"null");
		}
		else
		{
			$json_response=array();
		    foreach($result as $data)
			{  				
				$row_array['id'] = $data['id'];
				$row_array['college_name'] = $data['college_name'];
				$row_array['fest_name'] = $data['name'];
				$row_array['fest_date'] = $data['start_date'];
		        array_push($json_response,$row_array);   
			}
			if(count($json_response) > 0){
					$status="success";
					$message="";
				}	
			$obj = (object)array("status"=>$status,"message"=>$message,"data"=>$json_response);
			return $obj;
		}
 	}



 	public function dbRegUser($data, $key)
 	{
 		foreach ($data[$key] as $details)
 		{
		
 			$name= $details['name'];
$mobile= $details['mobile'];
$gender= $details['gender'];
$age= $details['age'];
$married_status= $details['married_status'];
$ft= $details['getheight'];
$inch= $details['inch'];
$weight= $details['weight'];
$age= $details['age'];
$pinzipcode= $details['pinzipcode'];
$smoking=$details['getsmoke'];
$blood_suger=$details['getsuger'];
$bp=$details['getbp'];
$headache=$details['getheadache'];
$travelling_mode=$details['gettravellingMode'];
$cough=$details['getcough'];
$night_sweat=$details['getnight'];
$appetite=$details['getioss'];

$promiscuity=$details['getpromiscuity'];
$alchol=$details['getalcohol'];
$substance=$details['getsubstanceUsage'];
$travellingfrequency=$details['gettravellingFrequncy'];
$bronchitis=$details['getbronchitis'];
$temparature=$details['gettemparature'];
 			
 		} 
$query="INSERT INTO `patient`(`name`,`mobile`, `age`, `gender`, `height`, `weight`, `marital_status`, `zipcode` ) VALUES('".$name."','".$mobile."','".$age."','".$gender."','".$ft."','".$weight."','".$married_status."','".$pinzipcode."')";

		
		$this->objSql2 = new SqlClass();
		$objSql2 = new SqlClass();
		$result=$objSql2->getLstInserted($query);
		if($result!='')
		{
$clinicQuery="INSERT INTO `clinical_data` (`patient_id`, `smoking`,`blood_suger`, `bp`, `headache`, `travelling_mode`, `cough`, `night_sweat`, `appetite`, `promiscuity`, `alchol`, `substance`, `travellingfrequency`, `bronchitis`, `temparature`) VALUES ('".$result."','".$smoking."','".$blood_suger."','".$bp."','".$headache."','".$travelling_mode."','".$cough."','".$night_sweat."','".$appetite."','".$promiscuity."','".$alchol."','".$substance."','".$travellingfrequency."','".$bronchitis."','".$temparature."')";



$this->objSql21 = new SqlClass();
		$objSql21 = new SqlClass();
		$result121=$objSql21->getLstInserted($clinicQuery);
			$status="success";
			$message="Inserted Successfully";
			$obj = '/'.$result121;
			return $obj;
		}
		else
		{
			$status="fail";
			$message="Failed to insert";
			return '/'.$message;		
		}			
 	}
 	public function dbAddFest($data, $key)
 	{
 		foreach ($data[$key] as $details)
 		{
 			$user_id=1;
 			$col_id = $details['col_map_id'];
 			$dept_ids = $details['depts'];
			$fests_type_ids = $details['fest_type'];
			$fest_name = $details['fest_name'];
			$start_date = $details['start_date'];
			$end_date = $details['end_date'];
			$reg_from = $details['reg_starts_from'];
			$event_ids = $details['events'];
			$weblink = $details['weblink'];
			$highlights = $details['highlights'];									
			$contact_name = $details['contact_name'];
			$contact_number = $details['contact_number'];
			$email_id = $details['email_id'];
			$fb_id = $details['fb_id'];			
			$twitter_id = $details['twitter_id'];
			$youtube_link = $details['youtube_link'];
			$posted_by = $details['posted_by'];
			$status_id = 1;
			$date='';
 		}
		if($data[$key]!='')
		{
			$queryFestDetails="INSERT INTO `fest_details`(`user_Id`, `college_map_id`, `name`, `start_date`, `end_date`, `reg_start_from`, `website`, `highlight`, `contact_no`, `contact_name`, `email_id`, `fb_id`, `twitter_id`, `youtube_link`, `status_id`, `created_on`, `updated_on`)
 			VALUES ('".$user_id."','".$col_id."','".$fest_name."','".$start_date."','".$end_date."','".$reg_from."','".$weblink."','".$highlights."','".$contact_number."','".$contact_name."','".$email_id."','".$fb_id."','".$twitter_id."','".$youtube_link."','".$status_id."','".$date."','".$date."')";
			$this->objSql2 = new SqlClass();
			$objSql2 = new SqlClass();
			$resultFestId=$objSql2->getLstInserted($queryFestDetails);
			$fest_id=$resultFestId;
			if($dept_ids!='')
			{
				$count=0;
				foreach ($dept_ids as $depts)
				{					
					$queryDept="INSERT INTO `dept_fest_map`(`fest_id`, `dept_id`) VALUES ('".$fest_id."','".$depts[$count]."')";				
					$this->objSql2 = new SqlClass();
					$objSql2 = new SqlClass();
					$resultDept=$objSql2->executesql($queryDept);	
					$count++;				
				}
			}	
			if($fests_type_ids!='')
			{
				$count=0;
				foreach ($fests_type_ids as $fest_type)
				{					
					$queryFest="INSERT INTO `festtype_fest_map`(`fest_id`, `fests_type_id`) VALUES ('".$fest_id."','".$fest_type[$count]."')";		
					$this->objSql2 = new SqlClass();
					$objSql2 = new SqlClass();
					$resultFest=$objSql2->executesql($queryFest);					
					$count++;
				}
			}	
			if($event_ids!='')
			{
				$count=0;
				foreach ($event_ids as $events)
				{
					$queryEvents="INSERT INTO `events_fest_map`(`fest_id`, `event_id`) VALUES ('".$fest_id."','".$events[$count]."')";
					$this->objSql2 = new SqlClass();
					$objSql2 = new SqlClass();
					$resultEvents=$objSql2->executesql($queryEvents);					
					$count++;
				}
			}					
		}		
		if($resultFestId!='')
		{
			$status="success";
			$message="Inserted Successfully";
			$obj = (object)array("status"=>$status,"message"=>$message,"data"=>"");
			return $obj;
		}
		else
		{
			$status="fail";
			$message="Failed to insert";
			return $obj = (object)array("status"=>$status,"message"=>$message,"data"=>"");		
		}			
 	}
 	public function dbDeleteFest($data, $key)
 	{
 		foreach ($data[$key] as $festId)
 		{
 			$fest_id=$festId['fest_id'];
			$status_id = 1;
			$date='';
 		}
		if($data[$key]!='')
		{
			$queryDept="DELETE FROM `dept_fest_map` WHERE fest_id='".$fest_id."'";				
			$this->objSql2 = new SqlClass();
			$objSql2 = new SqlClass();
			$resultDept=$objSql2->executesql($queryDept);	
		
			$queryFest="DELETE FROM `festtype_fest_map` WHERE fest_id='".$fest_id."'";		
			$this->objSql2 = new SqlClass();
			$objSql2 = new SqlClass();
			$resultFest=$objSql2->executesql($queryFest);					
		
			$queryEvents="DELETE FROM `events_fest_map` WHERE fest_id='".$fest_id."'";
			$this->objSql2 = new SqlClass();
			$objSql2 = new SqlClass();
			$resultEvents=$objSql2->executesql($queryEvents);										

			$queryFestDetails="DELETE FROM `fest_details` WHERE id='".$fest_id."'";
			//$queryFestDetails="UPDATE `fest_details` SET `status_id`=2, `updated_on`='".$date."' WHERE id='".$fest_id."'";
			$this->objSql2 = new SqlClass();
			$objSql2 = new SqlClass();
			$resultFestDetails=$objSql2->executesql($queryFestDetails);								
		}		
		if($resultFestDetails=='1')
		{
			$status="success";
			$message="Deleted Successfully";
			$obj = (object)array("status"=>$status,"message"=>$message,"data"=>"");
			return $obj;
		}
		else
		{
			$status="fail";
			$message="Failed to Delete";
			return $obj = (object)array("status"=>$status,"message"=>$message,"data"=>"");		
		}			
 	}
 	public function dbSearchFest($data, $key)
 	{
 		foreach ($data[$key] as $searchedTerm)
 		{
 			$search_term=$searchedTerm['search_term'];
			$status_id = 1;
			$date='';
 		}
		if($data[$key]!='')
		{
			$queryDept="DELETE FROM `dept_fest_map` WHERE fest_id='".$fest_id."'";				
			$this->objSql2 = new SqlClass();
			$objSql2 = new SqlClass();
			$resultDept=$objSql2->executesql($queryDept);	
		
			$queryFest="DELETE FROM `festtype_fest_map` WHERE fest_id='".$fest_id."'";		
			$this->objSql2 = new SqlClass();
			$objSql2 = new SqlClass();
			$resultFest=$objSql2->executesql($queryFest);					
		
			$queryEvents="DELETE FROM `events_fest_map` WHERE fest_id='".$fest_id."'";
			$this->objSql2 = new SqlClass();
			$objSql2 = new SqlClass();
			$resultEvents=$objSql2->executesql($queryEvents);										

			$queryFestDetails="DELETE FROM `fest_details` WHERE id='".$fest_id."'";
			//$queryFestDetails="UPDATE `fest_details` SET `status_id`=2, `updated_on`='".$date."' WHERE id='".$fest_id."'";
			$this->objSql2 = new SqlClass();
			$objSql2 = new SqlClass();
			$resultFestDetails=$objSql2->executesql($queryFestDetails);								
		}		
		if($resultFestDetails=='1')
		{
			$status="success";
			$message="Deleted Successfully";
			$obj = (object)array("status"=>$status,"message"=>$message,"data"=>"");
			return $obj;
		}
		else
		{
			$status="fail";
			$message="Failed to Delete";
			return $obj = (object)array("status"=>$status,"message"=>$message,"data"=>"");		
		}			
 	}
 	public function dbGetSpecFest($data, $key)
 	{
 		$fest_id='';
 		if($data[$key]!='')
 		{
 			foreach ($data[$key] as $festId)
	 		{
	 			$fest_id=$festId['fest_id'];
				$status_id = 1;
				$date='';
	 		}	
 		}
 		$queryFDtails="select f.name as fest_name, mc.college_name, mc_type.college_type, mu.name as university, ms.state_name, md.district_name, mcity.city_name from fest_details f join  master_college_map mc join master_college_type mc_type join master_university mu join master_state ms join master_district md join master_city mcity where f.id='".$fest_id."' and mc.id=f.college_map_id and mc.college_type=mc_type.id and mc.university_id=mu.id and mc.state_id=ms.id and mc.district_id=md.id and mc.city_id=mcity.id"; 		
		$objSql2 = new SqlClass();
		$resultFDtails=$objSql2->executesql($queryFDtails);

		$queryFDepts="select mdept.name as dept_name from master_departments mdept join dept_fest_map df_map where df_map.fest_id='".$fest_id."' and df_map.dept_id=mdept.id"; 		
		$objSql2 = new SqlClass();
		$resultFDepts=$objSql2->executesql($queryFDepts);

		$queryFEvents="select me.event_name from `master_events` me join events_fest_map ef_map on ef_map.fest_id='".$fest_id."' and ef_map.event_id=me.id"; 		
		$objSql2 = new SqlClass();
		$resultFEvents=$objSql2->executesql($queryFEvents);

		$queryFType="select mf_type.fest_type from festtype_fest_map ftype_map join master_fest_type mf_type on ftype_map.fest_id='".$fest_id."' and ftype_map.fests_type_id=mf_type.id"; 		
		$objSql2 = new SqlClass();
		$resultFType=$objSql2->executesql($queryFType);

		$status="fail";
		$message="no data found";
		if($resultFDtails == 'no rows')
		{
			return $obj = (object)array("status"=>$status,"message"=>$message,"data"=>"null");
		}
		else
		{
			$json_response=array();
			$json_dept=array();
			$json_events=array();
			$json_ftype=array();
		    foreach($resultFDtails as $data)
			{  				
				foreach($resultFDepts as $deptdata)
				{  				
					$dept_array = $deptdata['dept_name'];
					array_push($json_dept,$dept_array);   
				}
				foreach($resultFEvents as $eventdata)
				{  				
					$event_array = $eventdata['event_name'];
					array_push($json_events,$event_array);   
				}
				foreach($resultFType as $festtype)
				{  				
					$fest_type_array = $festtype['fest_type'];
					array_push($json_ftype,$fest_type_array);   
				}
				$row_array['college_name'] = $data['college_name'];
				$row_array['fest_name'] = $data['fest_name'];
				$row_array['college_type'] = $data['college_type'];
				$row_array['university'] = $data['university'];
				$row_array['state_name'] = $data['state_name'];
				$row_array['district_name'] = $data['district_name'];
				$row_array['city_name'] = $data['city_name'];
				$row_array['dept_name']=$json_dept;
				$row_array['event_name']=$json_events;
				$row_array['fest_type']=$json_ftype;
		        array_push($json_response,$row_array);   
			}
			if(count($json_response) > 0){
					$status="success";
					$message="";
				}	
			$obj = (object)array("status"=>$status,"message"=>$message,"data"=>$json_response);
			return $obj;
		}
 	}
}