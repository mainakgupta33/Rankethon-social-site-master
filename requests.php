<?php
include("head.php"); 
if(!(isset($_SESSION['user'])))
{
	header('location:logout.php');
}
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
	.req_pic
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
	a:hover{
		text-decoration:none;
		}
	</style>
	<title>Requests</title>
</head>
<body>
	<?php
		include("header.php");
	?>
	<div class="content">
		<div class="container">
		<div class="rows">
		<?php
		$req="SELECT * FROM request WHERE touser='{$id}'";
		$req1=mysqli_query($con,$req);
		$req_row=mysqli_fetch_array($req1);
		if(!count($req_row))
			echo '<br><h4 style="color:green"><b>No new requests</b></h4>';
		else
		{
			do
			{
				$idr=$req_row[0];
				$touser=$req_row[1];
				$fromuser=$req_row[2];
				//fu-from user and tu-to user
				$fu_query=mysqli_query($con,"SELECT * FROM user WHERE id='$fromuser'") or die(mysqli_error($con));
				$fu=mysqli_fetch_array($fu_query);
				$tu_query=mysqli_query($con,"SELECT * FROM user WHERE id='$touser'") or die(mysqli_error($con));
				$tu=mysqli_fetch_array($tu_query);
				$fupic=$fu[8];
				if ($fupic== "")
				{
					$fupic = "images/default_pic.jpg";
				}
				else
				{
					$fupic = "userdata/profile_pics/".$fupic;
				}
				
				$fu_name=ucfirst(strtolower($fu[1]));
				$fu_sname=ucfirst(strtolower($fu[2]));
				
			?>
			<?php
					if(isset($_POST['from'.$fromuser]))
					{
						$from_friend_array=$fu['friend_array'];
						$to_friend_array=$tu['friend_array'];
						$to_friend_count=count(explode(",",$to_friend_array));
						$from_friend_count=count(explode(",",$from_friend_array));
						
						if($from_friend_array=="")
							$from_friend_count=count(NULL);
						if($to_friend_array=="")
							$to_friend_count=count(NULL);
						
						if($from_friend_count==0)
							$add_in_from_query=mysqli_query($con,"UPDATE user SET friend_array=CONCAT(friend_array,'{$touser}') WHERE id='{$fromuser}'");
						if($to_friend_count==0)
							$add_in_to_query=mysqli_query($con,"UPDATE user SET friend_array=CONCAT(friend_array,'{$fromuser}') WHERE id='{$touser}'");
						if($from_friend_count>=1)
							$add_in_from_query=mysqli_query($con,"UPDATE user SET friend_array=CONCAT(friend_array,',{$touser}') WHERE id='{$fromuser}'");
						if($to_friend_count>=1)
							$add_in_to_query=mysqli_query($con,"UPDATE user SET friend_array=CONCAT(friend_array,',{$fromuser}') WHERE id='{$touser}'");
						
						$delete_request=mysqli_query($con,"DELETE FROM request WHERE id='{$idr}'");
						?>
						<div class="alert alert-success">	
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<strong>You and <a style="color:black" href="profile.php?u=<?php echo $fromuser;?>"><?php echo $fu_name;?></a> are friends now</strong>  
						</div>
					<?php  continue;}
					if(isset($_POST['ig'.$fromuser]))
					{
						$ignore_request=mysqli_query($con,"DELETE FROM request WHERE id='{$idr}'");
						?>
						<div class="alert alert-danger">	
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<strong>Request from <a style="color:black" href="profile.php?u=<?php echo $fromuser;?>"><?php echo $fu_name;?></a> deleted!</strong>  
						</div>
					<?php continue;//after deleting one request switch to next request user 
					}						
				?>
			<div class="col-sm-4">
				<div class="panel panel-default" >
					<div class="panel-heading" style="background: linear-gradient(to right, red,orange);color: white;">
						<?php
							echo '<b>'.$fu_name." sent you a friend request".'</b>';
						?>
					</div>
					<div class="panel-body">
						<div class="rows">
							<div class="col-xs-6">
								<div class="req_pic">
								<a href="profile.php?u=<?php echo $fromuser;?>">	<img src="<?php echo $fupic;?>" class="img-responsive" style="width:100%;height:100%;"></a>
								</div>
							</div>
							<div class="col-xs-6">
							<br>
							<a href="profile.php?u=<?php echo $fromuser;?>" style="color:black;">
							<?php echo '<b>'.$fu_name." ".$fu_sname.'</b>';?>
							</a>
							</div>
							<form action="" method="POST"><!--FORM-->
							<div class="col-xs-6">
							<br>
								<button class="btn btn-success btn-block" type="submit" name="from<?php echo $fromuser?>"><b>Accept request</b></button>
							</div>
							<div class="col-xs-6">
								<br>
								<button class="btn btn-danger btn-block" type="submit" name="ig<?php echo $fromuser?>"><b>Ignore request</b></button>
							</div>
						</form>
						</div>
					</div>
					</div>
				</div>
			<?php			
			}while($req_row=mysqli_fetch_array($req1));
		}
		?>
		</div>
	</div>
	</div>
</body>
</html>