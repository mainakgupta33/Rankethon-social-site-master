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
	margin-top:60px;
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
	.pospic
	{
		width:60px;
		height:60px;
		overflow: hidden;
		border-radius:50%;
		border:2px solid white;
	}
	.pospics
	{
		width:100px;
		height:100px;
		overflow: hidden;
		border-radius:50%;
		border:2px solid white;
	}
	</style>
	
	<title> Messages </title>
</head>
<body >

<?php

include("header.php");
$uid=mysqli_real_escape_string($con,$_GET['u']);
	$q="SELECT * FROM user WHERE id='{$uid}'";
	$res=mysqli_query($con,$q);
	$row=mysqli_fetch_array($res);
	if(mysqli_num_rows($res)==1)
	{
		$nameu=ucfirst(strtolower($row[1]));
		$snameu=ucfirst(strtolower($row[2]));
		$genu=$row[6];
		$dob=$row['dob'];
		$cityh=ucfirst(strtolower($row['city']));
		$counh=ucfirst(strtolower($row['coun']));
		$desigh=ucfirst(strtolower($row['desig']));
		$studyh=ucfirst(strtolower($row['study']));
		$workh=ucfirst(strtolower($row['work']));
		$streamh=ucfirst(strtolower($row['stream']));
				$profile_pic_db = $row['profpic'];
				if ($profile_pic_db == "" || !file_exists("userdata/profile_pics/$profile_pic_db"))
				{
					$profilepicu = "images/default_pic.jpg";
				}
				else
				{
					$profilepicu = "userdata/profile_pics/".$profile_pic_db;
				}
	}
	else
	{
		if((isset($_SESSION['user'])))
		echo '<script>window.open("profile.php?u='.$id.'","_self");</script>';
		else
		echo '<script>window.open("signup.php","_self");</script>';	
	}
