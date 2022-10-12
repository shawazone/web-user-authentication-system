<?php

session_start();
 

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
   
}
 

Include "config.php";
 

$username =  "";
$password = "";
$username_err =  "";
$password_err = "";
 $login_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){





    if(empty(($_POST["username"]))){
             $username_err = "Please enter username.";
    } else{


        $username = ($_POST["username"]);

    }
   
         if(empty(($_POST["password"]))){  


        $password_err = "Please enter your password.";
    } else{
        $password = ($_POST["password"]);
    }
    
 
    if(empty($username_err) && empty($password_err)){

        $sql = "SELECT id, username, password FROM users WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql)){
            


            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
        


                    $param_username = ($_POST["username"]);
            
         
            if($stmt->execute()){
         


                         if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $id = $row["id"];
                        $username = $row["username"];
                        $thePassword = $row["password"];
                        if(strcmp($password, $thePassword)==0){
                          

                            session_start();
                            
                          

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                    
                            header("location: welcome.php");
                        } else{
                          


                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{


                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

     
            unset($stmt);
        }
    }
    


    unset($pdo);
}
?>
 
<!DOCTYPE html>

<head>
 
    <title>login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{  font: 20px italic;
          align-content: center; }
            .center{  width: 600px;
            margin: 0 auto;}
    </style>
</head>
<body>
    <div class="center">
        <h2>log in</h2>
        <p>Please fill in your credentialse to login.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>



        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">

                
                <label>user name</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    


            <div class="form-group">
                <label>pass word</label>





                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">


                <input type="submit"  class="btn btn-danger" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php"  class="text-danger"  >Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>
