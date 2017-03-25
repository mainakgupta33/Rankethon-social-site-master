<?php
include("head.php"); 
if(!(isset($_SESSION['user'])))
{
	header('location:logout.php');
}
?>
<head>
	

	<style>
	body
	{
		background-color:#e9e9de;
	}
	.content
	{
	margin-top:25px;
	}
	.centered
	{
		margin-left: auto;
		margin-right: auto;
	}
	textarea.expandable 
	{
		height:40px;
		-webkit-transition: all 0.5s ease-in-out;	
	}
	textarea.expandable:hover, textarea.expandable:focus 
	{
		height:calc(100% - 90px);      
		-webkit-transition: all 0.8s ease-in-out;
	}
	.panel-300:hover, .panel-300 
	{
		height:300px;    
	}
	.aback
	{
		background-image: linear-gradient(rgba(255,255,255,0.2),rgba(255,255,255,0.2)), url("images/setback.jpg");
		width:100%;
		height:130px;
		border-radius:25px;
		padding-top:30px;
		text-align: center;
	}
	.foot
	{
		background-color:black;
		color:white;
		text-align:center;
		padding:10px;
	}
	</style>
	
	<title> Account Settings </title>
</head>
<body >

<?php
include("header.php");
?>
<div class="content" >
<div class="container">
<div class="aback">
		<h2 style="color:white;"><b> Account Settings </b></h2>
