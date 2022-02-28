<?php

$dbconn = pg_connect("host=localhost dbname=dbaccount user=postgres password=12345");

 // Performing SQL query



if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  //get username and password from post request
  $uname = $_POST['username'];
  $passwd = $_POST['password'];
   
  $query = "SELECT * FROM account WHERE username = '".$uname."' AND password = '".$passwd."'";
  $result = pg_query($dbconn ,$query);

  if (pg_num_rows($result) == 1){
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
  	<div class="container">
  <form action="" method = "post">
    <div class ="firstname">
    <div><label for="fname">Username</label></div>
    <div><input type="text" name="username" placeholder="Username"></div>
    </div>
    <br>
    <div class="password">
    <div><label for="password">password</label></div>
    <div><input type="password" name="password" placeholder="Password"></div>
    </div>
    <input type="submit" value="Submit">
  </form>
</div>

  	</div>
  </body>
</html>


