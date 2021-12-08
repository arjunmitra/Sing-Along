<?php 
    session_start();
    $_GET['page'] = 'login.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=`device-width`, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="base.css">
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="signUp.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu">
    <title>Login</title>
</head>
<body>
    <?php include 'nav.php';?>

    <div class="container">
        
        <form method="POST" action="loginConfirmation.php" id="login-form">

            <div class="pt-5">

                <div class="text-center pt-5">
                    <p class="h2">Login</p>
                </div>
                
                <div class="row justify-content-center p-2 pt-5">
                    <div class="col-6">
                    <label for="username">Username <small id="username-hint" class="form-text text-muted"><i class="fas fa-star"></i></small></label>
                    <input type="text" class="form-control"  name= "username"id="username" aria-describedby="username-hint" placeholder="Enter Username">
                    
                    </div>
                </div>
                <div class="row justify-content-center p-2">
                    <div class="col-6">
                        <label for="password">Password <small id="password-hint" class="form-text text-muted"><i class="fas fa-star"></i></small></label>
                        <input type="password" name ="password" class="form-control" id="password" placeholder="Enter Password">
                
                    </div>
                </div>

                <div class="row justify-content-center text-center p-2">
                    <div class="col-6">
                        <button type="submit" class="btn btn-outline-primary btn-lg">Submit</button>
                        
                        <br>
                        <small id="hint" class="form-text text-muted"><i class="fas fa-star"></i> Required</small>
                        
                    </div>
                    
                    
                </div>  

            </div>

        </form>

    </div>



    <script>
        document.querySelector("#login-form").onsubmit = function(event){
            
            if ( document.querySelector('#username').value.trim().length == 0 ) {
				document.querySelector('#username').classList.add('is-invalid');
                event.preventDefault();

			} 
            else {
                document.querySelector('#username').classList.remove('is-invalid');
            }

            if ( document.querySelector('#password').value.trim().length == 0 ) {
				document.querySelector('#password').classList.add('is-invalid');
                event.preventDefault();
                

			} 
            else {
                document.querySelector('#password').classList.remove('is-invalid');
            }

        }
        
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>