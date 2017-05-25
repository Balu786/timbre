<?php 
include("dc.php");

$query = "SELECT p.id, p.name, p.mobile, p.occupation, p.age, p.gender, p.height, p.weight, p.image,ci.audio_file FROM patient p, clinic_info ci where p.statusflag='-1' and p.id = ci.pat_id";// where username='$userName' and password='$password'";
//echo $query; 
$objSql2 = new SqlClass();
$result=$objSql2->executesql($query);

$filepartialPath="images/";
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
	Name
</th>
<th>
	Mobile Number
</th>
<th>
	Occupation
</th>
<th>
	Age
</th>
<th>
	Gender
</th>
<th>
	Height
</th>
<th>
	Weight
</th>
<th>
	Image
</th>
<th>
	Cough
</th>
<th>
	Update
</th>
<?php 
foreach($result as $data)
{
	$resultId = $data["mobile"];
	$linkURL = "details.php?patId=".$data['id'];
	?>
</tr>
	<td>
		<?php echo $data['id']?>
	</td>
	<td>
		<?php echo $data['name']?>
	</td>
	<td>
		<?php echo $data['mobile']?>
	</td>
	<td>
		<?php echo $data['occupation']?>
	</td>
	<td>
		<?php echo $data['age']?>
	</td>
	<td>
		<?php echo $data['gender']?>
	</td>
	<td>
		<?php echo $data['height']?>
	</td>
	<td>
		<?php echo $data['weight']?>
	</td>
	<td>
		<a href="<?php echo $filepartialPath.$data['image']?>" download> <?php echo $data['image']?></a>
	</td>
	<td>
		<a href="<?php echo $data['audio_file']?>" download> <?php echo $data['audio_file']?></a>
	</td>
	<td>
		<a href="<?php echo $linkURL; ?>" > Details </a>
		
	</td>

<tr>
<input type="hidden" name="patId" value="<?php  echo $data['id']?>" />
<input type="hidden" name="mobileNumber" value="<?php  echo $data['mobile']?>" />

</form>
<?php } ?>

</table>
</body>
</html>