<?php 
include ("head.php");
?>
<style>
	body
	{
		background-color:#e9e9de;
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
.compic
	{
		height:40px;
		overflow: hidden;
		box-shadow: 0px 2px 1px #7b7b52;
		border-radius:25px;
	}
	
	
	a:hover{text-decoration:none;color:white}
	a {color:white}
	.modal-header, .close
		{
			background: linear-gradient(to right, #1a1a4c , #5353c6);
			color:white !important;
			text-align: center;
			font-size: 30px;
		}

		.content
	{
	width:100%;
	}
	body{background-color:#f2f2f2;}
	.btn-link:hover, .btn-link:focus, .btn-link:active, .btn-link.active, .open > .dropdown-toggle.btn-link
	{
    color:#1aa3ff;}
	</style>

</head>
<body>
<?php
require_once("dbconnect.php");
$pid=$_GET['pid'];
$id=$_GET['id'];
$likequery=mysqli_query($con,"SELECT * FROM likes WHERE pid='$pid'");
$totlikesrows=mysqli_fetch_array($likequery);
$totlikes=$totlikesrows['likes'];
if($totlikes=="")
	$totlikes=0;

$query=mysqli_query($con,"SELECT * FROM userlikes WHERE user='$id' AND pid='$pid'");
if(mysqli_num_rows($query)>=1)
{$change=1;}
else if(mysqli_num_rows($query)==0)
{$change=0;}
?>
<?php
if(isset($_POST['like'.$pid]))
{
	if($totlikes=="")
	{
		$totlikes=1;
		$likes = mysqli_query($con,"INSERT INTO likes VALUES ('','$totlikes','$pid')");
	}
	else
	{
	  $totlikes=$totlikes+1;
	  $like = mysqli_query($con,"UPDATE likes SET likes='$totlikes' WHERE pid='$pid'");
	}
	echo $totlikes;
	$user_likes = mysqli_query($con,"INSERT INTO userlikes VALUES ('','$id','$pid')");
	header("Location: likes.php?id=".$id."&pid=".$pid);
}
if(isset($_POST['unlike'.$pid]))
{
	$totlikes=$totlikes-1;
	$like = mysqli_query($con,"UPDATE likes SET likes='$totlikes' WHERE pid='$pid'");
	$user_likes = mysqli_query($con,"DELETE FROM userlikes WHERE user='$id' AND pid='$pid'");
	header("Location: likes.php?id=".$id."&pid=".$pid);
}
?>
<form action="likes.php?id=<?php echo $id;?>&pid=<?php echo $pid;?>" method="POST">
<?php
if($change==0)
{
?>
<button type="submit" id="like" name="like<?php echo $pid;?>" class="btn btn-link" onmouseover="javascript:stext()" onmouseout="javascript:rtext()" style="color:grey;box-shadow: 0px 0px 0px #fff;text-decoration:none;">
<span class="badge"><?php echo $totlikes;?> <span class="glyphicon glyphicon-thumbs-up"></span></span> <b>Like </b></button>
<?php 
}
else
{ ?>
<button type="submit" id="unlike" name="unlike<?php echo $pid;?>"  class="btn btn-link" style="color:#1aa3ff;text-decoration:none;box-shadow: 0px 0px 0px #fff;">
<span class="badge"><?php echo $totlikes;?> <span class="glyphicon glyphicon-thumbs-up"></span></span> <b>Unlike </b></button>
<?php

}
?>
</form>
<script>
function stext() {
    var x = document.getElementById("like");
    x.style.color = '#1aa3ff';
}
function rtext() {
    var x = document.getElementById("like");
    x.style.color = 'grey';
}

</script>
</body>
</html>