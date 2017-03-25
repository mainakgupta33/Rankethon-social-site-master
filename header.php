<?php
if(isset($_SESSION['user']))
{
	$user=$_SESSION['user'];
}
require_once("dbconnect.php");
$query="SELECT * FROM user WHERE email='{$user}'";
$result=mysqli_query($con,$query);
$row=mysqli_fetch_array($result);
$name=strtolower($row[1]);
$name=ucfirst($name);
$sname=strtolower($row[2]);
$sname=ucfirst($sname);
$id=$row[0];
$profilepic=$row[8];
$dob=$row['dob'];

?>
	<!--Navigation bar-->
	<div class="navi">
	<nav class="navbar navbar-default navbar-fixed-top navbar-above navbar-inverse" style="background:linear-gradient(to right, #000033,#bf1786);">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span> 
				</button>
				<div class="navbar-brand">&nbsp;&nbsp;&nbsp;<b style="color:orange;">Rankethon</b></div>
				
			</div>
			<div class="collapse navbar-collapse" id="myNavbar" >
			<form role="search" method="POST" action="" class="navbar-form navbar-left">
			<div class="input-group">
						            <input type="text" class="form-control" placeholder="Search for friends.." size="50" id="query" name="sear" value="">
							            <div class="input-group-btn">
						            <button type="submit" class="btn btn-success btn-custom" name="seasubmit"><span class="glyphicon glyphicon-search"></span></button>
						            </div>
						        </div>
			</form>
			<?php
			if(isset($_POST['seasubmit']))
			{
				$sear=$_POST['sear'];
				echo '<script>window.open("search.php?s='.$sear.'","_self");</script>';
			}
			?>
				<ul class="nav navbar-nav navbar-right" >
					<li><a href="home.php?u=<?php echo $id;?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span><b> Home</b></a></li>
					<li><a href="profile.php?u=<?php echo $id;?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span><?php echo "<b>$name</b>";?></a></li>
					<li class="dropdown">
						<a id="noti" name="notify"  data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						<span class="glyphicon glyphicon-tag" aria-hidden="true"></span>
						<?php
						$num_req_query=mysqli_query($con,"SELECT COUNT(id) FROM request WHERE touser='{$id}'");
						$num_req=mysqli_fetch_array($num_req_query);
						$numreq=$num_req[0];
						?>
						<b>Notifications <span class="badge" style="background-color:<?php if($numreq==0) echo "brown"; else echo "red"; ?>;"><?php echo $numreq;?></span></b>
						<span class="caret"></span>
						<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="noti">
						<li><a href="requests.php" style="text-align:center"><b>Friend requests <span class="badge" style="background-color:green;"><?php echo $numreq;?></span></b></a></li>
						</ul>
						</a>
					</li>
					<li class="dropdown">
					<a id="dLabel" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
					<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
					<b>Account</b>
					<span class="caret"></span>
					<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dLabel">
					<li><a href="settings.php" style="text-align:center"><b>Settings</b></a></li>
					<li role="separator" class="divider"></li>
					<li><a href="logout.php" style="text-align:center"><strong>Logout</strong></a></li>
					</ul>
					</a>
					</li>
		</div>
	</nav>
	</div>