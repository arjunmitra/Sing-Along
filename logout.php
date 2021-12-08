<?php
	session_start();
	session_destroy(); 
    $_GET['page'] = 'logout.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Logout</title>
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
                <h1 class="col-12 mt-4 mb-4">Logout</h1>
                
            </div> 
            <div class="row text-center">
                <div class="col-12">
                    <div class="col-12">You are now logged out.</div>
                </div> 
            </div>
            <div class="row text-center">
                <div class="col-12">
                    <a href="login.php" role="button" class="btn btn-outline-primary btn-lg">Login</a>
                    <a href="index.php" role="button" class="btn btn-outline-dark btn-lg">Home</a>
                    
                </div> 
            </div>
        </div> 



    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>