<?php



session_start();
 

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
   
}
?>
 
<!DOCTYPE html>

<head>
  
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>

        
        body{font: 20px italic;
          align-content: left; }
           
    </style>
</head>
<body>
	


    <p>  Welcome to our site  <?php echo htmlspecialchars($_SESSION["username"]); ?></p>
        <a href="logout.php" class="btn btn-danger ml-3">log Out of Your Account</a>
  
  
</body>
</html>
