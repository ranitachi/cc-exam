<!DOCTYPE html>
<html>
<head>
	<title>CCIS PORTAL</title>
</head>
<body style="">
	<center>
		<div style="padding:20px;font-size:16px;text-align:center;">
			<img src="../media/logo.png">
			<h1>Welcome To CC Information System Portal</h1>
		</div>
	</center>
	<div style="width:500px;margin:0 auto">
		<div style="width:49%;float:left;height:120px;" class="menu">
				<a href="<?=site_url()?>form" style="color:white;font-weight:bold;">
					<div style="height:120px;width:100%;text-align:center;cursor:pointer" class="mm">
					SC
					<br>
					<div style="color:yellow;font-weight:bold;font-size:13px !important;">
						CCIT - Reguler
					</div>
					</div>
				</a>
		</div>
		<div style="width:49%;float:right;height:120px;" class="menu">
				<a href="<?=site_url()?>ccexam" style="color:white;font-weight:bold;">
			<div style="height:120px;width:100%;text-align:center;cursor:pointer" class="mm">
					TIPS
					<br>
					<div style="color:yellow;font-weight:bold;font-size:13px !important;">
						CCIT - Perbankan Syariah
					</div>
			</div>
				</a>
		</div>		
	</div>
</body>
</html>
<style type="text/css">
@font-face {
    font-family: fontawesome;
    src: url('../media/font/DXI1ORHCpsQm3Vp6mXoaTXhCUOGz7vYGh680lGh-uXM.woff');
}

*
{
	text-decoration: none;
	font-family: fontawesome;
}
.menu:hover,
.mm:hover
{
	background: #eeddff;
	color:blue;
	border-radius: 10px;
	/*border:1% solid blue;*/
}
.mm
{
	background-color:	blue;
	height:			66px;
	width:			182px;
	border:			none;	
	font-size: 60px;
	font-weight: bold;
	text-shadow: 0px 1px 1px #000;
	border-radius: 10px;
	box-shadow: 1px 1px 11px -2px #00AEE3;
-webkit-box-shadow: 1px 1px 11px -2px #00AEE3;
-moz-box-shadow: 1px 1px 11px -2px #00AEE3;
-o-box-shadow: 1px 1px 11px -2px #00AEE3;
}
.mm a
{
	color:white !important;
	text-indent:-999em;
	font-size: 60px;
	font-weight: bold;
	text-shadow: 0px 1px 1px #000;
	border-radius: 10px;
}
.mm a:hover
{
	color:blue !important;
	text-indent:-999em;
}
</style>