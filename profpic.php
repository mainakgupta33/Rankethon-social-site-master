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
	#cover
	{
		position:relative;
		top:0px; left:0px;
		width:100%;
		max-height:420px;
		overflow: hidden;
		z-index:-1;
		
	}
	.centered
	{
		margin-left: auto;
		margin-right: auto;
	}
	}
	textarea.expandable 
	{
		height:40px;
	-webkit-transition: all 0.5s ease-in-out;	
	}

	textarea.expandable:hover, textarea.expandable:focus {
	height:calc(100% - 90px);      
	-webkit-transition: all 0.8s ease-in-out;
	}
      
	.panel-300:hover, .panel-300 {
	height:300px;    
	}

	textarea.expandable + textarea.expandable:hover, textarea.expandable + textarea.expandable:focus {
	height:calc(100% - 90px)	
	}
	.panel > .panel-heading {
    background-color: black;
    color: white;

}
.covpic
	{
		position:relative;
		top:0px; left:0px;
		border-radius:20px;
		height:420px;
		overflow: hidden;
		z-index:-1;
		box-shadow: 0px 6px 5px #7b7b52;
		border:2px solid white;
		
	}
	
	::-webkit-input-placeholder { font-style:initial; }
	::-moz-placeholder { font-style:initial; } /* firefox 19+ */
	:-ms-input-placeholder { font-style:initial; } /* ie */
	input:-moz-placeholder { font-style:initial; }
	.ppic
	{
	position: absolute; 
		top:270px;
		left: 0;
		right: 0;
		display: block;
		z-index:1;
		box-shadow: 0px 6px 5px #7b7b52;
		border:2px solid white;
	border-radius:50%;
	height:200px;
	width:200px;
	overflow: hidden;
	margin-left: auto;
	margin-right: auto;
	}
	.btn
	{
		box-shadow: 0px 2px 1px #7b7b52;
	}
	.foot
	{
		background-color:black;
		color:white;
		text-align:center;
		padding:10px;
	}

	</style>
	<title>My Profile</title>
</head>
<body>
<?php
if(!(isset($_SESSION['user'])))
{
	header('location:logout.php');
}
include("header.php");
				$pr="";$pr1="";
				$check_pic = mysqli_query($con,"SELECT profpic FROM user WHERE id='{$id}'");
				$get_pic_row = mysqli_fetch_array($check_pic);
				$profile_pic_db = $get_pic_row[0];
				if ($profile_pic_db == "" || !file_exists("userdata/profile_pics/$profile_pic_db"))
				{
					$profile_pic = "images/default_pic.jpg";
				}
				else
				{
					$profile_pic = "userdata/profile_pics/".$profile_pic_db;
				}
				//Profile Image upload script
				if (isset($_FILES['profilepic']))
				{
					if ((($_FILES["profilepic"]["type"]=="image/jpeg") || ($_FILES["profilepic"]["type"]=="image/jpg") || ($_FILES["profilepic"]["type"]=="image/png") || ($_FILES["profilepic"]["type"]=="image/gif"))&&($_FILES["profilepic"]["size"] < 10485760)) //10 Megabyte
					{
						$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
						$rand_dir_name = substr(str_shuffle($chars), 0, 15);
						mkdir("userdata/profile_pics/$rand_dir_name");
						if (file_exists("userdata/profile_pics/$rand_dir_name/".$_FILES["profilepic"]["name"]))
						{
							$pr=$_FILES["profilepic"]["name"]." Already exists";
						}
						else
						{	
							move_uploaded_file($_FILES["profilepic"]["tmp_name"],"userdata/profile_pics/$rand_dir_name/".$_FILES["profilepic"]["name"]);
							//echo "Uploaded and stored in: userdata/profile_pics/$rand_dir_name/".@$_FILES["profilepic"]["name"];
							//Deleting the folder containing the earlier profile picture
							$del_check=$row['profpic']; 
							$del_fol="userdata/profile_pics/".explode('/',$del_check)[0];
							$del_file="userdata/profile_pics/".$del_check;
							if($del_check!="" && file_exists("userdata/profile_pics/$del_check")) 
							{
								unlink($del_file);
								rmdir($del_fol);
							}
							$profile_pic_name = $_FILES["profilepic"]["name"];
							$profile_pic_query = mysqli_query($con,"UPDATE user SET profpic='$rand_dir_name/$profile_pic_name' WHERE id='{$id}'");
							echo '<script>window.open("profpic.php", "_self");</script>';
						}
					}
				}
				else
				{
					$pr="";
				}
				//----------COVER PIC---------------------
				$check_pic1 = mysqli_query($con,"SELECT covpic FROM user WHERE id='{$id}'");
				$get_pic_row1 = mysqli_fetch_array($check_pic1);
				$cover_pic_db1 = $get_pic_row1[0];
				if ($cover_pic_db1 == "" || !file_exists("userdata/cover_pics/$cover_pic_db1"))//file exists to check if file is deleted or not
				{
					$cover_pic1 = "images/default_cov.jpg";
				}
				else
				{
					$cover_pic1 = "userdata/cover_pics/".$cover_pic_db1;
				}
				//Cover Image upload script
				if (isset($_FILES['coverpic']))
				{
					if ((($_FILES["coverpic"]["type"]=="image/jpeg") || ($_FILES["coverpic"]["type"]=="image/jpg") || ($_FILES["coverpic"]["type"]=="image/png") || ($_FILES["coverpic"]["type"]=="image/gif"))&&($_FILES["coverpic"]["size"] < 10485760)) //10 Megabyte
					{
						$charsc ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
						$rand_dir_namec = substr(str_shuffle($charsc), 0, 15);
						mkdir("userdata/cover_pics/$rand_dir_namec");
						if (file_exists("userdata/cover_pics/$rand_dir_namec/".$_FILES["coverpic"]["name"]))
						{
							$pr1=$_FILES["coverpic"]["name"]." Already exists";
						}
						else
						{	
							move_uploaded_file($_FILES["coverpic"]["tmp_name"],"userdata/cover_pics/$rand_dir_namec/".$_FILES["coverpic"]["name"]);
							//echo "Uploaded and stored in: userdata/cover_pics/$rand_dir_name1/".@$_FILES["coverpic"]["name"];
							//Deleting the folder containing the earlier cover picture
							$del_check1=$row['covpic']; 
							$del_fol1="userdata/cover_pics/".explode('/',$del_check1)[0];
							$del_file1="userdata/cover_pics/".$del_check1;
							if($del_check1!="" && file_exists("userdata/cover_pics/$del_check1")) 
							{
								unlink($del_file1);
								rmdir($del_fol1);
							}
							$cover_pic_name1= $_FILES["coverpic"]["name"];
							$cover_pic_query1 = mysqli_query($con,"UPDATE user SET covpic='$rand_dir_namec/$cover_pic_name1' WHERE id='{$id}'");
							echo '<script>window.open("profpic.php", "_self");</script>';
						}
					}
				}
				else
				{
					$pr1="";
				}