?>
<div class="content" >
	<div class="container">
		<div class="rows">
			<div class="col-sm-5">
				<form action="" method="POST">
					<div class="form-group">
					<h4>Compose Message for <?php echo $nameu." ".$snameu; ?> :</h4>
						<textarea class="form-control expandable" rows="5" name="message" placeholder="Type your message" required></textarea>
					</div>
					<button class="btn btn-primary" name="send" type="submit">Send</button>
				</form>
				<?php
				if(isset($_POST['send']))
				{
					$m_body=strip_tags($_POST['message']);
					date_default_timezone_set("Asia/Kolkata");
					$date_added = date("Y.m.d");
					$time_added=date("H:i:sa");
					$m_from = $id;
					$m_to =$uid;
					$code=($m_to+$m_from);//For showing the conversations among two persons
					$sqlCommand = "INSERT INTO messages VALUES('', '$m_from','$m_to','$m_body','$date_added','$time_added','0','$code')";  
					$query = mysqli_query($con,$sqlCommand) or die (mysqli_error($con));
				}
				?>
				<div class="pospic centered">
										<a href="profile.php?u=<?php echo $uid;?>">
										<img src="<?php echo $profilepicu;?>" class="img-responsive" style="width:100%;height:100%;" /></a>
									</div>
				<h5 style="text-align:center;"><b><?php echo $nameu." ".$snameu; ?></b></h5>
				<div class="chat" style="background-color:white;border-radius:25px;padding:8px;">
				<?php
				$code=$id+$uid;
				$show=mysqli_query($con,"SELECT * FROM messages WHERE code='$code' AND (mto='$id' OR mfrom='$id') ORDER BY id DESC");
				if(mysqli_num_rows($show)!=0)
				{
					while($showrows=mysqli_fetch_array($show))
					{
						$person=$showrows['mfrom'];
						if($person==$uid)
						{
							$person=$nameu." ".$snameu;
							?>
							<div class="righted" style="text-align:right;">
							<a href="profile.php?u=<?php echo $showrows['mfrom'];?>" style="color:black;"><b><?php echo $person;?></b></a><?php
						$msg=$showrows['mbody'];
						$date_added= $showrows['date'];
						$time_added=$showrows['time'];
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
						$time=$hr.":".$min;?>
						<b style="color:grey;font-size:70%;font-weight:70%;">[<?php
							if($t==0)
								echo $time."a.m";
							else
								echo $time."p.m";
							?> , <?php
								echo $date;
							?>]</b><br><span><?php echo $msg;?></span><hr></div><?php
						}
						else
						{//For msg from = user
							$person=$name." ".$sname;
							?>
							<a href="profile.php?u=<?php echo $showrows['mfrom'];?>" style="color:brown"><b><?php echo $person;?></b></a><?php
						$msg=$showrows['mbody'];
						$date_added= $showrows['date'];
						$time_added=$showrows['time'];
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
						$time=$hr.":".$min;?>
						<b style="color:grey;font-size:70%;font-weight:70%;">[<?php
							if($t==0)
								echo $time."a.m";
							else
								echo $time."p.m";
							?> , <?php
								echo $date;
							?>]</b><br><?php echo $msg;?><hr><?php
						}
						?>
							<?php
					}
				
				}
				else
				{
					echo "No Messages";
				}
			?>
			</div>
			</div>
			<div class="col-sm-7">
			<h4 style="text-align:center;"><b>My Inbox</b></h4>
			<div class="rows" style="color:white">
				<div class="col-sm-5 col-sm-offset-1" style="background-color:#0066cc;border-radius:25px;padding:2px;">
				<h5 style="text-align:center;"><b>Sent</b></h5>
				<hr>
				<?php	
				$rechecks=array('0');
				$sent=mysqli_query($con,"SELECT * FROM messages WHERE mfrom='$id' ORDER BY id DESC");
				while($sentrow=mysqli_fetch_array($sent))
				{
					$toid=$sentrow['mto'];
					$retrive=mysqli_query($con,"SELECT * FROM user WHERE id='$toid'");
					$retrow=mysqli_fetch_array($retrive);
						$skips=0;
						$ids=$retrow[0];
						foreach($rechecks as $sen)
						if($sen==$ids)
							$skips=1;
						if($skips==1)
							continue;
						array_push($rechecks,$ids);
						$names=ucfirst(strtolower($retrow[1]));
						$snames=ucfirst(strtolower($retrow[2]));
						$profile_pic_dbs = $retrow['profpic'];
						if ($profile_pic_dbs == "" || !file_exists("userdata/profile_pics/$profile_pic_dbs"))
						{
							$profilepicus = "images/default_pic.jpg";
						}
						else
						{
							$profilepicus= "userdata/profile_pics/".$profile_pic_dbs;
						}
						?>
						<div class="pospics centered">
						<a href="message.php?u=<?php echo $ids;?>">
						<img src="<?php echo $profilepicus;?>" class="img-responsive" style="width:100%;height:100%;" /></a>
						</div>
				<h5 style="text-align:center;"><b><?php echo $names." ".$snames; ?></b></h5>
						<?php
						
					
					
				}
			?>
				</div>
				<div class="col-sm-5 col-sm-offset-1" style="background-color:#ff944d;border-radius:25px;padding:2px;">
				<h5 style="text-align:center;"><b>Received</b></h5>
				<hr>
				<?php		
				$recheckr=array('0');
				$rec=mysqli_query($con,"SELECT * FROM messages WHERE mto='$id' ORDER BY id DESC");
				while($recrow=mysqli_fetch_array($rec))
				{
					
					$fromid=$recrow['mfrom'];
					$retriver=mysqli_query($con,"SELECT * FROM user WHERE id='$fromid'");
					$retrowr=mysqli_fetch_array($retriver);
					
						$skipr=0;
						$idr=$retrowr[0];
						foreach($recheckr as $senr)
						if($senr==$idr)
							$skipr=1;
						if($skipr==1)
							continue;
						array_push($recheckr,$idr);
						$namer=ucfirst(strtolower($retrowr[1]));
						$snamer=ucfirst(strtolower($retrowr[2]));
						$profile_pic_dbr = $retrowr['profpic'];
						if ($profile_pic_dbr == "" || !file_exists("userdata/profile_pics/$profile_pic_dbr"))
						{
							$profilepicur = "images/default_pic.jpg";
						}
						else
						{
							$profilepicur= "userdata/profile_pics/".$profile_pic_dbr;
						}
						?>
						<div class="pospics centered">
						<a href="message.php?u=<?php echo $idr;?>">
						<img src="<?php echo $profilepicur;?>" class="img-responsive" style="width:100%;height:100%;" /></a>
						</div>
				<h5 style="text-align:center;"><b><?php echo $namer." ".$snamer; ?></b></h5>
						<?php
						
					
					
				}
			?>
				</div>
				</div>
			
			
			
			</div>
		</div>
	</div>
</div>
</body>
</html>



