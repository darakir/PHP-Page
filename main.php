<?php
    session_start();

    if(!isset ($_SESSION['username'])) {
        header('Location: login.php');
    }
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Logged in as <?php echo $_SESSION['username']?></title>
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
    <li role="presentation"><a href="lulz.php">Lulz</a></li>
    <li role="presentation"><a href="logout.php"><p class="text-danger">Logout</p></a></li>
</ul>
</div>
<h1>Welcome</h1>

<p>You have logged in with session <em><?php echo $_SESSION['username']; ?></em>
</p>
</div>
</body>
</html>