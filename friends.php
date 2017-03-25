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
	
.bw {
  -webkit-transition: all 1s ease;
     -moz-transition: all 1s ease;
       -o-transition: all 1s ease;
      -ms-transition: all 1s ease;
          transition: all 1s ease;
}
 
.bw img:hover {
  -webkit-filter: contrast(1) grayscale(100%);
  filter: contrast(1) grayscale(100%);
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
    background: linear-gradient(to right,#1a3300,#59b300);
    color: white;

}
	::-webkit-input-placeholder { font-style:initial; }
	::-moz-placeholder { font-style:initial; } /* firefox 19+ */
	:-ms-input-placeholder { font-style:initial; } /* ie */
	input:-moz-placeholder { font-style:initial; }
	.btn
	{
		box-shadow: 0px 2px 1px #7b7b52;
	}
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
.compic
	{
		width:30px;
		height:40px;
		overflow: hidden;
		box-shadow: 0px 2px 1px #7b7b52;
	}
	.pospic
	{
		width:80px;
		height:80px;
		overflow: hidden;
		border-radius:50%;
		border:2px solid white;
	}
	.list-pic
	{
		height:120px;
		overflow: hidden;
		border-radius:20px;
		box-shadow: 0px 2px 1px #7b7b52;
	}
	.posted
	{
		display: inline;
	}
	a:hover{text-decoration:none;color:white}
	a {color:white}
	.carousel-caption a
	{
		visibility:hidden;
	}
	.carousel-caption:hover a
	{
		visibility:visible;
		webkit-text-stroke:1px black;
		text-shadow:
		3px 3px 0 #000,
		-1px -1px 0 #000,
		-1px -1px 0 #000,
		-1px -1px 0 #000,
		-1px -1px 0 #000
		;
		font-size:150%;
		margin-left: auto;
	margin-right: auto;
	}
	.modal-header, .close
		{
			background: linear-gradient(to right, #1a1a4c , #5353c6);
			color:white !important;
			text-align: center;
			font-size: 30px;
		}
	.carousel:hover
	{
		background-color:black;
	}

	</style>
	<title>Friends</title>
</head>
<body>
<?php
if((isset($_SESSION['user'])))
include("header.php");
require_once("dbconnect.php");
if(isset($_GET['u']))
{
	$uid=mysqli_real_escape_string($con,$_GET['u']);
	$q="SELECT * FROM user WHERE id='{$uid}'";
	$res=mysqli_query($con,$q);
	$row=mysqli_fetch_array($res);
	if(mysqli_num_rows($res)==1)
	{
		$nameu=ucfirst(strtolower($row[1]));
		$snameu=ucfirst(strtolower($row[2]));
		$genu=$row[6];
		
	}
	else
	{
		if((isset($_SESSION['user'])))
		echo '<script>window.open("profile.php?u='.$id.'","_self");</script>';
		else
		echo '<script>window.open("signup.php","_self");</script>';	
	}
}
else
{
		header("location:logout.php");
}
require_once("dbconnect.php");
$check_pic = mysqli_query($con,"SELECT profpic FROM user WHERE id='{$uid}'");
				$get_pic_row = mysqli_fetch_array($check_pic);
				$profile_pic_db = $get_pic_row[0];
				if ($profile_pic_db == "" || !file_exists("userdata/profile_pics/$profile_pic_db"))
				{
					$profilepicu = "images/default_pic.jpg";
				}
				else
				{
					$profilepicu = "userdata/profile_pics/".$profile_pic_db;
				}
				
				$check_pic1 = mysqli_query($con,"SELECT covpic FROM user WHERE id='{$uid}'");
				$get_pic_row1 = mysqli_fetch_array($check_pic1);
				$cover_pic_db1 = $get_pic_row1[0];
				if ($cover_pic_db1 == "" || !file_exists("userdata/cover_pics/$cover_pic_db1"))
				{
					$cover_picu = "images/default_cov.jpg";
				}
				else
				{
					$cover_picu = "userdata/cover_pics/".$cover_pic_db1;
				}
?>
<div class="content">
<div class="container">
	<div class="rows">
		<div class="col-md-10 col-md-offset-1">
			<div style="position:relative; left:0px; top:0px;">
				<div class="covpic">
					<img src="<?php echo $cover_picu; ?>" class="img-responsive" style="opacity:0.9;width:100%;height:100%;transform: scale(1);">
				</div>
				<div class="ppic  wow tada  bw">
					<img src="<?php echo $profilepicu; ?>" class="img-responsive centered hvr-grow-rotate" style="width:100%;height:100%" />
				</div>
			 </div><br><br>
			<h3 style="text-align:center"><b><?php echo $nameu." ".$snameu;?></b></h3>
			<div class="navi">
				<nav class="navbar navbar-default navbar-custom navbar-inverse" style=""><!--background: linear-gradient(to right,#4d1900,#e64d00);-->
				<div class="container-fluid">
				<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#prof">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span> 
				</button>
				<div class="navbar-brand">&nbsp;<a href="profile.php?u=<?php echo $uid;?>" style="color:yellow;"><b><?php echo $nameu;?></b></a></div>
				</div>
				<div class="collapse navbar-collapse" id="prof">
					<ul class="nav navbar-nav">
						<li><a href="friends.php?u=<?php echo $uid; ?>"><b>Friends</b></a></li>  
						<li><a href="message.php?u=<?php echo $uid; ?>"><b>Message</b></a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
					<?php
					if($id==$uid)
					{
					?>
						<li class="dropdown">
							<a id="dLabel1" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							<b><span class="glyphicon glyphicon-cog"></span>Update Info</b>
							<span class="caret"></span>
							<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dLabel1">
							<li><a href="settings.php"><a href="settings.php"><b>Account Settings</b></a></li>
							<li><a href="profpic.php"><b>Change display pics</b></a></li>
							</ul>
							</a>
						</li>
					<?php }
					else
					{
						?>
						<form action="" method="POST"><!--FORM MANAGE REQUEST-->
						<?php
						//For not allowing friends to send request to each other
						$check_friend=mysqli_query($con,"SELECT friend_array FROM user WHERE id='{$id}'");
						$check_friend_row=mysqli_fetch_array($check_friend);
						$explode_friend_array=explode(",",$check_friend_row[0]);//Here ',' acts as a delimter
						if($check_friend_row=="")
							$explode_friend_array=count(NULL);//Since explode returns something even when the array is empty so this is done to cure it
						$found=0;
						foreach($explode_friend_array as $friendid)
						{	
							if($friendid==$uid)
								$found=1;
						}
							if($found==1)
							{
								?>
								<li style="padding-top:8px;"><button type="button" class="btn btn-warning hvr-wobble-bottom" style="box-shadow: 0px 2px 1px #b34700;" data-toggle="modal" data-target="#remove" ><b>Remove Friend</b></button></li>
								<!--Modal-->
									<div id="remove" class="modal fade wow bounceInUp" role="dialog">
									<div class="modal-dialog ">
									<div class="modal-content">
										<div class="modal-header" style="">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span><strong> Remove Friend</strong></h4>
										</div>
										<div class="modal-body" style="">
										<form role="form" action="profile.php?u=<?echo $uid;?>" method="POST">
											<b>Do you really want to remove <?php echo $nameu;?> from your friend list?</b>
											<button class="btn btn-success" type="submit" name="removefr">Yes</button>
											<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
										</form>
									</div>
									</div>
									</div>
									</div>
								<!--End of Modal-->
								<?php
								if(isset($_POST['removefr']))//REMOVE FRIEND
								{
									$uid_comma=','.$uid;//viewed
									$id_comma=','.$id;//loguser
									$uid_comma2=$uid.',';//viewed
									$id_comma2=$id.',';//loguser
									
									$loguser_query=mysqli_query($con,"SELECT * FROM user WHERE id='$id'") or die(mysqli_error($con));
									$loguser=mysqli_fetch_array($loguser_query);
									$viewed_query=mysqli_query($con,"SELECT * FROM user WHERE id='$uid'") or die(mysqli_error($con));
									$viewed=mysqli_fetch_array($viewed_query);
									$loguser_array=$loguser['friend_array'];
									$viewed_array=$viewed['friend_array'];
									
									//check if friend is present in friend array of both
									if(strstr($loguser_array,$uid_comma))
										$loguser_final=str_replace($uid_comma,"",$loguser_array);
									else if(strstr($loguser_array,$uid_comma2))
										$loguser_final=str_replace($uid_comma2,"",$loguser_array);
									else if(strstr($loguser_array,$uid))
										$loguser_final=str_replace($uid,"",$loguser_array);
									
									if(strstr($viewed_array,$id_comma))
										$viewed_final=str_replace($id_comma,"",$viewed_array);
									else if(strstr($viewed_array,$id_comma2))
										$viewed_final=str_replace($id_comma2,"",$viewed_array);
									else if(strstr($viewed_array,$id))
										$viewed_final=str_replace($id,"",$viewed_array);
									
									
									//Removing from friend array and updating new value
									$remove_logged_query=mysqli_query($con,"UPDATE user SET friend_array='{$loguser_final}' WHERE id='{$id}'");
									$remove_viewed_query=mysqli_query($con,"UPDATE user SET friend_array='{$viewed_final}' WHERE id='{$uid}'");
									echo '<script>window.open("profile.php?u='.$uid.'","_self");</script>';
								}
							}
							else
							{
								?>
						<li style="padding-top:8px;"><button type="submit" class="btn btn-success" name="frequest"><b>
							<?php 
							//Checking if friend request once sent ,then it cannot be sent again
								$touser=$uid;
								$fromuser=$id;
								$sent=0;//when request has been sent
								$check_req=mysqli_query($con,"SELECT touser FROM request WHERE fromuser='{$id}'");
								while($check_req_row=mysqli_fetch_array($check_req))
								{
									if($check_req_row[0]==$uid)
										$sent=1;//checks if id has already sent uid request or not
								}
								$check_breq=mysqli_query($con,"SELECT fromuser FROM request WHERE touser='{$id}'");//before request
								while($check_breq_row=mysqli_fetch_array($check_breq))
								{
									if($check_breq_row[0]==$uid)
										$sent=2;//checks if uid has already sent me request or not
								}
								if($sent==0 && !isset($_POST['frequest']))
									echo "Add friend";
								if($sent==1)
									echo "Friend request sent";
								if($sent==2)
									echo '<a href="requests.php">See request</a>';
								if($sent==0 && isset($_POST['frequest']))
								{
										$insert_req=mysqli_query($con,"INSERT INTO request VALUES('','{$touser}','{$fromuser}')");
										echo "Friend request sent ";
								}
							?></b></button>
							<?php
							if($sent==1 || ($sent==0 && isset($_POST['frequest'])))
							{
							?><button type="submit" class="btn btn-danger" style="box-shadow: 0px 2px 1px #b34700;" name="can_request"><b>Cancel request</b></button></li>
							<?php
							}//To cancel Friend request 	
							if(isset($_POST['can_request']))
							{
								$select_req=mysqli_query($con,"SELECT id FROM request WHERE fromuser='{$id}' AND touser='{$uid}'");
								$idcr=mysqli_fetch_array($select_req);
								$idcrow=$idcr[0];
								$cancel_request=mysqli_query($con,"DELETE FROM request WHERE id='{$idcrow}'");
								echo '<script>window.open("profile.php?u='.$uid.'", "_self");</script>';
							}
						} 
						?>
							</form>
						<?php 
					}
					?>
					</ul>
				</div>
				</div>
				</nav>
			</div>
				<!--left pane cover-->
		<div class="rows">
				<div class="col-sm-12">
					<div class="panel panel-default">
						
					</div>
					<div class="panel panel-default"><!--Friends-->
						<div class="panel-heading" style="background: linear-gradient(to right, #b35900,#ff8c1a);color: white;">
						<b><?php
						$friend_query=mysqli_query($con,"SELECT friend_array FROM user WHERE id='{$uid}'");
						$friend_query_row=mysqli_fetch_array($friend_query);
						$explode_friend_query=explode(",",$friend_query_row[0]);
						if($friend_query_row[0]=="")
							$num_friends=0;
						else
							$num_friends=count($explode_friend_query);
						if($uid==$id)
						echo "My Friends";
						else
						echo $nameu."'s friends";
						?></b> <span class="badge"><?php echo $num_friends;?></span>
						</div>
						<div class="panel-body">
							<div class="rows">
							<?php
								if($friend_query_row[0]=="")
									echo "No friends";
								else
								{
									$i=1;
								foreach($explode_friend_query as $listitem)
								{				
									$get_query=mysqli_query($con,"SELECT * FROM user WHERE id='{$listitem}'");
									$get_row_query=mysqli_fetch_array($get_query);
									$get_name=ucfirst(strtolower($get_row_query['name']));
									$get_sname=ucfirst(strtolower($get_row_query['sname']));
									
									$cityh=ucfirst(strtolower($get_row_query['city']));
									$counh=ucfirst(strtolower($get_row_query['coun']));
									$desigh=ucfirst(strtolower($get_row_query['desig']));
									$studyh=ucfirst(strtolower($get_row_query['study']));
									$workh=ucfirst(strtolower($get_row_query['work']));
									$streamh=ucfirst(strtolower($get_row_query['stream']));
									
									$get_pic=$get_row_query['profpic'];
									
									if ($get_pic == "" || !file_exists("userdata/profile_pics/$get_pic"))
									{
										$get_pic = "images/default_pic.jpg";
									}
									else
									{
										$get_pic = "userdata/profile_pics/".$get_pic;
									}
									//carousel with single element
										?>
										<div class="col-sm-6" <?php if($i%2==0) echo 'style="border-left:1px solid grey;"';?>>
										&nbsp;
											<div class="rows">
												<div class="col-sm-4">
															<div class="list-pic">
															<a href="profile.php?u=<?php echo $listitem;?>">
																<img src="<?php echo $get_pic;?>" class="img-responsive" style="width:100%;height:100%;" />
															</a>
															</div>
												</div>
												<div class="col-sm-8">
												
														<a href="profile.php?u=<?php echo $listitem;?>" style="color:black;"><h4><b><?php echo $get_name." ".$get_sname; ?></b></h4></a>
												
													<?php
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
						?>
												</div>
											</div>
															
										</div>
										<?php
									$i++;
								}
								}
							?>
							</div>
						</div>
					</div>
				</div>
			
</script>
</body>
</html>