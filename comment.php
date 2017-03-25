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
	</style>

</head>
<body>

<div class="content">
<?php
require_once("dbconnect.php");

$postid=$_GET['idp'];
$postby=$_GET['pb'];
$postto=$_GET['pt'];
$uid=$postto;
$idp=$postid;
$id=$postby;
$query="SELECT * FROM user WHERE email='{$id}'";
$result=mysqli_query($con,$query);
$row=mysqli_fetch_array($result);
$profilepic=$row[8];
if ($profilepic == "" || !file_exists("userdata/profile_pics/$profilepic"))
								{
									$profilepic = "images/default_pic.jpg";
								}
								else
								{
									$profilepic = "userdata/profile_pics/".$profilepic;
								}
?>
<div class="container">
	<form action="" method="POST"><!--FORM COMMENT-->
						<div class="form-group">	
							
							<div class="rows" >
							<div class="col-xs-2" style="">
							<div class="compic">
									<img src="<?php echo $profilepic; ?>" class="img-responsive" style="width:100%;height:100%;" />
								</div>
							</div>
							<div class="col-xs-10" style="padding-left:2px; padding-bottom:7px">
							<input class="form-control" name="comment<?php echo $idp;?>" id="comment" placeholder="Write a comment..." required></textarea>
							</div>
						</div>
						
						<hr>
						<button type="submit" class="btn btn-primary pull-right" name="subcom<?php echo $idp;?>"><b>Comment</b></button>
						
						</div></form><div class="clearfix"></div>	
						<?php
						
						if(isset($_POST['subcom'.$postid]))
						{	$postbody=rtrim($_POST['comment'.$postid]," ");
							if($postbody!="")
							{$res=mysqli_query($con,"INSERT INTO comment VALUES('','$postby','$postto','$postbody','$postid')");}			
						}
						$show=mysqli_query($con,"SELECT * FROM comment WHERE postid='$idp' ORDER by id DESC");
						while($show_row=mysqli_fetch_array($show))
						{
							$commentbyid=$show_row['cby'];
							$combody=$show_row['cbody'];
									$cbyquery=mysqli_query($con,"SELECT * FROM user WHERE id='$commentbyid'") or die(mysqli_error($con));
									$cby=mysqli_fetch_array($cbyquery);
									$cpic=$cby['profpic'];
									if ($cpic== "" || !file_exists("userdata/profile_pics/$cpic"))
									{
										$cpic = "images/default_pic.jpg";
									}
									else
									{
										$cpic = "userdata/profile_pics/".$cpic;
									}
									$cname=ucfirst(strtolower($cby[1]));
									$csname=ucfirst(strtolower($cby[2]));
								?>
								<div class="rows" >
									<div class="col-xs-2" style="">
										<div class="compic">
											<a target="_parent" href="profile.php?u=<?php echo $commentbyid;?>">
											<img src="<?php echo $cpic; ?>" class="img-responsive" style="width:100%;height:100%;" />
											</a>
										</div>
									</div>
									<div class="col-xs-10" style="padding-left:2px;padding-bottom:7px;">
									<a target="_parent" href="profile.php?u=<?php echo $commentbyid;?>" style="color:grey"><b><?php echo $cname." ".$csname;?></b></a><br>
									<span style="font-size:90%;"><?php echo $combody;?></span>
									</div>
								</div>
								<?php
						}//While ends here
						?>
						</div>
						</div>

						
</body>
</html>