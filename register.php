<?php





require_once "config.php";
 

$username = "";
$password = "";
 $confirm_password = "";
$errorUser ="";
 $errorPassword ="";
  $confarmation_error = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
  //user name
    if(empty(($_POST["username"]))){
        $errorUser = "Please enter a username.";
    }  else{
      
        $sql = "SELECT id FROM users WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql)){
           
            $stmt->bindParam(":username", $_POST["username"]);
            
        
            if($stmt->execute()){
                if($stmt->rowCount() == 1){

                    $errorUser = "This username is already taken.";
                } else{


                    $username = $_POST["username"];
                }
            } else{



                echo "Oops! Something went wrong. Please try again later.";
            }

         
            unset($stmt);
        }
    }
    
// password
    if(empty(($_POST["password"]))){
        $errorPassword = "Please enter a password.";     
    }  else{
        $password = $_POST["password"];

    }
    
   // confirm password
    if(empty(($_POST["confirm_password"]))){


        $confarmation_error = "Please confirm password.";     
    } else{
        $confirm_password = $_POST["confirm_password"];
        if(empty($errorPassword) && ($password != $confirm_password)){


                   $confarmation_error = "Password did not match.";
        }
    }
    
  // inserting
 if(empty($errorUser) && empty($errorPassword) && empty($confarmation_error))
{
    
try{
    $sql = "INSERT INTO users (username,password) VALUES (:username,:password)";    
    $stmt = $pdo->prepare($sql);
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $_POST["username"]);
            $stmt->bindParam(":password", $_POST["password"]);
                                  
            $stmt->execute();
            } catch(PDOException $e){
        die("ERROR: Could not able to execute $sql. " . $e->getMessage());
            }

    
}
    
    
    unset($pdo);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>

    <title>Sign Up</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{  font: 20px italic;

          align-content: center; }

            .center{  width: 600px;

            margin: 0 auto;; }
    </style>
</head>
<body>
    <div class="center">

        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($errorUser)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $errorUser; ?></span>

                

            </div>    

            <div class="form-group">
                <label>Password</label>


                <input type="password" name="password" class="form-control <?php echo (!empty($errorPassword)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">

                <span class="invalid-feedback"><?php echo $errorPassword; ?></span>


            </div>
            <div class="form-group">
                <label>Confirm Password</label>


                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confarmation_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confarmation_error; ?></span>


            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-danger" value="submit" name="submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php"   class="text-danger">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>
