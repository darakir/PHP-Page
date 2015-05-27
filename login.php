<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>hi</title>
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
    <li role="presentation" class="active"><a href="#">Login</a></li>
    <li role="presentation"><a href="lulz.php">Lulz</a></li>
</ul>
</div>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="form-signin" method="POST">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label>Username</label>
        <input type="text" name="user" class="form-control" autofocus />
        <label>Password</label>
        <input type="password" name="password" class="form-control" />
        <!--<div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>-->
        <br />
        <button class="btn btn-lg btn-primary btn-block" name="form_submit" type="submit">Log in</button>
</form>

<?php
    if(isset($_POST['form_submit'])) {
        $servername = "localhost";
        $username = "test";
        $password = "logintest";
        $db_name = htmlspecialchars($_POST["user"]);
        $db_password = $_POST["password"];

        $conn = new PDO("mysql:host=$servername;dbname=logintest",
         $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $check_pass = $conn->prepare("SELECT password FROM Login WHERE '$db_name' = user LIMIT 1");
        $check_pass->execute();
        $hash = $check_pass->fetchColumn();

        if(password_verify($db_password, $hash)) {
            $_SESSION['username'] = $db_name;
            header('Location: main.php');
            /*echo "<p>
    <div class=\"alert alert-success\" role=\"alert\">
        <a href=\"#\" class=\"alert-link\">Password is correct!</a>
        You can log in.
    </div></p>";*/
        } else {
            header('Location login.php');
            echo "<p>
    <div class=\"alert alert-danger\" role=\"alert\">
        <a href=\"#\" class=\"alert-link\">Oops!</a>
        Password is incorrect or user doesn't exist.
    </div></p>";
        }
    }
?>
</div>
</body>
</html>