</div><br>
	<!--form-->
	<div class="rows">
	<div class="col-md-3">
	</div>
	<div class="col-md-6">
	<form action="" method= "post" role="form">
		<h4 style="text-align:center;"><b> Change your Password </b></h4> <br/>
		<div class="form-group">
			<label for="oldpass">Current Password <span style="color:red">(This field is mandatory)</span></label> 
			<input type="password" class="form-control" name="oldpass" id="oldpass" size="40" required>
		</div>
		<div class="form-group">
			<label for="newpass">New Password</label> 
			<input type="password" name="newpass" class="form-control" id="newpass" size="40"> 
		</div>
		<div class="form-group">
			<label for="repass">Re-type New Password</label> 
			<input type="password" name="repass" class="form-control" id="repass" size="40">
		</div>
		
		<hr/>
		<h4 style="text-align:center;"><b>Update Profile Info</b></h4>
		<div class="form-group">
			<label for="nwname">Name :</label>
			<input type="text" name="nwname" id="nwname" class="form-control" size="40" placeholder="Enter your name">
		</div>
		<div class="form-group">
			<label for="nwsname">Surname :</label>
			<input type="text" name="nwsname" id="nwsname" class="form-control" size="40" placeholder="Enter your surname">
		</div>
		
		<div class="form-group">
			<label for="nwmobile">Mobile Number :</label>
			<input type="text" name="nwmobile" id="nwmobile" class="form-control" size="40" placeholder="Enter your Mobile Number">
		</div>
		
		<div class="form-group">
			<label for="nwcity">City :</label>
			<input type="text" name="nwcity" id="nwcity" class="form-control" size="40" placeholder="Enter the city you belong to">
		</div>
		
		<div class="form-group">
			<label for="nwcountry">Country :</label>
			<input type="text" name="nwcountry" id="nwcountry" class="form-control" size="40" placeholder="Enter the country you belong to">
		</div>
		
		<div class="form-group">
			<label for="nwwork">Work :</label>
			<input type="text" name="nwwork" id="nwwork" class="form-control" size="40" placeholder="Where do you work?">
		</div>
		
		<div class="form-group">
			<label for="nwnwdesig">Designation :</label>
			<input type="nwdesig" name="nwdesig" id="nwstudy" class="form-control" size="40" placeholder="Your designation?">
		</div>
		
		<div class="form-group">
			<label for="nwstudy">Study :</label>
			<input type="nwstudy" name="nwstudy" id="nwstudy" class="form-control" size="40" placeholder="Where do you study?">
		</div>
		
		<div class="form-group">
			<label for="nwstream">Stream :</label>
			<input type="nwstream" name="nwstream" id="nwstream" class="form-control" size="40" placeholder="Enter your stream">
		</div>
		
		<div style="color:green;text-align:center;"><b>
		<?php
	
	if(isset($_POST['senddata']))
	{	
		$nwname = strip_tags(mysqli_real_escape_string($con,$_POST['nwname']));
		$nwsname = strip_tags(mysqli_real_escape_string($con,$_POST['nwsname']));
		$nwmobile = strip_tags(mysqli_real_escape_string($con,$_POST['nwmobile']));
		$nwcity = strip_tags(mysqli_real_escape_string($con,$_POST['nwcity']));
		$nwcountry = strip_tags(mysqli_real_escape_string($con,$_POST['nwcountry']));
		$nwwork = strip_tags(mysqli_real_escape_string($con,$_POST['nwwork']));
		$nwstudy = strip_tags(mysqli_real_escape_string($con,$_POST['nwstudy']));
		$nwstream = strip_tags(mysqli_real_escape_string($con,$_POST['nwstream']));
		$nwdesig= strip_tags(mysqli_real_escape_string($con,$_POST['nwdesig']));
		
		
		
		$repass=$_POST['repass'];
		$npass=$_POST['newpass'];
 
		
		$old_password = md5($_POST['oldpass']);
		$new_password = md5($npass);
		$repeat_password = md5($repass);
		$password_query = mysqli_query($con,"SELECT * FROM user WHERE id='{$id}'");
		$row = mysqli_fetch_array($password_query);
			$db_password= $row['pass'];
			if($old_password == $db_password)
			{
				
				
				if($npass!="" && $repass!="")
				{
					if($new_password== $repeat_password )
					{
						$pass_update_query = mysqli_query($con,"UPDATE user SET pass= '{$new_password}' WHERE id='{$id}'");
						echo "Password updated!<br>";
					}
					else
					{
						echo "Your new passwords doesn't match<br>";
					}
				}
				
				if($nwname!= "")
				{
				$regex="/^[a-z ]+$/i";  
				if(!preg_match($regex,$nwname))
				{
					echo 'Name is invalid';
				}
				else
				{
						
						$u_name = mysqli_query($con,"UPDATE user SET name= '{$nwname}' WHERE id='{$id}'");
						echo "Name Updated<br>"; 
						
				}
				}
				
				if($nwsname!= "")
				{
				$regex="/^[a-z ]+$/i";  
				if(!preg_match($regex,$nwsname))
				{
					echo 'Surname is invalid';	
				}
				else
				{
											
							$u_sname = mysqli_query($con,"UPDATE user SET sname= '{$nwsname}' WHERE id='{$id}'");
							echo "Surname Updated<br>";
						
				}
				}
			
				if($nwmobile!= "" )
				{
					$regex="/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";  
					if(!preg_match($regex,$nwmobile)) 
					{
						echo 'Mobile Number is invalid' ;
					}
				
				
					else
					{
						$u_smob = mysqli_query($con,"UPDATE user SET mob= '{$nwmobile}' WHERE id='{$id}'");
						echo "Mobile Number Updated <br>";
					}
				}
			
				if($nwcity!= "" )
				{

							$u_name = mysqli_query($con,"UPDATE user SET city= '{$nwcity}' WHERE id='{$id}'");
							echo "City Updated<br>"; 
					
				}
				
				if($nwcountry!= "" )
				{
					
						$u_name = mysqli_query($con,"UPDATE user SET coun= '{$nwcountry}' WHERE id='{$id}'");
						echo "Country Updated <br>"; 
					
				}
				
				if($nwstudy!= "" )
				{
				
						$u_name = mysqli_query($con,"UPDATE user SET study= '{$nwstudy}' WHERE id='{$id}'");
						echo "Study Updated <br>"; 
				
				}
				
				
				if($nwwork!= "" )
				{
				
						$u_name = mysqli_query($con,"UPDATE user SET work= '{$nwwork}' WHERE id='{$id}'");
						echo "Work Updated <br>"; 
					
				}
				
				if($nwstream!= "" )
				{
				
						$u_name = mysqli_query($con,"UPDATE user SET stream= '{$nwstream}' WHERE id='{$id}'");
						echo "Stream Updated <br>"; 
					
				}
				
				if($nwdesig!= "" )
				{
				
						$u_name = mysqli_query($con,"UPDATE user SET desig= '{$nwdesig}' WHERE id='{$id}'");
						echo "Designation Updated<br>"; 
					
				}
				
			}
			else
			{
				echo "The Old password is Incorrect<br>";
			}
					
	}	
			
	
?>
		</b></div><br>
		<button type="submit" name="senddata" class="btn btn-danger center-block" class="form-control" style="font-size:large" ><b>Update</b></button>
	</form>
	<br>
</div>	
</div>
</div>
</div>
<!--Footer-->
<div class="foot">
	<div class="container-fluid ">
		<p>&copy; Copyright Tech Wizards </p>
	</div>
</div>
</body>
</html>