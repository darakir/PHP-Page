<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Haru no hi - Registration</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<link rel="stylesheet" href="css/phppage.css" />
<!-- Optional theme
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
-->
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
<div role="navigation">
<ul class="nav nav-pills" style="float: right;">
    <li role="presentation"><a href="index.php">Home</a></li>
    <li role="presentation"><a href="login.php">Login</a></li>
    <li role="presentation"><a href="lulz.php">Lulz</a></li>
</ul>
</div>
<div style="clear: both;"></div>
<div class="panel panel-default">
<div class="panel-heading"><div class="panel-title">Debug information:</div></div>
<div class="panel-body">
<?php
	$servername = "localhost";
	$username = "test";
	$password = "logintest";

try {
	$conn = new PDO("mysql:host=$servername;dbname=logintest",
	 $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "<b>Connected successfully</b>";
} catch (PDOException $er) {
	//echo "Connection to database failed: " . $er->getMessage();
    echo "
    <div class=\"alert alert-danger\">
    <a href=\"#\" class=\"alert-link\">Oops!</a> Something went wrong. Try again.</div>";
}

?>
</div>
</div>

<h3>Registration</h3>
<a href="index.php">Click here</a>



</div><!-- End container -->
</body>
</html>