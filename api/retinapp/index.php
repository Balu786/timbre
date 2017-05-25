<?php 
include("dc.php");

if( isSet($_POST['userName']) && $_POST['userName'] != '' && isSet($_POST['passWord']) && $_POST['passWord']!= ''){
	
	$userName = trim($_POST['userName']);
	$password = trim($_POST['passWord']);
	//$query = 'select * from admin where username='.$userName.' and password ='.$password;
	$query = "SELECT * FROM admin where username='$userName' and password='$password'";
	//echo $query;
	$objSql2 = new SqlClass();
	$result=$objSql2->executesql($query);
	$status="fail";
	$message="invalid username or passowrd";
	//print_r($result);
	//echo "came till this point";
	if($result == 'no rows')
		{
			echo "Invalid user Name and password";
		}
		else
		{
			header("Location: resultUploadPage.php"); 
			echo "ok redirect";
		}
}
?>

<html>
<head>
<title>
Admin
</title>
</head>
<body>
<form action="" method="POST">
<table align="center" valign="center">
<tr>
<th colspan="2">
Login124
</th>
</tr>
<tr>
	<td>
		User Name
	</td>
	<td>
		<input type="text" id="txtUserName" name="userName">
	</td>
</tr>

<tr>
	<td>
		Password
	</td>
	<td>
		<input type="password" id="txtPassword" name="passWord">
	</td>
</tr>
<tr>
	<td colspan="2" align="center">
		<input type="submit" />
	</td>
</tr>
</table>
</form>
</body>
</html>