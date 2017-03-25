<?php 
session_start();	
if(!(isset($_SESSION['user'])))
{
	header('location:logout.php');
}
include ("head.php");
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
    background: linear-gradient(to right,#33001a, #b30059);
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
	.pospic
	{
		width:60px;
		height:60px;
		overflow: hidden;
		border-radius:50%;
		border:2px solid white;
	}
	.list-pic
	{
		height:120px;
		overflow: hidden;
		border-radius:25px;
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
	.propic
	{
		border-radius:50%; 
		height:200px; 
		width:200px;
		overflow: hidden;
		box-shadow: 0px 6px 5px #7b7b52;
		border:2px solid white;
	}
	</style>
	<title>Home</title>
</head>

<body>
<?php
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
		$nameu=$row[1];
		$snameu=$row[2];
		$genu=$row[6];
		$dob=$row['dob'];
		$cityh=ucfirst(strtolower($row['city']));
		$counh=ucfirst(strtolower($row['coun']));
		$desigh=ucfirst(strtolower($row['desig']));
		$studyh=ucfirst(strtolower($row['study']));
		$workh=ucfirst(strtolower($row['work']));
		$streamh=ucfirst(strtolower($row['stream']));
	}
	else
	{
		if((isset($_SESSION['user'])))
		header("location:home.php?u=".$id);
		else
		header("location:signup.php");	
	}
}
else
{
		header("location:logout.php");
}
require_once("dbconnect.php");
$check_pic = mysqli_query($con,"SELECT profpic FROM user WHERE id='{$id}'");
				$get_pic_row = mysqli_fetch_array($check_pic);
				$profile_pic_db = $get_pic_row[0];
				if ($profile_pic_db == "" || !file_exists("userdata/profile_pics/$profile_pic_db"))
				{
					$profilepic = "images/default_pic.jpg";
				}
				else
				{
					$profilepic = "userdata/profile_pics/".$profile_pic_db;
				}
