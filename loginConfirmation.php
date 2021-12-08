<?php 
    session_start();
    require "config/config.php";
    $_GET['page'] = '';

    if (!isset($_POST['username']) || empty($_POST['username'])
	|| !isset($_POST['password']) || empty($_POST['password']) ) {
	$error = "Please fill out all required fields.";
    
    }

    else{

        $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if ( $mysqli->connect_errno ) {
            echo $mysqli->connect_error;
            exit();
        }


        $statement_registered = $mysqli->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $password = hash("sha256", $_POST["password"]);
        $statement_registered->bind_param("ss", $_POST['username'], $password);
        $executed_registered = $statement_registered->execute();
        if(!$executed_registered) {
            echo $mysqli->error;
            $error = "There was an error in our database. Try again";
        }
        else{
            
            $statement_registered->store_result();
	        $numrows = $statement_registered->num_rows;
	        $statement_registered->close();
            if($numrows == 0) {
                $error = "These credentials do not exist. Please Enter a valid account";
            }
            else{

                $_SESSION["logged_in"] = true;
				$_SESSION["username"] = $_POST["username"];
                
            }


        }

        // Close DB Connection
        $mysqli->close();
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="base.css">
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu">
</head>
<body>
    <?php include 'nav.php';?>

    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="row text-center">
                <h1 class="col-12">Login Confirmation</h1>
                
            </div> 
            <div class="row text-center">
                <div class="col-12">
                    <?php if ( isset($error) && !empty($error) ) : ?>
                        <div class="text-danger"><?php echo $error; ?></div>
                    <?php else : ?>
                        <div class="text-success"><?php echo $_POST['username']; ?> was logged in successfully!</div>
                    <?php endif; ?>
                </div> 
            </div>
            <div class="row text-center">
                <div class="col-12">
                    <a href="index.php" role="button" class="btn btn-outline-primary btn-lg">Home</a>
                    <?php if ( isset($error) && !empty($error) ) : ?>
                        <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-outline-dark btn-lg">Back</a>
                    <?php endif; ?>
                </div> 
            </div>
        </div> 
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>