?>
<div class="content">
<div class="container">
	<div class="rows">
		<div class="col-md-10 col-md-offset-1">
			<div style="position:relative; left:0px; top:0px;">
				<div class="covpic">
					<img src="<?php echo $cover_pic1; ?>" class="img-responsive" style="opacity:0.9;width:100%;height:100%;transform: scale(1);">
				</div>
				<div class="ppic">	
					<img src="<?php echo $profile_pic; ?>" class="img-responsive centered hvr-grow-rotate"   style="height:100%;width:100%;">
				</div>
			 </div><br><br>
			<h3 style="text-align:center"><b><?php echo $name." ".$sname;?></b></h3>
			<div class="rows">
			<div class="col-md-5">
			<form role="form" action="" method="POST" enctype="multipart/form-data">
				<h4><b>Change profile picture</b></h4> <?php ?>
				<input type="file"  class="filestyle" data-placeholder="No file" data-buttonBefore="true" data-iconName="glyphicon glyphicon-inbox" data-buttonName="btn-success" name="profilepic" /><br />
				<input type="submit" data-toggle="tooltip" title="Your image should be within 2MB and must be either a .jpg, .jpeg, .png or .gif" data-placement="right" class="btn btn-primary" name="uploadpic" value="Upload Image">
				&nbsp;<b style="color:grey"><?php echo $pr;?></b>
			</form>
			</div>
			<div class="col-md-2">
			</div><!--changing cover picture-->
			<div class="col-md-5">
			<form role="form" action="" method="POST" enctype="multipart/form-data">
				<h4><b>Change Cover picture</b></h4>
				<input type="file"  class="filestyle" data-placeholder="No file" data-buttonBefore="true" data-iconName="glyphicon glyphicon-inbox" data-buttonName="btn-success" name="coverpic" /><br />
				<input type="submit" data-toggle="tooltip" title="Your image should be within 2MB and must be either a .jpg, .jpeg, .png or .gif" data-placement="right" class="btn btn-primary" name="uploadpic1" value="Upload Image">
				&nbsp;<b style="color:grey"><?php echo $pr1;?></b>
			</form>
			</div>
			</div>
		</div>
	</div>
</div>
</div><br>		
<!--Footer-->
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