?>
<div class="content">
	<div class="rows">
		<div class="col-md-3 col-md-offset-1">
			<div class="propic centered">
				<img src="<?php echo $profilepic; ?>" class="img-responsive centered" style="width:100%;height:100%;"/><hr>
			</div>
			<h4 style="text-align:center;"><b><?php
		echo $name." ".$sname;
			?></b></h4>
			<div class="panel panel-default centered">
						<div class="panel-body">
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
						$yrb=substr($dob,0,4);
						$monb=substr($dob,5,2);
						$dayb=substr($dob,8,2);
						$dateb=$dayb.".".$monb.".".$yrb;
						echo '<b>Birthday: '.$dateb.'</b>';
						?>
						</div>
					</div>
		</div>
		<div class="col-md-6">
			
					<?php
					//comment pic
							if ($profilepic == "" || !file_exists("userdata/profile_pics/$profilepic"))
								{
									$profilepic = "images/default_pic.jpg";
								}
								else
								{
									$profilepic = "userdata/profile_pics/".$profilepic;
								}			
					//Post
						$friend_query=mysqli_query($con,"SELECT friend_array FROM user WHERE id='{$uid}'");
						$friend_query_row=mysqli_fetch_array($friend_query);
						$explode_friend_query=explode(",",$friend_query_row[0]);
						$cempty=0;//check if newsfeed is empty or not
						if($friend_query_row[0]=="")
							echo '<h1 style="color:brown;"><b>You dont have any friends to see their posts  </b></h1>';
						else
						{	
						foreach($explode_friend_query as $listitem)
						{
						$getposts = mysqli_query($con,"SELECT * FROM posts WHERE user_posted_to='$listitem' ORDER BY id DESC") or die(mysqli_error($con));
						if(mysqli_num_rows($getposts)!=0)
						{	$cempty=1;
								while ($rowp = mysqli_fetch_array($getposts))//WHILE LOOP STARTS HERE 
								{
									$idp = $rowp['id'];
									$body = $rowp['body'];	
									$date_added = $rowp['date_added'];
									$time_added=$rowp['time_added'];
									$yr=substr($date_added,0,4);
									$mon=substr($date_added,5,2);
									$day=substr($date_added,8,2);
									$date=$day.".".$mon.".".$yr;
									$hr=substr($time_added,0,2);
									$t=0;
									if($hr>12)
									{//To detect night or day
										$hr=$hr-12;
										$t=1;
									}
									$min=substr($time_added,3,2);
									$time=$hr.":".$min;
									$added_by = $rowp['added_by'];
									$user_posted_to= $rowp['user_posted_to'];
									$addname=mysqli_query($con,"SELECT * FROM user WHERE id='$added_by'") or die(mysqli_error($con));
									$add=mysqli_fetch_array($addname);
									$postname=mysqli_query($con,"SELECT * FROM user WHERE id='$user_posted_to'") or die(mysqli_error($con));
									$posted2=mysqli_fetch_array($postname);
									$addpic=$add[8];
									if ($addpic== "" || !file_exists("userdata/profile_pics/$addpic"))
									{
										$addpic = "images/default_pic.jpg";
									}
									else
									{
										$addpic = "userdata/profile_pics/".$addpic;
									}
									$addby=ucfirst(strtolower($add[1]));
									$postby=ucfirst(strtolower($posted2[1]));
									if($postby==$name)
										$postby="your";
									else if($postby==$nameu)
										{
												if($genu=="male")
													$postby="his";
												else
													$postby="her";
										}
									else
										$postby=$postby."'s";
									if($addby==$name)
										$addby="You";
					?>
					<div class="panel panel-default" >
					<!--POSTs-->
						<div class="panel-heading">
							<div class="rows">
								<div class="col-xs-2">
									<div class="pospic">
										<a href="profile.php?u=<?php echo $added_by;?>">
										<img src="<?php echo $addpic;?>" class="img-responsive" style="width:100%;height:100%;" /></a>
									</div>
								</div>
								<div class="col-xs-10" style="font-size:130%;padding-top:15px;">
									<b><?php echo $addby." posted in ".$postby." timeline";?></b>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						
						<div class="panel-body">
							<div class="pull-right" style="color:grey;font-size:70%;font-weight:70%;">
							<b><?php
							if($t==0)
								echo $time."a.m";
							else
								echo $time."p.m";
							?> , <?php
								echo $date;
							?></b>
							</div><br>
							<div class="clearfix"></div>
							<span style="font-weight:700"><?php echo $body;?></span>
						</div>
						<div class="panel-footer" class=="display:inline"> 
						<iframe src="likes.php?id=<?php echo $id;?>&pid=<?php echo $idp;?>" frameBorder="0"  style='overflow:hidden;height: 35px; width: 123px;'></iframe>
						<a href='javascript:void(0)' onClick="javascript:toggle<?php echo $idp?>()" style="color:grey;position:absolute;padding-top:6.5px;margin-left:0px;"><b>Comments</b></a>
						<div id='toggleComment<?php echo $idp;?>' style="display:none;">
						<iframe src="comment.php?idp=<?php echo $idp;?>&pt=<?php echo $uid;?>&pb=<?php echo $id;?>" style='width:100%;' frameBorder="0"></iframe>
						
						</div><!--Toggle Ends here-->		
						<div class="clearfix"></div>						
					</div>
				<script language="javascript">
							function toggle<?php echo $idp; ?>() {
							var ele = document.getElementById("toggleComment<?php echo $idp; ?>");
							
							if (ele.style.display == "block") {
							ele.style.display = "none";
							}
							else
							{
								ele.style.display = "block";
							}
							}
							</script>	
					</div>
					
								<?php }
						}
								}
								if($cempty==0)//if there are no posts in any friends timeline
									echo '<h1 style="color:brown;"><b>Your friends does not have any posts  </b></h1>';
								}
								?>
</div>
</body>
</html>