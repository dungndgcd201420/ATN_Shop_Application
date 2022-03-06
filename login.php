<?php
session_start();
$dbconn = pg_connect("host=ec2-35-175-68-90.compute-1.amazonaws.com dbname=d1vup106c5v9qv user=ckcnruxsyyzsze password=7564fb08fadd71d9afaf47c548dd9b4c13b62237676e2196a9484d9486bffee1");

 // Performing SQL query


if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  //get username and password from post request
  $uname = $_POST['username'];
  $passwd = $_POST['password'];
   
  $query = "SELECT * FROM account WHERE username = '".$uname."' AND password = '".$passwd."'";
  $result = pg_query($dbconn ,$query);

  if (pg_num_rows($result) == 1){
    $user_info = pg_fetch_array($result);
    $role = $user_info["role"];
    $_SESSION["refresh"] = 5;
    $_SESSION["selected_shop"] = "ADMIN";
    $_SESSION["role"] = $role;
    header('Location: database.php');
  }
  else header('Location: login.php');
}



// Closing connection
pg_close($dbconn);

?>
<!DOCTYPE html> 
<html>
<head>
	<title>Lab Website</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<h1>Login</h1>
</head>
  <body>
  	<div class="login-container">
  <form action="" method = "post">
    <div class ="firstname">
    <div><label for="fname">Username</label></div>
    <div><input type="text" name="username" placeholder="Username"></div>
    </div>
    <br>
    <div class="password">
    <div><label for="password">Password</label></div>
    <div><input type="password" name="password" placeholder="Password"></div>
    </div>
    <div class ="account_submit">
    <input type="submit" value="Submit">
  </div>
  </form>
</div>

  	</div>
  </body>
</html>


