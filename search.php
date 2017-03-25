
<?php
include("head.php");
?>
	<style>
	body
	{
		background-color:#e9e9de;
	}
	.content
	{
	margin-top:60px;
	}
	.centered
	{
		margin-left: auto;
		margin-right: auto;
	}
	.sea_pic
	{
		width:150px;
		height:200px;
		overflow: hidden;
		border-radius:25px;
		box-shadow: 0px 2px 1px #7b7b52;
	}
	.btn
	{
		box-shadow: 0px 2px 1px #7b7b52;
	}
	a:hover,a:focus,a:visited{
		text-decoration:none;
		}
	</style>
	<title>My Profile</title>
</head>
<body>
<?php
include("header.php");?>
<div class="content">
	<div class="container">
<?php
require_once("dbconnect.php");
$search=$_GET['s'];
$search=strip_tags($search);
$query1="SELECT * FROM user WHERE name LIKE '$search%' ORDER BY name";
$result1=mysqli_query($con,$query1);
$row1=mysqli_fetch_array($result1);
if(mysqli_num_rows($result1)==0)
	echo '<h3 style="color:orange">No results found</h3>';
else
{
	?><div class="rows">
	<?php
	while($row1)
	{
		$sea_name=ucfirst(strtolower($row1[1]))." ".ucfirst(strtolower($row1[2]));
		$sea_id=$row1[0];
		$sea_pic=$row1[8];
		$cityh=ucfirst(strtolower($row1['city']));
		$counh=ucfirst(strtolower($row1['coun']));
		$desigh=ucfirst(strtolower($row1['desig']));
		$studyh=ucfirst(strtolower($row1['study']));
		$workh=ucfirst(strtolower($row1['work']));
		$streamh=ucfirst(strtolower($row1['stream']));
		if ($sea_pic == "" || !file_exists("userdata/profile_pics/$sea_pic"))
				{
					$sea_picu = "images/default_pic.jpg";
				}
				else
				{
					$sea_picu = "userdata/profile_pics/".$sea_pic;
				}
		?>
	<div class="col-sm-4">
				<div class="panel panel-default" >
					<div class="panel-heading" style="background: linear-gradient(to right, pink,blue);color: white;">
						<?php
							echo '<b>'.$sea_name.'</b>';
						?>
					</div>
					<div class="panel-body">
						<div class="rows">
							<div class="col-xs-6">
								<div class="sea_pic">
								<a href="profile.php?u=<?php echo $sea_id;?>">	<img src="<?php echo $sea_picu;?>" class="img-responsive" style="width:100%;height:100%;"></a>
								</div>
							</div>
							<div class="col-xs-6">
							<br>
							<a href="profile.php?u=<?php echo $sea_id;?>" style="color:black;">
							<?php echo '<h4 style="color:orange"><b> '.$sea_name.'</b></h4>';?>
							</a><?php
						//About Me
						if($studyh!="" || $studyh!=NULL)
						{
							if($streamh!="" || $streamh!=NULL)
								echo '<span class="glyphicon glyphicon-book"></span> &nbsp;Studied in <b>'.$studyh."</b> with <b>".$streamh.'</b><br>';
							else
								echo '<span class="glyphicon glyphicon-book"></span>  &nbsp;Studied in <b>'.$studyh.'</b><br>';
						}
						if($workh!="" || $workh!=NULL)
						{
							if($desigh!=""|| $desigh!=NULL)
								echo '<span class="glyphicon glyphicon-briefcase"></span> &nbsp;Worked in <b>'.$workh."</b> as <b>".$desigh.'</b><br>';
							else
								echo '<span class="glyphicon glyphicon-briefcase"></span> &nbsp;Worked in <b>'.$workh.'</b><br>';
						}
						if($counh!="" || $counh!=NULL)
						{
							if($cityh!="" || $cityh!=NULL)
								echo '<span class="glyphicon glyphicon-home"></span> &nbsp;Lives in <b>'.$counh."</b> from <b>".$cityh.'</b><br>';
							else
								echo '<span class="glyphicon glyphicon-home"></span>  &nbsp;Lives in <b>'.$counh.'</b><br>';
						}
						?><hr>
							<form action="profile.php?u=<?php echo $sea_id;?>" method="POST"><!--FORM-->
							<button type="submit" class="btn btn-info btn-block" name="go"><b>Go to profile</b></button>
							</form>
						</div>
						</div>
					</div>
					</div>
				</div>
	<?php
		$row1=mysqli_fetch_array($result1);
	
	}//While loop ends here
	?></div>
	<?php
 }
?>
	</div>
</div>
</body>
</html>