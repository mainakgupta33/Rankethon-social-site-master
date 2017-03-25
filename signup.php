<?php
session_start();
if(isset($_SESSION['user']))
{
	require_once("dbconnect.php");
	$email=$_SESSION['user'];
	$qb=mysqli_query($con,"SELECT id FROM user WHERE email='$email'");
	$qbrow=mysqli_fetch_array($qb);
	header("location:home.php?u=".$qbrow[0]);
}
?>
<!DOCTYPE HTML>
<html>
<head>
<link rel="SHORTCUT ICON" href="images/icon/logo.ico">
<title>Sign Up</title>
<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/animate.css">
	<link rel="stylesheet" media="all" href="css/bootstrap.min.css">
	<script src="js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-filestyle.min.js"> </script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script src="js/wow.min.js"></script>
              <script>
              new WOW().init();
              </script>
</head>
<style>
	body 
	{ background-image:url(images/Friends.jpg) ;
		  background-repeat:no-repeat;
		  background-attachment:scroll;
		  -webkit-background-size: cover;
		 -moz-background-size: cover;
		 -o-background-size: cover;
		 background-size: cover;
		  }
	.posi
	{
		margin-top:35px;
		margin-left:20px;
		padding:10px;
	}
	.modal-header, .close
		{
			background: linear-gradient(to right, #900048 , #B73D7A);
			color:white !important;
			text-align: center;
			font-size: 30px;
		}
	.modal-footer a
	{
		color:#B8005C;
	}
	.btn-danger 
	{
		background: linear-gradient(to right, #55002A , #FF0B85);
	}

	#login { color:#B8005C;}
	#centered 
	{
		display: block;
		margin-left: auto;
		margin-right: auto;
		box-shadow: 5px 5px 5px rgba(0,0,0,0.75);
	}
	#rankethon
	{
		margin-top:20px;
	}
	.foot
	{
		background-color:black;
		color:white;
		text-align:center;
		padding:10px;
	}
	.btn
	{
		box-shadow: 0px 2px 1px #7b7b52;
	}
	a:hover,a:focus,a:visited{
		text-decoration:none;
		}
</style>
<body>
<!--Modal-->
<div class="container">
		<div id="myModal" class="modal fade" role="dialog">
			<div class="modal-dialog ">
				<div class="modal-content">
					<div class="modal-header" style="padding=35px 50px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4><span class="glyphicon glyphicon-lock" aria-hidden="true"></span><strong> Login</strong></h4>
					</div>
					<div class="modal-body" style="padding:40px 50px;">
						<form role="form" action="" method="POST">
							<div class="form-group">
								<label for="usn"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Email</label>
								<input type="text" class="form-control" name="uname" id="usn" placeholder="Enter Email">
							</div>
							<div class="form-group">
								<label for="pass"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Password</label>
								<input type="password" class="form-control" name="upass" placeholder="Enter password">
							</div>
					</div>
					<div class="modal-footer" style="padding:10px 20px;">
						<button type="submit" name="login" class="btn btn-danger pull-left"><strong> Login</strong></button>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	</div>
<!--End of Modal-->
<?php
if(isset($_POST['login']))
{
	require_once("dbconnect.php");
	$emailid=$_POST['uname'];
	$password=md5($_POST['upass']);
	$query="SELECT * FROM user WHERE email='{$emailid}'";
	$result=mysqli_query($con,$query);
	$row=mysqli_fetch_array($result);
	$num=mysqli_num_rows($result);
	?>
	<div class="alert alert-danger">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>
	<?php
	if($num==0)
		echo "Email doesnt exist!";
	else
	{
		$dbpass=$row[4];
		if($password==$dbpass)
		{
			if(!(isset($_SESSION)))
				session_start();
			$id=$row[0];
			$_SESSION['user']=$emailid;
			header("location:home.php?u=$id");
		}
		else
			echo "Username password does not match";
	}
	?>
	</strong> .Please try again! <?php echo $num;?>
	</div>
	<?php
}
?>
<!--content-->
<div class="posi">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-5" style="color:white;">
				<br>
				<img src="images/rank.jpg" width="170" id="centered" class="img-responsive wow flip" height="170" style="border-radius:25px;">
				<br>
				<h1 style="text-align:center;" class="wow pulse">Welcome to Rankethon</h1>
				<h4 style="text-align:center;" class="wow pulse">Now express yourself with liberty and be a part of your friend's happy and sad moments because being social matters. </h4>
			</div>
			<div>
			<div class="col-md-2">
			</div>
				<div class="col-md-4" style="background-color:white; opacity:0.92; line-height:45%;  border-radius: 25px;">
				<div class="wow fadeIn">
				<br>
				<h4>Already a member !<a id="login" data-toggle="modal" href="#myModal"> Login</a> </h3>
				<h4>Not a member? Sign Up</h3><hr>
				
				<!--register php-->
<?php
require_once("dbconnect.php");
if(isset($_POST['submit']))
	{
		$name=strip_tags(mysqli_real_escape_string($con,$_POST['name']));
		$sname=strip_tags(mysqli_real_escape_string($con,$_POST['sname']));
		$email=strip_tags(mysqli_real_escape_string($con,$_POST['email']));
		$mnumber=strip_tags(mysqli_real_escape_string($con,$_POST['mnumber']));
		$pword=$_POST['pword'];
		$rpword=$_POST['rpword'];
		//error checking
		$e=0;$flag=1;
		//check for name
		$regex="/^[a-z ]+$/i";  
		if(!preg_match($regex,$name)) 
		{
			echo '<font color=red><b>Name is invalid</b></font><br>';
			$flag=0;
		} 
		
		//check for surname
		$regex="/^[a-z ]+$/i";  
		if(!preg_match($regex,$sname)) 
		{
			echo "<br><font color=red><b>Surname is invalid!</b></font><br>";
			$flag=0;
		}  
		
		
		
		//Check for email
		$regex="/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";  
		
		if(preg_match($regex,$email)) 
		{
			$result = mysqli_query($con,"SELECT * FROM user WHERE email = '{$email}'");
			if(!$result)
			{
				die(mysqli_error($con));
				$flag=0;
			}

			if(mysqli_num_rows($result) > 0)
			{
				die("<br><font color=red><b>Email already in DB </b></font><br>");
				$flag=0;
			}
		}
		else 
		{ 
			echo "<br><font color=red><b>Email is invalid!</b></font><br>";
			$flag=0;
		}
		
		//check for phone number
		$regex="/^[789][0-9]{9}$/";  
		if(!preg_match($regex,$mnumber)) 
		 {
			 echo "<br><font color=red><b>Phone number is invalid!</b></font><br>"; 
			 $flag=0;
		 }
		
		//check for password
		$str_len = strlen($pword);
		$str_len2 = strlen($rpword);   
		if(($str_len == 0)||($str_len2 == 0))
		{
			echo "<br><font color=red><b>Please enter valid password!</b></font><br>"; 
			$flag=0;
		}
		if(($str_len <= 6)||($str_len2 <= 6))
			{				
				echo "<br><font color=red><b>Password should be more than 6 characters.</b></font><br>";
				$flag=0;
			}   
		if($pword!= $rpword)     
				{
					echo "<br><font color=red><b>Passwords do not match!</b></font><br>";
					$flag=0;
				}
				
				
		$gender=NULL;

		if (!isset($_POST["gender"]))
			{
				echo "<br><font color=red><b>Gender is Mandatory</b></font><br>";
				$flag=0;
			}
		else
			{
				$gender=$_POST['gender'];
			}
		$day=$_POST['day'];
		$month=$_POST['month'];
		$year=$_POST['year'];
		$fulldate=$day.'/'.$month.'/'.$year;
		$pass=md5($pword);
		$query="INSERT INTO user(name,sname,email,pass,mob,gen,dob) VALUES('{$name}','{$sname}','{$email}','{$pass}','{$mnumber}','{$gender}',STR_TO_DATE('{$fulldate}','%d/%M/%Y'))";
		if($flag==1)
		{	
			$ins=mysqli_query($con,$query);
			$print='<div class="alert alert-success">	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Account Created</strong> Please <a id="login" data-toggle="modal" href="#myModal">login</a> </div>';
			echo $print;
		}
		else
			echo "<br><font color=red><b>Error!</b></font><br><br>";
		}
		
?>
					<form role="form" action="" method="post">
						<div class="form-group">
						<label for="name">Name :</label>
						<input type="text" data-toggle="tooltip" title="Name should not contain any number or special characters" data-placement="left" class="form-control" name="name" id="name" placeholder="Enter your name">
						</div>
						<div class="form-group">
						<label for="sname">Surname :</label>
						<input type="text" class="form-control" name="sname" data-toggle="tooltip" title="Surname should not contain any number or special characters" data-placement="left" placeholder="Enter your surname">
						</div>
						<div class="form-group">
						<label for="email">Email-id :</label>
						<input type="text" class="form-control" data-toggle="tooltip" title="You will use this to login" data-placement="left" name="email" placeholder="Enter Email-id">
						</div>
						<div class="form-group">
						<label for="pword">Password :</label>
						<input type="password" class="form-control" name="pword" data-toggle="tooltip" title="Be a little tricky!" data-placement="left" placeholder="Enter password [more than 6 characters]">
						</div>
						<div class="form-group">
						<label for="rpword">Re-enter password :</label>
						<input type="password" class="form-control" name="rpword" data-toggle="tooltip" title="Type the same password again" data-placement="left" placeholder="Re-type your password">
						</div>
						<div class="form-group">
						<label for="mnumber">Mobile-No. :</label>
						<input type="text" class="form-control" name="mnumber" data-toggle="tooltip" title="What's your mobile number?" data-placement="left" placeholder="Enter your mobile number">
						</div>
						<div class="form-group" >
						<label>Gender :&nbsp;</label>
						<input type="radio" name="gender" value="male" >Male
						<input type="radio" name="gender" value="female" >Female
						</div>
						<div class="form-group">
						<b>Date of Birth &nbsp;:&nbsp;</b>
						<select name="day" value="Day">
						<?php 
						for($i=1;$i<=31;$i++)
								echo "<option>$i</option>";
						?>
						</select>
						<select name="month">
						<?php 
						$m=array( "","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
						for($i=1;$i<=12;$i++)
								echo "<option>$m[$i]</option>";
						?>
						</select>
						<select name="year">
						<?php 
						for($i=2015;$i>=1905;$i--)
								echo "<option>$i</option>";
						?>
						</select>
						</div>
						<hr>
						<button type="submit" name="submit" class="btn btn-danger btn-block" style="font-size:large"><b>Create Account</b></button>
						<br>
					</div>	
					</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<!--End of content-->
<!--footer-->
<div class="foot">
	<div class="container-fluid ">
		<p>&copy; Copyright Tech Wizards </p>
	</div>
</div>

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
</body>
</html>