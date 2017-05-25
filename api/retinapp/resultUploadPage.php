<?php 
include("dc.php");

$query = "SELECT * FROM personalinfo per where per.statusflag=0";
//echo $query; 
$objSql2 = new SqlClass();
$result=$objSql2->executesql($query);

$filepartialPath="api/retinapp/";
$recordingPath="uploads/";

?>
<html>
<script   src="https://code.jquery.com/jquery-3.1.0.min.js"   integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s="   crossorigin="anonymous"></script>
<body>
<div style="withd:90%;float:right;">
	<a href="index.php">SignOut</a>
</div>
<br/>
<table align='center' border='1'>
<tr>
<th>
	id
</th>
<th>
	First Name
</th>
<th>
	Last Name
</th>
<th>
	Mobile Number
</th>

<th>
	Gender
</th>
<th>
diabetic since
</th>

<th>
diabetes type</th>

<th>protein urea</th>

<th>lipids</th>

<th>triglycerides</th>

<th>eye sight</th>

<th>H1bAc</th>

<th>
	Image
</th>

<th>
	Update
</th>
<?php 
foreach($result as $data)
{
	$resultId = $data["mobile"];
	$linkURL = "details.php?patId=".$data['patid'];
	?>
</tr>
	<td>
		<?php echo $data['patid']?>
	</td>
	<td>
		<?php echo $data['firstname']?>
	</td>

        <td>
		<?php echo $data['lastname']?>
	</td>
	<td>
		<?php echo $data['mobile']?>
	</td>
	
	<td>
		<?php echo $data['gender']==0? 'Male':'Female'?>
	</td>
	<td>
		<?php echo $data['diabeticsince'] ?>
	</td>
        <td>
		<?php echo $data['diabetestype'] ?>
	</td>
        <td>
		<?php echo $data['proteinurea']?>
	</td>
        <td>
		<?php echo $data['lipids']?>
	</td>
       <td>
		<?php echo $data['triglycerrides']?>
	</td>
        <td>
		<?php echo $data['eyesight'] == 0 ? 'No':'Yes'?>
	</td>
        <td>
          <?php echo $data['h1bac']?>
        </td>

	<td>
		<a href="<?php echo $data['imagepath']?>" download> <?php echo $data['imagepath']?></a>
	</td>
	
	<td>
		<a href="<?php echo $linkURL; ?>" > Details </a>
		
	</td>

<tr>
<input type="hidden" name="patId" value="<?php  echo $data['patid']?>" />
<input type="hidden" name="mobileNumber" value="<?php  echo $data['mobile']?>" />

</form>
<?php } ?>

</table>
</body>
</html>