<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Haru no hi</title>
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
	<li role="presentation" class="active"><a href="#">Home</a></li>
 	<li role="presentation"><a href="login.php">Login</a></li>
	<li role="presentation"><a href="lulz.php">Lulz</a></li>
</ul>
</div>
<h1>Hello</h1>

<div class="panel panel-default">
<div class="panel-heading"><div class="panel-title">Debug information:</div></div>
<div class="panel-body">
<?php
	$servername = "localhost";
	$username = "test";
	$password = "logintest";
    $register_success = false;
    $reg_err = false;
    $db_username = $db_password = $db_email = $cpassword = "";
    $pass_invalid_err = $user_invalid_err = $email_invalid_err = 
        $register_fail_string = "";

/* Create a connection to server */
try {
	$conn = new PDO("mysql:host=$servername;dbname=logintest",
	 $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "<b>Connected successfully</b>";
	//$conn->exec("DROP TABLE IF EXISTS Login");
	$createLoginTable = "CREATE TABLE IF NOT EXISTS Login (
						user VARCHAR(25) NOT NULL,
						password VARCHAR(60) NOT NULL,
						email VARCHAR(50) NOT NULL,
						PRIMARY KEY (email)
	)";
    $createPostsTable = "CREATE TABLE IF NOT EXISTS Posts (
                        id NOT NULL,
                        user VARCHAR(25) NOT NULL,
                        post_content NOT NULL,
                        date_posted NOT NULL
    )";
	$status = $conn->exec($createLoginTable);
    $status_2 = $conn->exec($createPostsTable);
	echo "<br />Affected " . $status . " rows.<br />";
    echo "<br />Affected " . $status_2 . " rows.<br />";
} catch (PDOException $er) {
	echo "Connection to database failed: " . $e->getMessage();
}

echo "test evalutes to " . password_hash("test", PASSWORD_BCRYPT);

/* Attempt to add user */
if(isset($_POST['submit'])) {
    $reg_err = false;
    $db_username = filter_var($_POST["user"], FILTER_SANITIZE_STRING);

    if(empty($_POST["user"]) || empty($_POST["password"]) || empty($_POST["email"])) {
        $register_fail_string = "<div class=\"alert alert-danger\">At least one field has been left blank.</div>";
    }

    if(!preg_match('/^[a-zA-Z0-9_-]{5,20}$/', $_POST["user"])) {
        $user_invalid_err = "<p class=\"text-danger\">Invalid username.</p>";
        $reg_err = true;
    } elseif (userInDatabase($db_username, $conn)) {
        $user_invalid_err = "<p class=\"text-danger\">Username already in use.</p>";
        $reg_err = true;
    }

    if(strlen($_POST["password"]) >= 8 && strlen($_POST["password"]) <= 20) {
        if($_POST["password"] === $_POST["confpassword"]) {
            $db_password = password_hash($_POST["password"], PASSWORD_BCRYPT);
        } else {
            $pass_invalid_err = "<p class=\"text-danger\">The passwords entered don't match.</p>";
            $reg_err = true;
        }
    } else {
        $pass_invalid_err = "<p class=\"text-danger\">Invalid password. Should be 8-20 characters long</p>";
        $reg_err = true;
    }

    if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $email_invalid_err = "<p class=\"text-danger\">Invalid email.</p>";
        $reg_err = true;
    } else {
        $db_email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    }

    if(!$reg_err) {
    	try {
        	$register_user = "INSERT IGNORE INTO Login (user, password, email)
        	                   VALUES('$db_username', '$db_password', '$db_email')";
        	$register_success = $conn->exec($register_user);
            if(!$register_success) {
                $register_fail_string = "<div class=\"alert alert-danger\">Failed to register or email has already been used.</div>";
            }
    	} catch (PDOException $er2) {
    		echo "
    		<div class=\"alert alert-danger\">
    	    Something went wrong...</div>";
    	}
    }
}

/* Checks if username in database */
function userInDatabase($user, PDO $c) {
    $usrchk = $c->prepare("SELECT * FROM Login WHERE user = '$user'");
    $usrchk->execute();
    if($usrchk->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}
?>
</div>
</div>

<h3>Sign up here</h3>
<p>Please make your password at least eight characters long, including alphanumerics and any symbols.
<br />Your username can contain letters, numbers, dashes or underscores.
</p>

<form action="" method="POST">
<div class="form-group">
	<div class="input-group">
		<span class="input-group-addon" id="basic-addon1">Username</span>
		<input type="text" name="user" class="form-control" placeholder="5-20 characters long" />
	</div>
    <?php if($reg_err) { echo $user_invalid_err; } ?>
</div>
<div class="form-group">
	<div class="input-group">
		<span class="input-group-addon">Password</span>
		<input type="password" name="password" class="form-control" placeholder="8-20 characters long" />
        <span class="input-group-addon"></span>
        <input type="password" name="confpassword" class="form-control" placeholder="Confirm password" />
	</div>
    <?php if($reg_err) { echo $pass_invalid_err; } ?>
</div>
<div class="form-group">
	<div class="input-group">
		<span class="input-group-addon" id="">Email</span>
		<input type="text" name="email" class="form-control" />
	</div>
    <?php if($reg_err) { echo $email_invalid_err; } ?>
</div>
<button type="submit" name="submit" class="btn btn-primary">Sign up</button>
</form>
<p>
<?php
if($register_success) {
	echo "<div class=\"alert alert-success\">Successfully registered " . $db_username . ".</div>";
} else {
    echo $register_fail_string;
}
?>
</p>
</div><!-- End container -->
</body>
</html>